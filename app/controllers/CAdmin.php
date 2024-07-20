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

            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));

            // Log per vedere quale utente viene restituito
            error_log('CAdmin::checkLogin - User retrieved: ' . print_r($user, true));

            if($user && password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('admin', $user->getId());  // Aggiunta logica per ottenere l'ID

                    // Controlla se l'utente è un Personal Trainer
                    if ($user instanceof EPersonalTrainer) {
                        header('Location: /GymBuddy/PersonalTrainer/homePT');
                    } elseif ($user instanceof EAdmin) {
                        // Logica per l'admin
                        header('Location: /GymBuddy/Admin/homeAD');
                    } else {
                        // Logica per l'utente registrato
                        header('Location: /GymBuddy/User/homeRU');
                    }
                }
            } else {
                error_log('CAdmin::checkLogin - Password verification failed for user: ' . UHTTPMethods::post('username'));
                $view->loginError();
            }
        } else {
            error_log('CAdmin::checkLogin - Email verification failed for username: ' . UHTTPMethods::post('username'));
            $view->loginError();
        }
    }


    public static function logout(){
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/Admin/Login');
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




    public static function newsForm()
    {
        USession::getInstance();
        self::isLogged(); // Verifica se l'admin è loggato

        $title = UHTTPMethods::post("titolo_comunicazione");
        $description = UHTTPMethods::post("contenuto_comunicazione");
        $idUser = USession::getSessionElement('admin');

        error_log("CAdmin::newsForm - Title: $title, Description: $description, User ID: $idUser");

        $news = new ENews($idUser, $title, $description);
        $result = FPersistentManager::getInstance()->uploadObj($news);

        $view = new VAdmin();
        $view->showNewsForm();

        // Reindirizza l'utente alla pagina di conferma
        header('Location: /GymBuddy/Admin/homeAD');
        exit();

    }





}