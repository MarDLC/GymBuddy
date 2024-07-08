<?php

/**
 * Class FUser
 *
 * This class is responsible for handling operations related to users.
 * It includes methods for getting table name, value, class name, key, binding values,
 * and verifying if a user exists in the database.
 */
class FUser{

    /**
     * @var string $table The name of the table in the database that this class interacts with.
     */
    private static $table = "user";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(NULL,:email,:username,:first_name,:last_name,:password,:role)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "idUser";

    /**
     * Returns the name of the table this class interacts with.
     *
     * @return string The name of the table.
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Returns the SQL value string for inserting a new record into the table.
     *
     * @return string The SQL value string.
     */
    public static function getValue(){
        return self::$value;
    }

    /**
     * Returns the name of this class.
     *
     * @return string The name of this class.
     */
    public static function getClass(){
        return self::class;
    }

    /**
     * Returns the primary key of the table this class interacts with.
     *
     * @return string The primary key of the table.
     */
    public static function getKey(){
        return self::$key;
    }

   /**
 * Binds the User entity attributes to a PDO statement.
 *
 * This method is used to bind the values of a User entity to the corresponding parameters in a PDO statement.
 * This is done using the bindValue method of the PDOStatement object, which binds a value to a corresponding named or question mark placeholder in the SQL statement.
 * This method is typically called prior to executing a PDO statement that involves a User entity.
 *
 * @param PDOStatement $stmt The PDO statement that the User entity attributes are to be bound to.
 * @param User $user The User entity whose attributes are to be bound.
 */
    public static function bind($stmt, $user){
        // Bind the email of the user to the corresponding parameter in the SQL statement
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        // Bind the username of the user to the corresponding parameter in the SQL statement
        $stmt->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
        // Bind the first name of the user to the corresponding parameter in the SQL statement
        $stmt->bindValue(":first_name", $user->getFirstName(), PDO::PARAM_STR);
        // Bind the last name of the user to the corresponding parameter in the SQL statement
        $stmt->bindValue(":last_name", $user->getLastName(), PDO::PARAM_STR);
        // Bind the password of the user to the corresponding parameter in the SQL statement
        $stmt->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
        // Bind the discriminator of the user (used for inheritance) to the corresponding parameter in the SQL statement
        $stmt->bindValue(":role", $user->role, PDO::PARAM_STR);
    }

/**
 * Verifies if a User entity exists in the database.
 *
 * This method is used to check if a User entity exists in the database based on a specified field and id.
 * It does this by retrieving the User entity from the database using the specified field and id, and then checking if the retrieved entity exists.
 * This method is typically called when you want to check if a User entity exists in the database before performing operations that require the entity to exist.
 *
 * @param string $field The field to check. This is typically the name of a column in the User table in the database.
 * @param string $id The id to check. This is typically the value of the field for the User entity you are checking for.
 * @return bool True if the User entity exists in the database, false otherwise.
 */
public static function verify($field, $id){
    // Retrieve the User entity from the database using the specified field and id
    $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);
    // Check if the retrieved User entity exists in the database and return the result
    return FEntityManagerSQL::getInstance()->existInDb($queryResult);
}
}