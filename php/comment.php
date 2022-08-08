<?php
class comment{

    private $username;
    private $comment;
    private $comment_ID;


    public function __construct($username, $comment, $comment_ID, $username_ID)
    {
        $this->username = $username;
        $this->comment = $comment;
        $this->comment_ID = $comment_ID;
        $this->username_ID = $username_ID;
    }


    public function getCommentID()
    {
        return $this->comment_ID;
    }


    public function getUsernameID()
    {
        return $this->username_ID;
    }




    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username): void
    {
        $this->username = $username;
    }


    public function getComment()
    {
        return $this->comment;
    }


    public function setComment($comment): void
    {
        $this->comment = $comment;
    }




}
