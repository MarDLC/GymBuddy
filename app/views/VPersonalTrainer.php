<?php


class VPersonalTrainer
{

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * @throws SmartyException
     */
    public function showHomePT()
    {
        $this->smarty->display('homePT.tpl');
    }


    /**
     * @throws SmartyException
     */
    //Assumendo che il parametro $emails sia un array contenente gli indirizzi email degli utenti seguiti, il metodo itera su di esso e li visualizza nel template followed_users.tpl
    public function showFollowedUsersList($emails)
    {
        $this->smarty->assign('emails', $emails);
        $this->smarty->display('followed_users.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showClientProfile($clientData)
    {
        $this->smarty->assign('client', $clientData);
        $this->smarty->display('client_profile.tpl');
    }

    public function registrationError()
    {
        $this->smarty->assign('error', false);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', true);
        $this->smarty->display('login.tpl');
    }

    public function showLoginForm()
    {
        $this->smarty->assign('error', false);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    public function loginError()
    {
        $this->smarty->assign('error', true);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }


    public function uploadFileError($error)
    {
        $this->smarty->assign('errore', $error);
        $this->smarty->display('errore.tpl');
    }

    /**
     * @throws SmartyException
     */
    public static function displayReservationDetails($reservation)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign('reservation', $reservation);
        $smarty->display('reservation_details.tpl');
    }

    /**
     * @throws SmartyException
     */
    public static function displayErrorMessage($message)
    {
        $smarty = StartSmarty::configuration();
        $smarty->assign('errorMessage', $message);
        $smarty->display('error_message.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showBookings($bookings)
    {
        $this->smarty->assign('bookings', $bookings);
        $this->smarty->display('bookings.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showPhysicalData($physicalData)
    {
        $this->smarty->assign('physicalData', $physicalData);
        $this->smarty->display('physical_data_trainer.tpl');
    }

    public function showTrainingCards($trainingCard)
    {
        $this->smarty->assign('trainingCard', $trainingCard);
        $this->smarty->display('training_card_trainer.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showCreatePhysicalDataForm()
    {
        $this->smarty->assign('formAction', 'createPhysicalData');
        $this->smarty->display('create_physical_data_form.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showCreateTrainingCardForm()
    {
        $this->smarty->assign('formAction', 'createTrainingCard');
        $this->smarty->display('create_training_card_form.tpl');
    }


    public function showClientsList($clients)
    {
        // Log the $clients array that is passed to the method
        error_log("Clients array passed to showClientsList: " . print_r($clients, true));
        // Debug output
        error_log("Before calling showClientsList: " . print_r($clients, true));

        // Prepare the data for the Smarty template
        $clientsData = [];
        if ($clients !== null) {
            foreach ($clients as $client) {
                error_log("Processing client: " . print_r($client, true)); // Log each client being processed
                $clientsData[] = [
                    'idUser' => isset($client['idUser']) ? (int)$client['idUser'] : null,
                    'name' => isset($client['first_name']) ? $client['first_name'] : '',
                    'surname' => isset($client['last_name']) ? $client['last_name'] : '',
                    'email' => isset($client['email']) ? $client['email'] : '',
                ];
            }
        }

        // Additional debug output for clientsData
        error_log("Prepared clientsData for Smarty: " . print_r($clientsData, true));

        // Assign the prepared data to the Smarty template
        $this->smarty->assign('clients', $clientsData);

        // Display the template
        try {
            error_log("Before calling Smarty display"); // Log before displaying the template
            $this->smarty->display('clientsList.tpl');
            error_log("After calling Smarty display"); // Log after displaying the template
        } catch (Exception $e) {
            error_log("Smarty display error: " . $e->getMessage());
        }

        // Log after calling showClientsList
        error_log("After calling showClientsList");
    }




    public function showReservationsList($reservations)
    {
        // Log dei dati passati al metodo
        error_log("Reservations array passed to showReservationsList: " . print_r($reservations, true));

        // Prepara i dati per il template Smarty
        $reservationsData = [];
        if ($reservations !== null) {
            foreach ($reservations as $reservation) {
                error_log("Processing reservation: " . print_r($reservation, true)); // Log per ogni prenotazione

                $reservationsData[] = [
                    'name' => isset($reservation['first_name']) ? $reservation['first_name'] : '',
                    'surname' => isset($reservation['last_name']) ? $reservation['last_name'] : '',
                    'email' => isset($reservation['email']) ? $reservation['email'] : '',
                    'date' => isset($reservation['date']) ? $reservation['date'] : '',
                    'time' => isset($reservation['time']) ? $reservation['time'] : '',
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
            header('Location: /GymBuddy/User/page404');
            exit();
        }

        // Assegna i dati preparati al template Smarty
        $this->smarty->assign('reservations', $reservationsData);

        // Mostra il template
        try {
            error_log("Before calling Smarty display"); // Log prima di mostrare il template
            $this->smarty->display('reservationsList.tpl');
            error_log("After calling Smarty display"); // Log dopo aver mostrato il template
        } catch (Exception $e) {
            error_log("Smarty display error: " . $e->getMessage());
        }

        // Log dopo aver chiamato showReservationsList
        error_log("After calling showReservationsList");
    }

    public function showPage404($message = 'Sorry, but no reservations have been made yet')
    {


        // Assegna il messaggio alla variabile Smarty
        $this->smarty->assign('errorMessage', $message);

        $this->smarty->assign('homePathFrom404', "/GymBuddy/PersonalTrainer/homePT");
        // Visualizza il template
        $this->smarty->display('404Reservation.tpl');
    }

}



