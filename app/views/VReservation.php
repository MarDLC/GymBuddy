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

    public function showReservationInfo()
    {
        if (CUser::isLoggedIn()) {
            // Visualizza il template
            $this->smarty->display('viewReservation.tpl');
        } else {
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


    public function showReservations($reservations) {
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

        $this->smarty->assign('reservations', $reservationsData);

        $this->smarty->display('viewReservation.tpl');
    }







    public function showPage404($message = 'Sorry, but no reservations have been made yet')
    {
        $this->smarty->assign('errorMessage', $message);

        $this->smarty->assign('homePathFrom404', "/GymBuddy/User/homeVIp");

        $this->smarty->display('404Reservation.tpl');
    }
}







