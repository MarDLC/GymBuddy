<?php

class FPhysicalData{

    private static $table = "PhysicalData";

    private static $value = "(NULL,:emailRegisteredUser,:sex,:height,:weight,:leanMass,:fatMass,:bmi,:date,:emailPersonalTrainer)";

    private static $key = "idPhysicalData";

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

    public static function createPhysicalDataObj($queryResult){
        if(count($queryResult) == 1){
            $physicalData = new EPhysicalData($queryResult[0]['emailRegisteredUser'],$queryResult[0]['sex'],$queryResult[0]['height'],$queryResult[0]['weight'],$queryResult[0]['leanMass'],$queryResult[0]['fatMass'],$queryResult[0]['bmi']);
            $physicalData->setIdPhysicalData($queryResult[0]['idPhysicalData']);
            $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[0]['creation_time']);
            $physicalData->setCreationTime($dateTime);
            $physicalData->setEmailPersonalTrainer($queryResult[0]['emailPersonalTrainer']);
            return $physicalData;
        }elseif(count($queryResult) > 1){
            $physicalDatas = array();
            for($i = 0; $i < count($queryResult); $i++){
                $physicalData = new EPhysicalData($queryResult[0]['emailRegisteredUser'],$queryResult[0]['sex'],$queryResult[0]['height'],$queryResult[0]['weight'],$queryResult[0]['leanMass'],$queryResult[0]['fatMass'],$queryResult[0]['bmi']);
                $physicalData->setIdPhysicalData($queryResult[$i]['idPhysicalData']);
                $dateTime =  DateTime::createFromFormat('Y-m-d H:i:s', $queryResult[$i]['creation_time']);
                $physicalData->setCreationTime($dateTime);
                $physicalData->setEmailPersonalTrainer($queryResult[$i]['emailPersonalTrainer']);
                $physicalDatas[] = $physicalData;
            }
            return $physicalDatas;
        }else{
            return array();
        }
    }

    public static function getObj($id){
        $result = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), self::getKey(), $id);
        if(count($result) > 0){
            $physicalData = self::createPhysicalDataObj($result);
            return $physicalData;
        }else{
            return null;
        }
    }

    public static function saveObj($obj , $fieldArray = null){
        if($fieldArray === null){
            $savePhysicalData = FEntityManagerSQL::getInstance()->saveObject(self::getClass(), $obj);
            if($savePhysicalData !== null){
                return $savePhysicalData;
            }else{
                return false;
            }
        }else{
            try{
                FEntityManagerSQL::getInstance()->getDb()->beginTransaction();
                foreach($fieldArray as $fv){
                    FEntityManagerSQL::getInstance()->updateObj(FPhysicalData::getTable(), $fv[0], $fv[1], self::getKey(), $obj->getIdPhysicalData());
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

    public static function deletePhysicalDataInDb($idPhysicalData){
        try{
            // Start a new database transaction
            FEntityManagerSQL::getInstance()->getDb()->beginTransaction();

            // Delete the news item from the database
            $queryResult  = FEntityManagerSQL::getInstance()->deleteObj(self::getTable(), self::getKey(), $idPhysicalData);

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
