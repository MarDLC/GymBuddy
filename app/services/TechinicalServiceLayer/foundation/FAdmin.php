<?php

class FAdmin{

    private static $table = "admin";

    private static $value = "(:email)";

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

    public static function createAdminObj($queryResult){
        if(count($queryResult) > 0){
            $mod = new EAdmin($queryResult[0]['first_name'], $queryResult[0]['last_name'], $queryResult[0]['email'], $queryResult[0]['password'], $queryResult[0]['username']);
            $mod->setEmail($queryResult[0]['Email']);
            $mod->setHashedPassword($queryResult[0]['password']);
            return $mod;
        }else{
            return array();
        }


    }

    public static function bind($stmt, $user){
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
    }

    public static function getObj($email){
        $result = FEntityManagerSQL::getInstance()->retriveObj(FUser::getTable(), self::getKey(), $email);
        //var_dump($result);
        if(count($result) > 0){
            $user = self::createAdminObj($result);
            return $user;
        }else{
            return null;
        }
    }

    public static function saveObj($obj){

        $saveUser = FEntityManagerSQL::getInstance()->saveObject(FUser::getClass(), $obj);
        if($saveUser !== null){
            $saveAdmin = FEntityManagerSQL::getInstance()->saveObjectFromId(self::getClass(), $obj, $saveUser);
            return $saveAdmin;
        }else{
            return false;
        }
    }

}
