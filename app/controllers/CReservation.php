<?php


class CReservation
{

    public static function cancelReservation($reservationId)
    {

        $result = FPersistentManager::getInstance()->deleteReservation($reservationId);

        if ($result) {

            header('Location: /GymBuddy/User/ReservationCancellationSuccess');
        } else {

            header('Location: /GymBuddy/User/ReservationCancellationError');
        }
    }

  public static function reservation()
{
    USession::getInstance();

    $userId = USession::getSessionElement('user');
    $user=FPersistentManager::retrieveUserById($userId);

    $view = new VReservation();

    if ($user->getType() == 'user_only') {
        $view->showReservationSub();
    } else if ($user->getType() == 'followed_user') {
        $view->showReservation();
    } else {

        error_log("Unrecognized user type: " . $user->getType());
    }
}


  public static function booking()
{

    USession::getInstance();

    if (!CUser::isLogged()) {

        header('Location: /GymBuddy/User/Login');
        exit();
    }

    $date = UHTTPMethods::post('date');
    $trainingPT = UHTTPMethods::post('pt') ? 1 : 0;
    $time = UHTTPMethods::post('time');

    $userId = USession::getSessionElement('user');

    $userReservation = FPersistentManager::retrieveReservationsByUserTimeAndDate($userId, $date, $time);
    if ($userReservation) {

        USession::setSessionElement('reservation_error', 'You have already made a reservation for this time slot.');
        header('Location: /GymBuddy/User/page404');
        exit();
    }

    $existingReservations = FPersistentManager::retrieveReservationsByTimeAndDate($date,$time );
    if (count($existingReservations) >= 2) {

        USession::setSessionElement('reservation_error', 'Maximum number of reservations reached for this time slot.');
        header('Location: /GymBuddy/User/page404');
        exit();
    }

    $reservation = new EReservation($userId, $date,$trainingPT, $time);

    // Save the EReservation object to the database
    FPersistentManager::getInstance()->uploadObj($reservation);
    USession::setSessionElement('reservation_success', 'reservation has been registered');

    header('Location: /GymBuddy/Reservation/confirmation');
    exit();
}

    public static function confirmation()
    {

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

    }

    public static function reservationInfo()
    {
        self::viewReservation();
    }


 public static function viewReservation() {
    // Ensure the session is started
    USession::getInstance();

    // Check if the user is logged in
    if (!CUser::isLoggedIn()) {
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    // Get the user ID from the session
    $userId = USession::getSessionElement('user');

    // Retrieve the training card data for the user
    $reservations = FPersistentManager::getReservationsById($userId);

    // Verify that the data was retrieved correctly
    if ($reservations === null || empty($reservations)) {
        // Log the error and redirect in case of data retrieval failure
        USession::setSessionElement('reservation_error',  'Sorry, but no reservations have been made yet');
        header('Location: /GymBuddy/Reservation/page404');
        exit();
    }

    // Get the view
    $view = new VReservation();

    // Show the training cards
    $view->showReservations($reservations);
}

    public static function page404()
    {

        USession::getInstance();

        $errorMessage = USession::getSessionElement('reservation_error');

        $view = new VReservation();

        $view->showPage404($errorMessage);

        USession::unsetSessionElement('reservation_error');
    }


    public static function deleteReservation() {
        // Ensure the session is started
        USession::getInstance();

        // Check if the user is logged in
        if (!CUser::isLoggedIn()) {
            header('Location: /GymBuddy/User/Login');
            exit();
        }

        // Get the reservation ID from the POST data
        $reservationId = UHTTPMethods::post('selected_reservation');

        // Delete the reservation from the database
        $result = FPersistentManager::deleteReservation($reservationId);

        // Redirect the user back to the reservations page
        if ($result) {
            header('Location: /GymBuddy/Reservation/viewReservation');
        } else {
            header('Location: /GymBuddy/Reservation/page404');
        }
        exit();
    }



}