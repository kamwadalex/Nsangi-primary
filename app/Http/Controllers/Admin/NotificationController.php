<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminUnreadCounts;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function unreadCounts(): JsonResponse
    {
        return response()->json(AdminUnreadCounts::get());
    }
}
