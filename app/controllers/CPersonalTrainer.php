<?php

namespace controllers;

class CPersonalTrainer{

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
        $view = new VPersonalTrainer();
        if(FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false){
            $user = new ERegisteredUser(UHTTPMethods::post('fist_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'),UHTTPMethods::post('password'),UHTTPMethods::post('username'));
            $user->setIsApproved(false); // Set the approval status to false
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
        $view = new VPersonalTrainer();
        $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if($username){
            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
            if(password_verify(UHTTPMethods::post('password'), $user->getPassword())){
                if(USession::getSessionStatus() == PHP_SESSION_NONE){
                    USession::getInstance();
                    USession::setSessionElement('personalTrainer', $user->getEmail());
                    header('Location: /GymBuddy/PersonalTrainer/Home');
                }
            }else{
                $view->loginError();
            }
        }else{
            $view->loginError();
        }
    }



}