<?php

/**
 * classe sql
 */
class FPersistentManager
{

    /**
     * Singleton Class
     */

    private static $instance;


    private function __construct()
    {


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
    public static function retriveObj($class, $id)
    {

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
    public static function uploadObj($obj)
    {
        $foundClass = "F" . substr(get_class($obj), 1);
        $staticMethod = "saveObj";

        $result = call_user_func([$foundClass, $staticMethod], $obj);

        return $result;
    }



   public static function retriveUserOnUsername($username)
{
    $result = FRegisteredUser::getUserByUsername($username);

    // If no RegisteredUser is found, try to retrieve a PersonalTrainer
    if ($result === null) {
        $result = FPersonalTrainer::getPersonalTrainerByUsername($username);
        // If multiple PersonalTrainers are found, return the first one
        if (is_array($result)) {
            $result = $result[0];
        }
    }

    // If no RegisteredUser or PersonalTrainer is found, try to retrieve an Admin
    if ($result === null) {
        $result = FAdmin::getUserByUsernameAdmin($username);
    }

    return $result;
}

public static function retrieveUserById($userId)
{
    // Try to retrieve a RegisteredUser by their ID
    $result = FRegisteredUser::getObj($userId);

    // Return the found user or null if no user was found
    return $result;
}

    public static function retrievePersonalTrainerById($userId)
    {
        // Try to retrieve a RegisteredUser by their ID
        $result = FPersonalTrainer::getObj($userId);

        // Return the found user or null if no user was found
        return $result;
    }


public static function retrieveAllUserById($userId)
{
    // Try to retrieve a RegisteredUser by their ID
    $result = FRegisteredUser::getObj($userId);
    error_log('RegisteredUser: ' . print_r($result, true));

    // If no RegisteredUser is found, try to retrieve a PersonalTrainer
    if ($result === null) {
        $result = FPersonalTrainer::getObj($userId);
        error_log('PersonalTrainer: ' . print_r($result, true));
    }

    // If no RegisteredUser or PersonalTrainer is found, try to retrieve an Admin
    if ($result === null) {
        $result = FAdmin::getObj($userId);
        error_log('Admin: ' . print_r($result, true));
    }

    // Return the found user or null if no user was found
    return $result;
}

public static function retrieveUserByIdAndType($userId, $type)
{
    // Initialize result to null
    $result = null;

    // Check if the type is 'followed_user'
    if ($type === 'followed_user') {
        // Try to retrieve followed users
        $followedUsers = FRegisteredUser::getFollowedUsers();
        // Search for the user with the given ID among the followed users
        foreach ($followedUsers as $user) {
            if ($user['idUser'] == $userId) {
                $result = $user;
                break;
            }
        }
    } else {
        // If the type is not 'followed_user', retrieve a RegisteredUser by their ID
        $result = FRegisteredUser::getObj($userId);
    }

    // Return the found user(s) or null if no user was found
    return $result;
}


public static function retrieveReservationByUserId($userId)
{
    // Try to retrieve Reservations by their User ID
    $result = FReservation::getObj($userId);

    // Return the found reservations or null if no reservations were found
    return $result;
}

public static function retrieveSubscriptionByUserId($userId){
    // Try to retrieve Reservations by their User ID
    $result = FSubscription::getLastSubscriptionByUserId($userId);

    // Debug output
    error_log("retrieveSubscriptionByUserId userId: " . $userId);
    error_log("retrieveSubscriptionByUserId result: " . print_r($result, true));

    // Return the found reservations or null if no reservations were found
    return $result;
}

    public function retriveUserOnUsernameAD($username)
    {
        $result = FAdmin::getUserByUsernameAdmin($username);
        error_log("retriveUserOnUsernameAD - Admin result: " . print_r($result, true));
        return $result;
    }

    public static function retrivePersonalTrainerOnUsername($username)
    {
        $result = FPersonalTrainer::getPersonalTrainerByUsername($username);

        // Assumi che la funzione restituisca un array
        return $result;
    }


    public static function retriveUserOnUsernameGeneral($username)
    {
        // Cerca l'utente nelle tabelle RegisteredUser, Admin e PersonalTrainer
        $registeredUser = FRegisteredUser::getUserByUsername($username);
        $admin = FAdmin::getUserByUsernameAdmin($username);
        $personalTrainer = FPersonalTrainer::getPersonalTrainerByUsername($username);

        // Log per vedere quali utenti sono stati trovati
        error_log('retriveUserOnUsernameGeneral - RegisteredUser: ' . print_r($registeredUser, true));
        error_log('retriveUserOnUsernameGeneral - Admin: ' . print_r($admin, true));
        error_log('retriveUserOnUsernameGeneral - PersonalTrainer: ' . print_r($personalTrainer, true));

        // Se l'utente esiste in una delle tabelle, restituisci l'utente
        if ($registeredUser) {
            return $registeredUser;
        } elseif ($admin) {
            return $admin;
        } elseif ($personalTrainer && is_array($personalTrainer) && count($personalTrainer) > 0) {
            return $personalTrainer[0];
        } else {
            // Se l'utente non esiste in nessuna delle tabelle, restituisci null
            return null;
        }
    }



    /**
     * Method to return the list of the followed user pf a user
     * @param int $idUser Refrs to the user who follow
     */
    public static function getUsersFollowedByTrainer($idTrainer)
    {
        //prende gli utenti seguiti dal personal trainer con id $idTrainer, crea una lista di utenti
        $followRow = FEntityManagerSQL::getInstance()->retriveObj(FRegisteredUser::getTable(), 'idFollower', $idTrainer);
        $result = array();
        if (count($followRow) > 0) {
            for ($i = 0; $i < count($followRow); $i++) {
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
    public static function getTrainersFollowingUser($idUser)
    {
        //prende i personal trainer che seguono $idUser, crea una lista di personal trainer
        $followerRow = FEntityManagerSQL::getInstance()->retriveObj(FPersonalTrainer::getTable(), 'idFollowed', $idUser);
        $result = array();
        if (count($followerRow) > 0) {
            for ($i = 0; $i < count($followerRow); $i++) {
                $trainer = FPersonalTrainer::getObj($followerRow[$i]['idFollower']);
                $result[] = $trainer;
            }
        }
        return $result;
    }
//----------------------------------------------VERIFY-----------------------------------------------------

    /**
     * verify if exist a user with this email (also mod)
     * @param String $email
     */
    public static function verifyUserEmail($email)
    {
        $result = FUser::verify('email', $email);

        return $result;
    }

    /**
     * verify if exist a user with this username (also mod)
     * @param String $username
     */
    public static function verifyUserUsername($username)
    {
        $result = FUser::verify('username', $username);

        return $result;
    }

    /**
     * Method to update a User that have changed the password
     * @param \EUser $user
     */
    public static function updateUserPassword($user)
    {
        $field = [['password', $user->getPassword()]];
        $result = FRegisteredUser::saveObj($user, $field);

        return $result;
    }

    /**
     * Method to update a User that have changed the username
     * @param \EUser $user
     */
    public static function updateUserUsername($user)
    {
        $field = [['username', $user->getUsername()]];
        $result = FRegisteredUser::saveObj($user, $field);

        return $result;
    }

//------------------------------------------------------------------------------------


    public static function loadUsers($userInput)
    {
        $result = array();
        if (is_array($userInput)) {
            foreach ($userInput as $u) {
                $result[] = $u;
            }
        } else {
            $user = self::retriveObj(FRegisteredUser::getClass(), $userInput);
            $result[] = $user;
        }
        return $result;
    }

    //-------------------------------METODI AGGIUNTI----------------------------------------------

    public static function updateUserApproval($user, $approvalStatus)
    {
        // Set the approval status of the user
        $user->setIsApproved($approvalStatus);

        // Update the user in the database
        $result = self::uploadObj($user);

        return $result;
    }

    /**
     * Method to update a physicalData Obj that have changed his physicalData (sex, fatMass, leanMass, height, weight, bmi)
     * @param \EPhysicalData $physicalData
     */

    public static function updatePhysicalData($physicalData)
    {
        $field = [['sex', $physicalData->getSex()], ['height', $physicalData->getHeight()], ['weight', $physicalData->getWeight()], ['leanMass', $physicalData->getLeanMass()], ['fatMass', $physicalData->getFatMass()], ['bmi', $physicalData->getBmi()]];
        $result = FPhysicalData::saveObj($physicalData, $field);

        return $result;
    }

    public static function updateTrainingCard($trainingCard)
    {
        $field = [['exercises', $trainingCard->getExercises()], ['repetition', $trainingCard->getRepetition()], ['recovery', $trainingCard->getRecovery()]];
        $result = FTrainingCard::saveObj($trainingCard, $field);

        return $result;
    }

    // Carica l'oggetto credit card dato l'ID della carta di credito
    public static function loadCreditCardById($idCreditCard)
    {
        // Recupera l'oggetto credit card dal database
        $creditCard = FCreditCard::getObj($idCreditCard);

        return $creditCard;
    }

    //salva l'oggetto subscription nel database
    public static function saveSubscription($subscription)
    {
        // Save the subscription object in the database
        $result = FSubscription::saveObj($subscription);
        return $result;
    }


    public static function saveReservation($reservation)
    {
        // Save the reservation object in the database
        $result = FReservation::saveObj($reservation);
        return $result;
    }



    public static function deleteRegisteredUser($email)
    {
        // Call the deleteObj method of FRegisteredUser to delete the user
        $result = FRegisteredUser::deleteRegisteredUserObj($email);

        // Return the result of the delete operation
        return $result;
    }

    public static function deletePersonalTrainer($id)
    {
        // Call the deleteObj method of FPersonalTrainer to delete the user
        $result = FPersonalTrainer::deletePersonalTrainerObj($id);

        // Return the result of the delete operation
        return $result;
    }

    public static function deleteReservation($email)
    {
        // Use the deleteReservationInDb method of FReservation to delete the reservation
        $result = FReservation::deleteObj($email);

        // Return the result of the delete operation
        return $result;
    }

    public static function deleteNews($email)
    {
        // Use the deleteReservationInDb method of FReservation to delete the reservation
        $result = FNews::deleteObj($email);

        // Return the result of the delete operation
        return $result;
    }


public static function getTrainingCardsById($userId)
{
    // Use FTrainingCard to get the training cards for the user
    $trainingCards = FTrainingCard::getTrainingCardsByIdUser($userId);
    // Return the array of TrainingCard objects
    return $trainingCards;
}

    public static function getPhysicalDataByEmail($emailRegisteredUser)
    {
        // get the objects from FPhysicalData
        $results = FPhysicalData::getObj($emailRegisteredUser);

        // Convert the results into PhysicalData objects
        $physicalData = [];
        foreach ($results as $row) {
            $data = new EPhysicalData($row['idUser'], $row['sex'], $row['height'], $row['weight'], $row['leanMass'], $row['fatMass'], $row['bmi']);
            $physicalData[] = $data;
        }
        // Return the array of PhysicalData objects
        return $physicalData;
    }

    public static function loadCreditCard($emailRegisteredUser)
    {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FCreditCard::getObj($emailRegisteredUser);

        // Convert the results into CreditCard objects
        $creditCard = [];
        foreach ($results as $row) {
            $card = new ECreditCard($row['idSubscription'], $row['idUser'], $row['cvc'], $row['accountHolder'], $row['cardNumber'], $row['expirationDate']);
            $creditCard[] = $card;
        }
        // Return the array of CreditCard objects
        return $creditCard;
    }

    public static function getFollowedUserReservationList($personalTrainerId)
    {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FReservation::getObj($personalTrainerId);

        // Convert the results into Reservation objects
        $reservations = [];
        foreach ($results as $row) {
            $reservation = new EReservation($row['idUser'], $row['date'], $row['trainingPT'], $row['time']);
            $reservations[] = $reservation;
        }
        // Return the array of Reservation objects
        return $reservations;
    }

    public static function createSubscription($idUser, $type, $duration, $price)
    {
        // Create a new Subscription object based on the subscription type
        $subscription = new ESubscription($idUser, $type, $duration, $price);

        // Return the created Subscription object
        return $subscription;
    }

 public static function updateUserTypeBasedOnSubscription($userId, $subscription)
{
    // Prepara la chiamata al metodo appropriato in FRegisteredUser
    $foundClass = "FRegisteredUser";
    $staticMethod = "updateType";

    // Esegui la chiamata al metodo
    $result = call_user_func([$foundClass, $staticMethod], $subscription);

    return $result;
}

    // Crea una nuova prenotazione
    public static function createReservation($idUser, $date, $trainingPT, $time = '02:00:00')
    {
        $reservation = new EReservation($idUser, $date, $trainingPT, $time);
        return $reservation;
    }

    // Conta le prenotazioni per una determinata data e ora
    public static function countReservationsByDateAndTime($date, $time)
    {
        return FReservation::countReservationsByDateAndTime($date, $time);
    }


    // Ottieni le prenotazioni di un utente
    public static function getUserReservation($idUser)
    {
        $results = FReservation::getObj($idUser);
        $reservations = [];
        foreach ($results as $row) {
            $reservation = new EReservation($row['idUser'], $row['date'], $row['trainingPT'], $row['time']);
            $reservations[] = $reservation;
        }
        return $reservations;
    }

    public static function getUserSubscription($idUser)
    {
        // Use FEntityManagerSQL to execute the SQL statement
        $results = FSubscription::getObj($idUser);

        // Convert the results into Reservation objects
        $subscriptions = [];
        foreach ($results as $row) {
            $subscription = new ESubscription($row ['idUser'], $row['type'], $row['duration'], $row['price']);
            $subscriptions[] = $subscription;
        }
        // Return the array of Reservation objects
        return $subscriptions;
    }


//TODO il path che si trova qui deve essere lo stesso del metodo generatePhysicalProgressChart in CPersonalTrainer
    public static function getChartImageUrl($emailRegisteredUser)
    {
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

    public static function getPhysicalDataById($userId)
    {
        error_log('getPhysicalDataById - id: ' . $userId);
        $physicalData = FPhysicalData::getPhysicalDataByIdUser($userId);
        error_log('getPhysicalDataById - PhysicalData results: ' . print_r($physicalData, true));
        return $physicalData;
    }

    public static function generatePhysicalProgressChart($idUser) {
        // Generate the physical progress chart
        return FPhysicalData::generatePhysicalProgressChart($idUser);
    }


    public static function getChartData($idUser) {
        return FPhysicalData::generatePhysicalProgressChart($idUser);
    }

    public static function saveNews($news)
    {
        error_log("FPersistentManager::saveNews - Saving news: " . print_r($news, true));

        $result = FNews::saveObj($news);

        if ($result) {
            error_log("FPersistentManager::saveNews - News saved successfully");
        } else {
            error_log("FPersistentManager::saveNews - Failed to save news");
        }

        return $result;
    }

    public static function getAllNews()
    {
        $newsList = FNews::getAll();
        return $newsList;
    }

  public static function retrieveReservationsByTimeAndDate($date, $time)
{
    // Call the corresponding method in FReservation
    return FReservation::retrieveReservationsByTimeAndDate($date, $time);
}

    public static function retrieveReservationsByUserTimeAndDate($userId, $date, $time)
    {
        // Call the corresponding method in FReservation
        return FReservation::retrieveReservationsByUserTimeAndDate($userId,  $date, $time);
    }

    public static function getTrainerData() {
        // Richiama il metodo getReservationsData di FPersonalTrainer senza passare $userId
        return FPersonalTrainer::getReservationsData();
    }

    public static function getReservationsById($userId)
    {
        // Use FTrainingCard to get the training cards for the user
        $reservations = FReservation::getReservationsByIdUser($userId);
        // Return the array of TrainingCard objects
        return $reservations;
    }

    public static function retrieveFollowedUsers() {
    // Call the getFollowedUsers method in FRegisteredUser
    $result = FRegisteredUser::getFollowedUsers();

    // Return the result
    return $result;
}


}


