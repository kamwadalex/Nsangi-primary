<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrimaryApplication;

class AdmissionsController extends Controller
{
    public function index()
    {
        return view('admin.admissions.index', [
            'primaryApplications' => PrimaryApplication::latest()->limit(10)->get(),
            'stats' => [
                'primary_total' => PrimaryApplication::count(),
                'primary_unread' => PrimaryApplication::where('is_read', false)->count(),
            ],
        ]);
    }

    public function primary()
    {
        $applications = PrimaryApplication::latest()->paginate(20);

        return view('admin.admissions.primary', compact('applications'));
    }

    public function showPrimary(PrimaryApplication $primaryApplication)
    {
        $primaryApplication->update(['is_read' => true]);
        \App\Support\AdminUnreadCounts::forget();

        return view('admin.admissions.primary-show', ['application' => $primaryApplication]);
    }
}
