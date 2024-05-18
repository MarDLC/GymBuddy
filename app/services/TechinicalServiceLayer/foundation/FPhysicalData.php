<?php

class FPhysicalData{

    private static $table = "PhysicalData";

    private static $value = "(NULL,:emailRegisteredUser,:sex,:height,:weight,:leanMass,:fatMass,:bmi,:date,:emailPersonalTrainer)";

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

    public static function bind($stmt, $physicalData){
        $stmt->bindValue(":emailRegisteredUser", $physicalData->getEmailRegisteredUser(), PDO::PARAM_STR);
        $stmt->bindValue(":sex", $physicalData->getSex(), PDO::PARAM_STR);
        $stmt->bindValue(":height", $physicalData->getHeight(), PDO::PARAM_STR);
        $stmt->bindValue(":weight", $physicalData->getWeight(), PDO::PARAM_STR);
        $stmt->bindValue(":leanMass", $physicalData->getLeanMass(), PDO::PARAM_STR);
        $stmt->bindValue(":fatMass", $physicalData->getFatMass(), PDO::PARAM_STR);
        $stmt->bindValue(":bmi", $physicalData->getBmi(), PDO::PARAM_STR);
        $stmt->bindValue(":date", $physicalData->getTimeStr(), PDO::PARAM_STR);
        $stmt->bindValue(":emailPersonalTrainer", $physicalData->getEmailPersonalTrainer(), PDO::PARAM_STR);
    }

    public static function verify($field, $id){
        $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

        return FEntityManagerSQL::getInstance()->existInDb($queryResult);
    }
}
