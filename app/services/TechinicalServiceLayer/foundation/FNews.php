<?php

class FNews{

    private static $table = "News";

    private static $value = "(NULL,:title,:description,:creation_time,:email)";

    private static $key = "idNews";


    public static function getTable(){
        return self::$table;
    }

    public static function getValue(){
        return self::$value;
    }

    public static function getClass(){
        return self::class;
    }

   public static function getKey(){
    return self::$key;
    }

public static function createNewsObj($queryResult){
    if(count($queryResult) == 1){
        $news = new ENews($queryResult[0]['title'],$queryResult[0]['description']);
        $news->setIdNews($queryResult[0]['idNews']);
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        $news->setCreationTime($dateTime);
        $news->setEmail($queryResult[0]['email']);
        return $news;
    }elseif(count($queryResult) > 1){
        $newss = array();
        for($i = 0; $i < count($queryResult); $i++){
            $news = new ENews($queryResult[$i]['title'],$queryResult[$i]['description']);
            $news->setIdNews($queryResult[$i]['idNews']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
            $news->setCreationTime($dateTime);
            $news->setEmail($queryResult[$i]['email']);
            $newss[] = $news;
        }
        return $newss;
    }else{
        return array();
    }
}

        public static function bind($stmt, $news){
        $stmt->bindValue(":title", $news->getTitle(), PDO::PARAM_STR);
        $stmt->bindValue(":description", $news->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(":date", $news->getTime(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $news->getEmail(), PDO::PARAM_STR);
    }

    public static function getObj($id){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
        if(count($result) > 0){
            $news = self::createNewsObj($result);
            return $news;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $saveNews = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($saveNews !== null){
                return $saveNews;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                //var_dump($fieldArray);
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FNews::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdNews());
                }
                FEntityManagerSQL::getInstance()->getDb()->commit();
                return true;
            }catch(PDOException $e){
                echo "ERROR " . $e->getMessage();
                FEntityManagerSQL::getInstance()->getDb()->rollBack();
                return false;
            }finally{
                FEntityManagerSQL::getInstance()->closeConnection();
            }
        }

    }

    public static function deleteNewsInDb($idNews){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the news item from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idNews);

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
