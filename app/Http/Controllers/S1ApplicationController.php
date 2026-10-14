<?php

namespace App\Http\Controllers;

use App\Models\S1Application;
use App\Support\AdminUnreadCounts;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class S1ApplicationController extends Controller
{
    public function create()
    {
        return view('applications.s1', [
            'pleGrades' => S1Application::PLE_GRADES,
        ]);
    }

    public function store(Request $request)
    {
        $gradeRule = ['required', Rule::in(S1Application::PLE_GRADES)];

        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'sex' => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => 'required|date|before:today',
            'age' => 'required|integer|min:10|max:20',
            'religion' => ['required', Rule::in(['Catholic', 'Anglican', 'Muslim', 'Others'])],
            'passport_photo' => 'required|image|max:2048',
            'former_primary_school' => 'required|string|max:255',
            'index_number' => 'required|string|max:50',
            'ple_english' => $gradeRule,
            'ple_mathematics' => $gradeRule,
            'ple_social_studies' => $gradeRule,
            'ple_science' => $gradeRule,
            'total_aggregates' => 'required|integer|min:4|max:36',
            'division' => ['required', Rule::in(['Div 1', 'Div 2', 'Div 3', 'Div 4'])],
            'result_slip' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'first_choice' => 'nullable|string|max:255',
            'second_choice' => 'nullable|string|max:255',
            'third_choice' => 'nullable|string|max:255',
            'co_curricular_activities' => 'required|string|max:2000',
            'dream_profession' => 'nullable|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:100',
            'confirm' => 'accepted',
        ]);

        unset($validated['confirm']);

        DB::transaction(function () use ($request, &$validated) {
            $validated['passport_photo'] = ImageOptimizer::store(
                $request->file('passport_photo'),
                's1-applications/photos',
                800
            );
            $validated['result_slip'] = $request->file('result_slip')->store('s1-applications/results', 'public');

            S1Application::create($validated);
        });

        AdminUnreadCounts::forget();

        return back()->with('success', 'Your S.1 application has been submitted successfully. Successful applicants will be contacted.');
    }
}
