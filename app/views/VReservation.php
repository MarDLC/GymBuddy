<?php

class VReservation
{

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    // Mostra il calendario
    public function showCalendar()
    {
        // Carica il template del calendario
        $this->smarty->display('calendar.tpl');
    }

    // Mostra le opzioni di prenotazione
    public function showBookingOptions($options)
    {
        // Assegna le opzioni al template
        $this->smarty->assign('options', $options);
        // Carica il template delle opzioni di prenotazione
        $this->smarty->display('bookingOptions.tpl');
    }

    // Mostra un messaggio di errore quando il limite di prenotazioni è stato raggiunto
    public function showReservationLimitReached()
    {
        // Carica il template del messaggio di errore
        $this->smarty->display('reservationLimitReached.tpl');
    }

    // ... Resto del codice ...


    public function showReservationInfo()
    {
        // Verifica se l'utente è loggato
        if (CUser::isLoggedIn()) {
            // Visualizza il template
            $this->smarty->display('viewReservation.tpl');
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/User/Login');
            exit();
        }
    }

    public function showReservation()
    {
        $this->smarty->display('reservationForm.tpl');
    }

    public function showReservationSub()
    {
        $this->smarty->display('reservationFormSub.tpl');
    }


    public function showConfirmation($message, $redirect)
    {
        // Assign the message to a Smarty variable
        $this->smarty->assign('message', $message);

        // Assign the redirect script to a Smarty variable
        $this->smarty->assign('redirect', $redirect);

        // Display the confirmation template
        $this->smarty->display('confirmation.tpl');
    }


    /*public function showReservations($reservations)
    {
        // Prepara i dati per il template Smarty
        $reservationsData = [];
        if ($reservations !== null) {
            foreach ($reservations as $reservation) {
                error_log("Processing reservation: " . print_r($reservation, true)); // Log per ogni prenotazione

                $reservationsData[] = [
                    'date' => $reservation->getDate()->format('Y-m-d'),
                    'trainingPT' => $reservation->getTrainingPT(),
                    'time' => $reservation->getTimeStr(),
                ];
            }
        }
        // Log dei dati preparati per Smarty
        error_log("Prepared reservationsData for Smarty: " . print_r($reservationsData, true));

        // Verifica se ci sono prenotazioni da mostrare
        if (empty($reservationsData)) {
            // Se non ci sono prenotazioni, log dell'errore e redirezione a una pagina 404 personalizzata
            error_log("No reservations found, redirecting to 404 error page.");
            USession::setSessionElement('reservation_error', 'No reservations found for the specified criteria.');
            header('Location: /GymBuddy/Reservation/page404');
            exit();
        }

        // Assegna i dati preparati al template Smarty
        $this->smarty->assign('reservations', $reservationsData);

        // Mostra il template
        try {
            $this->smarty->display('viewReservation.tpl');
        } catch (Exception $e) {
            error_log("Smarty display error: " . $e->getMessage());
        }

        // Log dopo aver chiamato showReservationsList
        error_log("After calling showReservationsList");
    }*/

    public function showReservations($reservations) {
        // Prepara i dati per il template Smarty
        $reservationsData = [];
        if ($reservations !== null) {
            foreach ($reservations as $reservation) {
                $reservationsData[] = [
                    'id' => $reservation->getIdReservation(),
                    'date' => $reservation->getDate()->format('Y-m-d'),
                    'trainingPT' => $reservation->getTrainingPT(),
                    'time' => $reservation->getTimeStr(),
                ];
            }
        }

        // Assegna i dati preparati al template Smarty
        $this->smarty->assign('reservations', $reservationsData);

        // Mostra il template
        $this->smarty->display('viewReservation.tpl');
    }







    public function showPage404($message = 'Sorry, but no reservations have been made yet')
    {



        // Assegna il messaggio alla variabile Smarty
        $this->smarty->assign('errorMessage', $message);

        $this->smarty->assign('homePathFrom404', "/GymBuddy/User/homeVIp");
        // Visualizza il template
        $this->smarty->display('404Reservation.tpl');
    }
}







