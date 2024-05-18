<?php

class FTrainingCard{

    private static $table = "TrainingCard";

    private static $value = "(NULL,:emailRegisteredUser,:creation,:exercises,:repetition,:recovery,:emailPersonalTrainer)";

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

    public static function bind($stmt, $trainingCard){
        $stmt->bindValue(":emailRegisteredUser", $trainingCard->getEmailRegisteredUser(), PDO::PARAM_STR);
        $stmt->bindValue(":creation", $trainingCard->getTimeStr(), PDO::PARAM_STR);
        $stmt->bindValue(":exercises", $trainingCard->getExercises(), PDO::PARAM_STR);
        $stmt->bindValue(":repetition", $trainingCard->getRepetition(), PDO::PARAM_STR);
        $stmt->bindValue(":recovery", $trainingCard->getRecovery(), PDO::PARAM_STR);
        $stmt->bindValue(":emailPersonalTrainer", $trainingCard->getEmailPersonalTrainer(), PDO::PARAM_STR);
    }


}
