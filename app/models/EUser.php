<?php

namespace models;

class EUser {

    //attributes
    protected $email;
    protected $username;
    protected $first_name;
    protected $last_name;
    protected $password;

    private static $entity = EUser::class;

    //constructor
    public function __construct($email, $username, $first_name, $last_name, $password)
    {
        $this->email = $email;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->password = $password;
    }

    //methods

    public static function getEntity(): string
    {
        return self::$entity;
    }
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}
