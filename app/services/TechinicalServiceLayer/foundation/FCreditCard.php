<?php

class FCreditCard{

    private static $table = "creditcard";

    private static $value = "(NULL,:cvc,:accountHolder,:cardNumber,:expirationDate,:email)";

    private static $key = "cvc";

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

    public static function bind($stmt, $creditCard){
        $stmt->bindValue(":cvc", $creditCard->getCvc(), PDO::PARAM_INT);
        $stmt->bindValue(":accountHolder", $creditCard->getAccountHolder(), PDO::PARAM_STR);
        $stmt->bindValue(":cardNumber", $creditCard->getCardNumber(), PDO::PARAM_INT);
        $stmt->bindValue(":expirationDate", $creditCard->getExpirationDate(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $creditCard->getEmail(), PDO::PARAM_STR);
    }

    public static function verify($field, $id){
        $queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

        return FEntityManagerSQL::getInstance()->existInDb($queryResult);
    }
}
