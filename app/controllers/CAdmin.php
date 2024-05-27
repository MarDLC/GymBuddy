<?php

class CAdmin{
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

    public static function redirectUser() {
        // Ottieni l'utente corrente
        $user = USession::getInstance()->getSessionElement('user');

        // Controlla il tipo di utente e reindirizza alla corretta home page
        if ($user instanceof ERegisteredUser) {
            header('Location: /GymBuddy/User/Home');
        } elseif ($user instanceof EPersonalTrainer) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        } elseif ($user instanceof EAdmin) {
            header('Location: /GymBuddy/Admin/Home');
        }
    }


}