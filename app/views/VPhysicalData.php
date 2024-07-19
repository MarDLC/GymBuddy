<?php

class VPhysicalData
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }



    public function showPhysicalDataInfo() {
        // Verifica se l'utente è loggato
        if (CUser::isLoggedIn()) {
            // Visualizza il template
            $this->smarty->display('viewGraphic.tpl');
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/User/Login');
            exit();
        }
    }


}

