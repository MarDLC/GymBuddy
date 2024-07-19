<?php

require_once(__DIR__ . '/../../../config/config.php');

class FEntityManagerSQL{
    /**
     * Singleton Class
     */

    private static $instance;

    private static $db;


    private function __construct(){
        try{
            self::$db = new PDO("mysql:dbname=".DB_NAME.";host=".DB_HOST."; charset=utf8;", DB_USER, DB_PASS);
        }catch(PDOException $e){
            echo "ERROR". $e->getMessage();
            die;
        }

    }

    /**
     * Method to create an instance af the EntityManager
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *  Method to close the connection with the Database destrying the instance of the EntityManager
     */
    public static function closeConnection(){

        static::$instance = null;
    }

    /**
     *  Method to return the PDO
     */
    public static function getDb(){
        return self::$db;
    }

    /**
     * Method to return rows from a query SELECT FROM @table WHERE @field = @id
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to a field of the table
     * @param mixed $id Refers to the value in the where clause
     * @return array
     */
  public static function retriveObj($table, $field ,$id){
    try{
        $query = "SELECT * FROM " .$table. " WHERE ".$field." = '".$id."';";

        // Debug output for the query
        error_log("retriveObj query: " . $query);

        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $rowNum = $stmt->rowCount();

        // Debug output for the number of rows
        error_log("retriveObj rowNum: " . $rowNum);

        if($rowNum > 0){
            $result = array();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()){
                $result[] = $row;
            }

            // Debug output for the result
            error_log("retriveObj result: " . print_r($result, true));

            return $result;
        }else{
            return array();
        }
    } catch(PDOException $e){
        // Debug output for the exception
        error_log("retriveObj exception: " . $e->getMessage());
        return array();
    }
}

