<?php
require_once ("EUser.php");

class EPersonalTrainer extends EUser {

    //no attributes

    public $role = "personal_trainer";

    private static $entity = PersonalTrainer::class;

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
