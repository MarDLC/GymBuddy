<?php

class VAdmin
{

    private $smarty;

    public function __construct(){

        $this->smarty = StartSmarty::configuration();

    }

    public function showLoginForm() {
        $this->smarty->assign('error', false);
        $this->smarty->assign('ban', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    public function loginError() {
        $this->smarty->assign('error', true);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    public function showHomeAD() {
        $this->smarty->display('homeAD.tpl');
    }

    public function showNewsForm() {
        $this->smarty->display('newsForm.tpl');
    }


}