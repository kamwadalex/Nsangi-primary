<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContinuingApplication;
use App\Support\AdminUnreadCounts;
use App\Support\ApplicationFormExport;

class ContinuingApplicationController extends Controller
{
    public function index()
    {
        $applications = ContinuingApplication::query()
            ->select([
                'id', 'surname', 'first_name', 'other_names', 'current_class',
                'previous_secondary_school', 'student_type', 'guardian_phone', 'created_at', 'is_read',
            ])
            ->latest('created_at')
            ->paginate(20);

        return view('admin.continuing-applications.index', compact('applications'));
    }

    public function show(ContinuingApplication $continuingApplication)
    {
        $continuingApplication->update(['is_read' => true]);
        AdminUnreadCounts::forget();

        return view('admin.continuing-applications.show', ['application' => $continuingApplication]);
    }

    public function print(ContinuingApplication $continuingApplication)
    {
        return ApplicationFormExport::print('admin.applications.print.continuing', $continuingApplication);
    }

    public function download(ContinuingApplication $continuingApplication)
    {
        return ApplicationFormExport::download(
            'admin.applications.print.continuing',
            'continuing-application-'.$continuingApplication->id.'-'.$continuingApplication->full_name,
            $continuingApplication
        );
    }

    public function blankPrint()
    {
        return ApplicationFormExport::print('admin.applications.print.continuing');
    }

    public function blankDownload()
    {
        return ApplicationFormExport::download('admin.applications.print.continuing', 'continuing-application-form-blank');
    }
}
