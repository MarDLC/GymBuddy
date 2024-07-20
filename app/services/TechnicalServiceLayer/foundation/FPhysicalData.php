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
    private static $table = "physicaldata";

    /**
     * @var string $value The SQL value string for inserting a new record into the table.
     */
    private static $value = "(:idUser,:sex,:height,:weight,:leanMass,:fatMass,:bmi,:date,NULL)";

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
    public static function bind($stmt, $physicalData)
    {
        error_log("EPhysicalData object: " . print_r($physicalData, true));

        $idUser = $physicalData->getIdUser();
        if ($idUser !== null) {
            $stmt->bindValue(":idUser", $idUser, PDO::PARAM_INT);
            error_log("Binding user ID: $idUser");
        } else {
            // Handle the error, e.g., throw an exception or show an error message
            $errorMessage = 'User ID is null';
            error_log($errorMessage);
            throw new Exception($errorMessage);
        }

        $sex = $physicalData->getSex();
        $stmt->bindValue(":sex", $sex, PDO::PARAM_STR);
        error_log("Binding sex: $sex");

        $height = $physicalData->getHeight();
        $stmt->bindValue(":height", $height, PDO::PARAM_STR);
        error_log("Binding height: $height");

        $weight = $physicalData->getWeight();
        $stmt->bindValue(":weight", $weight, PDO::PARAM_STR);
        error_log("Binding weight: $weight");

        $leanMass = $physicalData->getLeanMass();
        $stmt->bindValue(":leanMass", $leanMass, PDO::PARAM_STR);
        error_log("Binding leanMass: $leanMass");

        $fatMass = $physicalData->getFatMass();
        $stmt->bindValue(":fatMass", $fatMass, PDO::PARAM_STR);
        error_log("Binding fatMass: $fatMass");

        $bmi = $physicalData->getBmi();
        $stmt->bindValue(":bmi", $bmi, PDO::PARAM_STR);
        error_log("Binding bmi: $bmi");

        $stmt->bindValue("date", $physicalData->getTimeStr(), PDO::PARAM_STR);
    }



    /*
public static function createPhysicalDataObj($queryResult){
    // If the query result contains only one record
    if(count($queryResult) == 1){
        $author= FPersonalTrainer::getObj($queryResult[0]['idUser']);
        // Create a new PhysicalData object from the query result
        $physicalData = new EPhysicalData($author, $queryResult[0]['sex'],$queryResult[0]['height'],$queryResult[0]['weight'],$queryResult[0]['leanMass'],$queryResult[0]['fatMass'],$queryResult[0]['bmi']);
        // Set the ID of the PhysicalData object
        $physicalData->setIdPhysicalData($queryResult[0]['idPhysicalData']);
        // Use the date directly as it is already a DateTime object
        $physicalData->setCreationTime($queryResult[0]['date']);
        // Return the created PhysicalData object
        return $physicalData;
    // If the query result contains more than one record
    }elseif(count($queryResult) > 1){
        // Initialize an array to hold the PhysicalData objects
        $physicalDatas = array();
        // Loop through each record in the query result
        for($i = 0; $i < count($queryResult); $i++){
            // Create a new PhysicalData object from the current record
            $author = FPersonalTrainer::getObj($queryResult[$i]['idUser']);
            $physicalData = new EPhysicalData($author, $queryResult[$i]['sex'], $queryResult[$i]['height'], $queryResult[$i]['weight'], $queryResult[$i]['leanMass'], $queryResult[$i]['fatMass'], $queryResult[$i]['bmi']);
            // Set the ID of the PhysicalData object
            $physicalData->setIdPhysicalData($queryResult[$i]['idPhysicalData']);
            // Use the date directly as it is already a DateTime object
            $physicalData->setCreationTime($queryResult[$i]['date']);
            // Add the PhysicalData object to the array
            $physicalDatas[] = $physicalData;
        }
        // Return the array of PhysicalData objects
        return $physicalDatas;
        // If the query result is empty
    } else {
        // Return an empty array
        return array();
    }
} */

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
        error_log("Saving EPhysicalData object: " . print_r($obj, true));
        $savePhysicalData = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
        error_log("Result of save operation: " . $savePhysicalData);
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




    public static function getPhysicalDataByIdUser($idUser)
    {
        error_log('getPhysicalDataByIdUser - idUser: ' . $idUser);
        // Retrieve the PhysicalData objects for the client using the user ID
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), 'idUser', $idUser);
        error_log('getPhysicalDataByIdUser - Query Result: ' . print_r($result, true));

        // If the result is not empty, create PhysicalData objects from the result
        if (count($result) > 0) {
            $physicalData = self::createPhysicalDataObj($result);
            error_log('getPhysicalDataByIdUser - PhysicalData Created: ' . print_r($physicalData, true));
            return $physicalData;
        } else {
            error_log('getPhysicalDataByIdUser - No data found');
            return null;
        }
    }


    public static function generatePhysicalProgressChart($idUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = self::getPhysicalDataByIdUser($idUser);

        // Prepare data for the chart
        $weights = array_map(function($data) { return $data->getWeight(); }, $physicalData);
        $leanMasses = array_map(function($data) { return $data->getLeanMass(); }, $physicalData);
        $fatMasses = array_map(function($data) { return $data->getFatMass(); }, $physicalData);
        $dates = array_map(function($data) { return $data->getTime()->format('Y-m-d'); }, $physicalData);

        // Log the retrieved data
        error_log("Weights: " . print_r($weights, true));
        error_log("Lean Masses: " . print_r($leanMasses, true));
        error_log("Fat Masses: " . print_r($fatMasses, true));
        error_log("Dates: " . print_r($dates, true));

        // Return the data array
        return [
            'weights' => $weights,
            'leanMasses' => $leanMasses,
            'fatMasses' => $fatMasses,
            'dates' => $dates
        ];
    }


    public static function createPhysicalDataObj($queryResult)
    {
        error_log('createPhysicalDataObj - Query Result: ' . print_r($queryResult, true));
        $physicalDatas = [];
        if (count($queryResult) == 1) {
            $author = FPersonalTrainer::getObj($queryResult[0]['idUser']);
            $physicalData = new EPhysicalData($author, $queryResult[0]['sex'], $queryResult[0]['height'], $queryResult[0]['weight'], $queryResult[0]['leanMass'], $queryResult[0]['fatMass'], $queryResult[0]['bmi']);
            $physicalData->setIdPhysicalData($queryResult[0]['idPhysicalData']);
            $physicalData->setCreationTime(new DateTime($queryResult[0]['date']));
            $physicalDatas[] = $physicalData;
        } elseif (count($queryResult) > 1) {
            foreach ($queryResult as $row) {
                $author = FPersonalTrainer::getObj($row['idUser']);
                $physicalData = new EPhysicalData($author, $row['sex'], $row['height'], $row['weight'], $row['leanMass'], $row['fatMass'], $row['bmi']);
                $physicalData->setIdPhysicalData($row['idPhysicalData']);
                $physicalData->setCreationTime(new DateTime($row['date']));
                $physicalDatas[] = $physicalData;
            }
        }
        error_log('createPhysicalDataObj - PhysicalData Objects: ' . print_r($physicalDatas, true));
        return $physicalDatas;
    }



}