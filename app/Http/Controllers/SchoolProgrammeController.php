<?php

namespace App\Http\Controllers;

use App\Models\ProgrammeEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SchoolProgrammeController extends Controller
{
    public function index(Request $request)
    {
        $view = in_array($request->query('view'), ['month', 'week', 'day', 'grid', 'list'], true)
            ? $request->query('view')
            : 'month';

        $category = $request->query('category', 'all');
        $today = now()->startOfDay();

        if ($view === 'day') {
            $focus = $request->query('date')
                ? Carbon::parse($request->query('date'))->startOfDay()
                : $today->copy();
            $rangeStart = $focus->copy()->startOfDay();
            $rangeEnd = $focus->copy()->endOfDay();
            $month = (int) $focus->month;
            $year = (int) $focus->year;
        } elseif ($view === 'week') {
            $focus = $request->query('date')
                ? Carbon::parse($request->query('date'))->startOfDay()
                : $today->copy();
            $rangeStart = $focus->copy()->startOfWeek(Carbon::MONDAY);
            $rangeEnd = $focus->copy()->endOfWeek(Carbon::SUNDAY);
            $month = (int) $focus->month;
            $year = (int) $focus->year;
        } else {
            $month = (int) $request->query('month', $today->month);
            $year = (int) $request->query('year', $today->year);
            $month = max(1, min(12, $month));
            $year = max(2000, min(2100, $year));
            $focus = Carbon::create($year, $month, 1)->startOfDay();
            $rangeStart = $focus->copy()->startOfMonth();
            $rangeEnd = $focus->copy()->endOfMonth()->endOfDay();
        }

        $entries = ProgrammeEntry::published()
            ->forCategory($category)
            ->between($rangeStart, $rangeEnd)
            ->orderBy('starts_at')
            ->get();

        $entriesByDate = $entries->groupBy(fn ($entry) => $entry->starts_at->format('Y-m-d'));

        $categories = ProgrammeEntry::published()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if ($categories->isEmpty()) {
            $categories = collect([ProgrammeEntry::DEFAULT_CATEGORY]);
        }

        $calendarWeeks = $this->buildMonthWeeks($year, $month);

        return view('school-programme.index', [
            'view' => $view,
            'category' => $category,
            'month' => $month,
            'year' => $year,
            'focus' => $focus ?? Carbon::create($year, $month, 1),
            'today' => $today,
            'entries' => $entries,
            'entriesByDate' => $entriesByDate,
            'categories' => $categories,
            'calendarWeeks' => $calendarWeeks,
            'rangeStart' => $rangeStart,
            'rangeEnd' => $rangeEnd,
        ]);
    }

    private function buildMonthWeeks(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $cursor = $start->copy()->startOfWeek(Carbon::MONDAY);
        $weeks = [];

        while ($cursor->lte($end) || $cursor->month === $month || $cursor->copy()->endOfWeek(Carbon::SUNDAY)->month === $month) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = $cursor->copy();
                $cursor->addDay();
            }
            $weeks[] = $week;
            if ($cursor->gt($end) && $cursor->dayOfWeek === Carbon::MONDAY) {
                break;
            }
        }

        return $weeks;
    }
}
