<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AdminPasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    private const EMAIL_STEP_MINUTES = 15;

    private const PASSWORD_STEP_MINUTES = 10;

    public function __construct(
        private AdminPasswordResetService $passwordResetService,
    ) {}

    public function showForgotForm(Request $request)
    {
        $this->clearResetSession($request);

        return view('admin.auth.forgot-password');
    }

    public function submitEmail(Request $request)
    {
        $limits = $this->emailLimits($request);
        $this->ensureWithinLimits($limits, 'email');

        if ($request->filled('website')) {
            $this->hitLimits($limits);

            throw ValidationException::withMessages([
                'email' => 'No admin account was found for that email.',
            ]);
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $this->hitLimits($limits);

        $email = Str::lower($validated['email']);
        $user = $this->passwordResetService->findByEmail($email);

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => 'No admin account was found for that email.',
            ]);
        }

        if (! $this->passwordResetService->masterPasswordIsConfigured()) {
            Log::error('Admin password reset attempted while ADMIN_MASTER_RESET_PASSWORD is empty.');

            throw ValidationException::withMessages([
                'email' => 'Password reset is not available right now. Please contact the site developer.',
            ]);
        }

        $request->session()->put([
            'password_reset_user_id' => $user->id,
            'password_reset_email' => Str::lower($user->email),
            'password_reset_master_verified' => false,
            'password_reset_expires_at' => now()->addMinutes(self::EMAIL_STEP_MINUTES)->getTimestamp(),
        ]);
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.password.master');
    }

    public function showMasterForm(Request $request)
    {
        if ($redirect = $this->redirectIfResetUnavailable($request)) {
            return $redirect;
        }

        if ($request->session()->get('password_reset_master_verified')) {
            return redirect()->route('admin.password.reset');
        }

        return view('admin.auth.master-reset-password', [
            'email' => $request->session()->get('password_reset_email'),
        ]);
    }

    public function verifyMaster(Request $request)
    {
        $limits = $this->masterLimits($request);
        $this->ensureWithinLimits($limits, 'master_password');

        if ($redirect = $this->redirectIfResetUnavailable($request)) {
            return $redirect;
        }

        $email = (string) $request->session()->get('password_reset_email');

        if ($request->filled('website')) {
            $this->hitLimits($limits);

            throw ValidationException::withMessages([
                'master_password' => 'The master reset password is incorrect.',
            ]);
        }

        $validated = $request->validate([
            'master_password' => 'required|string|max:255',
        ]);

        if (! $this->passwordResetService->masterPasswordIsConfigured()) {
            Log::error('Admin master reset password is not configured.');

            throw ValidationException::withMessages([
                'master_password' => 'Password reset is not available right now. Please contact the site developer.',
            ]);
        }

        if (! $this->passwordResetService->masterPasswordMatches($validated['master_password'])) {
            $this->hitLimits($limits);

            Log::warning('Failed admin master reset password attempt', [
                'email' => $email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            throw ValidationException::withMessages([
                'master_password' => 'The master reset password is incorrect.',
            ]);
        }

        RateLimiter::clear('admin-master-reset-ip:'.$request->ip());

        $request->session()->put([
            'password_reset_master_verified' => true,
            'password_reset_expires_at' => now()->addMinutes(self::PASSWORD_STEP_MINUTES)->getTimestamp(),
        ]);
        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.password.reset');
    }

    public function showNewPasswordForm(Request $request)
    {
        if ($redirect = $this->redirectIfResetUnavailable($request, true)) {
            return $redirect;
        }

        return view('admin.auth.reset-password', [
            'email' => $request->session()->get('password_reset_email'),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $limits = $this->newPasswordLimits($request);
        $this->ensureWithinLimits($limits, 'password');

        if ($redirect = $this->redirectIfResetUnavailable($request, true)) {
            return $redirect;
        }

        $email = (string) $request->session()->get('password_reset_email');

        if ($request->filled('website')) {
            $this->hitLimits($limits);

            throw ValidationException::withMessages([
                'password' => 'The password could not be updated. Please try again.',
            ]);
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->letters()->numbers()],
        ]);

        $user = $this->userFromResetSession($request);

        if (! $user || Str::lower($user->email) !== $email) {
            $this->clearResetSession($request);

            return redirect()
                ->route('admin.password.forgot')
                ->withErrors(['email' => 'This reset session is no longer valid. Enter your email again.']);
        }

        $this->passwordResetService->resetPassword($user, $validated['password']);
        $this->clearResetSession($request);
        $this->clearLimits($limits);

        Auth::login($user);
        Auth::logoutOtherDevices($validated['password']);
        $request->session()->regenerate();

        Log::info('Admin password reset with master password', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => $request->ip(),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Your password has been updated.');
    }

    private function redirectIfResetUnavailable(Request $request, bool $requireMaster = false)
    {
        $email = $request->session()->get('password_reset_email');
        $expiresAt = (int) $request->session()->get('password_reset_expires_at', 0);
        $hasEmail = is_string($email) && $email !== '';

        if (! $hasEmail) {
            return redirect()->route('admin.password.forgot');
        }

        if ($expiresAt < now()->getTimestamp()) {
            $this->clearResetSession($request);

            return redirect()
                ->route('admin.password.forgot')
                ->withErrors(['email' => 'This reset session has expired. Enter your email again.']);
        }

        if ($requireMaster && ! $request->session()->get('password_reset_master_verified')) {
            return redirect()->route('admin.password.master');
        }

        return null;
    }

    private function userFromResetSession(Request $request): ?User
    {
        $userId = $request->session()->get('password_reset_user_id');

        if (! is_numeric($userId)) {
            return null;
        }

        return User::query()->find((int) $userId);
    }

    private function clearResetSession(Request $request): void
    {
        $request->session()->forget([
            'password_reset_user_id',
            'password_reset_email',
            'password_reset_master_verified',
            'password_reset_expires_at',
        ]);
    }

    private function emailLimits(Request $request): array
    {
        return [
            ['key' => 'admin-forgot-email-ip:'.$request->ip(), 'max' => 8, 'decay' => 900],
        ];
    }

    private function masterLimits(Request $request): array
    {
        return [
            ['key' => 'admin-master-reset-ip:'.$request->ip(), 'max' => 5, 'decay' => 900],
            ['key' => 'admin-master-reset-global', 'max' => 20, 'decay' => 3600],
        ];
    }

    private function newPasswordLimits(Request $request): array
    {
        return [
            ['key' => 'admin-reset-password-ip:'.$request->ip(), 'max' => 8, 'decay' => 900],
        ];
    }

    private function ensureWithinLimits(array $limits, string $errorField): void
    {
        $wait = 0;

        foreach ($limits as $limit) {
            if (RateLimiter::tooManyAttempts($limit['key'], $limit['max'])) {
                $wait = max($wait, RateLimiter::availableIn($limit['key']));
            }
        }

        if ($wait > 0) {
            Log::warning('Admin password reset rate limit triggered', [
                'field' => $errorField,
                'ip' => request()->ip(),
            ]);

            throw ValidationException::withMessages([
                $errorField => $this->retryAfterMessage($wait),
            ]);
        }
    }

    private function hitLimits(array $limits): void
    {
        foreach ($limits as $limit) {
            RateLimiter::hit($limit['key'], $limit['decay']);
        }
    }

    private function clearLimits(array $limits): void
    {
        foreach ($limits as $limit) {
            RateLimiter::clear($limit['key']);
        }
    }

    private function retryAfterMessage(int $seconds): string
    {
        $seconds = max(1, $seconds);

        if ($seconds < 60) {
            $unit = $seconds === 1 ? 'second' : 'seconds';

            return "Too many attempts. Please try again in {$seconds} {$unit}.";
        }

        $minutes = (int) ceil($seconds / 60);
        $unit = $minutes === 1 ? 'minute' : 'minutes';

        return "Too many attempts. Please try again in {$minutes} {$unit}.";
    }
}
