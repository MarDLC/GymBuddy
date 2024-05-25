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

}