<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\S1Application;
use App\Support\AdminUnreadCounts;
use App\Support\ApplicationFormExport;

class S1ApplicationController extends Controller
{
    public function index()
    {
        $applications = S1Application::query()
            ->select([
                'id', 'surname', 'first_name', 'other_names', 'index_number',
                'division', 'total_aggregates', 'guardian_phone', 'created_at', 'is_read',
            ])
            ->latest('created_at')
            ->paginate(20);

        return view('admin.s1-applications.index', compact('applications'));
    }

    public function show(S1Application $s1Application)
    {
        $s1Application->update(['is_read' => true]);
        AdminUnreadCounts::forget();

        return view('admin.s1-applications.show', ['application' => $s1Application]);
    }

    public function print(S1Application $s1Application)
    {
        return ApplicationFormExport::print('admin.applications.print.s1', $s1Application);
    }

    public function download(S1Application $s1Application)
    {
        return ApplicationFormExport::download(
            'admin.applications.print.s1',
            's1-application-'.$s1Application->id.'-'.$s1Application->full_name,
            $s1Application
        );
    }

    public function blankPrint()
    {
        return ApplicationFormExport::print('admin.applications.print.s1');
    }

    public function blankDownload()
    {
        return ApplicationFormExport::download('admin.applications.print.s1', 's1-application-form-blank');
    }
}
