<?php


class ESubscription {

    //attributes
    private $email;
    private $type;
    private$duration;
    private $price;

    private static $entity = ESubscription::class;

    //constructor
    public function __construct($email, $type, $duration, $price)
    {
        $this->email = $email;
        $this->type = $type;
        $this->duration = $duration;
        $this->price = $price;
    }

    //methods
    public static function getEntity(): string
    {
        return self::$entity;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }
}
