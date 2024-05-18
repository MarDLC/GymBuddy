<?php

class FCreditCard{

    private static $table = "creditcard";

    private static $value = "(NULL,:cvc,:accountHolder,:cardNumber,:expirationDate,:email)";

    private static $key = "idCreditCard";

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

    public static function createCreditCartObj($queryResult){
    if(count($queryResult) > 0){
        $subscriptions = array();
        for($i = 0; $i < count($queryResult); $i++){
            $sub = new ECreditCard($queryResult[$i]['cvc'],$queryResult[$i]['accountHolder'],$queryResult[$i]['cardNumber'],$queryResult[$i]['expirationDate'],$queryResult[$i]['email']);
            $sub->setIdCreditCard($queryResult[$i]['idCreditCard']);
            $subscriptions[] = $sub;
        }
        return $subscriptions;
    }else{
        return array();
    }
}
    public static function bind($stmt, $creditCard){
        $stmt->bindValue(":idCreditCard", $creditCard->getIdCreditCard(), PDO::PARAM_INT);
        $stmt->bindValue(":cvc", $creditCard->getCvc(), PDO::PARAM_INT);
        $stmt->bindValue(":accountHolder", $creditCard->getAccountHolder(), PDO::PARAM_STR);
        $stmt->bindValue(":cardNumber", $creditCard->getCardNumber(), PDO::PARAM_STR);
        $stmt->bindValue(":expirationDate", $creditCard->getExpirationDate(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $creditCard->getEmail(), PDO::PARAM_STR);
    }

    public static function getObj($idCreaditCard){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $idCreaditCard);
        //var_dump($result);
        if(count($result) > 0){
            $creditCard = self::createCreditCardObj($result);
            return $creditCard;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $saveCreditCard = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($saveCreditCard !== null){
                return $saveCreditCard;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                //var_dump($fieldArray);
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FCreditCard::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdCardCredit());
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

    public static function deleteCreditCard($idCreditCard){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the Subscription from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $idCreditCard);

            // Perform the commit of the transaction if the deletion operation was successful.
            FEntityManagerSQL::getInstance()->getDb()->commit();

            //Returns true if the subscription was successfully deleted.
            if($queryResult ){
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e){
            // Print the error message and perform a rollback of the transaction in case of an exception.
            echo "ERROR " . $e->getMessage();
            FEntityManagerSQL::getInstance()->getDb()->rollBack();
            return false;
        } finally{
            // Close database connection
            FEntityManagerSQL::getInstance()->closeConnection();
        }
    }



}
