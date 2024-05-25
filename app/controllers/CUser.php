<?php

class CUser{


    public static function login(){
        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('registeredUser')){
            header('Location: /GymBuddy/RegisteredUser/Home');
        }
        $view = new VRegisteredUser();
        $view->showLoginForm();
    }

    public static function registration()
    {
        $view = new VRegisteredUser();
        if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
            $user = new ERegisteredUser(UHTTPMethods::post('fist_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'),UHTTPMethods::post('password'),UHTTPMethods::post('username'));
            FPersistentManager::getInstance()->uploadObj($user);

            $view->showLoginForm();
        }else{
            $view->registrationError();
        }
    }

    public static function isLogged()
    {
        $logged = false;

        if(UCookie::isSet('PHPSESSID')){
            if(session_status() == PHP_SESSION_NONE){
                USession::getInstance();
            }
        }
        if(USession::isSetSessionElement('registeredUser')){
            $logged = true;
        }
        if(!$logged){
            header('Location: /GymBuddy/User/Login');
            exit;
        }
        return true;
    }

    public static function checkLogin(){
        $view = new VRegisteredUser();
        $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($username){
            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
            if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('registeredUser', $user->getEmail());
                    header('Location: /GymBuddy/RegisteredUser/Home');
                }
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
        header('Location: /GymBuddy/RegisteredUser/Login');
    }

    public static function settings(){
        if(CUser::isLogged()){
            $view = new VRegisteredUser();

            $userId = USession::getInstance()->getSessionElement('registeredUser');
            $user = FPersistentManager::getInstance()->loadUsers($userId);
            $view->settings($user);
        }
    }


    public static function setUsername(){
        if(CRegisteredUser::isLogged()){
            $userId = USession::getInstance()->getSessionElement('registeredUser');
            $user = FPersistentManager::getInstance()->retriveObj(ERegisteredUser::getEntity(), $userId);

            if($user->getUsername() == UHTTPMethods::post('username')){
                header('Location: /GymBuddy/RegisteredUser/PersonalProfile');
            }else{
                if(FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false)
                {
                    $user->setUsername(UHTTPMethods::post('username'));
                    FPersistentManager::getInstance()->updateUserUsername($user);
                    header('Location: /GymBuddy/RegisteredUser/PersonalProfile');
                }else{
                    $view = new VRegisteredUser();
                    $user = FPersistentManager::getInstance()->loadUsers($userId);
                    $view->usernameError($user , true);
                }
            }
        }
    }

    public static function setPassword(){
        if(CRegisteredUser::isLogged()){
            $userId = USession::getInstance()->getSessionElement('registeredUser');
            $user = FPersistentManager::getInstance()->retriveObj(ERegisteredUser::getEntity(), $userId);$newPass = UHTTPMethods::post('password');
            $user->setPassword($newPass);
            FPersistentManager::getInstance()->updateUserPassword($user);

            header('Location: /GymBuddy/RegisteredUser/PersonalProfile');
        }
    }



}