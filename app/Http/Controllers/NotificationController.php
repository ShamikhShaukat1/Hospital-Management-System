<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private function user(): User
    {
        /** @var User */
        return Auth::user();
    }

    public function index()
    {
        $notifications = $this->user()->notifications()->latest()->paginate(5);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(string $notification)
    {
        $this->user()->notifications()->where('id', $notification)->first()?->markAsRead();

        return back();
    }

    public function markAllAsRead()
    {
        $this->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy(string $notification)
    {
        $this->user()->notifications()->where('id', $notification)->delete();

        return back()->with('success', 'Notification removed successfully.');
    }
}
