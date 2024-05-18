<?php
require_once ("EUser.php");

class EAdmin extends EUser {

    //no attributes

    public $role = "admin";


    private static $entity = EAdmin::class;


    //no methods


    public static function getEntity(): string
    {
        return self::$entity;
    }
}