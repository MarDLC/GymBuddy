<?php

//use services\TechnicalServiceLayer\utility\UCookie;

class CUser
{


    public static function login()
    {
        if (UCookie::isSet('PHPSESSID')) {
            if (session_status() == PHP_SESSION_NONE) {
                USession::getInstance();
            }
        }
        if (USession::isSetSessionElement('user')) {
            header('Location: /GymBuddy/User/HomeRU');
        }
        $view = new VRegisteredUser();
        $view->showLoginForm();
    }

    public static function forceLogin()
    {
        $view = new VRegisteredUser();
        $view->showLoginForm();
    }

    public static function registration()
    {
        $view = new VRegisteredUser();
        if (FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false) {

            $user = new ERegisteredUser(UHTTPMethods::post('email'), UHTTPMethods::post('username'), UHTTPMethods::post('first_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('password'));

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
            header('Location: /GymBuddy/User/Login');
            exit;
        }
        return true;
    }

   public static function isLoggedIn()
{
    if (UCookie::isSet('PHPSESSID')) {
        if (session_status() == PHP_SESSION_NONE) {
            USession::getInstance();
        }
    }
    $isLoggedIn = USession::isSetSessionElement('user');
    return $isLoggedIn;
}

  public static function checkLogin()
{
    $view = new VRegisteredUser();
    $email = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
    if ($email) {

        $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));

        if ($user && password_verify(UHTTPMethods::post('password'), $user->getPassword())) {
            if (USession::getSessionStatus() == PHP_SESSION_NONE) {
                USession::getInstance();
                USession::setSessionElement('user', $user->getId());  // Aggiunta logica per ottenere l'ID

                if ($user instanceof EPersonalTrainer) {
                    header('Location: /GymBuddy/PersonalTrainer/homePT');
                } elseif ($user instanceof EAdmin) {

                    header('Location: /GymBuddy/Admin/homeAD');
                } else {

                    if ($user->getType() == 'followed_user' || $user->getType() == 'user_only') {
                        header('Location: /GymBuddy/User/homeVIP');
                    } else {
                        header('Location: /GymBuddy/User/homeRU');
                    }
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

    public static function home()
    {
        $view = new VRegisteredUser();
        $view->showHome();
    }

    public static function homeRU()
    {
        if (CUser::isLogged()) {
            $view = new VRegisteredUser();
            $view->showHomeRU();
        } else {

            header('Location: /GymBuddy/login');
            exit();
        }
    }

    public static function aboutus()
    {
        $view = new VRegisteredUser();
        $view->showAboutUs();
    }

    public static function services()
    {
        $view = new VRegisteredUser();
        $view->showServices();
    }

    public static function team()
    {
        $view = new VRegisteredUser();
        $view->showTeam();
    }

    public static function gallery()
    {
        $view = new VRegisteredUser();
        $view->showGallery();
    }

    public static function contact()
    {
        $view = new VRegisteredUser();
        $view->showContact();
    }

    public static function logout()
    {
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/User/Home');
    }

    public static function paymentForm($postData)
    {
        USession::getInstance();
        // Add this line to log the start of the method
        error_log("PaymentForm - Start");

        $type = $postData['type'];
        $duration = $postData['duration'];
        $price = $postData['price'];

        USession::setSessionElement('subscription_type', $type);
        USession::setSessionElement('subscription_duration', $duration);
        USession::setSessionElement('subscription_price', $price);

        if (empty($type) || empty($duration) || empty($price)) {
            error_log("ERROR: Subscription details are missing in paymentForm.");
            header('Location: /GymBuddy/User/chooseSubscription');
            exit();
        }

        $view = new VRegisteredUser();
        $view->showPaymentForm();

        $userId = USession::getSessionElement('user');
        $user = FPersistentManager::retrieveUserById($userId);
        error_log("User after showing payment form: " . print_r($user, true));
    }


public static function payment()
{
    // Ensure the session is started
    USession::getInstance();

    if (!self::isLoggedIn()) {
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    $userId = USession::getSessionElement('user');
    $user = FPersistentManager::retrieveUserById($userId);

    if (!($user instanceof ERegisteredUser)) {
        header('Location: /GymBuddy/User/error');
        exit();
    }

    $type = USession::getSessionElement('subscription_type');
    $duration = USession::getSessionElement('subscription_duration');
    $price = USession::getSessionElement('subscription_price');

    $cardNumber = UHTTPMethods::post('cardNumber');
    $expiryDate = UHTTPMethods::post('expiryDate');
    $cvv = UHTTPMethods::post('cvv');
    $accountHolder = UHTTPMethods::post('accountHolder');

    $subscription = new ESubscription($user->getId(), $type, $duration, $price);

    $idSubscription = FPersistentManager::getInstance()->uploadObj($subscription);

    $creditCard = new ECreditCard($idSubscription, $user->getId(), $cvv, $accountHolder, $cardNumber, $expiryDate);

    $result = FPersistentManager::getInstance()->uploadObj($creditCard);

    if ($idSubscription && $result) {
        FPersistentManager::getInstance()->updateUserTypeBasedOnSubscription($userId, $subscription);
    }

    // Set a session variable to indicate that the payment was successful
    USession::setSessionElement('payment_success', 'Your payment was successful!');

    // Reindirizza l'utente alla pagina di conferma
    header('Location: /GymBuddy/User/confirmation');
    exit();
}


public static function confirmation()
{
    // Get the payment success message from the session
    $message = USession::getSessionElement('payment_success');

    // Check if a session is active before destroying it
    if(session_status() == PHP_SESSION_ACTIVE) {
        // Destroy the session
        USession::unsetSession();
        USession::destroySession();
    }

    // Use ob_start() to start output buffering
    ob_start();

    // Use ob_end_flush() to flush the output buffer and turn off output buffering
    ob_end_flush();

    // Set a JavaScript redirect to the login page after 1 seconds
    $redirect = '<script>setTimeout(function(){ window.location.href = "/GymBuddy/User/forceLogin"; }, 1000);</script>';

    // Pass the message and the redirect script to the view
    $view = new VRegisteredUser();
    $view->showConfirmation($message, $redirect);

    // Log the end of the method
    error_log("Confirmation - End");
}

    public static function homeVIP()
    {
        if (CUser::isLogged()) {
            $view = new VRegisteredUser();
            $view->showHomeVIP();
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/login');
            exit();
        }
    }

    public static function getLoggedInUserId() {
        if (self::isLoggedIn()) {
            return USession::getInstance()->getSessionElement('user');
        }
        return null;
    }

    public static function news() {
        USession::getInstance();
        self::isLogged();

        $newsList = FPersistentManager::getInstance()->getAllNews();

        $view = new VRegisteredUser();

        $view->showNews($newsList);
    }


    public static function page404()
    {

        USession::getInstance();

        $errorMessage = USession::getSessionElement('reservation_error');
        error_log("Retrieved error message from session: " . $errorMessage);

        $view = new VRegisteredUser();

        $view->showPage404($errorMessage);

        USession::unsetSessionElement('reservation_error');
    }

}