<?php

/**
 * Class FUser
 *
 * This class represents the User entity in the database.
 * It provides methods to get the table name, value, class name, and key of the User entity.
 * It also provides a method to bind User entity attributes to a PDO statement.
 * Additionally, it provides a method to verify if a User entity exists in the database.
 */
class FUser{

    private static $table = "user";
    private static $value = "(:email,:username,:first_name,:last_name,:password,:discr)";
    private static $key = "email";

    /**
     * Get the table name of the User entity.
     *
     * @return string The table name.
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Get the value of the User entity.
     *
     * @return string The value.
     */
    public static function getValue(){
        return self::$value;
    }

    /**
     * Get the class name of the User entity.
     *
     * @return string The class name.
     */
    public static function getClass(){
        return self::class;
    }

    /**
     * Get the key of the User entity.
     *
     * @return string The key.
     */
    public static function getKey(){
        return self::$key;
    }

    /**
     * Bind the User entity attributes to a PDO statement.
     *
     * @param PDOStatement $stmt The PDO statement.
     * @param User $user The User entity.
     */
    public static function bind($stmt, $user){
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        $stmt->bindValue(":first_name", $user->getFirstName(), PDO::PARAM_STR);
        $stmt->bindValue(":last_name", $user->getLastName(), PDO::PARAM_STR);
        $stmt->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
        $stmt->bindValue(":discr", $user->discr, PDO::PARAM_STR);
    }

    /**
     * Verify if a User entity exists in the database.
     *
     * @param string $field The field to check.
     * @param string $id The id to check.
     * @return bool True if the User entity exists, false otherwise.
     */
    public static function verify($field, $id){
        $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

        return FEntityManagerSQL::getInstance()->existInDb($queryResult);
    }
}