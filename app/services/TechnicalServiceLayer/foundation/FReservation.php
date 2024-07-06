<?php

/**
 * Class FReservation
 *
 * This class is responsible for handling operations related to reservations.
 * It includes methods for getting table name, value, class name, key, binding values,
 * creating reservation object, getting object, saving object, and deleting reservation in database.
 */
class FReservation{

    /**
     * @var string $table The name of the table in the database that this class interacts with.
     */
    private static $table = "reservation";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(:emailRegisteredUser,:date,:time,:TrainingPT,:emailPersonalTrainer)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "emailRegisteredUser";

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
 * Bind the values to the SQL statement
 *
 * @param PDOStatement $stmt The SQL statement
 * @param EReservation $reservation The reservation object
 */
public static function bind($stmt, $reservation){
    // Bind the email of the registered user to the corresponding parameter in the SQL statement
    $stmt->bindValue(":emailRegisteredUser", $reservation->getEmailRegisteredUser(), PDO::PARAM_STR);
    // Bind the date of the reservation to the corresponding parameter in the SQL statement
    $stmt->bindValue(":date", $reservation->getDate(), PDO::PARAM_STR);
    // Bind the time of the reservation to the corresponding parameter in the SQL statement
    $stmt->bindValue(":time", $reservation->getTime(), PDO::PARAM_STR);
    // Bind the training PT of the reservation to the corresponding parameter in the SQL statement
    $stmt->bindValue(":TrainingPT", $reservation->getTrainingPT(), PDO::PARAM_BOOL);
    // Bind the email of the personal trainer to the corresponding parameter in the SQL statement
    $stmt->bindValue(":emailPersonalTrainer", $reservation->getEmailPersonalTrainer(), PDO::PARAM_STR);
}

/**
 * Create a reservation object from the query result
 *
 * @param array $queryResult The query result
 * @return EReservation|array The reservation object or an empty array if the query result is empty
 */
public static function createReservationObj($queryResult){
    // If the query result contains only one record
    if(count($queryResult) == 1){
        // Create a new Reservation object from the query result
        $reservation = new EReservation($queryResult[0]['emailRegisteredUser'],$queryResult[0]['date'],$queryResult[0]['time'],$queryResult[0]['trainingPT']);
        // Set the email of the registered user in the Reservation object
        $reservation->setEmailRegisteredUser($queryResult[0]['emailRegisteredUser']);
        // Set the creation time in the Reservation object
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        $reservation->setCreationTime($dateTime);
        // Set the email of the personal trainer in the Reservation object
        $reservation->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
        // Return the created Reservation object
        return $reservation;
    }else{
        // If the query result is empty, return an empty array
        return array();
    }
}

/**
 * Get a reservation object by its ID
 *
 * @param int $id The ID of the reservation
 * @return EReservation|null The reservation object or null if not found
 */
public static function getObj($id){
    // Retrieve the reservation object from the database using the provided ID
    $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
    // If the result is not empty, create a Reservation object from the result and return it
    if(count($result) > 0){
        $reservation = self::createReservationObj($result);
        return $reservation;
    }else{
        // If the result is empty, return null
        return null;
    }
}
   /**
 * Save a reservation object to the database
 *
 * If the $fieldArray parameter is null, it will save a new reservation. Otherwise, it will update the fields of an existing reservation.
 *
 * @param EReservation $obj The reservation object to save. This should be an instance of the EReservation class.
 * @param array|null $fieldArray An associative array where the keys are the field names and the values are the new values for the fields. If this parameter is null, a new reservation will be saved.
 *
 * @return bool True if the operation was successful, false otherwise.
 */
public static function saveObj($obj , $fieldArray = null){
    // If fieldArray is null, we are saving a new reservation
    if($fieldArray === null){
        // Save the reservation object
        $saveReservation = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
        // If the save operation was successful, return true
        if($saveReservation !== null){
            return $saveReservation;
        }else{
            // If the save operation was not successful, return false
            return false;
        }
    }else{
        // If fieldArray is not null, we are updating an existing reservation
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Loop through the fieldArray and update the reservation fields
            foreach($fieldArray as $fv){
                // Update the reservation field in the reservation table
                FEntityManagerSQL::getInstance()->updateObj(FReservation::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmailRegisteredUser());
            }
            // Commit the transaction after updating the reservation fields
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // Return true if the update operation was successful
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

/**
 * Delete a reservation from the database by the registered user's email
 *
 * @param string $emailRegisteredUser The email of the registered user
 * @return bool True if the operation was successful, false otherwise
 */
    public static function deleteObj($email){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Delete the user object from the database
            FEntityManagerSQL::getInstance()->deleteObjInDb(FReservation::getTable(), self::getKey(), $email);
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