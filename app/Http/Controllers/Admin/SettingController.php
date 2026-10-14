<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\ImageOptimizer;
use App\Support\PlainTextContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $settings = Setting::allCached();

        return view('admin.settings.edit', [
            'settings' => $settings,
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $fields = [
            'school_name', 'motto', 'tagline', 'school_story', 'about_school_content', 'school_anthem', 'phone', 'phone_2', 'phone_3', 'email', 'address',
            'levels_offered', 'admission_status', 'center_number', 'head_teacher_name', 'head_teacher_message', 'mission', 'vision', 'core_values',
            'years_existence', 'facebook', 'twitter',
        ];

        $plainTextFields = [
            'tagline', 'school_story', 'about_school_content', 'school_anthem',
            'head_teacher_message', 'mission', 'vision', 'mission_objectives', 'short_term_objectives',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                $value = $request->input($field);
                if (in_array($field, $plainTextFields, true)) {
                    $value = PlainTextContent::sanitize($value);
                }
                Setting::set($field, $value);
            }
        }

        foreach (['logo', 'hero_image', 'head_teacher_photo', 'about_image', 'page_banner'] as $field) {
            if ($request->hasFile($field)) {
                $request->validate([
                    $field => 'image|max:4096',
                ]);
            }
        }

        $imageMaxWidths = [
            'logo' => 512,
            'hero_image' => 1920,
            'head_teacher_photo' => 800,
            'about_image' => 1600,
            'page_banner' => 1920,
        ];

        foreach ($imageMaxWidths as $field => $maxWidth) {
            if ($request->hasFile($field)) {
                ImageOptimizer::delete(Setting::get($field));
                Setting::set(
                    $field,
                    ImageOptimizer::store($request->file($field), 'settings', $maxWidth)
                );
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function updateAccount(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'current_password' => 'required_with:password|nullable|current_password',
            'password' => ['nullable', 'confirmed', Password::min(12)->mixedCase()->letters()->numbers()],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (! empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $user->must_change_password = false;
        }

        $user->save();

        if (! empty($validated['password'])) {
            Auth::logoutOtherDevices($validated['password']);
            $request->session()->regenerate();
        }

        return back()->with('success', 'Admin account updated successfully.');
    }
}
