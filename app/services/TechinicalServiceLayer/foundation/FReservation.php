<?php

class FReservation{

private static $table = "Reservation";

private static $value = "(NULL,:emailRegisteredUser,:date,:time,:TrainingPT,:emailPersonalTrainer)";

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

public static function bind($stmt, $reservation){
$stmt->bindValue(":emailRegisteredUser", $reservation->getEmailRegisteredUser(), PDO::PARAM_STR);
$stmt->bindValue(":date", $reservation->getDate(), PDO::PARAM_STR);
$stmt->bindValue(":time", $reservation->getTime(), PDO::PARAM_STR);
$stmt->bindValue(":TrainingPT", $reservation->getTrainingPT(), PDO::PARAM_BOOL);
$stmt->bindValue(":emailPersonalTrainer", $reservation->getEmailPersonalTrainer(), PDO::PARAM_STR);
}

public static function verify($field, $id){
$queryResult = FEntityManagerSQL::getInstance()->retriveObj(self::getTable(), $field, $id);

return FEntityManagerSQL::getInstance()->existInDb($queryResult);
}
}

