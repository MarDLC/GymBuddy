<?php


class EPhysicalData {

    //attributes
    private $idPhysicalData;
    private $emailRegisteredUser;
    private $sex;
    private $height;
    private $weight;
    private $leanMass;
    private $fatMass;
    private $bmi;
    private DateTime $date;
    private $emailPersonalTrainer;

    private static $entity = EPhysicalData::class;

    //constructor
    public function __construct($emailRegisteredUser, $sex, $height, $weight, $leanMass, $fatMass, $bmi)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
        $this->sex = $sex;
        $this->height = $height;
        $this->weight = $weight;
        $this->leanMass = $leanMass;
        $this->fatMass = $fatMass;
        $this->bmi = $bmi;
        $this->setTime();
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getTime()
    {
        return $this->date;
    }

    private function setTime()
    {
        $this->date = new DateTime("now");
    }

    public function getTimeStr()
    {
        return $this->date->format('Y-m-d H:i:s');
    }

    public function setCreationTime(DateTime $dateTime){
        $this->date = $dateTime;
    }

    public function getEmailRegisteredUser()
    {
        return $this->emailRegisteredUser;
    }

    public function setEmailRegisteredUser($emailRegisteredUser)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getLeanMass()
    {
        return $this->leanMass;
    }

    public function setLeanMass($leanMass)
    {
        $this->leanMass = $leanMass;
    }

    public function getFatMass()
    {
        return $this->fatMass;
    }

    public function setFatMass($fatMass)
    {
        $this->fatMass = $fatMass;
    }

    public function getBmi()
    {
        return $this->bmi;
    }

    public function setBmi($bmi)
    {
        $this->bmi = $bmi;
    }

    public function getEmailPersonalTrainer()
    {
        return $this->emailPersonalTrainer;
    }

    public function setEmailPersonalTrainer($emailPersonalTrainer)
    {
        $this->emailPersonalTrainer = $emailPersonalTrainer;
    }

    public function getIdPhysicalData()
    {
        return $this->idPhysicalData;
    }

    public function setIdPhysicalData($idPhysicalData)
    {
        $this->idPhysicalData = $idPhysicalData;
    }

}
