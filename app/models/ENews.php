<?php


class ENews {

    //attributes
    private $title;
    private $description;
    private DateTime $date;
    private $email;

    private static $entity = ENews::class;

    //constructor
    public function __construct($title, $description)
    {
        $this->title = $title;
        $this->description = $description;
        $this->setTime();
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
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


    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
