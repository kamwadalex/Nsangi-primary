<?php

namespace App\Http\Controllers;

use App\Models\ContinuingApplication;
use App\Support\AdminUnreadCounts;
use App\Support\ImageOptimizer;
use App\Support\PublicStorageMirror;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContinuingApplicationController extends Controller
{
    public function create()
    {
        return view('applications.continuing', [
            'classes' => ContinuingApplication::CLASSES,
            'studentTypes' => ContinuingApplication::STUDENT_TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $classRule = ['required', Rule::in(ContinuingApplication::CLASSES)];

        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => 'required|date|before:today',
            'age' => 'required|integer|min:10|max:25',
            'religion' => ['required', Rule::in(['Catholic', 'Anglican', 'Muslim', 'Others'])],
            'passport_photo' => 'required|image|max:2048',
            'current_class' => $classRule,
            'previous_secondary_school' => 'required|string|max:255',
            'previous_class' => $classRule,
            'student_type' => ['required', Rule::in(ContinuingApplication::STUDENT_TYPES)],
            'index_number' => 'nullable|string|max:50',
            'reason_for_transfer' => 'required|string|max:2000',
            'report_card' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'co_curricular_activities' => 'required|string|max:2000',
            'dream_profession' => 'nullable|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:100',
            'guardian_address' => 'nullable|string|max:255',
            'confirm' => 'accepted',
        ]);

        unset($validated['confirm']);

        DB::transaction(function () use ($request, &$validated) {
            $validated['passport_photo'] = ImageOptimizer::store(
                $request->file('passport_photo'),
                'continuing-applications/photos',
                800
            );

            $reportPath = $request->file('report_card')->store('continuing-applications/reports', 'public');
            PublicStorageMirror::sync($reportPath);
            $validated['report_card'] = $reportPath;

            ContinuingApplication::create($validated);
        });

        AdminUnreadCounts::forget();

        return back()->with('success', 'Your continuing student application has been submitted successfully. The school will contact successful applicants.');
    }
}
