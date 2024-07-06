<?php


class CSubscription
{

    //Buy a subscription
    public static function purchaseSubscription() {
        // Check if the user is logged in
        if (CUser::isLogged()) {
            // Get the current logged-in user
            $userId = USession::getInstance()->getSessionElement('user');

            // Load the user's credit card information
            $creditCards = FPersistentManager::getInstance()->loadCreditCard($userId);

            // Check if the user has a valid credit card
            if (!empty($creditCards)) {
                $creditCard = $creditCards[0];
                if ($creditCard->isValid()){
                    // Create a new subscription
                    $subscription = FPersistentManager::getInstance()->createSubscription(UHTTPMethods::post('email'),UHTTPMethods::post('type'), UHTTPMethods::post('duration'), UHTTPMethods::post('price'));

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


}