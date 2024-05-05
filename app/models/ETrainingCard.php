<?php


class ETrainingCard {

    //attributes
    private $emailRegisteredUser;
    private DateTime $creation;
    private$exercises;
    private $repetition;
    private $recovery;
    private $emailPersonalTrainer;

    private static $entity = ETrainingCard::class;

    //constructor
    public function __construct($emailRegisteredUser, $exercises, $repetition, $recovery)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
        $this->exercises = $exercises;
        $this->repetition = $repetition;
        $this->recovery = $recovery;
        $this->setTime();
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
    public function getTime()
    {
        return $this->creation;
    }

    private function setTime()
    {
        $this->creation = new DateTime("now");
    }

    public function getTimeStr()
    {
        return $this->creation->format('Y-m-d H:i:s');
    }

    public function setCreationTime(DateTime $dateTime){
        $this->creation = $dateTime;
    }

    public function getExercises()
    {
        return $this->exercises;
    }

    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }

    public function getRepetition()
    {
        return $this->repetition;
    }

    public function setRepetition($repetition)
    {
        $this->repetition = $repetition;
    }

    public function getRecovery()
    {
        return $this->recovery;
    }

    public function setRecovery($recovery)
    {
        $this->recovery = $recovery;
    }


}
