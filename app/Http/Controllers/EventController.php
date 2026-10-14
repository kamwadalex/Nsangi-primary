<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $upcoming = Event::published()->upcoming()->take(24)->get();
        $past = Event::published()
            ->where('starts_at', '<', now())
            ->orderByDesc('starts_at')
            ->paginate(9);

        return view('events.index', compact('upcoming', 'past'));
    }

    public function show(string $slug)
    {
        $event = Event::published()->where('slug', $slug)->firstOrFail();

        return view('events.show', compact('event'));
    }
}
