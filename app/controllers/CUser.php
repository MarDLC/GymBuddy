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
    error_log("Is user logged in: " . ($isLoggedIn ? "Yes" : "No")); // Debug message
    return $isLoggedIn;
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
                    // Controlla il tipo di utente
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

    // Recupera i dettagli dell'abbonamento dalla sessione
    $type = USession::getSessionElement('subscription_type');
    $duration = USession::getSessionElement('subscription_duration');
    $price = USession::getSessionElement('subscription_price');

    // Recupera i dati della carta di credito dal form
    $cardNumber = UHTTPMethods::post('cardNumber');
    $expiryDate = UHTTPMethods::post('expiryDate');
    $cvv = UHTTPMethods::post('cvv');
    $accountHolder = UHTTPMethods::post('accountHolder');

    // Crea un nuovo oggetto Subscription
    $subscription = new ESubscription($user->getId(), $type, $duration, $price);

    // Salva l'oggetto Subscription nel database e verifica il risultato
    $idSubscription = FPersistentManager::getInstance()->uploadObj($subscription);

    // Crea un nuovo oggetto CreditCard
    $creditCard = new ECreditCard($idSubscription, $user->getId(), $cvv, $accountHolder, $cardNumber, $expiryDate);

    // Salva l'oggetto CreditCard nel database e verifica il risultato
    $result = FPersistentManager::getInstance()->uploadObj($creditCard);

    // Se l'oggetto Subscription e l'oggetto CreditCard sono stati salvati con successo, aggiorna il tipo di utente
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
    // Log the start of the method
    error_log("Confirmation - Start");
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
        self::isLogged(); // Verifica se l'utente è loggato

        // Recupera tutte le news dal database
        $newsList = FPersistentManager::getInstance()->getAllNews();

        // Crea una nuova istanza di VRegisteredUser
        $view = new VRegisteredUser();

        // Mostra le news utilizzando il metodo showNews
        $view->showNews($newsList);
    }




}