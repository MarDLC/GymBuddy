<?php

class VPhysicalData
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }





    public function displayProgressChart($chartImageUrl) {
        // Assign the chart image URL to a Smarty variable
        $this->smarty->assign('chartImageUrl', $chartImageUrl);

        // Display the template
        $this->smarty->display('viewGraphic.tpl');
    }

    public function showPhysicalDataInfo($dates, $weights, $leanMasses, $fatMasses)
    {
        // Verifica se l'utente è loggato
        if (CUser::isLoggedIn()) {
            // Assegna i dati del grafico al template
            $chartData = json_encode([
                'dates' => $dates,
                'weights' => $weights,
                'leanMasses' => $leanMasses,
                'fatMasses' => $fatMasses,
            ]);
            $this->smarty->assign('chartData', $chartData);
            // Visualizza il template
            $this->smarty->display('viewGraphic.tpl');
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/User/Login');
            exit();
        }
    }


    public function showPhysicalDataForm()
    {
        // Recupera l'ID utente selezionato dalla sessione
        $selectedUserId = USession::getSessionElement('selected_user');

        // Assegna l'ID utente selezionato a una variabile Smarty
        $this->smarty->assign('selectedUserId', $selectedUserId);

        // Mostra il template del form dei dati fisici
        $this->smarty->display('physicalDataForm.tpl');
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

