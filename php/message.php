<?php
class message
{


    private $sender_username;
    private $message;


    public function __construct($sender_username, $message)
    {
        $this->sender_username = $sender_username;
        $this->message = $message;
    }


    public function getSenderUsername()
    {
        return $this->sender_username;
    }


    public function getMessage()
    {
        return $this->message;
    }

}