<?php

class VReservation {

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    // Mostra il calendario
    public function showCalendar() {
        // Carica il template del calendario
        $this->smarty->display('calendar.tpl');
    }

    // Mostra le opzioni di prenotazione
    public function showBookingOptions($options) {
        // Assegna le opzioni al template
        $this->smarty->assign('options', $options);
        // Carica il template delle opzioni di prenotazione
        $this->smarty->display('bookingOptions.tpl');
    }

    // Mostra un messaggio di errore quando il limite di prenotazioni è stato raggiunto
    public function showReservationLimitReached() {
        // Carica il template del messaggio di errore
        $this->smarty->display('reservationLimitReached.tpl');
    }

    // ... Resto del codice ...



public static function showReservationInfo($reservations) {
    // Assegna le prenotazioni alla variabile Smarty
    $smarty = new Smarty();
    $smarty->assign('reservations', $reservations);

    // Visualizza il template
    $smarty->display('viewReservation.tpl');
}

    public function showReservation()
    {
        $this->smarty->display('reservationForm.tpl');
    }

    public function showReservationSub()
    {
        $this->smarty->display('reservationFormSub.tpl');
    }



    public function showConfirmation($message, $redirect) {
        // Assign the message to a Smarty variable
        $this->smarty->assign('message', $message);

        // Assign the redirect script to a Smarty variable
        $this->smarty->assign('redirect', $redirect);

        // Display the confirmation template
        $this->smarty->display('confirmation.tpl');
    }

}