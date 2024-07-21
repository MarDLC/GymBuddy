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
    private static $value = "(:idUser,NULL, :exercises,:repetition,:recovery,:date)";

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


    /*
 public static function createTrainingCardObj($queryResult){
    // Initialize an array to hold the TrainingCard objects
    $trainingCards = array();

    // Loop through the query result
    for($i = 0; $i < count($queryResult); $i++){
        $author = FPersonalTrainer::getObj($queryResult[$i]['idUser']);
        // Check if the author is a valid FPersonalTrainer object
        if ($author === null) {
            // Handle the error, e.g., skip the current iteration or throw an exception
            continue;
        }
        // Create a new TrainingCard object for each record in the query result
        $trainingCard = new ETrainingCard($author,$queryResult[$i]['exercises'],$queryResult[$i]['repetition'],$queryResult[$i]['recovery']);
        // Set the id of the training card in the TrainingCard object
        $trainingCard->setIdTrainingCard($queryResult[$i]['idTrainingCard']);
        // Use the date directly as it is already a DateTime object
        $trainingCard->setCreationTime(new DateTime($queryResult[$i]['date']));

        // Add the TrainingCard object to the array of TrainingCard objects
        $trainingCards[] = $trainingCard;
    }

    // If the query result was a single record, return the single TrainingCard object
    if (count($queryResult) == 1) {
        return $trainingCards[0];
    }

    // Return the array of TrainingCard objects
    return $trainingCards;
} */




    public static function getTrainingCardsByIdUser($userId){
        // Retrieve the TrainingCard objects for the user
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), 'idUser', $userId);
        // If the result is not empty, create a TrainingCard object from the result
        if(count($result) > 0){
            $trainingCards = self::createTrainingCardObj($result);
            return $trainingCards;
        }else{
            // If the result is empty, return null
            return null;
        }
    }



    /**
     * Bind the values to the SQL statement
     *
     * @param PDOStatement $stmt The SQL statement
     * @param ETrainingCard $trainingCard The training card object
     */
    public static function bind($stmt, $trainingCard){
        $idUser = $trainingCard->getIdUser();
        if ($idUser !== null) {
            $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
            error_log("Binding user ID: $idUser");
        } else {
            // Handle the error, e.g., throw an exception or show an error message
            $errorMessage = 'User ID is null';
            error_log($errorMessage);
            throw new Exception($errorMessage);
        }

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

    public static function createTrainingCardObj($queryResult) {
        $trainingCards = [];
        foreach ($queryResult as $result) {
            $idUser = isset($result['idUser']) ? $result['idUser'] : null;
            $idTrainingCard = isset($result['idTrainingCard']) ? $result['idTrainingCard'] : null;
            $exercises = isset($result['exercises']) ? $result['exercises'] : null;
            $repetition = isset($result['repetition']) ? $result['repetition'] : null;
            $recovery = isset($result['recovery']) ? $result['recovery'] : null;
            $date = isset($result['date']) ? $result['date'] : null;

            // Log per debugging
            error_log("createTrainingCardObj - idUser: $idUser, idTrainingCard: $idTrainingCard, exercises: $exercises, repetition: $repetition, recovery: $recovery, date: $date");

            // Recupera l'oggetto utente utilizzando l'ID dell'utente
            $user = $idUser ? FRegisteredUser::getObj($idUser) : null;

            // Log per debugging
            error_log("createTrainingCardObj - user: " . print_r($user, true));

            // Assicurati di gestire correttamente gli eventuali valori nulli
            if ($user !== null && $idTrainingCard !== null && $exercises !== null && $repetition !== null && $recovery !== null && $date !== null) {
                // Crea l'oggetto usando i valori ottenuti
                $trainingCard = new ETrainingCard($user->getIdUser(), $exercises, $repetition, $recovery);
                $trainingCard->setIdTrainingCard($idTrainingCard);
                $trainingCard->setCreationTime(new DateTime($date));
                $trainingCards[] = $trainingCard;
            } else {
                // Gestisci l'errore appropriato
                error_log("Dati mancanti per creare l'oggetto TrainingCard");
                throw new Exception("Dati mancanti per creare l'oggetto TrainingCard");
            }
        }
        return $trainingCards;
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



}