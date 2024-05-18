<?php

class FPersonalTrainer{

    private static $table = "personaltrainer";

    private static $value = "(NULL,:email)";

    private static $key = "email";

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

    public static function bind($stmt, $user){
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
    }

    public static function verify($field, $id){
        $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

        return FEntityManagerSQL::getInstance()->existInDb($queryResult);
    }
}
