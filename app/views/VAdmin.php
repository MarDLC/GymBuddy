<?php

class VAdmin
{

    private $smarty;

    public function __construct(){

        $this->smarty = StartSmarty::configuration();

    }

    public function showLoginForm()
    {
        $this->smarty->assign('error', false);
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

    public function showRequests() {
        $this->smarty->assign('meta_description', 'Gym Template');
        $this->smarty->assign('meta_keywords', 'Gym, unica, creative, html');
        $this->smarty->assign('title', 'Richieste Personal Trainer');
        $this->smarty->assign('section_title', 'Required approvals');
        $this->smarty->assign('options', ['Opzione 1', 'Opzione 2', 'Opzione 3']);
        $this->smarty->display('approvaiscrizioni.tpl');
    }


}