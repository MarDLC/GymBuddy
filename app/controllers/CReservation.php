<?php


class CReservation
{

    public static function bookSingleTraining() {
        // Check if the user is logged in
        if (CUser::isLogged()) {
            // Get the current logged-in user
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
        if (CUser::isLogged()) {
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
}