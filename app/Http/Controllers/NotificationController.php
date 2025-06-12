<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();
        return $this->formatResponse($notifications, 'Notifications retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $notification = Notification::create($request->all());
        return $this->formatResponse($notification, 'Notification created successfully', true, 201);
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return $this->formatResponse(null, 'Notification not found', false, 404);
        }

        $notification->update($request->all());
        return $this->formatResponse($notification, 'Notification updated successfully');
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return $this->formatResponse(null, 'Notification not found', false, 404);
        }

        $notification->delete();
        return $this->formatResponse(null, 'Notification deleted successfully');
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        if (!$notification) {
            return $this->formatResponse(null, 'Notification not found', false, 404);
        }

        $notification->update(['read' => true]);
        return $this->formatResponse($notification, 'Notification marked as read successfully');
    }
}
