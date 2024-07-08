<?php

/**
 * classe sql
 */
class FPersistentManager{

    /**
     * Singleton Class
     */

    private static $instance;


    private function __construct(){


    }

    /**
     * Method to create an instance af the PersistentManager
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    //------------------------------Directly with EntityManager---------------------------
    /**
     * return an object specifying the class and the id
     * @param String $class Refers to the Entity class of the object
     * @param int $id Refers to the id o the object
     * @return mixed
     */
    public static function retriveObj($class, $id){

        $foundClass = "F" . substr($class, 1);
        $staticMethod = "getObj";

        $result = call_user_func([$foundClass, $staticMethod], $id);

        return $result;
    }

    /**
     * upload any Object in the database
     * @param Object $obj Rfers to the object to store
     * @return mixed
     */
    public static function uploadObj($obj){
        $foundClass = "F" . substr(get_class($obj), 1);
        $staticMethod = "saveObj";

        $result = call_user_func([$foundClass, $staticMethod], $obj);

        return $result;
    }

    /**
     * return a User findig it not on the id but on it's username
     * @param String $username Refers to the username of the user to get
     */
    public static function retriveUserOnUsername($username)
    {
        $result = FRegisteredUser::getUserByUsername($username);

        return $result;
    }

    /**
     * Method to return the list of the followed user pf a user
     * @param int $idUser Refrs to the user who follow
     */
    public static function getFollowedUserList($idUser){
        //prende gli utenti seguti da $idUser, crea una lista di utenti
        $followRow = FEntityManagerSQL::getInstance()->retriveObj(FRegisteredUser::getTable(), 'idFollower', $idUser);
        $result = array();
        if(count($followRow) > 0){
            for($i = 0; $i < count($followRow); $i++){
                $user = FRegisteredUser::getObj($followRow[$i]['idFollowed']);
                $result[] = $user;
            }
        }
        return $result;
    }

    /**
     * Method to return the list of the follower user pf a user
     * @param int $idUser Refrs to the user who follow
     */
    public static function getFollowerUserList($idUser){
        //prende gli utenti che seguono $idUser, crea una lista di utenti
        $followerRow = FEntityManagerSQL::getInstance()->retriveObj(FRegisteredUser::getTable(), 'idFollowed', $idUser);
        $result = array();
        if(count($followerRow) > 0){
            for($i = 0; $i < count($followerRow); $i++){
                $user = FRegisteredUser::getObj($followerRow[$i]['idFollower']);
                $result[] = $user;
            }
        }
        return $result;
    }

//----------------------------------------------VERIFY-----------------------------------------------------

    /**
     * verify if exist a user with this email (also mod)
     * @param String $email
     */
    public static function verifyUserEmail($email){
        $result = FUser::verify('email', $email);

        return $result;
    }

    /**
     * verify if exist a user with this username (also mod)
     * @param String $username
     */
    public static function verifyUserUsername($username){
        $result = FUser::verify('username', $username);

        return $result;
    }

    /**
     * Method to update a User that have changed the password
     * @param \EUser $user
     */
    public static function updateUserPassword($user){
        $field = [['password', $user->getPassword()]];
        $result = FRegisteredUser::saveObj($user, $field);

        return $result;
    }

    /**
     * Method to update a User that have changed the username
     * @param \EUser $user
     */
    public static function updateUserUsername($user){
        $field = [['username', $user->getUsername()]];
        $result = FRegisteredUser::saveObj($user, $field);

        return $result;
    }

//------------------------------------------------------------------------------------


    public static function loadUsers($userInput){
        $result = array();
        if(is_array($userInput)){
            foreach($userInput as $u){
                $result[] = $u;
            }
        }else{
            $user = self::retriveObj(FRegisteredUser::getClass(), $userInput);
            $result[] = $user;
        }
        return $result;
    }

    //-------------------------------METODI AGGIUNTI----------------------------------------------

    public static function updateUserApproval($user){
        // Set the approval status of the user
        $user->setIsApproved(true);

        // Update the user in the database
        $result = self::uploadObj($user);

        return $result;
    }
    /**
     * Method to update a physicalData Obj that have changed his physicalData (sex, fatMass, leanMass, height, weight, bmi)
     * @param \EPhysicalData $physicalData
     */

    public static function updatePhysicalData($physicalData){
        $field = [['sex', $physicalData->getSex()], ['height', $physicalData->getHeight()], ['weight', $physicalData->getWeight()], ['leanMass', $physicalData->getLeanMass()], ['fatMass', $physicalData->getFatMass()], ['bmi', $physicalData->getBmi()]];
        $result = FPhysicalData::saveObj($physicalData, $field);

        return $result;
    }

    public static function updateTrainingCard($trainingCard){
        $field = [['exercises', $trainingCard->getExercises()], ['repetition', $trainingCard->getRepetition()], ['recovery', $trainingCard->getRecovery()]];
        $result = FTrainingCard::saveObj($trainingCard, $field);

        return $result;
    }

    // Carica l'oggetto credit card dato l'ID della carta di credito
    public static function loadCreditCardById($idCreditCard){
        // Recupera l'oggetto credit card dal database
        $creditCard = FCreditCard::getObj($idCreditCard);

        return $creditCard;
    }

    //salva l'oggetto subscription nel database
    public static function saveSubscription($subscription){
        // Save the subscription object in the database
        $result = FSubscription::saveObj($subscription);
        return $result;
    }


    public static function saveReservation($reservation){
        // Save the reservation object in the database
        $result = FReservation::saveObj($reservation);
        return $result;
    }

