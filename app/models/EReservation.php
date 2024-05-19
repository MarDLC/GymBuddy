<?php


class EReservation {

    //attributes
    private $emailRegisteredUser;
    private $date;
    private $time;
    private $trainingPT;
    private $emailPersonalTrainer;

    private static $entity = EReservation::class;

    //constructor
    public function __construct($emailRegisteredUser, $date, $trainingPT, $time = '02:00:00')
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
        $this->date = $date;
        $this->time = $time;
        $this->trainingPT = $trainingPT;
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

    public function getEmailPersonalTrainer()
    {
        return $this->emailPersonalTrainer;
    }

    public function setEmailPersonalTrainer($emailPersonalTrainer)
    {
        $this->emailPersonalTrainer = $emailPersonalTrainer;
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

    public function setCreationTime(DateTime $dateTime){
        $this->date = $dateTime;
    }

    public function getTrainingPT()
    {
        return $this->trainingPT;
    }

    public function setTrainingPT($trainingPT)
    {
        $this->trainingPT = $trainingPT;
    }


}
