<?php




class CPersonalTrainer
{

public static function login(){
    if (UCookie::isSet('PHPSESSID')) {
        if (session_status() == PHP_SESSION_NONE) {
            USession::getInstance();
        }
    }
    if (USession::isSetSessionElement('personalTrainer')) {
        header('Location: /GymBuddy/PersonalTrainer/homePT');
    }
    $view = new VPersonalTrainer();

    // Prima di mostrare il form di login, assicurati che 'regErr' sia sempre impostato
    if (!isset($view->regErr)) {
        $view->regErr = false;
    }

    $view->showLoginForm();
}

    public static function registration()
    {
        $view = new VPersonalTrainer();
        if (FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false) {
            $user = new EPersonalTrainer(UHTTPMethods::post('first_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'), UHTTPMethods::post('password'), UHTTPMethods::post('username'));
            FPersistentManager::getInstance()->uploadObj($user);

            $view->showLoginForm();
        } else {
            $view->registrationError();
        }
    }

    public static function isLogged()
    {
        $logged = false;

        if (UCookie::isSet('PHPSESSID')) {
            if (session_status() == PHP_SESSION_NONE) {
                USession::getInstance();
            }
        }
        if (USession::isSetSessionElement('personalTrainer')) {
            $logged = true;
        }
        if (!$logged) {
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
        return true;
    }




    public static function checkLogin(){
        $view = new VPersonalTrainer();
        $email = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($email){

            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));

            // Log per vedere quale utente viene restituito
            error_log('CPersonalTrainer::checkLogin - User retrieved: ' . print_r($user, true));

            if($user && password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('personalTrainer', $user->getId());  // Aggiunta logica per ottenere l'ID

                    // Controlla se l'utente è un Personal Trainer
                    if ($user instanceof EPersonalTrainer) {
                        header('Location: /GymBuddy/PersonalTrainer/homePT');
                    } elseif ($user instanceof EAdmin) {
                        // Logica per l'admin
                        header('Location: /GymBuddy/Admin/homeAD');
                    } else {
                        // Logica per l'utente registrato
                        header('Location: /GymBuddy/User/homeRU');
                    }
                }
            } else {
                error_log('CPersonalTrainer::checkLogin - Password verification failed for user: ' . UHTTPMethods::post('username'));
                $view->loginError();
            }
        } else {
            error_log('CPersonalTrainer::checkLogin - Email verification failed for username: ' . UHTTPMethods::post('username'));
            $view->loginError();
        }
    }



    public static function logout()
    {
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/PersonalTrainer/login');
    }







    public static function showFollowedUsers()
    {
        // Check if the personal trainer is logged in
        if (self::isLogged()) {
            // Get the list of emails of followed users
            $followedUsersEmails = FPersonalTrainer::getListEmailsOfFollowedUsers();

            // Get the view
            $view = new VPersonalTrainer();

            // Show the followed users on the home page
            $view->showFollowedUsersList($followedUsersEmails);
        } else {
            // If the personal trainer is not logged in, redirect to the login page
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
    }



    public static function viewBookings() {
        // Check if the personal trainer is logged in
        if (self::isLogged()) {
            // Get the current logged in personal trainer
            $personalTrainerId = USession::getInstance()->getSessionElement('user');

            // Retrieve the bookings for the personal trainer
            $bookings = FPersistentManager::getInstance()->getFollowedUserReservationList($personalTrainerId);

            // Get the view
            $view = new VPersonalTrainer();

            // Show the bookings on the profile page
            $view->showBookings($bookings);
        } else {
            // If the personal trainer is not logged in, redirect to the login page
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
    }

    public static function viewUserReservation() {
        // Check if the user is logged in
        if (self::isLogged()) {
            // Get the current logged-in user
            $userId = USession::getInstance()->getSessionElement('user');

            // Retrieve the user's reservation using FPersistentManager
            $reservation = FPersistentManager::getInstance()->getUserReservation($userId);

            // Check if the reservation was retrieved successfully
            if ($reservation) {
                // If successful, display the reservation details
                // Implement a method to display the reservation details
                VPersonalTrainer::displayReservationDetails($reservation);
            } else {
                // If not successful, display an error message
                // Implement a method to display an error message
                VPersonalTrainer::displayErrorMessage("No reservation found.");
            }
        } else {
            // If the user is not logged in, display an error message
            VPersonalTrainer::displayErrorMessage("User not logged in.");
        }
    }

    public static function homePT(){
        if (CPersonalTrainer::isLogged()) {
            $view = new VPersonalTrainer();
            $view->showHomePT();
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/login');
            exit();
        }
    }


public static function clientsList() {
    // Ensure the session is started
    USession::getInstance();



    // Recupera gli utenti seguiti dal personal trainer corrente
    $lists = FRegisteredUser::getFollowedUsers();

    // Log the retrieved lists
    error_log("Retrieved lists: " . print_r($lists, true));

    // Crea un'istanza di VPersonalTrainer
    $vClientsList = new VPersonalTrainer();

    // Passa gli utenti seguiti alla vista
    $vClientsList->showClientsList($lists);
}



}