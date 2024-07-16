<?php

class CAdmin{

    public static function login(){
        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('admin')){
            header('Location: /GymBuddy/Admin/HomeAD');
        }
        $view = new VAdmin();
        $view->showLoginForm();
    }


    public static function isLogged()
    {
        $logged = false;

        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('admin')){
            $logged = true;
        }
        if(!$logged){
            header('Location: /GymBuddy/Admin/Login');
            exit;
        }
        return true;
    }

    public static function checkLogin(){
        $view = new VAdmin();
        $email = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($email){
            $user = FPersistentManager::getInstance()->retriveUserOnUsernameAD(UHTTPMethods::post('username'));
            if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('admin', $user->getId());  // Aggiunta logica per ottenere l'ID
                    /*
                     // Controlla se l'utente è un Personal Trainer approvato
                     if ($user instanceof EPersonalTrainer && $user->getApproved() == 1) {
                         header('Location: /GymBuddy/PersonalTrainer/Home');
                     } else {*/
                    header('Location: /GymBuddy/Admin/homeAD');
                }
                //}
            }else{
                $view->loginError();
            }
        }else{
            $view->loginError();
        }
    }

    public static function logout(){
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/Admin/Login');
    }

    public static function settings(){
        if(CAdmin::isLogged()){
            $view = new VAdmin();

            $userId = USession::getInstance()->getSessionElement('user');
            $user = FPersistentManager::getInstance()->loadUsers($userId);
            $view->settings($user);
        }
    }



    public static function redirectUser() {
        // Ottieni l'utente corrente
        $user = USession::getInstance()->getSessionElement('admin');

        // Controlla il tipo di utente e reindirizza alla corretta home page
        if ($user instanceof ERegisteredUser) {
            header('Location: /GymBuddy/User/HomeRU');
        } elseif ($user instanceof EPersonalTrainer) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        } elseif ($user instanceof EAdmin) {
            header('Location: /GymBuddy/Admin/HomeAD');
        }
    }

    public static function homeAD(){
        if (CAdmin::isLogged()) {
            $view = new VAdmin();
            $view->showHomeAD();
        } else {
            // Se l'utente non è loggato, reindirizza alla pagina di login
            header('Location: /GymBuddy/login');
            exit();
        }
    }

    public static function requests(){
        $view = new VAdmin();
        $view->showRequests();
    }





    public static function approveTrainer($trainerId){
        // Retrieve the trainer object from the database
        $trainer = FPersistentManager::getInstance()->retriveObj('EPersonalTrainer', $trainerId);

        // Check if the trainer exists
        if($trainer){
            // Set the trainer's approval status to true
            $trainer->setApproved(true);

            // Update the trainer in the database
            $result = FPersistentManager::getInstance()->updateUserApproval($trainer);

            // Check if the update was successful
            if($result){
                // The trainer was successfully approved
                return true;
            }else{
                // There was an error approving the trainer
                return false;
            }
        }else{
            // The trainer does not exist
            return false;
        }
    }


public static function rejectTrainer($trainerId){
        // Retrieve the trainer object from the database
        $trainer = FPersistentManager::getInstance()->retriveObj('EPersonalTrainer', $trainerId);

        // Check if the trainer exists
        if($trainer){
            // Set the trainer's approval status to false
            $trainer->setApproved(false);

            // Update the trainer in the database
            $result = FPersistentManager::getInstance()->updateUserApproval($trainer);

            // Check if the update was successful
            if($result){
                // The trainer was successfully rejected
                return true;
            }else{
                // There was an error rejecting the trainer
                return false;
            }
        }else{
            // The trainer does not exist
            return false;
        }
    }

    public static function postNews($title, $description) {
    // Create a new news item
    $news = new ENews($title, $description);

    // Save the news item in the database
    $result = FPersistentManager::getInstance()->saveNews($news);

    // Check if the news item was saved successfully
    if ($result) {
        // If successful, redirect the admin to a success page
        header('Location: /GymBuddy/Admin/NewsSuccess');
    } else {
        // If not successful, redirect the admin to an error page
        header('Location: /GymBuddy/Admin/NewsError');
       }
    }


    public static function cancelNews($newsId) {
        // Call the method to delete the news from the database
        $result = FPersistentManager::getInstance()->deleteNews($newsId);

        // Check if the news was deleted successfully
        if ($result) {
            // If successful, redirect the admin to a success page
            header('Location: /GymBuddy/Admin/NewsDeletionSuccess');
        } else {
            // If not successful, redirect the admin to an error page
            header('Location: /GymBuddy/Admin/NewsDeletionError');
        }
    }


    //TODO implementare la funzione per visualizzare le richieste di personal trainer
    public static function viewTrainerRequests() {
        // Recupera tutti i personal trainer con 'approved' impostato a 0
        $trainers = FPersistentManager::getInstance()->retrieveUnapprovedTrainers();

        // Passa i personal trainer alla vista
        $view = new VAdmin();
        $view->showTrainerRequests($trainers);
    }




}