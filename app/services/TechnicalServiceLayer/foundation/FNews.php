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
    private static $value = "(NULL,:idUser,:title, :description,:creation_time)";

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


public static function createNewsObj($queryResult){
    if(count($queryResult) == 1){
        $author = FAdmin::getOBj($queryResult[0]['idUser']);
        $news = new ENews($queryResult[0]['idUser'], $queryResult[0]['title'], $queryResult[0]['description']);
        $news->setIdNews($queryResult[0]['idNews']);
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        $news->setCreationTime($dateTime);
        return array($news); // Wrap the news object in an array
    } elseif(count($queryResult) > 1){
        $newss = array();
        for($i = 0; $i < count($queryResult); $i++){
            $author = FAdmin::getOBj($queryResult[$i]['idUser']);
            $news = new ENews($queryResult[$i]['idUser'], $queryResult[$i]['title'], $queryResult[$i]['description']);
            $news->setIdNews($queryResult[$i]['idNews']);
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
            $news->setCreationTime($dateTime);
            $newss[] = $news;
        }
        return $newss;
    } else {
        return array();
    }
}
/**
 * Bind the News parameters to the SQL statement.
 *
 * @param PDOStatement $stmt The SQL statement.
 * @param ENews $news The News object.
 */
    public static function bind($stmt, $news) {
        // Log dei valori prima di bind
        error_log("FNews::bind - Binding parameters: " . print_r([
                'idUser' => $news->getIdUser(),
                'title' => $news->getTitle(),
                'description' => $news->getDescription(),
                'creation_time' => $news->getTimeStr()
            ], true));

        // Bind dei valori
        $stmt->bindValue(":idUser", $news->getIdUser(), PDO::PARAM_INT);
        $stmt->bindValue(":title", $news->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(":description", $news->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(":creation_time", $news->getTimeStr(), PDO::PARAM_STR);
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
    public static function saveObj($obj, $fieldArray = null)
    {
        error_log("FNews::saveObj - Saving news object: " . print_r($obj, true));

        if ($fieldArray === null) {
            $saveNews = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if ($saveNews !== null) {
                error_log("FNews::saveObj - News saved successfully with ID: $saveNews");
                return $saveNews;
            } else {
                error_log("FNews::saveObj - Failed to save news");
                return false;
            }
        } else {
            try {
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                foreach ($fieldArray as $fv) {
                    FEntityManagerSQL::getInstance()->updateObj(FNews::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdNews());
                }
                FEntityManagerSQL::getInstance()->getDb()->commit();
                error_log("FNews::saveObj - News updated successfully");
                return true;
            } catch (PDOException $e) {
                error_log("FNews::saveObj - ERROR: " . $e->getMessage());
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            } finally {
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

  public static function getAll() {
    $results = FEntityManagerSQL::getInstance()->getAllObjects(self::getTable());
    $newsList = self::createNewsObj($results);

    // If $newsList is not an array, make it an array
    if (!is_array($newsList)) {
        $newsList = array($newsList);
    }

    return $newsList;
}

}
