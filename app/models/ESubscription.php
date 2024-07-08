<?php

/**
 * Class ESubscription
 *
 * This class represents a subscription in the application.
 * It includes properties for email, type, duration, and price of the subscription.
 * It also includes methods for getting and setting these properties.
 */
class ESubscription {

    /**
     * @var int $idSubscription The id of the subscription.
     */
    private $idSubscription;


    private $idUser;

    /**
     * @var string $type The type of the subscription.
     */
    private $type;

    /**
     * @var int $duration The duration of the subscription.
     */
    private $duration;

    /**
     * @var float $price The price of the subscription.
     */
    private $price;

    /**
     * @var string $entity The name of the class. This is set to ESubscription::class.
     */
    private static $entity = ESubscription::class;

    /**
     * Constructor for the ESubscription class.
     *
     * @param string $type The type of the subscription.
     * @param int $duration The duration of the subscription.
     * @param float $price The price of the subscription.
     */
    public function __construct($idUser, $type, $duration, $price)
    {
        $this->idUser = $idUser;
        $this->type = $type;
        $this->duration = $duration;
        $this->price = $price;
    }

    /**
     * Get the name of the class.
     *
     * @return string The name of the class.
     */
    public static function getEntity(): string
    {
        return self::$entity;
    }

    /**
     * Get the id of the subscription.
     *
     * @return int The id of the subscription.
     */
    public function getIdSubscription()
    {
        return $this->idSubscription;
    }

    /**
     * Set the id of the subscription.
     *
     * @param int $idSubscription The new id of the subscription.
     */
    public function setIdSubscription($idSubscription)
    {
        $this->idSubscription = $idSubscription;
    }

   public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Get the type of the subscription.
     *
     * @return string The type of the subscription.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of the subscription.
     *
     * @param string $type The new type of the subscription.
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get the duration of the subscription.
     *
     * @return int The duration of the subscription.
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set the duration of the subscription.
     *
     * @param int $duration The new duration of the subscription.
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * Get the price of the subscription.
     *
     * @return float The price of the subscription.
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the price of the subscription.
     *
     * @param float $price The new price of the subscription.
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}