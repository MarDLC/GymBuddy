<?php

//use services\TechnicalServiceLayer\utility\UCookie;

class CUser{


    public static function login(){
        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('user')){
            header('Location: /GymBuddy/User/HomeRU');
        }
        $view = new VRegisteredUser();
        $view->showLoginForm();
    }

    public static function registration()
{
    $view = new VRegisteredUser();
    if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){

        $user = new ERegisteredUser(UHTTPMethods::post('email'), UHTTPMethods::post('username'), UHTTPMethods::post('first_name'),UHTTPMethods::post('last_name'),UHTTPMethods::post('password'));

        FPersistentManager::getInstance()->uploadObj($user);
        $view->showLoginForm();
    }else{
        $view->registrationError();
    }
}


    public static function isLogged()
    {
        $logged = false;

        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('user')){
            $logged = true;
        }
        if(!$logged){
            header('Location: /GymBuddy/User/Login');
            exit;
        }
        return true;
    }



    public static function checkLogin(){
        $view = new VRegisteredUser();
        $email = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($email){

            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));

            // Log per vedere quale utente viene restituito
            error_log('CUser::checkLogin - User retrieved: ' . print_r($user, true));

            if($user && password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('user', $user->getId());  // Aggiunta logica per ottenere l'ID

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
                error_log('CUser::checkLogin - Password verification failed for user: ' . UHTTPMethods::post('username'));
                $view->loginError();
            }
        } else {
            error_log('CUser::checkLogin - Email verification failed for username: ' . UHTTPMethods::post('username'));
            $view->loginError();
        }
    }







    public static function checkRole() {
        // Prendi l'username dal POST request
        $username = UHTTPMethods::post('username');

        // Cerca l'utente nel database
        $user = FPersistentManager::getInstance()->retriveUserOnUsernameGeneral($username);

        // Se l'utente esiste, restituisci il suo ruolo
        if ($user) {
            echo $user->getRole();
        } else {
            // Se l'utente non esiste, restituisci un messaggio di errore
            echo "User not found";
        }
    }



    public static function home(){
            $view = new VRegisteredUser();
            $view->showHome();
    }

    public static function homeRU(){
        if (CUser::isLogged()) {
            $view = new VRegisteredUser();
            $view->showHomeRU();
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/login');
            exit();
        }
    }






    public static function logout(){
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/User/Home');
    }



   /*
    public static function redirectUser() {
        // Ottieni l'utente corrente
        $user = USession::getInstance()->getSessionElement('user');

        // Controlla il tipo di utente e reindirizza alla corretta home page
        if ($user instanceof ERegisteredUser) {
            header('Location: /GymBuddy/User/HomeRU');
        } elseif ($user instanceof EPersonalTrainer) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        } elseif ($user instanceof EAdmin) {
            header('Location: /GymBuddy/Admin/Home');
        }
    } */


    public static function showUserSubscription() {
        // Check if the user is logged in
        if (self::isLogged()) {
            // Get the current logged-in user
            $userId = USession::getInstance()->getSessionElement('user');

            // Retrieve the user's subscription using FPersistentManager
            $subscription = FPersistentManager::getInstance()->getUserSubscription($userId);

            // Return the subscription object or null if no subscription was found
            return $subscription;
        }
        return null;
    }


    public static function showUserReservation() {
        // Check if the user is logged in
        if (self::isLogged()) {
            // Get the current logged-in user
            $userId = USession::getInstance()->getSessionElement('user');

            // Retrieve the user's reservation using FPersistentManager
            $reservation = FPersistentManager::getInstance()->getUserReservation($userId);

            // Return the reservation object or null if no reservation was found
            return $reservation;
        }
        return null;
    }

    //TODO FARE showUserPhysicalData e showUserTrainingCard

}