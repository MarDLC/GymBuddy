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
    private static $value = "(NULL, :idUser,:date, :trainingPT, :time )";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "idReservation";

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
    // Bind the user ID to the corresponding parameter in the SQL statement
    $idUser = $reservation->getIdUser();
    if ($idUser !== null) {
        $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
        error_log("Binding user ID: $idUser");
    } else {
        // Handle the error, e.g., throw an exception or show an error message
        $errorMessage = 'User ID is null';
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }

    // Bind the date to the corresponding parameter in the SQL statement
    $stmt->bindValue(":date", $reservation->getDate(), PDO::PARAM_STR);
    // Bind the training PT of the reservation to the corresponding parameter in the SQL statement
    $stmt->bindValue(":trainingPT", $reservation->getTrainingPT(), PDO::PARAM_BOOL);
    // Bind the time of the reservation to the corresponding parameter in the SQL statement
    $stmt->bindValue(":time", $reservation->getTimeStr(), PDO::PARAM_STR);



}

/**
 * Create a reservation object from the query result
 *
 * @param array $queryResult The query result
 * @return EReservation|array The reservation object or an empty array if the query result is empty
 */
public static function createReservationObj($queryResult){
    $reservations= array();
    // Loop through the query result
    for($i = 0; $i < count($queryResult); $i++){
        $author= FRegisteredUser ::getObj($queryResult[$i]['idUser']);
        // Create a new Reservation object from the query result
        $reservation = new EReservation($author, $queryResult[$i]['date'],$queryResult[$i]['time'],$queryResult[$i]['trainingPT']);
        // Set the ID of the reservation in the Reservation object
        $reservation->setIdReservation($queryResult[$i]['idReservation']);
        // Convert the date string to a DateTime object and set the creation time
        $reservation->setCreationTime(DateTime::createFromFormat('Y-m-d', $queryResult[$i]['date']));
        // Add the Reservation object to the reservations array
        $reservations[] = $reservation;
    }
    // If the query result is empty, return an empty array
    return $reservations;
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
                FEntityManagerSQL::getInstance()->updateObj(FReservation::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdReservation());
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
    public static function deleteObj($id){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Delete the user object from the database
            $queryResult = FEntityManagerSQL::getInstance()->deleteObjInDb(FReservation::getTable(), self::getKey(), $id);
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // If the delete operation was successful, return true
            if($queryResult ){
                return true;
            } else {
                // If the delete operation was not successful, return false
                return false;
            }
        } catch(PDOException $e){
            // If an exception occurs, print the error message and rollback the transaction
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            // Return false to indicate that the delete operation was not successful
            return false;
        } finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }

    public static function countReservationsByDateAndTime($date, $time) {
        return FEntityManagerSQL::countReservations(self::getTable(), $date, $time);
    }

 public static function retrieveReservationsByTimeAndDate($date, $time)
{
    // Call the corresponding method in FEntityManagerSQL
    return FEntityManagerSQL::getInstance()->retrieveReservationsByTimeAndDate(self::getTable(), $date, $time);
}

    public static function retrieveReservationsByUserTimeAndDate($userId, $date, $time)
    {
        // Call the corresponding method in FEntityManagerSQL
        return FEntityManagerSQL::getInstance()->retrieveReservationsByUserTimeAndDate(self::getTable(), $userId, $date, $time);
    }

    public static function getReservationsByIdUser($userId) {
        // Retrieve the Reservation objects for the user
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), 'idUser', $userId);
        // If the result is not empty, create a Reservation object from the result
        if(count($result) > 0){
            $reservations = self::createReservationObj($result);
            return $reservations;
        } else {
            // If the result is empty, return null
            return null;
        }
    }


}