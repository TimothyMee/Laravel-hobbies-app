<?php

namespace App\Broadcasting;

class SMSMessage
{

    public $message = "";
    public $to = "";
    /**
     * Create a new message instance.
     *
     * @param  string  $message
     * @return void
     */
    public function __construct($message = '', $to = '')
    {
        $this->message = $message;
        $this->to = $to;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }
}
