<?php

class FFollowedUser{

    private static $table = "FollowedUser";

    private static $value = "(NULL,:emailPersonalTrainer,:emailRegisteredUser)";

    private static $key = "emailPersonalTrainer";

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

    public static function bind($stmt, $followedUser){
        $stmt->bindValue(":emailPersonalTrainer", $followedUser->getEmailPersonalTrainer(), PDO::PARAM_STR);
        $stmt->bindValue(":emailRegisteredUser", $followedUser->getEmailRegisteredUser(), PDO::PARAM_STR);
    }

    public static function verify($field, $id){
        $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

        return FEntityManagerSQL::getInstance()->existInDb($queryResult);
    }
}
