<?php

/**
 * Class FTrainingCard
 *
 * This class is responsible for handling operations related to training cards.
 * It includes methods for getting table name, value, class name, key, binding values,
 * creating training card object, getting object, saving object, and deleting training card in database.
 */
class FTrainingCard{

    /**
     * @var string $table The name of the table in the database that this class interacts with.
     */
    private static $table = "trainingcard";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(NULL,:idUser,:creation,:exercises,:repetition,:recovery,:date)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "idTrainingCard";

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
     * Create a training card object from the query result
     *
     * @param array $queryResult The query result
     * @return ETrainingCard|array The training card object or an array of training card objects if the query result is more than one, or an empty array if the query result is empty
     */
    public static function createTrainingCardObj($queryResult){
        // If the query result contains only one record
        if(count($queryResult) == 1){
            $author = FPersonalTrainer::getObj($queryResult[0]['idUser']);
            // Create a new TrainingCard object from the query result
            $trainingCard = new ETrainingCard($author,$queryResult[0]['excercises'],$queryResult[0]['repetition'],$queryResult[0]['recovery']);
            // Set the id of the training card in the TrainingCard object
            $trainingCard->setIdTrainingCard($queryResult[0]['idTrainingCard']);
            // Use the date directly as it is already a DateTime object
            $trainingCard->setCreationTime($queryResult[0]['date']);

            // Return the created TrainingCard object
            return $trainingCard;
        }elseif(count($queryResult) > 1){
            // If the query result contains more than one record, create an array of TrainingCard objects
            $trainingCards = array();
            for($i = 0; $i < count($queryResult); $i++){
                $author = FPersonalTrainer::getObj($queryResult[$i]['idUser']);
                // Create a new TrainingCard object for each record in the query result
                $trainingCard = new ETrainingCard($author,$queryResult[$i]['excercises'],$queryResult[$i]['repetition'],$queryResult[$i]['recovery']);
                // Set the id of the training card in the TrainingCard object
                $trainingCard->setIdTrainingCard($queryResult[$i]['idTrainingCard']);
                // Use the date directly as it is already a DateTime object
                $trainingCard->setCreationTime($queryResult[$i]['date']);

                // Add the TrainingCard object to the array of TrainingCard objects
                $trainingCards[] = $trainingCard;
            }
            // Return the array of TrainingCard objects
            return $trainingCards;
        }else{
            // If the query result is empty, return an empty array
            return array();
        }
    }

    /**
     * Bind the values to the SQL statement
     *
     * @param PDOStatement $stmt The SQL statement
     * @param ETrainingCard $trainingCard The training card object
     */
    public static function bind($stmt, $trainingCard){
       $stmt->bindValue(":idUser", $trainingCard->getIdUser()->getId(), PDO::PARAM_INT);

        // Bind the exercises of the training card to the corresponding parameter in the SQL statement
        $stmt->bindValue(":exercises", $trainingCard->getExercises(), PDO::PARAM_STR);
        // Bind the repetition of the training card to the corresponding parameter in the SQL statement
        $stmt->bindValue(":repetition", $trainingCard->getRepetition(), PDO::PARAM_STR);
        // Bind the recovery of the training card to the corresponding parameter in the SQL statement
        $stmt->bindValue(":recovery", $trainingCard->getRecovery(), PDO::PARAM_STR);
        $stmt->bindValue(":date", $trainingCard->getTimeStr(), PDO::PARAM_STR);

    }

    /**
     * Get a training card object by its ID
     *
     * @param int $id The ID of the training card
     * @return ETrainingCard|null The training card object or null if not found
     */
    public static function getObj($id){
        // Retrieve the training card object from the database using the provided ID
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
        // If the result is not empty, create a TrainingCard object from the result and return it
        if(count($result) > 0){
            $trainingCard = self::createTrainingCardObj($result);
            return $trainingCard;
        }else{
            // If the result is empty, return null
            return null;
        }
    }

    /**
     * Save a training card object to the database
     *
     * @param ETrainingCard $obj The training card object
     * @param array|null $fieldArray The fields to be updated
     * @return bool True if the operation was successful, false otherwise
     */
    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            // Save the training card object
            $saveTrainingCard = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            // If the save operation was successful, return true
            if($saveTrainingCard !== null){
                return $saveTrainingCard;
            }else{
                // If the save operation was not successful, return false
                return false;
            }
        }else{
            // If fieldArray is not null, we are updating an existing training card
            try{
                // Start a new database transaction
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // Loop through the fieldArray and update the training card fields
                foreach($fieldArray as $fv){
                    // Update the training card field in the training card table
                    FEntityManagerSQL::getInstance()->updateObj(FTrainingCard::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdTrainingCard());
                }
                // Commit the transaction after updating the training card fields
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
     * Delete a training card from the database by its ID
     *
     * @param int $idTrainingCard The ID of the training card
     * @return bool True if the operation was successful, false otherwise
     */
    public static function deleteTrainingCardInDb($idTrainingCard){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Delete the training card from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idTrainingCard);
            // Commit the transaction if the delete operation was successful
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // Return true if the training card was deleted successfully
            if($queryResult ){
                return true;
            } else {
                // Return false if the training card was not deleted successfully
                return false;
            }
        } catch(PDOException $e){
            // If an exception occurs, print the error message, rollback the transaction, and return false
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        } finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }

    public static function getTrainingCardsByIdUserl($idUser){
        // Retrieve the TrainingCard objects for the client
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), 'idUser', $idUser);
        // If the result is not empty, create a TrainingCard object from the result
        if(count($result) > 0){
            $trainingCards = self::createTrainingCardObj($result);
            return $trainingCards;
        }else{
            // If the result is empty, return null
            return null;
        }
    }

}