<?php

/**
 * Class EReservation
 *
 * This class represents a reservation in the application.
 * It includes properties for email of registered user, date, time, trainingPT, and email of personal trainer.
 * It also includes methods for getting and setting these properties.
 */
class EReservation {

    /**
     * @var int $idReservation The id of the reservation.
     */
    private $idReservation;

    private $idUser;

    /**
     * @var DateTime $date The date of the reservation.
     */
    private $date;

    /**
     * @var string $time The time of the reservation.
     */
    private $time;

    /**
     * @var string $trainingPT The training personal trainer of the reservation.
     */
    private $trainingPT;



    /**
     * @var string $entity The name of the class. This is set to EReservation::class.
     */
    private static $entity = EReservation::class;

    /**
     * Constructor for the EReservation class.
     *
     * @param string $emailRegisteredUser The email of the registered user.
     * @param DateTime $date The date of the reservation.
     * @param string $trainingPT The training personal trainer of the reservation.
     * @param string $time The time of the reservation. Default is '02:00:00'.
     */
    public function __construct($idUser, $date, $trainingPT, $time = '02:00:00')
    {
        $this->idUser = $idUser;
        $this->date = $date;
        $this->time = $time;
        $this->trainingPT = $trainingPT;
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
     * Get the id of the reservation.
     *
     * @return int The id of the reservation.
     */
    public function getIdReservation()
    {
        return $this->idReservation;
    }

    /**
     * Set the id of the reservation.
     *
     * @param int $idReservation The new id of the reservation.
     */
    public function setIdReservation($idReservation)
    {
        $this->idReservation = $idReservation;
    }

    /**
     * Get the date of the reservation.
     *
     * @return DateTime The date of the reservation.
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the date of the reservation.
     *
     * @param DateTime $date The new date of the reservation.
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get the time of the reservation.
     *
     * @return string The time of the reservation.
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the time of the reservation.
     *
     * @param string $time The new time of the reservation.
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    public function getTimeStr()
    {
        return $this->date->format('Y-m-d H:i:s');
    }

    /**
     * Set the creation time of the physical data record.
     *
     * @param DateTime $dateTime The new creation time of the physical data record.
     */
    public function setCreationTime(DateTime $dateTime){
        $this->date = $dateTime;
    }
    /**
     * Get the training personal trainer of the reservation.
     *
     * @return string The training personal trainer of the reservation.
     */
    public function getTrainingPT()
    {
        return $this->trainingPT;
    }

    /**
     * Set the training personal trainer of the reservation.
     *
     * @param string $trainingPT The new training personal trainer of the reservation.
     */
    public function setTrainingPT($trainingPT)
    {
        $this->trainingPT = $trainingPT;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }


}