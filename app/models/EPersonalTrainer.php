<?php

// Include the EUser class
require_once ("EUser.php");

/**
 * Class EPersonalTrainer
 *
 * This class represents a personal trainer user in the application.
 * It extends the EUser class, inheriting all its properties and methods.
 * It has an additional property, $role, which is set to "personalTrainer".
 * It also has a static property, $entity, which is set to the class name.
 * The class does not have any methods apart from the getEntity method, which returns the class name.
 */
class EPersonalTrainer extends EUser {

    /**
     * @var string $role The role of the user. For a personal trainer user, this is set to "personalTrainer".
     */
    public $role = "personalTrainer";

    /**
     * @var string $entity The name of the class. This is set to PersonalTrainer::class.
     */
    private static $entity = PersonalTrainer::class;

    /**
     * Constructor for the EPersonalTrainer class.
     *
     * @param string $email The email of the personal trainer.
     * @param string $username The username of the personal trainer.
     * @param string $first_name The first name of the personal trainer.
     * @param string $last_name The last name of the personal trainer.
     * @param string $password The password of the personal trainer.
     */
    public function __construct($email, $username, $first_name, $last_name, $password)
    {
        parent::__construct($email, $username, $first_name, $last_name, $password);
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
}