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
            header('Location: /GymBuddy/User/Home');
        }
        $view = new VRegisteredUser();
        $view->showLoginForm();
    }

    public static function registration()
    {
        error_log('first_name: ' . (isset($_POST['first_name']) ? $_POST['first_name'] : 'missing'));
        error_log('last_name: ' . (isset($_POST['last_name']) ? $_POST['last_name'] : 'missing'));

        $view = new VRegisteredUser();
        if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
            /*
            // Controlla se l'utente vuole registrarsi come Personal Trainer
            if (isset($_POST['isTrainer'])) {
                $user = new EPersonalTrainer(UHTTPMethods::post('email'), UHTTPMethods::post('username'), UHTTPMethods::post('first_name'),UHTTPMethods::post('last_name'),UHTTPMethods::post('password'));
                $user->setApproved(0);  // Imposta 'approved' a 0
                FPersistentManager::getInstance()->uploadObj($user);

                // Mostra un messaggio all'utente per informarlo che la sua richiesta è in attesa di approvazione
                $view->showMessage('La tua richiesta è stata inviata e sarà esaminata da un amministratore. Riceverai una notifica quando la tua richiesta sarà approvata.');
            } else { */
                $user = new ERegisteredUser(UHTTPMethods::post('email'), UHTTPMethods::post('username'), UHTTPMethods::post('first_name'),UHTTPMethods::post('last_name'),UHTTPMethods::post('password'));

                FPersistentManager::getInstance()->uploadObj($user);
                $view->showLoginForm();
           // }
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
        $email = FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email'));
        if($email){
            $user = FPersistentManager::getInstance()->retriveUserOnEmail(UHTTPMethods::post('email'));
            if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('user', $user);
                    // Controlla se l'utente è un Personal Trainer approvato
                    if ($user instanceof EPersonalTrainer && $user->getApproved() == 1) {
                        header('Location: /GymBuddy/PersonalTrainer/Home');
                    } else {
                        header('Location: /GymBuddy/User/Home');
                    }
                }
            }else{
                $view->loginError();
            }
        }else{
            $view->loginError();
        }
    }




    public static function logout(){
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/User/Login');
    }

    public static function settings(){
        if(CUser::isLogged()){
            $view = new VRegisteredUser();

            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->loadUsers($userId);
            $view->settings($user);
        }
    }


    public static function setUsername(){
        if(CUser::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retriveObj(ERegisteredUser::getEntity(), $userId);

            if($user->getUsername() == UHTTPMethods::post('username')){
                header('Location: /GymBuddy/User/PersonalProfile');
            }else{
                if(FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false)
                {
                    $user->setUsername(UHTTPMethods::post('username'));
                    FPersistentManager::getInstance()->updateUserUsername($user);
                    header('Location: /GymBuddy/User/PersonalProfile');
                }else{
                    $view = new VRegisteredUser();
                    $user = FPersistentManager::getInstance()->loadUsers($userId);
                    $view->usernameError($user , true);
                }
            }
        }
    }

    public static function setPassword(){
        if(CUser::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retriveObj(ERegisteredUser::getEntity(), $userId);$newPass = UHTTPMethods::post('password');
            $user->setPassword($newPass);
            FPersistentManager::getInstance()->updateUserPassword($user);

            header('Location: /GymBuddy/User/PersonalProfile');
        }
    }

    public static function redirectUser() {
        // Ottieni l'utente corrente
        $user = USession::getInstance()->getSessionElement('user');

        // Controlla il tipo di utente e reindirizza alla corretta home page
        if ($user instanceof ERegisteredUser) {
            header('Location: /GymBuddy/User/Home');
        } elseif ($user instanceof EPersonalTrainer) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        } elseif ($user instanceof EAdmin) {
            header('Location: /GymBuddy/Admin/Home');
        }
    }


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