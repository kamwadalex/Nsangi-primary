<?php

namespace App\Http\Controllers;

use App\Models\S5Application;
use App\Support\AdminUnreadCounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class S5ApplicationController extends Controller
{
    public function create()
    {
        return view('applications.s5', [
            'divisions' => S5Application::DIVISIONS,
            'uceResults' => S5Application::UCE_RESULTS,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'religion' => ['required', Rule::in(['Catholic', 'Anglican', 'Muslim', 'Others'])],
            'previous_school' => 'nullable|string|max:255',
            'uce_english' => 'required|string|max:50',
            'uce_mathematics' => 'required|string|max:50',
            'uce_biology' => 'required|string|max:50',
            'uce_chemistry' => 'required|string|max:50',
            'uce_physics' => 'required|string|max:50',
            'uce_history' => 'required|string|max:50',
            'uce_geography' => 'required|string|max:50',
            'uce_cre' => 'nullable|string|max:50',
            'uce_literature' => 'nullable|string|max:50',
            'uce_french' => 'nullable|string|max:50',
            'uce_luganda' => 'nullable|string|max:50',
            'uce_fine_art' => 'nullable|string|max:50',
            'uce_kiswahili' => 'nullable|string|max:50',
            'uce_ict' => 'nullable|string|max:50',
            'uce_entrepreneurship' => 'nullable|string|max:50',
            'uce_physical_education' => 'nullable|string|max:50',
            'uce_ire' => 'nullable|string|max:50',
            'uce_nutrition' => 'nullable|string|max:50',
            'uce_agriculture' => 'nullable|string|max:50',
            'uce_technical_drawing' => 'nullable|string|max:50',
            'uce_project_work' => 'required|string|max:50',
            'uce_result' => ['required', Rule::in(S5Application::UCE_RESULTS)],
            'ple_aggregates' => 'required|string|max:50',
            'division' => ['required', Rule::in(S5Application::DIVISIONS)],
            'preferred_combinations' => 'required|string|max:2000',
            'career_interests' => 'nullable|string|max:2000',
            'co_curricular_activities' => 'nullable|string|max:2000',
            'former_school_responsibilities' => 'nullable|string|max:2000',
            'guardian_name' => 'required|string|max:255',
            'guardian_address' => 'nullable|string|max:500',
            'guardian_phone' => 'required|string|max:100',
            'result_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'confirm' => 'accepted',
        ]);

        unset($validated['confirm']);

        DB::transaction(function () use ($request, &$validated) {
            if ($request->hasFile('result_slip')) {
                $validated['result_slip'] = $request->file('result_slip')->store('s5-applications/results', 'public');
            }

            S5Application::create($validated);
        });

        AdminUnreadCounts::forget();

        return back()->with('success', 'Your S.5 application has been submitted successfully. Successful applicants will be contacted.');
    }
}
