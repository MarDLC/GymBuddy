<?php

class VTrainingCard{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

  public function showTrainingCardInfo() {
    // Verifica se l'utente è loggato
    if (CUser::isLoggedIn()) {
        // Visualizza il template
        $this->smarty->display('viewTrainingCard.tpl');
    } else {
        // Se l'utente non è loggato, reindirizza alla pagina di login
        header('Location: /GymBuddy/User/Login');
        exit();
    }
}


    public function showTrainingCardForm()
    {
        // Recupera l'ID utente selezionato dalla sessione
        $selectedUserId = USession::getSessionElement('selected_user');

        // Assegna l'ID utente selezionato a una variabile Smarty
        $this->smarty->assign('selectedUserId', $selectedUserId);

        // Mostra il template del form dei dati fisici
        $this->smarty->display('trainingCardForm.tpl');
    }


}