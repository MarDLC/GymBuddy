<?php
// Include the EUser class
require_once ("EUser.php");

/**
 * Class EAdmin
 *
 * This class represents an admin user in the application.
 * It extends the EUser class, inheriting all its properties and methods.
 * It has an additional property, $role, which is set to "admin".
 * It also has a static property, $entity, which is set to the class name.
 * The class does not have any methods apart from the getEntity method, which returns the class name.
 */
class EAdmin extends EUser {

    /**
     * @var string $role The role of the user. For an admin user, this is set to "admin".
     */
    public $role = "admin";

    /**
     * @var string $entity The name of the class. This is set to EAdmin::class.
     */
    private static $entity = EAdmin::class;

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