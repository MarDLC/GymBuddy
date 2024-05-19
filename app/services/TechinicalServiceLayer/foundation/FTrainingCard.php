<?php

class FTrainingCard{

    private static $table = "TrainingCard";

    private static $value = "(NULL,:emailRegisteredUser,:creation,:exercises,:repetition,:recovery,:emailPersonalTrainer)";

    private static $key = "idTrainingCard";

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

    public static function createTrainingCardObj($queryResult){
        if(count($queryResult) == 1){
            $trainingCard = new ETrainingCard($queryResult[0]['emailRegisteredUser'],$queryResult[0]['excercises'],$queryResult[0]['repetition'],$queryResult[0]['recovery']);
            $trainingCard->setIdTrainingCard($queryResult[0]['idTrainingCard']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
            $trainingCard->setCreationTime($dateTime);
            $trainingCard->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
            return $trainingCard;
        }elseif(count($queryResult) > 1){
            $trainingCards = array();
            for($i = 0; $i < count($queryResult); $i++){
                $trainingCard = new ETrainingCard($queryResult[0]['emailRegisteredUser'],$queryResult[0]['excercises'],$queryResult[0]['repetition'],$queryResult[0]['recovery']);
                $trainingCard->setIdTrainingCard($queryResult[$i]['idTrainingCard']);
                $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
                $trainingCard->setCreationTime($dateTime);
                $trainingCard->setEmailPersonalTrainer($queryResult[$i]['emailPersonalTrainer']);
                $trainingCards[] = $trainingCard;
            }
            return $trainingCards;
        }else{
            return array();
        }
    }

    public static function bind($stmt, $trainingCard){
        $stmt->bindValue(":emailRegisteredUser", $trainingCard->getEmailRegisteredUser(), PDO::PARAM_STR);
        $stmt->bindValue(":creation", $trainingCard->getTimeStr(), PDO::PARAM_STR);
        $stmt->bindValue(":exercises", $trainingCard->getExercises(), PDO::PARAM_STR);
        $stmt->bindValue(":repetition", $trainingCard->getRepetition(), PDO::PARAM_STR);
        $stmt->bindValue(":recovery", $trainingCard->getRecovery(), PDO::PARAM_STR);
        $stmt->bindValue(":emailPersonalTrainer", $trainingCard->getEmailPersonalTrainer(), PDO::PARAM_STR);
    }

    public static function getObj($id){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
        if(count($result) > 0){
            $trainingCard = self::createTrainingCardObj($result);
            return $trainingCard;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $saveTrainingCard = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($saveTrainingCard !== null){
                return $saveTrainingCard;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FTrainingCard::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdTrainingCard());
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

    public static function deleteTrainingCardInDb($idTrainingCard){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the news item from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idTrainingCard);

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
