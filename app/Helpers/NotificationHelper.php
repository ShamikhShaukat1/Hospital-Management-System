<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\GenericNotification;
use Illuminate\Support\Facades\Auth;

class NotificationHelper
{

    public static function notifyUser(User $user, string $title, string $message, ?string $url = null, string $type = 'general', string $icon = 'fa-bell', string $color = 'slate'): void
    {
        $user->notify(new GenericNotification($title, $message, $url, $type, $icon, $color));
    }

    public static function notifyUsers(iterable $users, string $title, string $message, ?string $url = null, string $type = 'general', string $icon = 'fa-bell', string $color = 'slate'): void
    {
        foreach ($users as $user) {
            if ($user instanceof User) {
                self::notifyUser($user, $title, $message, $url, $type, $icon, $color);
            }
        }
    }

    public static function notifyRoles(array $roles, string $title, string $message, ?string $url = null, string $type = 'general', string $icon = 'fa-bell', string $color = 'slate'): void
    {
        $users = User::whereIn('role', $roles)->get();
        self::notifyUsers($users, $title, $message, $url, $type, $icon, $color);
    }

    public static function notifyAllExceptCurrent(string $title, string $message, ?string $url = null, string $type = 'general', string $icon = 'fa-bell', string $color = 'slate'): void
    {
        $currentUserId = Auth::id();
        $users = User::where('id', '!=', $currentUserId)->get();
        self::notifyUsers($users, $title, $message, $url, $type, $icon, $color);
    }

    public static function notifyRolesExceptCurrent(array $roles, string $title, string $message, ?string $url = null, string $type = 'general', string $icon = 'fa-bell', string $color = 'slate'): void
    {
        $currentUserId = Auth::id();
        $users = User::whereIn('role', $roles)->where('id', '!=', $currentUserId)->get();
        self::notifyUsers($users, $title, $message, $url, $type, $icon, $color);
    }
}
