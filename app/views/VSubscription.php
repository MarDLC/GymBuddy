<?php

require_once 'libs/Smarty/Smarty.class.php'; // Assicurati di includere Smarty

class VSubscription {
    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration(); // Usa l'istanza condivisa di Smarty
    }

    /**
     * Mostra il form di sottoscrizione
     *
     * @throws SmartyException
     */
    public function showSubscriptionForm() {
        $this->smarty->display('subscriptionForm.tpl');
    }

    /**
     * Visualizza un messaggio di errore
     *
     * @param string $errorMessage
     * @throws SmartyException
     */
    public function showError($errorMessage) {
        $this->smarty->assign('error', $errorMessage);
        $this->smarty->display('error.tpl');
    }
}
