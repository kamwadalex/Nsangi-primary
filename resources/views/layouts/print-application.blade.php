<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Application Form') — {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</title>
    @unless(!empty($isPdf))
        @include('partials.favicon')
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        <style>
            @page { margin: 24px; }
            body { margin: 0; font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
            .print-form { padding: 8px 4px; }
            .print-form__header { display: table; width: 100%; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid #1f6b3a; }
            .print-form__logo,
            .print-form__heading,
            .print-form__photo { display: table-cell; vertical-align: middle; }
            .print-form__logo { width: 70px; }
            .print-form__logo img,
            .school-image--badge { width: 64px; height: 64px; object-fit: contain; }
            .print-form__heading { padding: 0 10px; }
            .print-form__heading h1 { margin: 0 0 4px; font-size: 15px; color: #14532d; }
            .print-form__heading p { margin: 0; font-weight: 700; font-size: 12px; }
            .print-form__meta { margin-top: 6px !important; font-weight: 400 !important; color: #666; font-size: 11px !important; }
            .print-form__photo { width: 80px; height: 100px; border: 1px solid #ccc; overflow: hidden; }
            .print-form__photo img { width: 80px; height: 100px; object-fit: cover; }
            .print-form__photo--blank { text-align: center; vertical-align: middle; font-size: 10px; color: #888; }
            .print-form__section { margin-bottom: 14px; clear: both; }
            .print-form__section h2 { margin: 0 0 8px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.03em; color: #14532d; }
            .print-form__grid { width: 100%; margin-bottom: 8px; }
            .print-form__field { display: inline-block; vertical-align: top; width: 48%; margin: 0 1% 8px 0; box-sizing: border-box; }
            .print-form__grid--3 .print-form__field { width: 31%; }
            .print-form__grid--4 .print-form__field { width: 23%; }
            .print-form__field--full { width: 98%; display: block; }
            .print-form__label { display: block; font-size: 10px; font-weight: 700; color: #444; margin-bottom: 2px; }
            .print-form__value { min-height: 18px; padding: 2px 0; border-bottom: 1px solid #bbb; font-size: 12px; line-height: 1.4; }
            .print-form__note, .print-form__attachment { margin: 0 0 8px; font-size: 11px; color: #555; }
            .print-form__footer { margin-top: 16px; padding-top: 10px; border-top: 1px solid #ddd; font-size: 11px; clear: both; }
            .print-form__signature { width: 100%; margin-top: 24px; }
            .print-form__signature span { display: inline-block; width: 45%; margin-right: 5%; border-top: 1px solid #333; padding-top: 4px; font-size: 11px; }
            .no-print { display: none !important; }
        </style>
    @endunless
</head>
<body class="print-application-body">
    @unless(!empty($isPdf))
        <div class="print-application-toolbar no-print">
            <p>Open the browser print dialog to save as PDF or print on paper.</p>
            <button type="button" class="btn btn-primary" onclick="window.print()">Print / Save as PDF</button>
            <button type="button" class="btn btn-outline" onclick="window.close()">Close</button>
        </div>
    @endunless

    <main class="print-application">
        @yield('content')
    </main>

    @if(!empty($autoPrint) && empty($isPdf))
    <script>window.addEventListener('load', function () { window.print(); });</script>
    @endif
</body>
</html>
