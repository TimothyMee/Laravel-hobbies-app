<?php

namespace App\Notifications;

use App\Broadcasting\SMSChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use App\Broadcasting\SMSMessage;

class ActionNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $message;
    public $emailMessage;
    public $user;
    public function __construct($user, $message, $emailMessage)
    {
        //
        $this->message = $message;
        $this->emailMessage = $emailMessage;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //To use the laravel official nexmo option uncomment return code below
        // return ['mail', 'nexmo'];

        //To use the smartweb sms option uncomment the return code below
        return ['mail', SMSChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line($this->emailMessage)
            ->action('Goto the site', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage())
            ->content($this->message);
    }

    /**
     * Get the SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SMSMessage
     */
    public function toSMS($notifiable)
    {
        return (new SMSMessage())
            ->message($this->message)
            ->to($user['phone_number']);
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
