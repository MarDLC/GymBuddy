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
            $TrainingCard = new ETrainingCard($queryResult[0]['emailRegisteredUser'],$queryResult[0]['excercises'],$queryResult[0]['repetition'],$queryResult[0]['recovery']);
            $TrainingCard->setIdTrainingCard($queryResult[0]['idTrainingCard']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
            $TrainingCard->setCreationTime($dateTime);
            $TrainingCard->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
            return $TrainingCard;
        }elseif(count($queryResult) > 1){
            $TrainingCards = array();
            for($i = 0; $i < count($queryResult); $i++){
                $TrainingCard = new ETrainingCard($queryResult[0]['emailRegisteredUser'],$queryResult[0]['excercises'],$queryResult[0]['repetition'],$queryResult[0]['recovery']);
                $TrainingCard->setIdTrainingCard($queryResult[$i]['idTrainingCard']);
                $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
                $TrainingCard->setCreationTime($dateTime);
                $TrainingCard->setEmailPersonalTrainer($queryResult[$i]['emailPersonalTrainer']);
                $TrainingCards[] = $TrainingCard;
            }
            return $TrainingCards;
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


}
