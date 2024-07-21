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

    $userId = USession::getSessionElement('user');

    $user = FPersistentManager::retrieveUserById($userId);

    if ($user && ($user->getType() === 'followed_user' || $user->getType() === 'user_only')){
        $path = "/GymBuddy/User/homeVIP";
    } else if ($user && $user->getType() === null) {
        $path = "/GymBuddy/User/homeRU";
    } else {
        $path = USession::getSessionElement('homePath');
    }

    $view->showSubscription($path);
}


public static function subscriptionInfo() {
    // Ensure the session is started
    USession::getInstance();

    $userId = USession::getSessionElement('user');

    $subscriptions = FPersistentManager::retrieveSubscriptionByUserId($userId);

    $vSubscription = new VSubscription();

    $vSubscription->showSubscriptionInfo($subscriptions);
}
}
