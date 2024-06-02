<?php

/**
 * Class FRegisteredUser
 *
 * This class is responsible for handling operations related to registered users.
 * It provides methods for interacting with the 'registereduser' table in the database.
 */
class FRegisteredUser{

    /**
     * @var string $table The name of the table in the database that this class interacts with.
     */
    private static $table = "registereduser";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(:email, :type)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "email";

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
 * Creates a RegisteredUser object from the given query result.
 *
 * @param array $queryResult The query result to create the RegisteredUser object from.
 * @return EUser|array|null The created RegisteredUser object, or an array of RegisteredUser objects, or null if no RegisteredUser object could be created.
 */
public static function createRegisteredUserObj($queryResult){
    // If the query result contains only one record
    if(count($queryResult) == 1){
        // Create a new RegisteredUser object from the query result
        $registeredUser = new ERegisteredUser($queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['email'], $queryResult[0]['password'], $queryResult[0]['username']);
        // Return the created RegisteredUser object
        return $registeredUser;
    // If the query result contains more than one record
    } elseif(count($queryResult) > 1){
        // Initialize an array to hold the RegisteredUser objects
        $registeredUsers = array();
        // Loop through each record in the query result
        for($i = 0; $i < count($queryResult); $i++){
            // Create a new RegisteredUser object from the current record
            $registeredUser = new EUser($queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['email'], $queryResult[$i]['password'], $queryResult[$i]['username']);
            // Add the RegisteredUser object to the array
            $registeredUsers[] = $registeredUser;
        }
        // Return the array of RegisteredUser objects
        return $registeredUsers;
    // If the query result is empty
    } else{
        // Return an empty array
        return array();
    }
}

/**
 * Binds the given email to the given PDOStatement's parameters.
 *
 * @param PDOStatement $stmt The PDOStatement to bind the parameters to.
 * @param string $email The email to bind.
 */
public static function bind($stmt,$email){
    // Bind the email to the corresponding parameter in the SQL statement
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
}

/**
 * Retrieves a RegisteredUser object with the given email.
 *
 * @param string $email The email of the RegisteredUser object to retrieve.
 * @return EUser|null The retrieved RegisteredUser object, or null if no RegisteredUser object was found.
 */
public static function getObj($email){
    // Retrieve the object from the database using the provided email
    $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $email);
    // If the result is not empty, create a RegisteredUser object from the result
    if(count($result) > 0){
        $registeredUser = self::createRegisteredUserObj($result);
        // Return the created RegisteredUser object
        return $registeredUser;
    }else{
        // If the result is empty, return null
        return null;
    }
}

  /**
 * Save a user object.
 *
 * This method is responsible for saving a user object to the database. It can either save a new user or update an existing one.
 * If the $fieldArray parameter is null, it will save a new user. Otherwise, it will update the fields of an existing user.
 *
 * @param EUser $obj The user object to save. This should be an instance of the EUser class.
 * @param array|null $fieldArray An associative array where the keys are the field names and the values are the new values for the fields. If this parameter is null, a new user will be saved.
 *
 * @return bool|string If a new user is saved, it returns the email of the last inserted user. If an existing user is updated, it returns true if the update was successful and false otherwise. If an error occurs during the saving process, it returns false.
 *
 * @throws PDOException If there is an error with the database operation, a PDOException will be thrown.
 */
public static function saveObj($obj, $fieldArray = null){
    // If fieldArray is null, we are saving a new user
    if($fieldArray === null){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Save the user object and get the last inserted email
            $savePersonAndLastInsertedEmail = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);
            // If the save operation was successful, save the user object with the last inserted email
            if($savePersonAndLastInsertedEmail !== null){
                $saveRegisteredUser = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $savePersonAndLastInsertedEmail);
                // If the user was saved successfully, commit the transaction and return the last inserted email
                if($saveRegisteredUser){
                    FEntityManagerSQL::getInstance()->getDb()->commit();
                    return $savePersonAndLastInsertedEmail;
                }
            }
            // If the save operation was not successful, return false
            return false;
        }catch(PDOException $e){
            // If an exception occurs, print the error message, rollback the transaction, and return false
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }else{
        // If fieldArray is not null, we are updating an existing user
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Loop through the fieldArray and update the user fields
            foreach($fieldArray as $fv){
                // If the field is not username or password, update the user field in the registered user table
                if($fv[0] != "username" && $fv[0] != "password"){
                    FEntityManagerSQL::getInstance()->updateObj(FRegisteredUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
                }else{
                    // If the field is username or password, update the user field in the user table
                    FEntityManagerSQL::getInstance()->updateObj(FRegisteredUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
                }
            }
            // After updating the user fields, commit the transaction and return true
            FEntityManagerSQL::getInstance()->getDb()->commit();
            return true;
        }catch(PDOException $e){
            // If an exception occurs, print the error message, rollback the transaction, and return false
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }
}

    public static function deleteObj($email){
        // Call the deleteObjInDb method of FEntityManagerSQL to delete the user
        $result = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $email);

        // Return the result of the delete operation
        return $result;
    }

    public static function deleteRegisteredUserObj($email){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Delete the user object from the database
            FEntityManagerSQL::getInstance()->deleteObjInDb(FUser::getTable(), self::getKey(), $email);
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            return true;
        }catch(PDOException $e){
            // Print the error message and rollback the transaction in case of an exception
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }


    /**
 * Retrieves a RegisteredUser object with the given username.
 *
 * @param string $username The username of the RegisteredUser object to retrieve.
 * @return EUser|null The retrieved RegisteredUser object, or null if no RegisteredUser object was found.
 */
public static function getUserByUsername($username)
{
    // Retrieve the user object from the database using the provided username
    $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), 'username', $username);

    // If the result is not empty, create a RegisteredUser object from the result and return it
    if(count($result) > 0){
        $registeredUser = self::createRegisteredUserObj($result);
        return $registeredUser;
    }else{
        // If the result is empty, return null
        return null;
    }
}

    public static function updateTypeIfSubscribedWithPT($email){
    try{
        // Start a new database transaction
        FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
        // Check if the user has a 'coached' subscription using the verifyFieldValue method
        if(FEntityManagerSQL::verifyFieldValue('subscription', 'type', 'coached')){
            // If the user has a 'coached' subscription, use the updateObj method of FEntityManagerSQL to update the user type
            FEntityManagerSQL::updateObj(self::getTable(), 'type', 'followed_user', 'email', $email);
        }
        // Commit the transaction
        FEntityManagerSQL::getInstance()->getDb()->commit();
        return true;
    }catch(PDOException $e){
        // Print the error message and rollback the transaction in case of an exception
        echo "ERROR " . $e->getMessage();
        FEntityManagerSQL::getInstance()->getDb()->rollBack();
        return false;
    }finally{
        // Close the database connection
        FEntityManagerSQL::getInstance()->closeConnection();
    }
}

    public static function updateTypeIfSubscribedUserOnly($email){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Check if the user has a 'individual' subscription using the verifyFieldValue method
            if(FEntityManagerSQL::verifyFieldValue('subscription', 'type', 'individual')){
                // If the user has a 'individual' subscription, use the updateObj method of FEntityManagerSQL to update the user type
                FEntityManagerSQL::updateObj(self::getTable(), 'type', 'user_only', 'email', $email);
            }
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            return true;
        }catch(PDOException $e){
            // Print the error message and rollback the transaction in case of an exception
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }


}
