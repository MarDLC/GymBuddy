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

    // ... Resto del codice ...
}
