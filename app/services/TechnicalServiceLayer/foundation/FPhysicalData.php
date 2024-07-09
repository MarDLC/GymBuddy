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
    private static $value = "(NULL,:idUser,:sex,:height,:weight,:leanMass,:fatMass,:bmi,:date)";

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
    // Bind the user ID to the corresponding parameter in the SQL statement
    $stmt->bindValue(":idUser", $physicalData->getIdUser()->getId(), PDO::PARAM_INT);
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

    public static function getPhysicalDataByIdUser($idUser){
        // Retrieve the PhysicalData objects for the client using the user ID
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), 'idUser', $idUser);
        // If the result is not empty, create a PhysicalData object from the result
        if(count($result) > 0){
            $physicalData = self::createPhysicalDataObj($result);
            return $physicalData;
        } else {
            // If the result is empty, return null
            return null;
        }
    }

    public static function generatePhysicalProgressChart($idUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = self::getPhysicalDataByIdUser($idUser);

        // Create a new pChart object
        $chart = new pChart\pData();

        // For each physical data you want to track, add a data series to the chart
        $chart->addPoints(array_column($physicalData, 'weight'), "Peso");
        $chart->addPoints(array_column($physicalData, 'fatMass'), "Massa grassa");
        $chart->addPoints(array_column($physicalData, 'leanMass'), "Massa magra");
        $chart->addPoints(array_column($physicalData, 'bmi'), "BMI");

        // Set the X-axis labels with the dates of the checks
        $chart->addPoints(array_column($physicalData, 'time'), "Labels");
        $chart->setSerieDescription("Labels","Mesi");
        $chart->setAbscissa("Labels");

        // Create a new pChart object for drawing the chart
        $chartPicture = new pChart\pImage(700, 230, $chart);

        // Draw the chart
        $chartPicture->drawLineChart();

        // Save the chart as an image
        $chartPicture->Render("path/to/save/your/image.png");
    }
}