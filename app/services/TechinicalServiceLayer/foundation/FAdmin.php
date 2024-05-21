<?php
/**
 * Class FAdmin
 *
 * This class is responsible for handling operations related to the Admin entity.
 */
class FAdmin{

    /**
     * @var string $table The name of the table in the database.
     */
    private static $table = "admin";

    /**
     * @var string $value The value for the SQL query.
     */
    private static $value = "(:email)";

    /**
     * @var string $key The key for the SQL query.
     */
    private static $key = "email";

    /**
     * Get the table name.
     *
     * @return string The name of the table.
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Get the value for the SQL query.
     *
     * @return string The value for the SQL query.
     */
    public static function getValue(){
        return self::$value;
    }

    /**
     * Get the class name.
     *
     * @return string The name of the class.
     */
    public static function getClass(){
        return self::class;
    }

    /**
     * Get the key for the SQL query.
     *
     * @return string The key for the SQL query.
     */
    public static function getKey(){
        return self::$key;
    }

   /**
 * Create an Admin object from a query result.
 *
 * @param array $queryResult The result of the query.
 * @return EAdmin|array An Admin object if the query result is not empty, otherwise an empty array.
 */
public static function createAdminObj($queryResult){
    // Check if the query result is not empty
    if(count($queryResult) > 0){
        // Create a new Admin object using the first_name, last_name, email, password, and username from the query result
        $mod = new EAdmin($queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['email'], $queryResult[0]['password'], $queryResult[0]['username']);
        // Set the email of the Admin object
        $mod->setEmail($queryResult[0]['Email']);
        // Set the hashed password of the Admin object
        $mod->setHashedPassword($queryResult[0]['password']);
        // Return the Admin object
        return $mod;
    }else{
        // If the query result is empty, return an empty array
        return array();
    }
}

    /**
 * Bind the email parameter to the SQL statement.
 *
 * @param PDOStatement $stmt The SQL statement.
 * @param EUser $user The user object.
 */
public static function bind($stmt, $user){
    // Bind the email value from the user object to the ":email" parameter in the SQL statement
    $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
}

/**
 * Get an Admin object by email.
 *
 * @param string $email The email of the Admin.
 * @return EAdmin|null An Admin object if found, otherwise null.
 */
public static function getObj($email){
    // Use the singleton instance of FEntityManagerSQL to retrieve the user object from the database
    $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $email);

    // Check if the result is not empty
    if(count($result) > 0){
        // If the result is not empty, create an Admin object from the result
        $user = self::createAdminObj($result);
        // Return the Admin object
        return $user;
    }else{
        // If the result is empty, return null
        return null;
    }
}

    /**
 * Save an Admin object to the database.
 *
 * @param EAdmin $obj The Admin object to save.
 * @return bool|int The ID of the saved Admin object if successful, otherwise false.
 */
public static function saveObj($obj){
    // Use the singleton instance of FEntityManagerSQL to save the user part of the Admin object to the database
    $saveUser = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);

    // Check if the user part of the Admin object was saved successfully
    if($saveUser !== null){
        // If the user part was saved successfully, save the admin part of the Admin object to the database
        // The ID of the saved user part is used as the ID for the admin part
        $saveAdmin = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $saveUser);

        // Return the ID of the saved Admin object
        return $saveAdmin;
    }else{
        // If the user part of the Admin object was not saved successfully, return false
        return false;
    }
}

}