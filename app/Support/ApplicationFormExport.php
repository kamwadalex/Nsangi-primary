<?php

namespace App\Support;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ApplicationFormExport
{
    public static function print(string $view, ?Model $application = null): Response
    {
        return response()->view($view, [
            'application' => $application,
            'autoPrint' => true,
            'isPdf' => false,
        ]);
    }

    public static function download(string $view, string $filenameBase, ?Model $application = null): Response
    {
        $canEmbedImages = extension_loaded('gd');

        view()->share('isPdf', true);
        view()->share('pdfEmbedImages', $canEmbedImages);

        try {
            $pdf = Pdf::loadView($view, [
                'application' => $application,
                'autoPrint' => false,
                'isPdf' => true,
                'pdfEmbedImages' => $canEmbedImages,
            ])
                ->setPaper('a4', 'portrait')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('chroot', public_path());

            $filename = Str::slug($filenameBase).'.pdf';

            return $pdf->download($filename);
        } finally {
            view()->share('isPdf', false);
            view()->share('pdfEmbedImages', true);
        }
    }
}
