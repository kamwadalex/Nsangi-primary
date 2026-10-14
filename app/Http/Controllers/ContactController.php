<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Support\AdminUnreadCounts;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);
        AdminUnreadCounts::forget();

        return back()->with('success', 'Thank you for your message. We will get back to you soon.');
    }
}
