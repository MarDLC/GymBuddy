<?php

/**
 * Class EPhysicalData
 *
 * This class represents the physical data of a registered user in the application.
 * It includes properties for id, email of registered user, sex, height, weight, lean mass, fat mass, bmi, date, and email of personal trainer.
 * It also includes methods for getting and setting these properties.
 */
class EPhysicalData {

    //TODO PHPDOC
    protected $personalTrainer;

    /**
     * @var int $idPhysicalData The ID of the physical data record.
     */
    private $idPhysicalData;

    /**
     * @var string $emailRegisteredUser The email of the registered user.
     */
    private $emailRegisteredUser;

    /**
     * @var string $sex The sex of the registered user.
     */
    private $sex;

    /**
     * @var float $height The height of the registered user.
     */
    private $height;

    /**
     * @var float $weight The weight of the registered user.
     */
    private $weight;

    /**
     * @var float $leanMass The lean mass of the registered user.
     */
    private $leanMass;

    /**
     * @var float $fatMass The fat mass of the registered user.
     */
    private $fatMass;

    /**
     * @var float $bmi The Body Mass Index (BMI) of the registered user.
     */
    private $bmi;

    /**
     * @var DateTime $date The date of the physical data record.
     */
    private DateTime $date;

    /**
     * @var string $emailPersonalTrainer The email of the personal trainer.
     */
    private $emailPersonalTrainer;

    /**
     * @var string $entity The name of the class. This is set to EPhysicalData::class.
     */
    private static $entity = EPhysicalData::class;

    /**
     * Constructor for the EPhysicalData class.
     *
     * @param string $emailRegisteredUser The email of the registered user.
     * @param string $sex The sex of the registered user.
     * @param float $height The height of the registered user.
     * @param float $weight The weight of the registered user.
     * @param float $leanMass The lean mass of the registered user.
     * @param float $fatMass The fat mass of the registered user.
     * @param float $bmi The Body Mass Index (BMI) of the registered user.
     */
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
 * Get the date of the physical data record.
 *
 * @return DateTime The date of the physical data record.
 */
public function getTime()
{
    return $this->date;
}

/**
 * Set the current date and time as the date of the physical data record.
 */
private function setTime()
{
    $this->date = new DateTime("now");
}

/**
 * Get the date of the physical data record as a string.
 *
 * @return string The date of the physical data record in 'Y-m-d H:i:s' format.
 */
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
 * Get the sex of the registered user.
 *
 * @return string The sex of the registered user.
 */
public function getSex()
{
    return $this->sex;
}

/**
 * Set the sex of the registered user.
 *
 * @param string $sex The new sex of the registered user.
 */
public function setSex($sex)
{
    $this->sex = $sex;
}

/**
 * Get the height of the registered user.
 *
 * @return float The height of the registered user.
 */
public function getHeight()
{
    return $this->height;
}

/**
 * Set the height of the registered user.
 *
 * @param float $height The new height of the registered user.
 */
public function setHeight($height)
{
    $this->height = $height;
}

   /**
 * Get the weight of the registered user.
 *
 * @return float The weight of the registered user.
 */
public function getWeight()
{
    return $this->weight;
}

/**
 * Set the weight of the registered user.
 *
 * @param float $weight The new weight of the registered user.
 */
public function setWeight($weight)
{
    $this->weight = $weight;
}

/**
 * Get the lean mass of the registered user.
 *
 * @return float The lean mass of the registered user.
 */
public function getLeanMass()
{
    return $this->leanMass;
}

/**
 * Set the lean mass of the registered user.
 *
 * @param float $leanMass The new lean mass of the registered user.
 */
public function setLeanMass($leanMass)
{
    $this->leanMass = $leanMass;
}

/**
 * Get the fat mass of the registered user.
 *
 * @return float The fat mass of the registered user.
 */
public function getFatMass()
{
    return $this->fatMass;
}

/**
 * Set the fat mass of the registered user.
 *
 * @param float $fatMass The new fat mass of the registered user.
 */
public function setFatMass($fatMass)
{
    $this->fatMass = $fatMass;
}

/**
 * Get the Body Mass Index (BMI) of the registered user.
 *
 * @return float The Body Mass Index (BMI) of the registered user.
 */
public function getBmi()
{
    return $this->bmi;
}

/**
 * Set the Body Mass Index (BMI) of the registered user.
 *
 * @param float $bmi The new Body Mass Index (BMI) of the registered user.
 */
public function setBmi($bmi)
{
    $this->bmi = $bmi;
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
 * Get the ID of the physical data record.
 *
 * @return int The ID of the physical data record.
 */
public function getIdPhysicalData()
{
    return $this->idPhysicalData;
}

/**
 * Set the ID of the physical data record.
 *
 * @param int $idPhysicalData The new ID of the physical data record.
 */
public function setIdPhysicalData($idPhysicalData)
{
    $this->idPhysicalData = $idPhysicalData;
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
