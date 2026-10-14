<?php

namespace App\Http\Controllers;

use App\Models\PrimaryApplication;
use App\Support\AdminUnreadCounts;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrimaryApplicationController extends Controller
{
    public function create()
    {
        return view('applications.primary');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'class_applying_for' => ['required', Rule::in(['Nursery', 'P.1', 'P.2', 'P.3', 'P.4', 'P.5', 'P.6'])],
            'attendance_type' => ['required', Rule::in(['Day', 'Boarding'])],
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:50',
            'guardian_email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:3000',
            'confirm' => 'accepted',
        ]);

        unset($validated['confirm']);
        PrimaryApplication::create($validated);
        AdminUnreadCounts::forget();

        return back()->with('success', 'Thank you. Your application enquiry has been received. The school will contact you soon.');
    }
}
