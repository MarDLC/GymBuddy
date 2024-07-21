<?php

class VTrainingCard{
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

  public function showTrainingCardInfo() {
    if (CUser::isLoggedIn()) {
        $this->smarty->display('viewTrainingCard.tpl');
    } else {
        header('Location: /GymBuddy/User/Login');
        exit();
    }
}


    public function showTrainingCardForm()
    {
        $selectedUserId = USession::getSessionElement('selected_user');

        $this->smarty->assign('selectedUserId', $selectedUserId);

        $this->smarty->display('trainingCardForm.tpl');
    }


    public function showConfirmation($message, $redirect) {
        // Assign the message to a Smarty variable
        $this->smarty->assign('message', $message);

        // Assign the redirect script to a Smarty variable
        $this->smarty->assign('redirect', $redirect);

        // Display the confirmation template
        $this->smarty->display('confirmation.tpl');
    }

    public function showTrainingCards($trainingCards) {
        // Assign the training card data to the Smarty template
        $this->smarty->assign('trainingCards', $trainingCards);

        // Display the viewTrainingCard.tpl template
        $this->smarty->display('viewTrainingCard.tpl');
    }

    public function showPage404($message = 'Sorry, but no Training Cards have been made yet')
    {
        $this->smarty->assign('errorMessage', $message);

        $this->smarty->assign('homePathFrom404', "/GymBuddy/User/homeVIP");

        $this->smarty->display('404Reservation.tpl');
    }



}