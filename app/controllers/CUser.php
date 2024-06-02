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
        $view = new VRegisteredUser();
        if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
            $user = new ERegisteredUser(UHTTPMethods::post('first_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'),UHTTPMethods::post('password'),UHTTPMethods::post('username'));
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
        if(USession::isSetSessionElement('registeredUser')){
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
        $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($username){
            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
            if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('user', $user);
                    header('Location: /GymBuddy/User/Home');
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

    //take the training card of the user
    public static function viewTrainingCard($emailRegisteredUser) {
        // Retrieve the TrainingCard objects for the client using FPersistentManager
        $trainingCards = FPersistentManager::getInstance()->getTrainingCardsByEmail($emailRegisteredUser);

        // Pass the TrainingCard objects to the view for display
        $view = new VPersonalTrainer();
        $view->showTrainingCards($trainingCards);
    }


    public static function viewPhysicalData($emailRegisteredUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPersistentManager::getInstance()->getPhysicalDataByEmail($emailRegisteredUser);

        // Pass the PhysicalData objects to the view for display
        $view = new VPersonalTrainer();
        $view->showPhysicalData($physicalData);
    }

    //Buy a subscription
   public static function purchaseSubscription() {
    // Check if the user is logged in
    if (CUser::isLogged()) {
        // Get the current logged in user
        $userId = USession::getInstance()->getSessionElement('user');

        // Load the user and their credit card information
        $user = FPersistentManager::getInstance()->loadUsers($userId);
        $creditCard = FPersistentManager::getInstance()->loadCreditCard($userId);

        // Check if the user has a valid credit card
        if ($creditCard->isValid()) {
            // Create a new subscription
            $subscription = FPersistentManager::getInstance()->createSubscription(UHTTPMethods::post('subscriptionType'), UHTTPMethods::post('duration'), UHTTPMethods::post('price'));

            // Use the credit card to pay for the subscription
            if ($creditCard->pay($subscription->getPrice())) {
                // If the payment is successful, save the subscription in the database
                FPersistentManager::getInstance()->saveSubscription($subscription);

                // Redirect the user to a success page
                header('Location: /GymBuddy/User/SubscriptionSuccess');
            } else {
                // If the payment is not successful, redirect the user to an error page
                header('Location: /GymBuddy/User/SubscriptionError');
            }
        } else {
            // If the user does not have a valid credit card, redirect them to an error page
            header('Location: /GymBuddy/User/CreditCardError');
        }
    }
}

    public static function bookSingleTraining() {
    // Check if the user is logged in
    if (self::isLogged()) {
        // Get the current logged in user
        $userId = USession::getInstance()->getSessionElement('user');

        // Create a new reservation using FPersistentManager
        $reservation = FPersistentManager::getInstance()->createReservation(UHTTPMethods::post('emailRegisteredUser'), UHTTPMethods::post('date'), UHTTPMethods::post('time'), 'Single Training');

        // Save the reservation in the database
        $result = FPersistentManager::getInstance()->saveReservation($reservation);

        // Check if the reservation was saved successfully
        if ($result) {
            // If successful, redirect the user to a success page
            header('Location: /GymBuddy/User/ReservationSuccess');
        } else {
            // If not successful, redirect the user to an error page
            header('Location: /GymBuddy/User/ReservationError');
        }
    }
}

//TODO $emailPersonalTrainer da decidere se recuperarla così oppure con metodo UHTTPMethods::post('emailPersonalTrainer')
    public static function bookTrainingWithPT( $emailPersonalTrainer) {
        // Check if the user is logged in
        if (self::isLogged()) {
            // Get the current logged-in user
            $userId = USession::getInstance()->getSessionElement('user');

            // Create a new reservation using FPersistentManager
            $reservation = FPersistentManager::getInstance()->createReservation(UHTTPMethods::post('emailRegisteredUser'), UHTTPMethods::post('date'), UHTTPMethods::post('time'), 'Training with PT', $emailPersonalTrainer);

            // Save the reservation in the database
            $result = FPersistentManager::getInstance()->saveReservation($reservation);

            // Check if the reservation was saved successfully
            if ($result) {
                // If successful, redirect the user to a success page
                header('Location: /GymBuddy/User/ReservationSuccess');
            } else {
                // If not successful, redirect the user to an error page
                header('Location: /GymBuddy/User/ReservationError');
            }
        }
    }

    public static function cancelReservation($reservationId) {
    // Call the method to delete the reservation from the database
    $result = FPersistentManager::getInstance()->deleteReservation($reservationId);

    // Check if the reservation was deleted successfully
    if ($result) {
        // If successful, redirect the user to a success page
        header('Location: /GymBuddy/User/ReservationCancellationSuccess');
    } else {
        // If not successful, redirect the user to an error page
        header('Location: /GymBuddy/User/ReservationCancellationError');
    }
    }

    //TODO
    public static function viewProgressChart($emailRegisteredUser) {
        // Get the URL of the generated chart image using FPersistentManager
        $chartImageUrl = FPersistentManager::getInstance()->getChartImageUrl($emailRegisteredUser);

        // Return the HTML to display the chart image
        return '<img src="' . $chartImageUrl . '" alt="Physical Progress Chart">';
    }




}