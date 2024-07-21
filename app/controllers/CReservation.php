<?php


class CReservation
{

//TODO IN VIEW AGGIUNGERE UNA FUNZIONE CHE MOSTRI LE RESERVATION DI UN UTENTE
    // Mostra il calendario
    public static function showCalendar()
    {
        $view = new VReservation();
        $view->showCalendar();
    }

    // Gestisci la prenotazione dell'allenamento
    public static function bookTraining()
    {
        // Check if the user is logged in
        if (CUser::isLogged()) {
            // Get the current logged-in user
            $user = USession::getInstance()->getSessionElement('user');

            // Set the trainingPT field based on the user type
            $trainingPT = ($user->getType() == 'followed_user') ? 1 : 0;

            $date = UHTTPMethods::post('date');
            $time = UHTTPMethods::post('time');

            // Controlla il numero di prenotazioni esistenti per la data e l'ora specificate
            $maxReservationsPerSlot = 15;  // Definisce il limite di prenotazioni per fascia oraria
            $currentReservations = FReservation::countReservationsByDateAndTime($date, $time);

            if ($currentReservations >= $maxReservationsPerSlot) {
                // Se il limite è stato raggiunto, reindirizza l'utente a una pagina di errore
                header('Location: /GymBuddy/User/ReservationLimitReached');
            } else {
                // Se il limite non è stato raggiunto, crea una nuova prenotazione
                $reservation = FPersistentManager::getInstance()->createReservation($user->getEmail(), $date, $trainingPT, $time);

                // Salva la prenotazione nel database
                $result = FPersistentManager::getInstance()->saveReservation($reservation);

                // Controlla se la prenotazione è stata salvata correttamente
                if ($result) {
                    // Se ha avuto successo, reindirizza l'utente a una pagina di successo
                    header('Location: /GymBuddy/User/ReservationSuccess');
                } else {
                    // Se non ha avuto successo, reindirizza l'utente a una pagina di errore
                    header('Location: /GymBuddy/User/ReservationError');
                }
            }
        }
    }

    public static function cancelReservation($reservationId)
    {
        // Chiama il metodo per eliminare la prenotazione dal database
        $result = FPersistentManager::getInstance()->deleteReservation($reservationId);

        // Controlla se la prenotazione è stata eliminata correttamente
        if ($result) {
            // Se ha avuto successo, reindirizza l'utente a una pagina di successo
            header('Location: /GymBuddy/User/ReservationCancellationSuccess');
        } else {
            // Se non ha avuto successo, reindirizza l'utente a una pagina di errore
            header('Location: /GymBuddy/User/ReservationCancellationError');
        }
    }

  public static function reservation()
{
    USession::getInstance();
    // Retrieve the logged in user from the session
    $userId = USession::getSessionElement('user');
    $user=FPersistentManager::retrieveUserById($userId);

    // Create a new VReservation object
    $view = new VReservation();

    // Check the user type and call the appropriate view method
    if ($user->getType() == 'user_only') {
        $view->showReservationSub();
    } else if ($user->getType() == 'followed_user') {
        $view->showReservation();
    } else {
        // Handle the case where the user type is not recognized
        error_log("Unrecognized user type: " . $user->getType());
    }
}

    public static function reservationInfo()
    {
        // Recupera l'ID dell'utente corrente
        $userId = USession::getSessionElement('user');

        // Recupera le prenotazioni per l'utente corrente
        $reservations = FPersistentManager::retrieveReservationByUserId($userId);

        // Passa le prenotazioni alla vista
        VReservation::showReservationInfo($reservations);
    }

  public static function booking()
{
    // Ensure the session is started
    USession::getInstance();

    // Check if the user is logged in
    if (!CUser::isLogged()) {
        error_log("User is not logged in, redirecting to login page.");
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    // Retrieve the form data
    $date = UHTTPMethods::post('date');
    $time = UHTTPMethods::post('time');
    $trainingPT = UHTTPMethods::post('pt') ? 1 : 0;

    // Retrieve the logged in user ID from the session
    $userId = USession::getSessionElement('user');

    // Check if the user has already made a reservation for the same time slot and date
    $userReservation = FPersistentManager::retrieveReservationsByUserTimeAndDate($userId, $time, $date);
    if ($userReservation) {
        // If the user has already made a reservation, log an error message and redirect the user to an error page
        error_log("User has already made a reservation for time slot: $time on date: $date");
        USession::setSessionElement('reservation_error', 'You have already made a reservation for this time slot.');
        header('Location: /GymBuddy/User/page404');
        exit();
    }

    // Check the number of existing reservations for the same time slot and date
    $existingReservations = FPersistentManager::retrieveReservationsByTimeAndDate($time, $date);
    if (count($existingReservations) >= 2) {
        // If there are 15 or more existing reservations, log an error message and redirect the user to an error page
        error_log("Maximum number of reservations reached for time slot: $time on date: $date");
        USession::setSessionElement('reservation_error', 'Maximum number of reservations reached for this time slot.');
        header('Location: /GymBuddy/User/page404');
        exit();
    }

    // Create a new EReservation object
    $reservation = new EReservation($userId, $date, $trainingPT, $time);

    // Save the EReservation object to the database
    FPersistentManager::getInstance()->uploadObj($reservation);
    USession::setSessionElement('reservation_success', 'reservation has been registered');

    // Reindirizza l'utente alla pagina di conferma
    header('Location: /GymBuddy/Reservation/confirmation');
    exit();
}

    public static function confirmation()
    {
        // Log the start of the method
        error_log("Confirmation - Start");
        // Get the payment success message from the session
        $message = USession::getSessionElement('reservation_success');

        // Check if a session is active before destroying it
        if (session_status() == PHP_SESSION_ACTIVE) {
            // Destroy the session
            USession::unsetSession();
            USession::destroySession();
        }

        // Use ob_start() to start output buffering
        ob_start();

        // Use ob_end_flush() to flush the output buffer and turn off output buffering
        ob_end_flush();

        // Set a JavaScript redirect to the login page after 1 seconds
        $redirect = '<script>setTimeout(function(){ window.location.href = "/GymBuddy/User/homeVIP"; }, 1000);</script>';

        // Pass the message and the redirect script to the view
        $view = new VReservation();
        $view->showConfirmation($message, $redirect);

        // Log the end of the method
        error_log("Confirmation - End");
    }

}