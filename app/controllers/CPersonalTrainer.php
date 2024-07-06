<?php




class CPersonalTrainer
{

    public static function login(){
        if (UCookie::isSet('PHPSESSID')) {
            if (session_status() == PHP_SESSION_NONE) {
                USession::getInstance();
            }
        }
        if (USession::isSetSessionElement('user')) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        }
        $view = new VPersonalTrainer();
        $view->showLoginForm();
    }

    public static function registration()
    {
        $view = new VPersonalTrainer();
        if (FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false) {
            $user = new EPersonalTrainer(UHTTPMethods::post('first_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'), UHTTPMethods::post('password'), UHTTPMethods::post('username'));
            $user->setApproved(false); // Set the approval status to false
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
        if (USession::isSetSessionElement('user')) {
            $logged = true;
        }
        if (!$logged) {
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
        return true;
    }

    public static function checkLogin()
    {
        $view = new VPersonalTrainer();
        $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if ($username) {
            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
            if (password_verify(UHTTPMethods::post('password'), $user->getPassword())) {
                if (USession::getSessionStatus() == PHP_SESSION_NONE) {
                    USession::getInstance();
                    // Salva l'intero oggetto utente nella sessione
                    USession::setSessionElement('user', $user);
                    header('Location: /GymBuddy/PersonalTrainer/Home');
                }
            } else {
                $view->loginError();
            }
        } else {
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

    public static function settings(){
        if(CPersonalTrainer::isLogged()){
            $view = new VPersonalTrainer();

            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->loadUsers($userId);
            $view->settings($user);
        }
    }


    public static function setUsername(){
        if(CPersonalTrainer::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retriveObj(EPersonalTrainer::getEntity(), $userId);

            if($user->getUsername() == UHTTPMethods::post('username')){
                header('Location: /GymBuddy/User/PersonalTrainerProfile');
            }else{
                if(FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false)
                {
                    $user->setUsername(UHTTPMethods::post('username'));
                    FPersistentManager::getInstance()->updateUserUsername($user);
                    header('Location: /GymBuddy/User/PersonalTrainerProfile');
                }else{
                    $view = new VPersonalTrainer();
                    $user = FPersistentManager::getInstance()->loadUsers($userId);
                    $view->usernameError($user , true);
                }
            }
        }
    }

    public static function setPassword(){
        if(CPersonalTrainer::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->retriveObj(ERegisteredUser::getEntity(), $userId);$newPass = UHTTPMethods::post('password');
            $user->setPassword($newPass);
            FPersistentManager::getInstance()->updateUserPassword($user);

            header('Location: /GymBuddy/User/PersonalTrainerProfile');
        }
    }

    public static function redirectUser()
    {
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


}