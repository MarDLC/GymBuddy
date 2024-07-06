<?php


class VPersonalTrainer{

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct(){
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * @throws SmartyException
     */
    public function showHome($trainerData) {
        $this->smarty->assign('trainer', $trainerData);
        $this->smarty->display('home_trainer.tpl');
    }


    /**
     * @throws SmartyException
     */
    //Assumendo che il parametro $emails sia un array contenente gli indirizzi email degli utenti seguiti, il metodo itera su di esso e li visualizza nel template followed_users.tpl
    public function showFollowedUsersList($emails) {
        $this->smarty->assign('emails', $emails);
        $this->smarty->display('followed_users.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showClientProfile($clientData) {
        $this->smarty->assign('client', $clientData);
        $this->smarty->display('client_profile.tpl');
    }

    public function registrationError() {
        $this->smarty->assign('error',false);
        $this->smarty->assign('ban',false);
        $this->smarty->assign('regErr',true);
        $this->smarty->display('login.tpl');
    }

    public function showLoginForm() {
        $this->smarty->assign('error', false);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    public function loginError() {
        $this->smarty->assign('error', true);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    public function settings($user) {
        $this->smarty->assign('errorImg', false);
        $this->smarty->assign('error', false);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->assign('userPic', $user[0][1]);
        $this->smarty->display('setting.tpl');
    }

    public function usernameError($user, $error) {
        $this->smarty->assign('errorImg', false);
        $this->smarty->assign('error', $error);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->assign('userPic', $user[0][1]);
        $this->smarty->display('setting.tpl');
    }

    public function uploadFileError($error){
        $this->smarty->assign('errore', $error);
        $this->smarty->display('errore.tpl');
    }

    /**
     * @throws SmartyException
     */
    public static function displayReservationDetails($reservation) {
        $smarty = StartSmarty::configuration();
        $smarty->assign('reservation', $reservation);
        $smarty->display('reservation_details.tpl');
    }

    /**
     * @throws SmartyException
     */
    public static function displayErrorMessage($message) {
        $smarty = StartSmarty::configuration();
        $smarty->assign('errorMessage', $message);
        $smarty->display('error_message.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showBookings($bookings) {
        $this->smarty->assign('bookings', $bookings);
        $this->smarty->display('bookings.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showPhysicalData($physicalData) {
        $this->smarty->assign('physicalData', $physicalData);
        $this->smarty->display('physical_data_trainer.tpl');
    }

    public function showTrainingCards($trainingCard) {
        $this->smarty->assign('trainingCard', $trainingCard);
        $this->smarty->display('training_card_trainer.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showCreatePhysicalDataForm() {
        $this->smarty->assign('formAction', 'createPhysicalData');
        $this->smarty->display('create_physical_data_form.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showCreateTrainingCardForm() {
        $this->smarty->assign('formAction', 'createTrainingCard');
        $this->smarty->display('create_training_card_form.tpl');
    }







}
