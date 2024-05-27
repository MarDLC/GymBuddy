<?php

/**
 * Class ETrainingCard
 *
 * This class represents a training card in the application.
 * It includes properties for id, email of registered user, creation date, exercises, repetition, recovery, and email of personal trainer.
 * It also includes methods for getting and setting these properties.
 */
class ETrainingCard {

    /**
     * @var int $idTrainingCard The ID of the training card.
     */
    private $idTrainingCard;

    /**
     * @var string $emailRegisteredUser The email of the registered user.
     */
    private $emailRegisteredUser;

   //TODO PHPDOC
    protected $personalTrainer;

    /**
     * @var DateTime $creation The creation date of the training card.
     */
    private DateTime $creation;

    /**
     * @var string $exercises The exercises in the training card.
     */
    private $exercises;

    /**
     * @var int $repetition The repetition count for the exercises.
     */
    private $repetition;

    /**
     * @var string $recovery The recovery time after the exercises.
     */
    private $recovery;

    /**
     * @var string $emailPersonalTrainer The email of the personal trainer.
     */
    private $emailPersonalTrainer;

    /**
     * @var string $entity The name of the class. This is set to ETrainingCard::class.
     */
    private static $entity = ETrainingCard::class;

    /**
     * Constructor for the ETrainingCard class.
     *
     * @param string $emailRegisteredUser The email of the registered user.
     * @param string $exercises The exercises in the training card.
     * @param int $repetition The repetition count for the exercises.
     * @param string $recovery The recovery time after the exercises.
     */
    public function __construct($emailRegisteredUser, $exercises, $repetition, $recovery)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
        $this->exercises = $exercises;
        $this->repetition = $repetition;
        $this->recovery = $recovery;
        $this->setTime();
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
     * Get the email of the registered user.
     *
     * @return string The email of the registered user.
     */
    public function getEmailRegisteredUser()
    {
        return $this->emailRegisteredUser;
    }

    /**
     * Set the email of the registered user.
     *
     * @param string $emailRegisteredUser The new email of the registered user.
     */
    public function setEmailRegisteredUser($emailRegisteredUser)
    {
        $this->emailRegisteredUser = $emailRegisteredUser;
    }

    /**
     * Get the creation date of the training card.
     *
     * @return DateTime The creation date of the training card.
     */
    public function getTime()
    {
        return $this->creation;
    }

    /**
     * Set the current date and time as the creation date of the training card.
     */
    private function setTime()
    {
        $this->creation = new DateTime("now");
    }

    /**
     * Get the creation date of the training card as a string.
     *
     * @return string The creation date of the training card in 'Y-m-d H:i:s' format.
     */
    public function getTimeStr()
    {
        return $this->creation->format('Y-m-d H:i:s');
    }

    /**
     * Set the creation date of the training card.
     *
     * @param DateTime $dateTime The new creation date of the training card.
     */
    public function setCreationTime(DateTime $dateTime){
        $this->creation = $dateTime;
    }

    /**
     * Get the exercises in the training card.
     *
     * @return string The exercises in the training card.
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * Set the exercises in the training card.
     *
     * @param string $exercises The new exercises in the training card.
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }


    /**
 * Get the repetition count for the exercises.
 *
 * @return int The repetition count for the exercises.
 */
public function getRepetition()
{
    return $this->repetition;
}

/**
 * Set the repetition count for the exercises.
 *
 * @param int $repetition The new repetition count for the exercises.
 */
public function setRepetition($repetition)
{
    $this->repetition = $repetition;
}

/**
 * Get the recovery time after the exercises.
 *
 * @return string The recovery time after the exercises.
 */
public function getRecovery()
{
    return $this->recovery;
}

/**
 * Set the recovery time after the exercises.
 *
 * @param string $recovery The new recovery time after the exercises.
 */
public function setRecovery($recovery)
{
    $this->recovery = $recovery;
}

/**
 * Get the email of the personal trainer.
 *
 * @return string The email of the personal trainer.
 */
public function getEmailPersonalTrainer()
{
    return $this->emailPersonalTrainer;
}

/**
 * Set the email of the personal trainer.
 *
 * @param string $emailPersonalTrainer The new email of the personal trainer.
 */
public function setEmailPersonalTrainer($emailPersonalTrainer)
{
    $this->emailPersonalTrainer = $emailPersonalTrainer;
}

/**
 * Get the ID of the training card.
 *
 * @return int The ID of the training card.
 */
public function getIdTrainingCard()
{
    return $this->idTrainingCard;
}

/**
 * Set the ID of the training card.
 *
 * @param int $idTrainingCard The new ID of the training card.
 */
public function setIdTrainingCard($idTrainingCard)
{
    $this->idTrainingCard = $idTrainingCard;
}

public function getPersonalTrainer()
{
    return $this->personalTrainer;
}

public function setPersonalTrainer(EPersonalTrainer $personalTrainer):void
{
    $this->personalTrainer = $personalTrainer;
}


}
