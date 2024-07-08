<?php


class CReservation
{

//TODO IN VIEW AGGIUNGERE UNA FUNZIONE CHE MOSTRI LE RESERVATION DI UN UTENTE
    // Mostra il calendario
    public static function showCalendar() {
        $view = new VReservation();
        $view->showCalendar();
    }

    // Gestisci la prenotazione dell'allenamento
    public static function bookTraining() {
        // Check if the user is logged in
        if (CUser::isLogged()) {
            // Get the current logged-in user
            $user = USession::getInstance()->getSessionElement('user');

            // Set the trainingPT field based on the user type
            $trainingPT = ($user->getType() == 'followed_user') ? 1 : 0;

            // Create a new reservation using FPersistentManager
            $reservation = FPersistentManager::getInstance()->createReservation($user->getEmail(), UHTTPMethods::post('date'), $trainingPT, UHTTPMethods::post('time'));

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