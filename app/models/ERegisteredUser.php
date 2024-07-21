<?php

// Include the EUser class
require_once("EUser.php");

/**
 * Class ERegisteredUser
 *
 * This class represents a registered user in the application.
 * It extends the EUser class, inheriting all its properties and methods.
 * It has an additional property, $role, which is set to "registeredUser".
 * It also has a static property, $entity, which is set to the class name.
 * The class does not have any methods apart from the getEntity method, which returns the class name.
 */
class ERegisteredUser extends EUser {

   /**
    * @var string|null $type The type of the registered user. This is used to store the type of subscription the user has.
    * It is set to null by default, meaning the user does not have a subscription yet.
    */
    protected $type;

    /**
     * @var string $role The role of the user. For a registered user, this is set to "registeredUser".
     */
    public $role = "registeredUser";

    /**
     * @var string $entity The name of the class. This is set to ERegisteredUser::class.
     */
    private static $entity = ERegisteredUser::class;

   /**
 * Constructor for the ERegisteredUser class.
 *
 * This constructor initializes a new instance of the ERegisteredUser class.
 * It takes five parameters: email, username, first_name, last_name, and password.
 * These parameters are used to set the corresponding properties of the ERegisteredUser instance.
 * The constructor also calls the parent constructor (from the EUser class) with the same parameters.
 * Finally, it sets the type property of the ERegisteredUser instance to null, indicating that the user does not have a subscription yet.
 *
 * @param string $email The email of the registered user. This is used as the unique identifier for the user.
 * @param string $username The username of the registered user. This is used for display purposes and for user login.
 * @param string $first_name The first name of the registered user. This is used for display purposes.
 * @param string $last_name The last name of the registered user. This is used for display purposes.
 * @param string $password The password of the registered user. This is used for user login.
 */
public function __construct($email, $username, $first_name, $last_name, $password)
{
    parent::__construct($email, $username, $first_name, $last_name, $password);
    $this->type = null;
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
 * Get the type of the registered user.
 *
 * This method returns the type of the registered user. The type represents the type of subscription the user has.
 * If the user does not have a subscription, the type is null.
 *
 * @return string|null The type of the registered user.
 */
public function getType()
{
    return $this->type;
}


    public function getIdUser() {
        return $this->idUser;
    }

/**
 * Set the type of the registered user.
 *
 * This method sets the type of the registered user. The type represents the type of subscription the user has.
 * If the user does not have a subscription, the type should be set to null.
 *
 * @param string|null $type The type of the registered user.
 */
public function setType($type)
{
    $this->type = $type;
}
}