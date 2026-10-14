<?php

namespace App\Http\Controllers;

use App\Models\StaffMember;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category', 'administration');

        $categories = [
            'administration' => 'Administration',
            'teaching' => 'Teaching Staff',
            'non-teaching' => 'Non-Teaching Staff',
        ];

        $staff = StaffMember::published()
            ->category($category)
            ->orderBy('sort_order')
            ->get();

        return view('staff.index', compact('staff', 'categories', 'category'));
    }
}