public static function retriveLastObj($table, $field, $id, $orderBy){
    try{
        $query = "SELECT * FROM " .$table. " WHERE ".$field." = '".$id."' ORDER BY " . $orderBy . " DESC LIMIT 1;";

        // Debug output for the query
        error_log("retriveLastObj query: " . $query);

        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $rowNum = $stmt->rowCount();

        // Debug output for the number of rows
        error_log("retriveLastObj rowNum: " . $rowNum);

        if($rowNum > 0){
            $result = array();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()){
                $result[] = $row;
            }

            // Debug output for the result
            error_log("retriveLastObj result: " . print_r($result, true));

            return $result;
        }else{
            return array();
        }
    } catch(PDOException $e){
        // Debug output for the exception
        error_log("retriveLastObj exception: " . $e->getMessage());
        return array();
    }
}

    /**
     * Method to return rows from a query SELECT FROM WHERE but with 2 fields
     * @param String $table Refers to the table of the Database
     * @param String $field1  Refers to a field of the table (1st field)
     * @param mixed $id1 Refers to the value in the where clause (1st value)
     * @param String $field2  Refers to a field of the table (1st field)
     * @param mixed $id2 Refers to the value in the where clause (1st value)
     * @return array
     */
    public static function getObjOnAttributes($table, $field1, $id1, $field2, $id2)
    {
        try{
            $query = "SELECT * FROM " . $table . " WHERE " . $field1 . " = '".$id1. "' AND " . $field2 . " = '". $id2. "';";
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            $rowNum = $stmt->rowCount();
            if($rowNum > 0){
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()){
                    $result[] = $row;
                }
                return $result;
            }else{
                return array();
            }

        }catch(PDOException $e){
            echo "ERROR" . $e->getMessage();
            return array();
        }
    }

    /**
     * Method to check if the query return or not a row
     * @param array $queryResult Is the output of a query
     * @return bool
     */
    public static function existInDb($queryResult){
        if(count($queryResult) > 0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Method to update rows with UPDATE @table SET @field = @fieldValue WHERE @cond = @condvalue
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to the field to update
     * @param mixed $fieldvalue Refers to the value to update
     * @param String  $cond Refers to the Where condition
     * @param mixed $condvalue Refers to the value of the condition
     * @return bool
     */
    public static function updateObj($table, $field, $fieldValue, $cond, $condValue){

        try{
            $query = "UPDATE " . $table . " SET ". $field. " = '" . $fieldValue . "' WHERE " . $cond . " = '" . $condValue . "';";
            $stmt = self::$db->prepare($query);
            //var_dump($stmt);
            $stmt->execute();
            return true;
        }catch(Exception $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Method to save an object in the Database using the INSERT TO query
     * @param String $foundClass Refers to the name of the foundation class, so you can get the table and the value
     * @param Object $obj Refers to an Entity Object to save in the Database
     * @return int | null
     */
    public static function saveObject($foundClass, $obj)
    {
        try {
            $query = "INSERT INTO " . $foundClass::getTable() . " VALUES " . $foundClass::getValue();
            $stmt = self::$db->prepare($query);
            $foundClass::bind($stmt, $obj);

            error_log("Executing query: $query with object: " . var_export($obj, true));

            $stmt->execute();
            $id = self::$db->lastInsertId();

            error_log("Object saved successfully with ID: $id");

            return $id;
        } catch (Exception $e) {
            error_log("ERROR in saveObject: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Method to store an object in the Database if we only have the id and we need to store only the id
     * @param String $foundClass Refers to the name of the foundation class, so you can get the table and the value
     * @param int $id Refers to an Entity Object id to save in the Database
     * @return bool
     */
    public static function saveObjectFromId($foundClass, $obj, $id)
    {
        try{
            $query = "INSERT INTO " . $foundClass::getTable() . " VALUES " . $foundClass::getValue();
            $stmt = self::$db->prepare($query);
            $foundClass::bind($stmt,$obj, $id);
            //var_dump($stmt);
            $stmt->execute();
            return true;
        }catch(Exception $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Method to return rows from a SELECT FROM WHERE but removed is = 0 (so it's not banned)
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to a field of the table
     * @param mixed $id Refers to the value in the where clause
     * @return array
     */
    public static function objectListNotRemoved($table, $field, $id)
    {
        try{
            $query = "SELECT * FROM " . $table . " e WHERE e." . $field . " = '" . $id . "' AND e.removed = 0;";
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            $rowNum = $stmt->rowCount();
            if($rowNum > 0){
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()){
                    $result[] = $row;
                }
                self::closeConnection();
                return $result;
            }else{
                return array();
            }
        }catch(Exception $e){
            echo "ERROR " . $e->getMessage();
            return array();
        }
    }

    /**
     * Method to delete a row from the Database with query DELETE FROM WHERE
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to a field of the table
     * @param mixed $id Refers to the value in the where clause
     * @return boolean
     */
    public static function deleteObjInDb($table, $field, $id){
        try{
            $query = "DELETE FROM " . $table . " WHERE " . $field . " = '".$id."';";
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            return true;
        }catch(Exception $e){
            echo "ERROR: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Method to check if a row (not on User) have the same attribute @idUser
     * @param array $queryResult
     * @param int $idUser
     * @return bool
     */
    public static function checkCreator($queryResult, $idUser){
        if(self::existInDb($queryResult) && $queryResult[0][FUser::getKey()] == $idUser){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Method to retrun rows from a SELECT FROM WHERE, but the @str is a string so search a row using LIKE % @str %
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to a field of the table
     * @param String $str Refers to a string to serach on a field
     * @return array
     */
    public static function getSearchedItem($table, $field, $str){
        try{
            $query = "SELECT * FROM " . $table . " WHERE " . $field . " LIKE '%" . $str . "%'";
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            $rowNum = $stmt->rowCount();
            if($rowNum > 0){
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()){
                    $result[] = $row;
                }
                self::closeConnection();
                return $result;
            }else{
                return array();
            }
        }catch(Exception $e){
            echo "ERROR " . $e->getMessage();
            return array();
        }
    }

    /**
     * Method to return rows from a SELECT FROM WHERE but the @field is NULL
     * @param Sring $table Refers to the table of the Database
     * @param String $field  Refers to a field of the table
     * @return array
     */
    public static function objectListOnNull($table, $field){
        try{
            $query = "SELECT * FROM " .$table. " WHERE ".$field." IS NULL;";
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            $rowNum = $stmt->rowCount();
            if($rowNum > 0){
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()){
                    $result[] = $row;
                }
                return $result;
            }else{
                return array();
            }

        }catch(PDOException $e){
            echo "ERROR" . $e->getMessage();
            return array();
        }
    }

    public static function verifyFieldValue($table, $field, $value){
    try{
        // Prepare the SQL statement to check if a record with the specified value for the specified field exists
        $stmt = self::$db->prepare("SELECT * FROM " . $table . " WHERE " . $field . " = :value");
        // Bind the parameters
        $stmt->bindValue(":value", $value, PDO::PARAM_STR);
        // Execute the SQL statement
        $stmt->execute();
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // If a record with the specified value for the specified field exists, return the value of the field
        if($result){
            return $result[$field];
        }
        // If a record with the specified value for the specified field does not exist, return null
        return null;
    }catch(PDOException $e){
        // Print the error message
        echo "ERROR " . $e->getMessage();
        return false;
    }
}

//utilizzato per  recuperare i dati dei personal trainer non approvati dal database:
    public static function retrieveDataWithCondition($table, $field, $value) {
        try{
            $query = "SELECT * FROM " . $table . " WHERE " . $field . " = :value";
            $stmt = self::$db->prepare($query);
            $stmt->bindValue(":value", $value, PDO::PARAM_STR);
            $stmt->execute();
            $rowNum = $stmt->rowCount();
            if($rowNum > 0){
                $result = array();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $stmt->fetch()){
                    $result[] = $row;
                }
                self::closeConnection();
                return $result;
            }else{
                return array();
            }
        } catch(PDOException $e) {
            echo "ERROR " . $e->getMessage();
            return array();
        }
    }

    public function retrieveDataWithJoinCondition($table1, $conditionField, $conditionValue, $table2, $joinField) {
        // Preparare la query SQL
        $sql = "SELECT * FROM $table1 JOIN $table2 ON $table1.$joinField = $table2.$joinField WHERE $table1.$conditionField = :conditionValue";

        // Preparare lo statement
        $stmt = $this->getDb()->prepare($sql);

        // Bind del valore della condizione
        $stmt->bindValue(':conditionValue', $conditionValue);

        // Eseguire la query
        $stmt->execute();

        // Restituire i risultati come un array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public static function countReservations($table, $date, $time) {
        try {
            $query = "SELECT COUNT(*) as count FROM " . $table . " WHERE date = :date AND time = :time";
            $stmt = self::$db->prepare($query);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->bindValue(':time', $time, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (PDOException $e) {
            echo "ERROR: " . $e->getMessage();
            return 0;
        }
    }



}