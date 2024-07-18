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
    private static $value = "(:idUser)";

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
    public static function bind($stmt, $personaltrainer){
        $stmt->bindValue(":idUser", $personaltrainer->getId(), PDO::PARAM_INT);

    }



public static function createPersonalTrainerObj($queryResult){
    // Check if the query result is a multidimensional array
    if(isset($queryResult[0]) && is_array($queryResult[0])){
        // If the query result contains more than one record
        // Initialize an array to hold the PersonalTrainer objects
        $personalTrainers = array();
        // Loop through each record in the query result
        for($i = 0; $i < count($queryResult); $i++){
            // Create a new Personal Trainer object from the current record
            $personalTrainer = new EPersonalTrainer($queryResult[$i]['email'], $queryResult[$i]['username'], $queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['password']);
            $personalTrainer->setId($queryResult[$i]['idUser']);
            $personalTrainer->setHashedPassword($queryResult[$i]['password']);
            // Add the RegisteredUser object to the array
            $personalTrainers[] = $personalTrainer;
        }
        // Return the array of RegisteredUser objects
        return $personalTrainers;
    } else {
        // If the query result contains only one record
        // Create a new PersonalTrainer object from the query result
        $personalTrainer = new EPersonalTrainer($queryResult['email'], $queryResult['username'], $queryResult['first_name'], $queryResult['last_name'], $queryResult['password']);
        $personalTrainer->setId($queryResult['idUser']);
        $personalTrainer->setHashedPassword($queryResult['password']);
        // Return the created Personal Trainer object
        return $personalTrainer;
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


    public static function saveObj($obj, $fieldArray = null) {
        if ($fieldArray === null) {
            try {
                // Inizia una nuova transazione del database
                $db = FEntityManagerSQL::getInstance()->getDb();
                $db->beginTransaction();
                error_log('Inizio transazione per il salvataggio di un nuovo utente');

                // Salva l'oggetto utente e ottieni l'ID dell'ultimo inserimento
                $savePersonAndLastInsertedID = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);

                // Se l'operazione di salvataggio è avvenuta con successo, salva l'oggetto utente con l'ID inserito
                if ($savePersonAndLastInsertedID !== null) {
                    // Setta l'ID dell'oggetto con l'ID appena generato
                    $obj->setId($savePersonAndLastInsertedID);

                    // Salva l'oggetto nella tabella registeredUser
                    $savePersonalTrainer = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $obj);

                    // Se l'utente è stato salvato con successo, commetti la transazione e ritorna l'ID dell'ultimo inserimento
                    if ($savePersonalTrainer) {
                        $db->commit();
                        error_log('Transazione completata con successo per il nuovo utente ID: ' . $savePersonAndLastInsertedID);
                        return $savePersonAndLastInsertedID;
                    } else {
                        $db->rollBack();
                        error_log('Errore durante il salvataggio nella tabella `personalTrainer`');
                        return false;
                    }
                } else {
                    $db->rollBack();
                    error_log('Errore durante il salvataggio nella tabella `user`');
                    return false;
                }
            } catch (PDOException $e) {
                error_log('Errore PDO: ' . $e->getMessage());
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            } finally {
                FEntityManagerSQL::getInstance()->closeConnection();
            }
        } else {
            // Aggiornamento di un utente esistente
            try {
                $db = FEntityManagerSQL::getInstance()->getDb();
                $db->beginTransaction();
                error_log('Inizio transazione per l\'aggiornamento di un utente esistente');

                foreach ($fieldArray as $fv) {
                    if ($fv[0] != "username" && $fv[0] != "password") {
                        FEntityManagerSQL::getInstance()->updateObj(FPersonalTrainer::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                    } else {
                        FEntityManagerSQL::getInstance()->updateObj(FUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                    }
                }

                $db->commit();
                error_log('Transazione completata con successo per l\'aggiornamento utente ID: ' . $obj->getId());
                return true;
            } catch (PDOException $e) {
                error_log('Errore PDO: ' . $e->getMessage());
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            } finally {
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

    public static function getTrainingCardsOfClient($idUser) {
        // Retrieve the TrainingCard objects for the client
        return FTrainingCard::getTrainingCardsByIdUserl($idUser);
    }

    public static function getPhysicalDataOfClient($idUser) {
        // Retrieve the PhysicalData objects for the client
        return FPhysicalData::getPhysicalDataByIdUser($idUser);
    }


    public static function getPersonalTrainerByUsername($username)
    {
        // Get an instance of FEntityManagerSQL to ensure the database connection is established
        $entityManager = FEntityManagerSQL::getInstance();

        // Retrieve the user data from the User table
        $userResult = $entityManager->retriveObj('user', 'username', $username);

        if ($userResult !== null && !empty($userResult)) {
            // Assume retriveObj returns an array; take the first user found
            $user = $userResult[0];

            // Retrieve the personal trainer data from the PersonalTrainer table
            $trainerResult = $entityManager->retriveObj('personalTrainer', 'idUser', $user['idUser']);

            if ($trainerResult !== null && !empty($trainerResult)) {
                // Take the first personal trainer found
                $trainer = $trainerResult[0];

                // Merge the user data and the personal trainer data
                $result = array_merge($user, $trainer);

                // Create the PersonalTrainer object
                $personalTrainer = self::createPersonalTrainerObj($result);
                return $personalTrainer;
            }
        }

        return null;
    }


}
