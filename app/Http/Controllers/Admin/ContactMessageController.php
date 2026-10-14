<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Support\AdminUnreadCounts;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::query()
            ->select(['id', 'name', 'email', 'subject', 'created_at', 'is_read'])
            ->latest('created_at')
            ->paginate(20);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        AdminUnreadCounts::forget();

        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        AdminUnreadCounts::forget();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
