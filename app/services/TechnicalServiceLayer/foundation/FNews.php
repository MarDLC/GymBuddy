<?php


/**
 * Class FNews
 *
 * This class is responsible for handling operations related to the News entity.
 * It provides methods for creating, retrieving, updating, and deleting News records in the database.
 */
class FNews{

    /**
     * @var string $table The name of the table in the database.
     * This is used in SQL queries to specify the table to perform operations on.
     */
    private static $table = "News";

    /**
     * @var string $value The value for the SQL query.
     * This is used in SQL queries to specify the values to be inserted into the table.
     */
    private static $value = "(NULL,:title,:description,:creation_time,:email)";

    /**
     * @var string $key The key for the SQL query.
     * This is used in SQL queries to specify the primary key of the table.
     */
    private static $key = "idNews";

    /**
     * Get the table name.
     *
     * @return string The name of the table.
     * This method is used to get the name of the table for use in SQL queries.
     */
    public static function getTable(){
        return self::$table;
    }
    /**
     * Get the value for the SQL query.
     *
     * @return string The value for the SQL query.
     * This method is used to get the value for the SQL query for use in SQL queries.
     */
    public static function getValue(){
        return self::$value;
    }

    /**
     * Get the class name.
     *
     * @return string The name of the class.
     * This method is used to get the name of the class for use in SQL queries.
     */
    public static function getClass(){
        return self::class;
    }

    /**
     * Get the key for the SQL query.
     *
     * @return string The key for the SQL query.
     * This method is used to get the key for the SQL query for use in SQL queries.
     */
   public static function getKey(){
    return self::$key;
    }

   /**
 * Create a News object from a query result.
 *
 * @param array $queryResult The result of the query.
 * @return ENews|array A News object if the query result is not empty, otherwise an empty array.
 */
public static function createNewsObj($queryResult){
    // Check if the query result contains exactly one item
    if(count($queryResult) == 1){
        // If it does, create a new News object using the data from the query result
        $news = new ENews($queryResult[0]['title'],$queryResult[0]['description']);
        // Set the id of the News object
        $news->setIdNews($queryResult[0]['idNews']);
        // Convert the creation time from a string to a DateTime object
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        // Set the creation time of the News object
        $news->setCreationTime($dateTime);
        // Set the email of the News object
        $news->setEmail($queryResult[0]['email']);
        // Return the News object
        return $news;
    }elseif(count($queryResult) > 1){
        // If the query result contains more than one item, initialize an empty array to hold the News objects
        $newss = array();
        // Loop through each item in the query result
        for($i = 0; $i < count($queryResult); $i++){
            // Create a new News object using the data from the current item in the query result
            $news = new ENews($queryResult[$i]['title'],$queryResult[$i]['description']);
            // Set the id of the News object
            $news->setIdNews($queryResult[$i]['idNews']);
            // Convert the creation time from a string to a DateTime object
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
            // Set the creation time of the News object
            $news->setCreationTime($dateTime);
            // Set the email of the News object
            $news->setEmail($queryResult[$i]['email']);
            // Add the News object to the array
            $newss[] = $news;
        }
        // Return the array of News objects
        return $newss;
    }else{
        // If the query result is empty, return an empty array
        return array();
    }
}

/**
 * Bind the News parameters to the SQL statement.
 *
 * @param PDOStatement $stmt The SQL statement.
 * @param ENews $news The News object.
 */
public static function bind($stmt, $news){
    // Bind the title of the News object to the ":title" parameter in the SQL statement
    $stmt->bindValue(":title", $news->getTitle(), PDO::PARAM_STR);
    // Bind the description of the News object to the ":description" parameter in the SQL statement
    $stmt->bindValue(":description", $news->getDescription(), PDO::PARAM_STR);
    // Bind the creation time of the News object to the ":date" parameter in the SQL statement
    $stmt->bindValue(":date", $news->getTime(), PDO::PARAM_STR);
    // Bind the email of the News object to the ":email" parameter in the SQL statement
    $stmt->bindValue(":email", $news->getEmail(), PDO::PARAM_STR);
}

   /**
 * Get a News object by id.
 *
 * @param int $id The id of the News.
 * @return ENews|null A News object if found, otherwise null.
 */
public static function getObj($id){
    // Use the singleton instance of FEntityManagerSQL to retrieve the News object from the database
    $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);

    // Check if the result is not empty
    if(count($result) > 0){
        // If the result is not empty, create a News object from the result
        $news = self::createNewsObj($result);
        // Return the News object
        return $news;
    }else{
        // If the result is empty, return null
        return null;
    }
}

/**
 * Save a News object to the database.
 *
 * @param ENews $obj The News object to save.
 * @param array|null $fieldArray The fields to update.
 * @return bool|int The ID of the saved News object if successful, otherwise false.
 */
public static function saveObj($obj , $fieldArray = null){
    // Check if the fieldArray is null
    if($fieldArray === null){
        // If the fieldArray is null, save the News object to the database
        $saveNews = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
        // Check if the News object was saved successfully
        if($saveNews !== null){
            // If the News object was saved successfully, return the ID of the saved News object
            return $saveNews;
        }else{
            // If the News object was not saved successfully, return false
            return false;
        }
    }else{
        // If the fieldArray is not null, start a new database transaction
        try{
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
            // Loop through each field in the fieldArray
            foreach($fieldArray as $fv){
                // Update the field in the database
                FEntityManagerSQL::getInstance()->updateObj(FNews::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdNews());
            }
            // Commit the transaction
            FEntityManagerSQL::getInstance()->getDb()->commit();
            // Return true to indicate that the operation was successful
            return true;
        }catch(PDOException $e){
            // If an exception occurred, print the error message
            echo "ERROR " . $e->getMessage();
            // Rollback the transaction
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            // Return false to indicate that the operation was not successful
            return false;
        }finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }
}

    /**
     * Delete a News from the database.
     *
     * @param int $idNews The id of the News to delete.
     * @return bool True if the News was successfully deleted, otherwise false.
     * This method is used to delete a News from the database.
     */
    public static function deleteObj($idNews){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the news item from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(FNews::getTable(), FNews::getKey(), $idNews);

            // Commit the transaction if the delete operation was successful
            FEntityManagerSQL::getInstance()->getDb()->commit();

            // Return true if the news item was deleted successfully
            if($queryResult ){
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e){
            // Print the error message and rollback the transaction in case of an exception
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        } finally{
            // Close the database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }


}
