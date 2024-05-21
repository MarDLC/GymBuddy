<?php

/**
 * Class FPhysicalData
 *
 * This class is responsible for handling operations related to the PhysicalData entity.
 * It provides methods for interacting with the 'PhysicalData' table in the database.
 */
class FPhysicalData{

    /**
     * @var string $table The name of the table in the database that this class interacts with.
     */
    private static $table = "PhysicalData";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(NULL,:emailRegisteredUser,:sex,:height,:weight,:leanMass,:fatMass,:bmi,:date,:emailPersonalTrainer)";

    /**
     * @var string $key The primary key of the table.
     */
    private static $key = "idPhysicalData";

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
 * Binds the given PhysicalData object's properties to the given PDOStatement's parameters.
 *
 * @param PDOStatement $stmt The PDOStatement to bind the parameters to.
 * @param EPhysicalData $physicalData The PhysicalData object whose properties to bind.
 */
public static function bind($stmt, $physicalData){
    // Bind the email of the registered user to the corresponding parameter in the SQL statement
    $stmt->bindValue(":emailRegisteredUser", $physicalData->getEmailRegisteredUser(), PDO::PARAM_STR);
    // Bind the sex to the corresponding parameter in the SQL statement
    $stmt->bindValue(":sex", $physicalData->getSex(), PDO::PARAM_STR);
    // Bind the height to the corresponding parameter in the SQL statement
    $stmt->bindValue(":height", $physicalData->getHeight(), PDO::PARAM_STR);
    // Bind the weight to the corresponding parameter in the SQL statement
    $stmt->bindValue(":weight", $physicalData->getWeight(), PDO::PARAM_STR);
    // Bind the lean mass to the corresponding parameter in the SQL statement
    $stmt->bindValue(":leanMass", $physicalData->getLeanMass(), PDO::PARAM_STR);
    // Bind the fat mass to the corresponding parameter in the SQL statement
    $stmt->bindValue(":fatMass", $physicalData->getFatMass(), PDO::PARAM_STR);
    // Bind the BMI to the corresponding parameter in the SQL statement
    $stmt->bindValue(":bmi", $physicalData->getBmi(), PDO::PARAM_STR);
    // Bind the date to the corresponding parameter in the SQL statement
    $stmt->bindValue(":date", $physicalData->getTimeStr(), PDO::PARAM_STR);
    // Bind the email of the personal trainer to the corresponding parameter in the SQL statement
    $stmt->bindValue(":emailPersonalTrainer", $physicalData->getEmailPersonalTrainer(), PDO::PARAM_STR);
}

/**
 * Creates a PhysicalData object from the given query result.
 *
 * @param array $queryResult The query result to create the PhysicalData object from.
 * @return EPhysicalData|array|null The created PhysicalData object, or an array of PhysicalData objects, or null if no PhysicalData object could be created.
 */
public static function createPhysicalDataObj($queryResult){
    // If the query result contains only one record
    if(count($queryResult) == 1){
        // Create a new PhysicalData object from the query result
        $physicalData = new EPhysicalData($queryResult[0]['emailRegisteredUser'],$queryResult[0]['sex'],$queryResult[0]['height'],$queryResult[0]['weight'],$queryResult[0]['leanMass'],$queryResult[0]['fatMass'],$queryResult[0]['bmi']);
        // Set the ID of the PhysicalData object
        $physicalData->setIdPhysicalData($queryResult[0]['idPhysicalData']);
        // Convert the creation time from a string to a DateTime object
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        // Set the creation time of the PhysicalData object
        $physicalData->setCreationTime($dateTime);
        // Set the email of the personal trainer
        $physicalData->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
        // Return the created PhysicalData object
        return $physicalData;
    // If the query result contains more than one record
    }elseif(count($queryResult) > 1){
        // Initialize an array to hold the PhysicalData objects
        $physicalDatas = array();
        // Loop through each record in the query result
        for($i = 0; $i < count($queryResult); $i++){
            // Create a new PhysicalData object from the current record
            $physicalData = new EPhysicalData($queryResult[0]['emailRegisteredUser'],$queryResult[0]['sex'],$queryResult[0]['height'],$queryResult[0]['weight'],$queryResult[0]['leanMass'],$queryResult[0]['fatMass'],$queryResult[0]['bmi']);
            // Set the ID of the PhysicalData object
            $physicalData->setIdPhysicalData($queryResult[$i]['idPhysicalData']);
            // Convert the creation time from a string to a DateTime object
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
            // Set the creation time of the PhysicalData object
            $physicalData->setCreationTime($dateTime);
            // Set the email of the personal trainer
            $physicalData->setEmailPersonalTrainer($queryResult[$i]['emailPersonalTrainer']);
            // Add the PhysicalData object to the array
            $physicalDatas[] = $physicalData;
        }
        // Return the array of PhysicalData objects
        return $physicalDatas;
    // If the query result is empty
    }else{
        // Return an empty array
        return array();
    }
}

    /**
 * Retrieves a PhysicalData object with the given ID.
 *
 * @param int $id The ID of the PhysicalData object to retrieve.
 * @return EPhysicalData|null The retrieved PhysicalData object, or null if no PhysicalData object was found.
 */
public static function getObj($id){
    // Retrieve the object from the database using the provided ID
    $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
    // If the result is not empty, create a PhysicalData object from the result
    if(count($result) > 0){
        $physicalData = self::createPhysicalDataObj($result);
        // Return the created PhysicalData object
        return $physicalData;
    }else{
        // If the result is empty, return null
        return null;
    }
}

/**
 * Saves the given PhysicalData object to the database.
 *
 * If the given field array is null, a new PhysicalData object is saved. Otherwise, an existing PhysicalData object is updated.
 *
 * @param EPhysicalData $obj The PhysicalData object to save.
 * @param array|null $fieldArray The array of fields to update, or null to save a new PhysicalData object.
 * @return string|bool The last inserted ID if a new PhysicalData object was saved, true if an existing PhysicalData object was updated, or false if the save operation was not successful.
 */
public static function saveObj($obj , $fieldArray = null){
    // If the field array is null, save a new PhysicalData object
    if($fieldArray === null){
        $savePhysicalData = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
        // If the save operation was successful, return the last inserted ID
        if($savePhysicalData !== null){
            return $savePhysicalData;
        }else{
            // If the save operation was not successful, return false
            return false;
        }
    }else{
        // If the field array is not null, update an existing PhysicalData object
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Loop through each field in the field array
            foreach($fieldArray as $fv){
                // Update the corresponding field in the database
                FEntityManagerSQL::getInstance()->updateObj(FPhysicalData::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdPhysicalData());
            }
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // Return true to indicate that the update operation was successful
            return true;
        }catch(PDOException $e){
            // If an exception occurs, print the error message and rollback the transaction
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            // Return false to indicate that the update operation was not successful
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }
}

   /**
 * Deletes a PhysicalData object with the given ID from the database.
 *
 * @param int $idPhysicalData The ID of the PhysicalData object to delete.
 * @return bool True if the PhysicalData object was deleted successfully, false otherwise.
 */
public static function deletePhysicalDataInDb($idPhysicalData){
    try{
        // Start a new database transaction
        FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

        // Delete the PhysicalData object from the database using the provided ID
        $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idPhysicalData);

        // Commit the transaction if the delete operation was successful
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
}