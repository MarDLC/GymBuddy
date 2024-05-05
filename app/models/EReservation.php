<?php


class EReservation {

    //attributes
    private $emailRegisteredUser;
    private $date;
    private $time;
    private $TrainingPT;
    private $emailPersonalTrainer;

    private static $entity = EReservation::class;

    //constructor
    public function __construct($emailRegisteredUser, $date, $TrainingPT, $time = '02:00:00')
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
        $this->date = $date;
        $this->time = $time;
        $this->TrainingPT = $TrainingPT;
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getEmailRegisteredUser()
    {
        return $this->emailRegisteredUser;
    }

    public function setEmailRegisteredUser($emailRegisteredUser)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getTrainingPT()
    {
        return $this->TrainingPT;
    }

    public function setTrainingPT($TrainingPT)
    {
        $this->TrainingPT = $TrainingPT;
    }


}
