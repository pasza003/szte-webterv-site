<?php

session_start();
require_once('connection.php');


class User{
    private $ID;
    private $username;
    private $email;
    private $password;
    private $birthdate;
    private $picture;
    private $emailPrivate;
    private $birthdatePrivate;
    private $admin;


    public function __construct($ID, $username, $email, $password, $birthdate, $picture, $emailPrivate, $birthdatePrivate, $admin)
    {
        $this->ID = $ID;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->picture = $picture;
        $this->emailPrivate = $emailPrivate;
        $this->birthdatePrivate = $birthdatePrivate;
        $this->admin = $admin;
    }


    public function getID()
    {
        return $this->ID;
    }


    public function setID($ID)
    {
        $this->ID = $ID;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getEmail()
    {
        return $this->email;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password, $id)
    {
        $db = new Database();
        $db->mysqli->query("UPDATE users SET password = '$password' WHERE id = '$id'");
        $this->password = $password;
    }


    public function getBirthdate()
    {
        return $this->birthdate;
    }


    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function setPicture($picture) {
        $this->picture = $picture;
    }


    public function isBirthDatePrivate()
    {
        return $this->birthdatePrivate;
    }

    public function isEmailPrivate()
    {
        return $this->emailPrivate;
    }


    public function isAdmin()
    {
        return $this->admin;
    }
}

?>
