<?php

class VRegisteredUser {

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
    public function showLoginForm() {
        $this->smarty->assign('error', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function loginError() {
        $this->smarty->assign('error', true);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function registrationError() {
        $this->smarty->assign('error', false);
        $this->smarty->assign('regErr', true);
        $this->smarty->display('login.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function settings($user) {
        $this->smarty->assign('error', false);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->display('setting.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function usernameError($user, $error) {
        $this->smarty->assign('error', $error);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->display('setting.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showPhysicalData($physicalData) {
        $this->smarty->assign('physicalData', $physicalData);
        $this->smarty->display('physical_data_user.tpl');
    }



}
