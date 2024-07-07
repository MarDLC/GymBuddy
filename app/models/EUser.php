<?php

/**
 * Class EUser
 *
 * This class represents a user in the application.
 * It includes properties for email, username, first name, last name, and password.
 * It also includes methods for getting and setting these properties.
 */
class EUser {

    /**
     * @var int $idUser The id of the user.
     */
    protected $idUser;
    /**
     * @var string $email The email of the user.
     */
    protected $email;

    /**
     * @var string $username The username of the user.
     */
    protected $username;

    /**
     * @var string $first_name The first name of the user.
     */
    protected $first_name;

    /**
     * @var string $last_name The last name of the user.
     */
    protected $last_name;

    /**
     * @var string $password The hashed password of the user.
     */
    protected $password;

    /**
     * @var string $role The role of the user. Default is "user".
     */
    public $role = "user";

    /**
     * @var string $entity The name of the class. This is set to EUser::class.
     */
    private static $entity = EUser::class;

    /**
     * Constructor for the EUser class.
     *
     * @param string $email The email of the user.
     * @param string $username The username of the user.
     * @param string $first_name The first name of the user.
     * @param string $last_name The last name of the user.
     * @param string $password The password of the user. This will be hashed before being stored.
     */
    public function __construct($email, $username, $first_name, $last_name, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->email = $email;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->password = $hashedPassword;
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

    public function getId()
    {
        return $this->idUser;
    }

    public function setId($id)
    {
        $this->idUser = $id;
    }

    /**
     * Get the email of the user.
     *
     * @return string The email of the user.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the email of the user.
     *
     * @param string $email The new email of the user.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the username of the user.
     *
     * @return string The username of the user.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the username of the user.
     *
     * @param string $username The new username of the user.
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get the first name of the user.
     *
     * @return string The first name of the user.
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set the first name of the user.
     *
     * @param string $first_name The new first name of the user.
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * Get the last name of the user.
     *
     * @return string The last name of the user.
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set the last name of the user.
     *
     * @param string $last_name The new last name of the user.
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * Get the hashed password of the user.
     *
     * @return string The hashed password of the user.
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the password of the user. The password will be hashed before being stored.
     *
     * @param string $password The new password of the user.
     */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
    }

    /**
     * Set the hashed password of the user.
     *
     * @param string $hashedPassword The new hashed password of the user.
     */
    public function setHashedPassword($hashedPassword)
    {
        $this->password = $hashedPassword;
    }
}
