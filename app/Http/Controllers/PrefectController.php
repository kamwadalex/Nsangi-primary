<?php

namespace App\Http\Controllers;

use App\Models\Prefect;
use Illuminate\Http\Request;

class PrefectController extends Controller
{
    public function index(Request $request)
    {
        $current = $request->get('view', 'current') === 'current';

        $prefects = Prefect::query()
            ->where('is_current', $current)
            ->orderBy('sort_order')
            ->get();

        return view('prefects.index', compact('prefects', 'current'));
    }
}
