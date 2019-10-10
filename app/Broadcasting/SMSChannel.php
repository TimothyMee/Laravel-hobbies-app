<?php

namespace App\Broadcasting;

use App\User;
use Illuminate\Notifications\Notification;
use App\Broadcasting\SMSMessage;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PhpParser\Node\Stmt\TryCatch;

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

        $content = new SMSMessage($content->message, $content->to);

        try {
            $this->sendSMS($content);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function sendSMS($content)
    {
        $client = new Client();
        $res = $client->request('POST', 'https://smartsmssolutions.com/api/json.php?', [
            'verify' => false,
            'form_params' => [
                'token' => env('SMS_TOKEN'),
                'sender' => env('SMS_SENDER_ID'),
                'routing' => env('SMS_ROUTING'),
                'to' => $content->to,
                'type' => env('SMS_TYPE'),
                'message' => $content->message
            ]
        ]);
        $resbody = $res->getBody();
        $resbody = json_decode($resbody, true);
        if ($resbody['code'] !== 1000)
            throw new Exception($resbody['comment']);
    }
}
