<?php

class VRegisteredUser
{

    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct()
    {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * @throws SmartyException
     */
    public function showLoginForm($message = null, $isTrainer = false)
    {
        $this->smarty->assign('message', $message);
        $this->smarty->assign('isTrainer', $isTrainer);
        $this->smarty->assign('error', false);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function loginError()
    {
        $this->smarty->assign('error', true);
        $this->smarty->assign('regErr', false);
        $this->smarty->display('login.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function registrationError()
    {
        $this->smarty->assign('error', false);
        $this->smarty->assign('regErr', true);
        $this->smarty->display('login.tpl');
    }

   public function showHome()
{
    // Nel tuo controller
    if (CUser::isLoggedIn()) {
        $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
    } else {
        $this->smarty->assign('homePath', '/GymBuddy/User/home');
    }
    $this->smarty->display('home.tpl');
}
    public function showHomeRU()
    {
        $this->smarty->display('homeRU.tpl');
    }


    /**
     * @throws SmartyException
     */
    public function settings($user)
    {
        $this->smarty->assign('error', false);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->display('setting.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function usernameError($user, $error)
    {
        $this->smarty->assign('error', $error);
        $this->smarty->assign('user', $user[0][0]);
        $this->smarty->display('setting.tpl');
    }

    /**
     * @throws SmartyException
     */
    public function showPhysicalData($physicalData)
    {
        $this->smarty->assign('physicalData', $physicalData);
        $this->smarty->display('physical_data_user.tpl');
    }

    public function showAboutUs()
    {
        // Nel tuo controller
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('about-us.tpl');
    }

   public function showServices()
{
    // Nel tuo controller
    if (CUser::isLoggedIn()) {
        $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        $this->smarty->assign('enrollPath', '/GymBuddy/Subscription/subscription');
    } else {
        $this->smarty->assign('homePath', '/GymBuddy/User/home');
        $this->smarty->assign('enrollPath', '/GymBuddy/User/login');
    }
    $this->smarty->display('services.tpl');
}


    public function showPaymentForm()
    {
        $this->smarty->display('paymentForm.tpl');
    }



    public function showTeam()
    {
        // Nel tuo controller
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('team.tpl');
    }

    public function showGallery()
    {
        // Nel tuo controller
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('gallery.tpl');
    }

    public function showContact()
    {
        // Nel tuo controller
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('contact.tpl');
    }


   public function showConfirmation($message, $redirect) {
    // Assign the message to a Smarty variable
    $this->smarty->assign('message', $message);

    // Assign the redirect script to a Smarty variable
    $this->smarty->assign('redirect', $redirect);

    // Display the confirmation template
    $this->smarty->display('confirmation.tpl');
}

public function showHomeVip() {
    // Recupera l'ID utente dalla sessione
    $userId = USession::getSessionElement('user');
    // Recupera l'utente dal database
    $user = FPersistentManager::retrieveUserById($userId);

    // Controlla il tipo di utente e imposta il path appropriato per TrainingCard
    if ($user->getType() === 'followed_user') {
        $pathTrainingCard = "/GymBuddy/TrainingCard/trainingCardInfo";
    } else if ($user->getType() === 'user_only') {
        $pathTrainingCard = "#";
    }

    // Controlla il tipo di utente e imposta il path appropriato per PhysicalData
    if ($user->getType() === 'followed_user') {
        $pathPhysicalData = "/GymBuddy/PhysicalData/physicalDataInfo";
    } else if ($user->getType() === 'user_only') {
        $pathPhysicalData = "#";
    }

    // Assegna i path a variabili Smarty
    $this->smarty->assign('pathTrainingCardInfo', $pathTrainingCard);
    $this->smarty->assign('pathGraphicInfo', $pathPhysicalData);

    // Visualizza il template
    $this->smarty->display('homeVIP.tpl');
}



}
