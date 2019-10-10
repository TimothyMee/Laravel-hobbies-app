<?php

namespace App\Broadcasting;
class SMSMessage
{

  public $content = "";

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    public function content($content){
        $this->content = $content;
        return $this;
    }

}
