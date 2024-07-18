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
        return USession::isSetSessionElement('user');
    }


    public static function checkLogin()
    {
        $view = new VRegisteredUser();
        $email = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if ($email) {

            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));

            // Log per vedere quale utente viene restituito
            error_log('CUser::checkLogin - User retrieved: ' . print_r($user, true));

            if ($user && password_verify(UHTTPMethods::post('password'), $user->getPassword())) {
                if (USession::getSessionStatus() == PHP_SESSION_NONE) {
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
            // Se l'utente non è loggato, reindirizza alla pagina di login
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

    public static function subscription()
    {
        $view = new VRegisteredUser();
        $view->showSubscription();
    }


    public static function logout()
    {
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/User/Home');
    }


    public static function showUserSubscription()
    {
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


    public static function showUserReservation()
    {
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

    public static function paymentForm($postData)
    {
        USession::getInstance();
        // Add this line to log the start of the method
        error_log("PaymentForm - Start");

        // Recupera i dettagli dell'abbonamento dal form e li salva nella sessione
        $type = $postData['type'];
        $duration = $postData['duration'];
        $price = $postData['price'];

        // Add these lines to log the values returned by UHTTPMethods::post
        error_log("PaymentForm - Type from post: $type");
        error_log("PaymentForm - Duration from post: $duration");
        error_log("PaymentForm - Price from post: $price");

        USession::setSessionElement('subscription_type', $type);
        USession::setSessionElement('subscription_duration', $duration);
        USession::setSessionElement('subscription_price', $price);

        // Add these lines to log the subscription details
        error_log("Stored subscription type: " . USession::getSessionElement('subscription_type'));
        error_log("Stored subscription duration: " . USession::getSessionElement('subscription_duration'));
        error_log("Stored subscription price: " . USession::getSessionElement('subscription_price'));

        // Add these lines to check the session status and the session data
        error_log("Session status in paymentForm: " . session_status());
        error_log("Session data in paymentForm: " . print_r($_SESSION, true));
        error_log("Session ID in paymentForm: " . session_id());

        // Verifica che i dettagli dell'abbonamento siano stati salvati nella sessione
        if (empty($type) || empty($duration) || empty($price)) {
            error_log("ERROR: Subscription details are missing in paymentForm.");
            header('Location: /GymBuddy/User/chooseSubscription');
            exit();
        }

        // Visualizza il modulo di pagamento
        $view = new VRegisteredUser();
        $view->showPaymentForm();

        // Debug: Log the user object after showing the payment form
        $userId = USession::getSessionElement('user');
        $user = FPersistentManager::retrieveUserById($userId);
        error_log("User after showing payment form: " . print_r($user, true));
    }


 public static function payment()
{
    // Ensure the session is started
    USession::getInstance();

    // Add these lines to check the session status and the session data
    error_log("Session status in payment: " . session_status());
    error_log("Session data in payment: " . print_r($_SESSION, true));
    error_log("Session ID in paymentInizio: " . session_id());

    // Verifica se l'utente è loggato
    if (!self::isLoggedIn()) {
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    // Debug: Verifica l'utente nella sessione
    $userId = USession::getSessionElement('user');
    $user = FPersistentManager::retrieveUserById($userId);

    // Verifica che $user sia un oggetto ERegisteredUser
    if (!($user instanceof ERegisteredUser)) {
        error_log("ERROR: User is not an ERegisteredUser object.");
        // Gestisci l'errore qui, ad esempio reindirizzando l'utente a una pagina di errore
        header('Location: /GymBuddy/User/error');
        exit();
    }

    error_log("User in session: " . print_r($user, true));

    // Add this line to log the user object
    error_log("Retrieved user: " . print_r($user, true));

    // Recupera i dettagli dell'abbonamento dalla sessione
    $type = USession::getSessionElement('subscription_type');
    $duration = USession::getSessionElement('subscription_duration');
    $price = USession::getSessionElement('subscription_price');

    // Add these lines to log the subscription details
    error_log("Retrieved subscription type: " . $type);
    error_log("Retrieved subscription duration: " . $duration);
    error_log("Retrieved subscription price: " . $price);
    error_log("Session ID in paymentFine: " . session_id());

    // Recupera i dati della carta di credito dal form
    $cardNumber = UHTTPMethods::post('cardNumber');
    $expiryDate = UHTTPMethods::post('expiryDate');
    $cvv = UHTTPMethods::post('cvv');
    $accountHolder = UHTTPMethods::post('accountHolder');

    // Debug: Verifica i dati ricevuti
    error_log("Type: $type, Duration: $duration, Price: $price");
    error_log("Card Number: $cardNumber, Expiry Date: $expiryDate, CVV: $cvv, Account Holder: $accountHolder");

    // Crea un nuovo oggetto Subscription
    $subscription = new ESubscription($user->getId(), $type, $duration, $price);

    // Salva l'oggetto Subscription nel database e verifica il risultato
    $idSubscription = FPersistentManager::getInstance()->uploadObj($subscription);
    error_log("Subscription save result: " . print_r($idSubscription, true));

    // Crea un nuovo oggetto CreditCard
    $creditCard = new ECreditCard($idSubscription, $user->getId(), $cvv, $accountHolder, $cardNumber, $expiryDate);

    // Salva l'oggetto CreditCard nel database e verifica il risultato
    $result = FPersistentManager::getInstance()->uploadObj($creditCard);
    error_log("CreditCard save result: " . print_r($result, true));

    // Set a session variable to indicate that the payment was successful
    USession::setSessionElement('payment_success', 'Your payment was successful!');

    // Debug: Log the user object after all operations
    error_log("User after all operations: " . print_r($user, true));

    // Reindirizza l'utente alla pagina di conferma
    header('Location: /GymBuddy/User/confirmation');
    exit();
}
    public static function confirmation()
    {
        // Get the payment success message from the session
        $message = USession::getSessionElement('payment_success');

        // Pass the message to the view
        $view = new VRegisteredUser();
        $view->showConfirmation($message);
    }


}