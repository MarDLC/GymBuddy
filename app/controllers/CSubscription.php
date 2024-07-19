<?php

class CSubscription {

    // Mostra il modulo di sottoscrizione
    public static function showForm() {
        $view = new VSubscription();
        $view->showSubscriptionForm();
    }


 public static function subscription()
{
    // Ensure the session is started
    USession::getInstance();

    $view = new VSubscription();

    // Recupera l'ID utente dalla sessione
    $userId = USession::getSessionElement('user');
    error_log("User ID: " . $userId);  // Log the user ID

    // Recupera l'utente dal database
    $user = FPersistentManager::retrieveUserById($userId);
    error_log("User: " . print_r($user, true));  // Log the user object

    // Controlla il tipo di utente e imposta il path appropriato
    if ($user && ($user->getType() === 'followed_user' || $user->getType() === 'user_only')){
        $path = "/GymBuddy/User/homeVIP";
    } else if ($user && $user->getType() === null) {
        $path = "/GymBuddy/User/homeRU";
    } else {
        $path = USession::getSessionElement('homePath');
    }

    // Log the path
    error_log("Path: " . $path);

    $view->showSubscription($path);
}


public static function subscriptionInfo() {
    // Ensure the session is started
    USession::getInstance();
    // Recupera l'ID dell'utente corrente
    $userId = USession::getSessionElement('user');

    // Debug output
    error_log("subscriptionInfo userId: " . $userId);

    // Recupera le prenotazioni per l'utente corrente
    $subscriptions = FPersistentManager::retrieveSubscriptionByUserId($userId);

    // Crea un'istanza di VSubscription
    $vSubscription = new VSubscription();

    // Passa le prenotazioni alla vista
    $vSubscription->showSubscriptionInfo($subscriptions);
}
}
