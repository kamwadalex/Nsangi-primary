<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function showForm(Request $request)
    {
        if (! $request->user()->must_change_password) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.change-password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->letters()->numbers()],
        ]);

        $user = $request->user();

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'must_change_password' => false,
        ])->save();

        Auth::logoutOtherDevices($validated['password']);

        $request->session()->regenerate();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Your password has been updated successfully.');
    }
}
