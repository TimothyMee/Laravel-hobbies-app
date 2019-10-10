<?php

namespace App\Broadcasting;

use App\User;
use Illuminate\Notifications\Notification;
use App\Broadcasting\SMSMessage;

class SMSChannel
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function send($notifiable, Notification $notification)
    {
        $content = $notification->toSMS($notifiable);

        $content = new SMSMessage($content);

            dd($content);

    }
}
