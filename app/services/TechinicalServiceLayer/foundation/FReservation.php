<?php

class FReservation{

    private static $table = "Reservation";

    private static $value = "(NULL,:emailRegisteredUser,:date,:time,:TrainingPT,:emailPersonalTrainer)";

    private static $key = "emailRegisteredUser";

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

    public static function bind($stmt, $reservation){
    $stmt->bindValue(":emailRegisteredUser", $reservation->getEmailRegisteredUser(), PDO::PARAM_STR);
    $stmt->bindValue(":date", $reservation->getDate(), PDO::PARAM_STR);
    $stmt->bindValue(":time", $reservation->getTime(), PDO::PARAM_STR);
    $stmt->bindValue(":TrainingPT", $reservation->getTrainingPT(), PDO::PARAM_BOOL);
    $stmt->bindValue(":emailPersonalTrainer", $reservation->getEmailPersonalTrainer(), PDO::PARAM_STR);
    }

    public static function createReservationObj($queryResult){
    if(count($queryResult) == 1){
        $reservation = new EReservation($queryResult[0]['emailRegisteredUser'],$queryResult[0]['date'],$queryResult[0]['time'],$queryResult[0]['trainingPT']);
        $reservation->setEmailRegisteredUser($queryResult[0]['emailRegisteredUser']);
        $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
        $reservation->setCreationTime($dateTime);
        $reservation->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
        return $reservation;
    }else{
        return array();
    }
    }

    public static function getObj($id){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
        if(count($result) > 0){
            $reservation = self::createReservationObj($result);
            return $reservation;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $saveReservation = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($saveReservation !== null){
                return $saveReservation;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FReservation::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmailRegisteredUser());
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

    public static function deleteReservationInDb($emailRegisteredUser){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the news item from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $emailRegisteredUser);

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

