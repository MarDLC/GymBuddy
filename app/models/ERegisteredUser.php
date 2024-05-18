<?php

require_once("EUser.php");

class ERegisteredUser extends EUser {

    public $role = "registered_user";




    private static $entity = ERegisteredUser::class;

    //constructor
    public function __construct($email, $username, $first_name, $last_name, $password)
    {
        parent::__construct($email, $username, $first_name, $last_name, $password);

    }

    //no methods


    public static function getEntity(): string
    {
        return self::$entity;
    }
}