    public static function saveNews($news) {
        // Use the saveObj method of FNews to save the news item
        $result = FNews::saveObj($news);

        // Return the result of the save operation
        return $result;
    }

    public static function deleteRegisteredUser($email){
        // Call the deleteObj method of FRegisteredUser to delete the user
        $result = FRegisteredUser::deleteRegisteredUserObj($email);

        // Return the result of the delete operation
        return $result;
    }

    public static function deletePersonalTrainer($email){
        // Call the deleteObj method of FRegisteredUser to delete the user
        $result = FPersonalTrainer::deletePersonalTrainerObj($email);

        // Return the result of the delete operation
        return $result;
    }

    public static function deleteReservation($email) {
    // Use the deleteReservationInDb method of FReservation to delete the reservation
    $result = FReservation::deleteObj($email);

    // Return the result of the delete operation
    return $result;
   }
    public static function deleteNews($email) {
        // Use the deleteReservationInDb method of FReservation to delete the reservation
        $result = FNews::deleteObj($email);

        // Return the result of the delete operation
        return $result;
    }


    public function getTrainingCardsByEmail($emailRegisteredUser) {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FTrainingCard::getObj($emailRegisteredUser);
        // Convert the results into TrainingCard objects
        $trainingCards = [];
        foreach ($results as $row) {
            $trainingCard = new ETrainingCard($row['emailRegisteredUser'], $row['exercises'], $row['repetition'], $row['recovery']);
            $trainingCards[] = $trainingCard;
        }
        // Return the array of TrainingCard objects
        return $trainingCards;
    }

    public static function getPhysicalDataByEmail($emailRegisteredUser) {
        // get the objects from FPhysicalData
        $results = FPhysicalData::getObj($emailRegisteredUser);

        // Convert the results into PhysicalData objects
        $physicalData = [];
        foreach ($results as $row) {
            $data = new EPhysicalData($row['emailRegisteredUser'], $row['sex'], $row['height'], $row['weight'], $row['leanMass'], $row['fatMass'], $row['bmi']);
            $physicalData[] = $data;
        }
        // Return the array of PhysicalData objects
        return $physicalData;
    }

    public static function loadCreditCard($emailRegisteredUser) {
        // Use FEntityManagerSQL to execute the SQL statement
        $results= FCreditCard::getObj($emailRegisteredUser);

        // Convert the results into CreditCard objects
        $creditCard = [];
        foreach ($results as $row) {
            $card = new ECreditCard($row['cvc'], $row['accountHolder'], $row['cardNumber'], $row['expirationDate'], $row['email']);
            $creditCard[] = $card;
        }
        // Return the array of CreditCard objects
        return $creditCard;
    }

    public static function getFollowedUserReservationList($personalTrainerId) {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FReservation::getObj($personalTrainerId);

        // Convert the results into Reservation objects
        $reservations = [];
        foreach ($results as $row) {
            $reservation = new EReservation($row['emailRegisteredUser'], $row['date'], $row['trainingPT'], $row['time']);
            $reservations[] = $reservation;
        }
        // Return the array of Reservation objects
        return $reservations;
    }

    public static function createSubscription($email, $subscriptionType, $duration, $price) {
        // Create a new Subscription object based on the subscription type
        $subscription = new ESubscription($email, $subscriptionType, $duration, $price);

        // Return the created Subscription object
        return $subscription;
    }

    public static function createReservation($emailRegisteredUser, $date, $trainingPT, $time){
    $reservation = new EReservation($emailRegisteredUser, $date, $trainingPT, $time);

    // Return the created Subscription object
    return $reservation;
}

    public static function getUserReservation($emailRegisteredUser) {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FReservation::getObj($emailRegisteredUser);

        // Convert the results into Reservation objects
        $reservations = [];
        foreach ($results as $row) {
            $reservation = new EReservation($row['emailRegisteredUser'], $row['date'], $row['trainingPT'], $row['time']);
            $reservations[] = $reservation;
        }
        // Return the array of Reservation objects
        return $reservations;
    }


    public static function getUserSubscription($emailRegisteredUser) {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FSubscription::getObj($emailRegisteredUser);

        // Convert the results into Reservation objects
        $reservations = [];
        foreach ($results as $row) {
            $reservation = new EReservation($row ['email'], $row['type'], $row['duration'], $row['price']);
            $reservations[] = $reservation;
        }
        // Return the array of Reservation objects
        return $reservations;
    }




//TODO il path che si trova qui deve essere lo stesso del metodo generatePhysicalProgressChart in CPersonalTrainer
   public static function getChartImageUrl($emailRegisteredUser) {
    // Generate the physical progress chart
    FPhysicalData::generatePhysicalProgressChart($emailRegisteredUser);

    // Define the path where the chart image is saved
    $chartImagePath = "path/to/save/your/image.png";

    // Check if the chart image file exists
    if (file_exists($chartImagePath)) {
        // If the file exists, return the URL of the chart image
        return $chartImagePath;
    } else {
        // If the file does not exist, return an error message or a default image URL
        return "path/to/default/image.png";
    }
}

    public static function retrieveUnapprovedTrainers() {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FPersonalTrainer::getUnapprovedTrainers();

        // Convert the results into PersonalTrainer objects
        $trainers = [];
        foreach ($results as $row) {
            if ($row['approved'] == 0) { // Check if the trainer is unapproved
                $trainer = new EPersonalTrainer($row['first_name'], $row['last_name'], $row['email'], $row['password'], $row['username']);
                $trainer->setApproved($row['approved']);
                $trainers[] = $trainer;
            }
        }
        // Return the array of unapproved PersonalTrainer objects
        return $trainers;
    }


}

