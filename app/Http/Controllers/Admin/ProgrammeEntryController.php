<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgrammeEntry;
use App\Support\PlainTextContent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgrammeEntryController extends Controller
{
    public function index(Request $request)
    {
        $month = max(1, min(12, (int) $request->query('month', now()->month)));
        $year = max(2000, min(2100, (int) $request->query('year', now()->year)));

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth()->endOfDay();

        $entries = ProgrammeEntry::query()
            ->between($start, $end)
            ->orderBy('starts_at')
            ->get();

        return view('admin.programme-entries.index', compact('entries', 'month', 'year'));
    }

    public function create(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));

        return view('admin.programme-entries.form', [
            'entry' => new ProgrammeEntry([
                'starts_at' => Carbon::parse($date)->setTime(8, 0),
                'category' => ProgrammeEntry::DEFAULT_CATEGORY,
                'is_published' => true,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        ProgrammeEntry::create($this->validated($request));

        return redirect()->to($this->redirectUrl($request))->with('success', 'Programme entry added.');
    }

    public function edit(ProgrammeEntry $programmeEntry)
    {
        return view('admin.programme-entries.form', ['entry' => $programmeEntry]);
    }

    public function update(Request $request, ProgrammeEntry $programmeEntry)
    {
        $programmeEntry->update($this->validated($request));

        return redirect()->to($this->redirectUrl($request))->with('success', 'Programme entry updated.');
    }

    public function destroy(Request $request, ProgrammeEntry $programmeEntry)
    {
        $programmeEntry->delete();

        return redirect()->to($this->redirectUrl($request))->with('success', 'Programme entry deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'is_published' => 'boolean',
        ]);

        $startsAt = Carbon::parse($data['event_date'].' '.$data['start_time']);
        $endsAt = ! empty($data['end_time'])
            ? Carbon::parse($data['event_date'].' '.$data['end_time'])
            : null;

        return [
            'title' => $data['title'],
            'description' => PlainTextContent::sanitize($data['description'] ?? null),
            'category' => $data['category'],
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_published' => $request->boolean('is_published'),
        ];
    }

    private function redirectUrl(Request $request): string
    {
        $month = $request->input('return_month', now()->month);
        $year = $request->input('return_year', now()->year);

        return route('admin.updates.programme.index', ['month' => $month, 'year' => $year]);
    }
}
