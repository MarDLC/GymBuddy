<?php

/**
 * Class FPersonalTrainer
 *
 * This class represents a personal trainer in the system. It provides methods for retrieving, binding, creating, and saving personal trainer objects.
 */
class FPersonalTrainer{

    /**
     * @var string The name of the table in the database where personal trainers are stored.
     */
    private static $table = "PersonalTrainer";

    /**
     * @var string The value to be used in SQL queries.
     */
    private static $value = "(:idUser,:approved)";

    /**
     * @var string The key to be used in SQL queries.
     */
    private static $key = "idUser";

    /**
     * Returns the name of the table where personal trainers are stored.
     *
     * @return string The name of the table.
     */
    public static function getTable(){
        return self::$table;
    }

    /**
     * Returns the value to be used in SQL queries.
     *
     * @return string The value.
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
     * Returns the key to be used in SQL queries.
     *
     * @return string The key.
     */
    public static function getKey(){
        return self::$key;
    }

    /**
     * Binds the given user's id to the given statement.
     *
     * @param PDOStatement $stmt The statement to bind the user's idto.
     * @param EPersonalTrainer $user The user whose email to bind.
     */
    public static function bind($stmt, $personaltrainer,$id){
        $stmt->bindValue(":idUser", $id->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":approved", $personaltrainer->isApproved(), PDO::PARAM_BOOL);

    }

    /**
     * Creates a personal trainer object or an array of personal trainer objects from the given query result.
     *
     * @param array $queryResult The query result to create the personal trainer object(s) from.
     * @return EPersonalTrainer|array The created personal trainer object or array of personal trainer objects.
     */
    public static function createPersonalTrainerObj($queryResult){
        if(count($queryResult) == 1){
            // If there is only one result, create a single user object.
            $personalTrainer = new EPersonalTrainer($queryResult[0]['email'], $queryResult[0]['username'], $queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['password']);
            $personalTrainer->setId($queryResult[0]['idUser']);
            if (isset($queryResult[0]['approved'])) {
                $personalTrainer->setApproved($queryResult[0]['approved']);
            }
            return $personalTrainer;
        } elseif(count($queryResult) > 1){
            // If there are multiple results, create an array of user objects.
            $personalTrainers = array();
            for($i = 0; $i < count($queryResult); $i++){
                $personalTrainer = new EPersonalTrainer($queryResult[$i]['email'], $queryResult[$i]['username'], $queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['password']);
                $personalTrainer->setId($queryResult[$i]['idUser']);
                if (isset($queryResult[$i]['approved'])) {
                    $personalTrainer->setApproved($queryResult[$i]['approved']);
                }
                $personalTrainers[] = $personalTrainer;
            }
            return $personalTrainers;
        } else{
            // If there are no results, return an empty array.
            return array();
        }
    }

    /**
 * Retrieves a personal trainer object with the given email.
 *
 * @param string $email The email of the personal trainer to retrieve.
 * @return EPersonalTrainer|null The retrieved personal trainer object, or null if no personal trainer was found.
 */
    public static function getObj($id){
        // Retrieve the personal trainer object from the database using the given email
        $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $id);
        // Check if the query returned any results
        if(count($result) > 0){
            // If results were found, create a personal trainer object from the result
            $personalTrainer = self::createPersonalTrainerObj($result);
            // Return the created personal trainer object
            return $personalTrainer;
        }else{
            // If no results were found, return null
            return null;
        }
    }

    /**
     * Saves the given personal trainer object to the database.
     *
     * If the given field array is null, a new personal trainer is saved. Otherwise, an existing personal trainer is updated.
     *
     * @param EPersonalTrainer $obj The personal trainer object to save.
     * @param array|null $fieldArray The array of fields to update, or null to save a new personal trainer.
     * @return string|bool The last inserted email if a new personal trainer was saved, true if an existing personal trainer was updated, or false if the save operation was not successful.
     */
    public static function saveObj($obj, $fieldArray = null){
        // Check if fieldArray is null, which means we are saving a new user
        if($fieldArray === null){
            try{
                // Start a new database transaction
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // Save the user object and get the last inserted email
                $savePersonAndLastInsertedID = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);
                // If the save operation was successful, save the user object with the last inserted email
                if($savePersonAndLastInsertedID !== null) {
                    // Save the user object with the last inserted email
                    $savePersonalTrainer = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $savePersonAndLastInsertedID);
                    // If the user was saved successfully, commit the transaction and return the last inserted email
                    if ($savePersonalTrainer) {
                        FEntityManagerSQL::getInstance()->getDb()->commit();
                        return $savePersonAndLastInsertedID;
                    }
                }
                // if the save operation was not successful, return false
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
                    // If the field is not username or password, update the user field in the personal trainer table
                    if($fv[0] != "username" && $fv[0] != "password"){
                        // Update the user field in the personal trainer table
                        FEntityManagerSQL::getInstance()->updateObj(FPersonalTrainer::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                    }else{
                        // if the field is username or password, update the user field in the user table
                        FEntityManagerSQL::getInstance()->updateObj(FUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
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


    public static function deletePersonalTrainerObj($id){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Delete the user object from the database
            FEntityManagerSQL::getInstance()->deleteObjInDb(FUser::getTable(), self::getKey(), $id);
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

    public static function getListEmailsOfFollowedUsers() {
    // Get the rows where type is 'followed_user'
    $rows = FEntityManagerSQL::retriveObj('registereduser', 'type', 'followed_user');

    // Initialize an empty array to hold the emails
    $emails = array();

    // Iterate over the rows
    foreach ($rows as $row) {
        // Add the email to the array
        $emails[] = $row['email'];
    }

    // Return the array of emails
    return $emails;
}

    public static function getTrainingCardsOfClient($emailRegisteredUser) {
        // Retrieve the TrainingCard objects for the client
        return FTrainingCard::getTrainingCardsByEmail($emailRegisteredUser);
    }

    public static function getPhysicalDataOfClient($idUser) {
        // Retrieve the PhysicalData objects for the client
        return FPhysicalData::getPhysicalDataByIdUser($idUser);
    }

    public static function getUnapprovedTrainers() {
        // Retrieve the unapproved trainer data from the database
        $results = FEntityManagerSQL::retrieveDataWithCondition('EPersonalTrainer', 'approved', 0);

        // Convert the results into PersonalTrainer objects
        $trainers = [];
        foreach ($results as $row) {
            $trainer = self::createPersonalTrainerObj($row);
            $trainers[] = $trainer;
        }

        // Return the array of unapproved PersonalTrainer objects
        return $trainers;
    }




}
