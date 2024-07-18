<?php

class CSubscription {

    // Mostra il modulo di sottoscrizione
    public static function showForm() {
        $view = new VSubscription();
        $view->showSubscriptionForm();
    }


}
