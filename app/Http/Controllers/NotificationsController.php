<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ActivateNotification;

class NotificationsController extends Controller
{
    public function send()
    {
        $user = User::find(13);
        $user->notify(new ActivateNotification("Hello World!"));
        return response()->json([
            'message' => 'Notification sent successfully',
        ], 200);
    }
}