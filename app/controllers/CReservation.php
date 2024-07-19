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

    public static function cancelReservation($reservationId) {
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
        $view = new VRegisteredUser();
        $view->showReservation();
    }


}