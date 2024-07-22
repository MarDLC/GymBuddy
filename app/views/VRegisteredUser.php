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


    public function showAboutUs()
    {
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('about-us.tpl');
    }

    public function showServices()
    {
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
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('team.tpl');
    }

    public function showGallery()
    {
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('gallery.tpl');
    }

    public function showContact()
    {
        if (CUser::isLoggedIn()) {
            $this->smarty->assign('homePath', '/GymBuddy/User/homeRU');
        } else {
            $this->smarty->assign('homePath', '/GymBuddy/User/home');
        }
        $this->smarty->display('contact.tpl');
    }


    public function showConfirmation($message, $redirect)
    {
        // Assign the message to a Smarty variable
        $this->smarty->assign('message', $message);

        // Assign the redirect script to a Smarty variable
        $this->smarty->assign('redirect', $redirect);

        // Display the confirmation template
        $this->smarty->display('confirmation.tpl');
    }

    public function showHomeVip()
    {
        $userId = USession::getSessionElement('user');

        $user = FPersistentManager::retrieveUserById($userId);

        if ($user->getType() === 'followed_user') {
            $pathTrainingCard = "/GymBuddy/TrainingCard/trainingCardInfo";
        } else if ($user->getType() === 'user_only') {
            $pathTrainingCard = "#";
        }

        if ($user->getType() === 'followed_user') {
            $pathPhysicalData = "/GymBuddy/PhysicalData/physicalDataInfo";
        } else if ($user->getType() === 'user_only') {
            $pathPhysicalData = "#";
        }

        $this->smarty->assign('pathTrainingCardInfo', $pathTrainingCard);
        $this->smarty->assign('pathGraphicInfo', $pathPhysicalData);

        $this->smarty->display('homeVIP.tpl');
    }


 public function showNews($newsList)
{
    // If $newsList is not an array, make it an array
    if (!is_array($newsList)) {
        $newsList = array($newsList);
    }

    $userId = USession::getSessionElement('user');

    $user = FPersistentManager::retrieveUserById($userId);

    if ($user->getType() === 'followed_user' || $user->getType() === 'user_only') {
        $pathHome = "/GymBuddy/User/homeVIP";
    } else if ($user->getType() === null) {
        $pathHome = "/GymBuddy/User/homeRU";
    }

    $this->smarty->assign('pathHomeFromNews', $pathHome);

    $this->smarty->assign('newsList', $newsList);
    $this->smarty->display('newsList.tpl');
}

public function showPage404($message = 'Sorry, but you have made multiple reservations at the same time on the same day, or the slots are fully booked.')
{
    $this->smarty->assign('errorMessage', $message);

    $this->smarty->assign('homePathFrom404', "/GymBuddy/User/homeVIP");

    $this->smarty->display('404Reservation.tpl');
}

}
