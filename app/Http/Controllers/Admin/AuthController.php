<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->ensureLoginIsNotRateLimited($request);

        if ($request->filled('website')) {
            $this->hitLoginLimits($request);

            return $this->failedLoginResponse($request);
        }

        $credentials = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $this->clearLoginLimits($request);

            $request->session()->regenerate();

            $user = $request->user();
            $user->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();

            if ($user->must_change_password) {
                return redirect()->route('admin.password.change');
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        $this->hitLoginLimits($request);

        Log::warning('Failed admin login attempt', [
            'email' => Str::lower($credentials['email']),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $this->failedLoginResponse($request);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function ensureLoginIsNotRateLimited(Request $request): void
    {
        $wait = 0;

        foreach ($this->loginLimits($request) as $limit) {
            if (RateLimiter::tooManyAttempts($limit['key'], $limit['max'])) {
                $wait = max($wait, RateLimiter::availableIn($limit['key']));
            }
        }

        if ($wait < 1) {
            return;
        }

        Log::warning('Admin login rate limit triggered', [
            'email' => Str::lower((string) $request->input('email')),
            'ip' => $request->ip(),
        ]);

        throw ValidationException::withMessages([
            'email' => $this->retryAfterMessage($wait),
        ]);
    }

    private function hitLoginLimits(Request $request): void
    {
        foreach ($this->loginLimits($request) as $limit) {
            RateLimiter::hit($limit['key'], $limit['decay']);
        }
    }

    private function clearLoginLimits(Request $request): void
    {
        foreach ($this->loginLimits($request) as $limit) {
            RateLimiter::clear($limit['key']);
        }
    }

    private function loginLimits(Request $request): array
    {
        $email = Str::transliterate(Str::lower((string) $request->input('email', '')));
        $ip = (string) $request->ip();

        return [
            ['key' => 'admin-login:'.Str::transliterate(Str::lower($ip.'|'.$email)), 'max' => 5, 'decay' => 900],
            ['key' => 'admin-login-ip:'.$ip, 'max' => 12, 'decay' => 900],
            ['key' => 'admin-login-email:'.$email, 'max' => 8, 'decay' => 1800],
        ];
    }

    private function retryAfterMessage(int $seconds): string
    {
        $seconds = max(1, $seconds);

        if ($seconds < 60) {
            $unit = $seconds === 1 ? 'second' : 'seconds';

            return "Too many login attempts. Please try again in {$seconds} {$unit}.";
        }

        $minutes = (int) ceil($seconds / 60);
        $unit = $minutes === 1 ? 'minute' : 'minutes';

        return "Too many login attempts. Please try again in {$minutes} {$unit}.";
    }

    private function failedLoginResponse(Request $request)
    {
        return back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->onlyInput('email');
    }
}
