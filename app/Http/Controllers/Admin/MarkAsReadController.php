<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MarkAsReadController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        // Get the authenticated admin user
        $admin = Auth::guard('admin')->user();

        // Find the notification by ID for the authenticated admin
        $notification = $admin->notifications()->where('id', $id)->first();

        // If notification exists, mark it as read
        if ($notification) {
            $notification->markAsRead();
        }

        // Return the count of unread notifications for the admin
        return response()->json(['count' => $admin->unreadNotifications()->count()]);
       
    }
}
