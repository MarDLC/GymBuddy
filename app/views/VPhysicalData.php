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
        $this->smarty->display('viewChart.tpl');
    }

    public function showPhysicalDataInfo($dates, $weights, $leanMasses, $fatMasses)
    {
        if (CUser::isLoggedIn()) {

            $chartData = json_encode([
                'dates' => $dates,
                'weights' => $weights,
                'leanMasses' => $leanMasses,
                'fatMasses' => $fatMasses,
            ]);
            $this->smarty->assign('chartData', $chartData);

            $this->smarty->display('viewChart.tpl');
        } else {

            header('Location: /GymBuddy/User/Login');
            exit();
        }
    }


    public function showPhysicalDataForm()
    {
        $selectedUserId = USession::getSessionElement('selected_user');

        $this->smarty->assign('selectedUserId', $selectedUserId);

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

