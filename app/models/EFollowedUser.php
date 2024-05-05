<?php


class EFollowedUser {

    //attributes
    protected $emailPersonalTrainer;
    protected $emailRegisteredUser;

    private static $entity = EFollowedUser::class;

    //constructor
    public function __construct($emailPersonalTrainer, $emailRegisteredUser)
    {
        $this->emailPersonalTrainer = $emailPersonalTrainer;
        $this->emailRegisteredUser = $emailRegisteredUser;
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getEmailPersonalTrainer()
    {
        return $this->emailPersonalTrainer;
    }

    public function setEmailPersonalTrainer($emailPersonalTrainer)
    {
        $this->emailPersonalTrainer = $emailPersonalTrainer;
    }

    public function getEmailRegisteredUser()
    {
        return $this->emailRegisteredUser;
    }

    public function setEmailRegisteredUser($emailRegisteredUser)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
    }
}
