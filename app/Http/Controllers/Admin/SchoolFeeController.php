<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolFee;
use Illuminate\Http\Request;

class SchoolFeeController extends Controller
{
    public function index()
    {
        $fees = SchoolFee::orderBy('sort_order')->orderBy('class')->get();

        return view('admin.school-fees.index', compact('fees'));
    }

    public function create()
    {
        return view('admin.school-fees.form', ['fee' => new SchoolFee]);
    }

    public function store(Request $request)
    {
        SchoolFee::create($this->validated($request));

        return redirect()->route('admin.school-fees.index')->with('success', 'Fee row added.');
    }

    public function edit(SchoolFee $school_fee)
    {
        return view('admin.school-fees.form', ['fee' => $school_fee]);
    }

    public function update(Request $request, SchoolFee $school_fee)
    {
        $school_fee->update($this->validated($request));

        return redirect()->route('admin.school-fees.index')->with('success', 'Fee row updated.');
    }

    public function destroy(SchoolFee $school_fee)
    {
        $school_fee->delete();

        return redirect()->route('admin.school-fees.index')->with('success', 'Fee row deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'class' => 'required|string|max:255',
            'item' => 'required|string|max:255',
            'day_students' => 'nullable|string|max:255',
            'boarding_students' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
