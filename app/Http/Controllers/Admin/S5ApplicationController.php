<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\S5Application;
use App\Support\AdminUnreadCounts;
use App\Support\ApplicationFormExport;

class S5ApplicationController extends Controller
{
    public function index()
    {
        $applications = S5Application::query()
            ->select([
                'id', 'surname', 'first_name', 'other_names', 'previous_school',
                'uce_result', 'division', 'guardian_phone', 'created_at', 'is_read',
            ])
            ->latest('created_at')
            ->paginate(20);

        return view('admin.s5-applications.index', compact('applications'));
    }

    public function show(S5Application $s5Application)
    {
        $s5Application->update(['is_read' => true]);
        AdminUnreadCounts::forget();

        return view('admin.s5-applications.show', ['application' => $s5Application]);
    }

    public function print(S5Application $s5Application)
    {
        return ApplicationFormExport::print('admin.applications.print.s5', $s5Application);
    }

    public function download(S5Application $s5Application)
    {
        return ApplicationFormExport::download(
            'admin.applications.print.s5',
            's5-application-'.$s5Application->id.'-'.$s5Application->full_name,
            $s5Application
        );
    }

    public function blankPrint()
    {
        return ApplicationFormExport::print('admin.applications.print.s5');
    }

    public function blankDownload()
    {
        return ApplicationFormExport::download('admin.applications.print.s5', 's5-application-form-blank');
    }
}
