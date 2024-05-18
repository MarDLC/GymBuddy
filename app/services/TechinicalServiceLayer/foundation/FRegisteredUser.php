<?php

/**
 * Class FRegisteredUser
 *
 * This class is responsible for handling operations related to registered users.
 */

class FRegisteredUser{

    private static $table = "registereduser";

    private static $value = "(:email)";

    private static $key = "email";

    /**
     * Get the table name.
     *
     * @return string The table name.
     */

    public static function getTable(){
        return self::$table;
    }


    /**
     * Get the value.
     *
     * @return string The value.
     */

    public static function getValue(){
        return self::$value;
    }

    /**
     * Get the class name.
     *
     * @return string The class name.
     */
    public static function getClass(){
        return self::class;
    }

    /**
     * Get the key.
     *
     * @return string The key.
     */
    public static function getKey(){
        return self::$key;
    }

    /**
 * This function creates user objects from the query result.
 *
 * @param array $queryResult The result of the database query.
 *
 * @return array|EUser Returns an array of user objects if there are multiple results, a single user object if there is one result, or an empty array if there are no results.
 */
public static function createUserObj($queryResult){
    if(count($queryResult) == 1){
        // If there is only one result, create a single user object.
        $user = new EUser($queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['email'], $queryResult[0]['password'], $queryResult[0]['username']);
        return $user;
    } elseif(count($queryResult) > 1){
        // If there are multiple results, create an array of user objects.
        $users = array();
        for($i = 0; $i < count($queryResult); $i++){
            $user = new EUser($queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['email'], $queryResult[$i]['password'], $queryResult[$i]['username']);
            $users[] = $user;
        }
        return $users;
    } else{
        // If there are no results, return an empty array.
        return array();
    }
}
     /**
     * Bind the email to the statement.
     *
     * @param PDOStatement $stmt The statement to bind the email to.
     * @param string $email The email to bind.
     */
    public static function bind($stmt,$email){
    $stmt->bindValue(":email", $email, PDO::PARAM_STR);
    }

    /**
     * Get a user object by email.
     *
     * @param string $email The email of the user.
     *
     * @return EUser|null The user object if found, null otherwise.
     */
    public static function getObj($email){
    $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $email);
    //var_dump($result);
    if(count($result) > 0){
        $user = self::createUserObj($result);
        return $user;
    }else{
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
    // Check if fieldArray is null, which means we are saving a new user
    if($fieldArray === null){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Save the user object and get the last inserted email
            $savePersonAndLastInsertedEmail = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);
            // Check if the save operation was successful
            if($savePersonAndLastInsertedEmail !== null){
                // Save the user object with the last inserted email
                $saveUser = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $savePersonAndLastInsertedEmail);
                // Commit the transaction if the save operation was successful
                FEntityManagerSQL::getInstance()->getDb()->commit();
                // Return the last inserted email if the user was saved successfully
                if($saveUser){
                    return $savePersonAndLastInsertedEmail;
                }
            }else{
                // Return false if the save operation was not successful
                return false;
            }
        }catch(PDOException $e){
            // Print the error message and rollback the transaction in case of an exception
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
                // Check if the field is not username or password
                if($fv[0] != "username" && $fv[0] != "password"){
                    // Update the user field in the registered user table
                    FEntityManagerSQL::getInstance()->updateObj(FRegisteredUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
                }else{
                    // Update the user field in the user table
                    FEntityManagerSQL::getInstance()->updateObj(FUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
                }
            }
            // Commit the transaction after updating the user fields
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

}
