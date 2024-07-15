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
    private static $value = "(:idUser,:type)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "idUser";

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
            $attributes = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), "idUser", $queryResult[0]['idUser']);

            // Create a new RegisteredUser object from the query result
            $registeredUser = new ERegisteredUser($queryResult[0]['email'], $queryResult[0]['username'], $queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['password']);
            $registeredUser->setId($queryResult[0]['idUser']);
            $registeredUser->setHashedPassword($queryResult[0]['password']);
            $registeredUser->setType($attributes[0]['type']);
            // Return the created RegisteredUser object
            return $registeredUser;
            // If the query result contains more than one record
        } elseif(count($queryResult) > 1){
            // Initialize an array to hold the RegisteredUser objects
            $registeredUsers = array();
            // Loop through each record in the query result
            for($i = 0; $i < count($queryResult); $i++){
                $attributes = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), "idUser", $queryResult[$i]['idUser']);

                // Create a new RegisteredUser object from the current record
                $registeredUser = new ERegisteredUser($queryResult[$i]['email'], $queryResult[$i]['username'], $queryResult[$i]['first_name'], $queryResult[$i]['last_name'], $queryResult[$i]['password']);
                $registeredUser->setId($queryResult[$i]['idUser']);
                $registeredUser->setHashedPassword($queryResult[$i]['password']);
                $registeredUser->setType($attributes[0]['type']);
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
    public static function bind($stmt, $registeredUser, $id) {
        // Bind the email to the corresponding parameter in the SQL statement
        $stmt->bindValue(":idUser", $registeredUser->getId(), PDO::PARAM_INT); // Use the registeredUser object to get the ID
        $stmt->bindValue(":type", $registeredUser->getType(), PDO::PARAM_STR);
    }


    /**
     * Retrieves a RegisteredUser object with the given email.
     *
     * @param string $email The email of the RegisteredUser object to retrieve.
     * @return EUser|null The retrieved RegisteredUser object, or null if no RegisteredUser object was found.
     */
    public static function getObj($id){
        // Retrieve the object from the database using the provided email
        $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $id);
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


    /*public static function saveObj($obj, $fieldArray = null) {
        // If fieldArray is null, we are saving a new user
        if ($fieldArray === null) {
            try {
                // Start a new database transaction
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // Save the user object and get the last inserted ID
                $savePersonAndLastInsertedID = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);
                // If the save operation was successful, save the user object with the last inserted ID
                if ($savePersonAndLastInsertedID !== null) {
                    $saveRegisteredUser = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $obj); // Pass the object itself
                    // If the user was saved successfully, commit the transaction and return the last inserted ID
                    FEntityManagerSQL::getInstance()->getDb()->commit();
                    if ($saveRegisteredUser) {
                        return $savePersonAndLastInsertedID;
                    }
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "ERROR " . $e->getMessage();
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            } finally {
                FEntityManagerSQL::getInstance()->closeConnection();
            }
        } else {
            try {
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                // var_dump($fieldArray);
                foreach ($fieldArray as $fv) {
                    if ($fv[0] != "username" && $fv[0] != "password") {
                        FEntityManagerSQL::getInstance()->updateObj(FRegisteredUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                    } else {
                        FEntityManagerSQL::getInstance()->updateObj(FUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
                    }
                }
                FEntityManagerSQL::getInstance()->getDb()->commit();
                return true;
            } catch (PDOException $e) {
                echo "ERROR " . $e->getMessage();
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            } finally {
                FEntityManagerSQL::getInstance()->closeConnection();
            }
        }
    }*/

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
                    $saveRegisteredUser = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $obj);

                    // Se l'utente è stato salvato con successo, commetti la transazione e ritorna l'ID dell'ultimo inserimento
                    if ($saveRegisteredUser) {
                        $db->commit();
                        error_log('Transazione completata con successo per il nuovo utente ID: ' . $savePersonAndLastInsertedID);
                        return $savePersonAndLastInsertedID;
                    } else {
                        $db->rollBack();
                        error_log('Errore durante il salvataggio nella tabella `registeredUser`');
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
                        FEntityManagerSQL::getInstance()->updateObj(FRegisteredUser::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getId());
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



    public static function deleteRegisteredUserObj($id){
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


    /**
     * Retrieves a RegisteredUser object with the given username.
     *
     * @param string $username The username of the RegisteredUser object to retrieve.
     * @return EUser|null The retrieved RegisteredUser object, or null if no RegisteredUser object was found.
     */


    public static function getUserByUsername($username)
    {
        $result = FEntityManagerSQL::getInstance()->retriveObj(FPerson::getTable(), 'username', $username);

        if(count($result) > 0){
            $user = self::createRegisteredUserObj($result);
            return $user;
        }else{
            return null;
        }
    }





    public static function getUserByEmail($email)
    {
        // Recupera gli oggetti utente dal database utilizzando l'email fornita
        $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), 'email', $email);

        // Se il risultato non è vuoto, crea un oggetto RegisteredUser dal primo risultato e restituiscilo
        if(count($result) > 0){
            $registeredUser = self::createRegisteredUserObj(array($result[0]));
            return $registeredUser;
        }else{
            // Se il risultato è vuoto, restituisci null
            return null;
        }
    }


    public static function updateTypeIfSubscribedWithPT($id){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Check if the user has a 'coached' subscription using the verifyFieldValue method
            if(FEntityManagerSQL::verifyFieldValue('subscription', 'type', 'coached')){
                // If the user has a 'coached' subscription, use the updateObj method of FEntityManagerSQL to update the user type
                FEntityManagerSQL::updateObj(self::getTable(), 'type', 'followed_user', 'idUser', $id);
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

    public static function updateTypeIfSubscribedUserOnly($id){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Check if the user has a 'individual' subscription using the verifyFieldValue method
            if(FEntityManagerSQL::verifyFieldValue('subscription', 'type', 'individual')){
                // If the user has a 'individual' subscription, use the updateObj method of FEntityManagerSQL to update the user type
                FEntityManagerSQL::updateObj(self::getTable(), 'type', 'user_only', 'idUser', $id);
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