<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if ($notification && !$notification->read_at) {
            $notification->markAsRead();
        }
        $data = $notification?->data;
        return redirect($data['action_url'] ?? '/');
    }

    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
