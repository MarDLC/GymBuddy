<?php

class FPersonalTrainer{

    private static $table = "personaltrainer";

    private static $value = "(:email)";

    private static $key = "email";

    public static function getTable(){
        return self::$table;
    }

    public static function getValue(){
        return self::$value;
    }

    public static function getClass(){
        return self::class;
    }

    public static function getKey(){
        return self::$key;
    }

    public static function bind($stmt, $user){
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
    }

    public static function createPersolTrainerObj($queryResult){
        if(count($queryResult) == 1){
            // If there is only one result, create a single user object.
            $personalTrainer = new EPersonalTrainer($queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['email'], $queryResult[0]['password'], $queryResult[0]['username']);
            return $personalTrainer;
        } elseif(count($queryResult) > 1){
            // If there are multiple results, create an array of user objects.
            $personalTrainers = array();
            for($i = 0; $i < count($queryResult); $i++){
                $personalTrainer = new EPersonalTrainer($queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['email'], $queryResult[$i]['password'], $queryResult[$i]['username']);
                $personalTrainers[] = $personalTrainer;
            }
            return $personalTrainers;
        } else{
            // If there are no results, return an empty array.
            return array();
        }
    }

    public static function getObj($email){
        $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $email);
        //var_dump($result);
        if(count($result) > 0){
            $personalTrainer = self::createUserObj($result);
            return $personalTrainer;
        }else{
            return null;
        }
    }

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
                    $savePersonalTrainer = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $savePersonAndLastInsertedEmail);
                    // Commit the transaction if the save operation was successful
                    FEntityManagerSQL::getInstance()->getDb()->commit();
                    // Return the last inserted email if the user was saved successfully
                    if($savePersonalTrainer){
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
                        FEntityManagerSQL::getInstance()->updateObj(FPersonalTrainer::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
                    }else{
                        // Update the user field in the user table
                        FEntityManagerSQL::getInstance()->updateObj(FPersonalTrainer::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
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
