<?php
require_once ("EUser.php");

class EAdmin extends EUser {

    //no attributes


    private static $entity = EAdmin::class;

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