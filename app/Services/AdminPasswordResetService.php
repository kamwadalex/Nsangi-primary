<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPasswordResetService
{
    public function findByEmail(string $email): ?User
    {
        $email = Str::lower(trim($email));

        if ($email === '') {
            return null;
        }

        return User::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();
    }

    public function masterPasswordIsConfigured(): bool
    {
        return $this->expectedMasterPassword() !== '';
    }

    public function masterPasswordMatches(string $provided): bool
    {
        $expected = $this->expectedMasterPassword();

        if ($expected === '' || $provided === '') {
            hash('sha256', $provided, true);

            return false;
        }

        return hash_equals(
            hash('sha256', $expected, true),
            hash('sha256', $provided, true),
        );
    }

    public function resetPassword(User $user, string $password): void
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'must_change_password' => false,
            'remember_token' => null,
        ])->save();
    }

    private function expectedMasterPassword(): string
    {
        return (string) config('admin.master_reset_password', '');
    }
}
