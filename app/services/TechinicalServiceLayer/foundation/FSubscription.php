<?php

class FSubscription{

    private static $table = "subscription";

    private static $value = "(:type,:duration,:price)";

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


    public static function createSubscriptionObj($queryResult){
        if(count($queryResult) > 0){
            $subscriptions = array();
            for($i = 0; $i < count($queryResult); $i++){
                $sub = new ESubscription($queryResult[$i]['type'],$queryResult[$i]['duration'],$queryResult[$i]['price']);
                $subscriptions[] = $sub;
            }
            return $subscriptions;
        }else{
            return array();
        }
    }

    public static function bind($stmt, $subscription){
        $stmt->bindValue(":email", $subscription->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":type", $subscription->getType(), PDO::PARAM_STR);
        $stmt->bindValue(":duration", $subscription->getDuration(), PDO::PARAM_INT);
        $stmt->bindValue(":price", $subscription->getPrice(), PDO::PARAM_INT);
    }

    public static function getObj($email){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $email);
        //var_dump($result);
        if(count($result) > 0){
            $comment = self::crateCommentObj($result);
            return $comment;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $saveSubscription = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($saveSubscription !== null){
                return $saveSubscription;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                //var_dump($fieldArray);
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FSubscription::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getEmail());
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

    public static function deleteSubscription($email){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the Subscription from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObjInDb(self::getTable(), self::getKey(), $email);

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
