<?php


class CPhysicalData
{

    public static function createPhysicalData() {
        if (CPersonalTrainer::isLogged()) {
            $view = new VPersonalTrainer();

            $personalTrainerId = USession::getInstance()->getSessionElement('user');
            $personalTrainer = FPersistentManager::getInstance()->retriveObj(EPersonalTrainer::getEntity(), $personalTrainerId);

            // Create new PhysicalData Obj and upload it in the db
            $physicalData = new EPhysicalData(UHTTPMethods::post('emailRegisteredUser'), UHTTPMethods::post('sex'), UHTTPMethods::post('height'), UHTTPMethods::post('weight'), UHTTPMethods::post('leanMass'), UHTTPMethods::post('fatMass'), UHTTPMethods::post('bmi'));
            $physicalData->setPersonalTrainer($personalTrainer);
            $lastId = FPersistentManager::getInstance()->uploadObj($physicalData);
            $physicalData->setIdPhysicalData($lastId);

            // Check for any errors that occurred while saving the PhysicalData object
            if (!$lastId) {
                $view->uploadFileError($lastId);
            }

            header('Location: /GymBuddy/PersonalTrainer/PhysicalDataView');
        }
    }

    public static function showPhysicalData($emailRegisteredUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPersistentManager::getInstance()->getPhysicalDataByEmail($emailRegisteredUser);

        // Pass the PhysicalData objects to the view for display
        $view = new VPersonalTrainer();
        $view->showPhysicalData($physicalData);
    }

    //TODO
    public static function showProgressChart($emailRegisteredUser) {
        // Get the URL of the generated chart image using FPersistentManager
        $chartImageUrl = FPersistentManager::getInstance()->getChartImageUrl($emailRegisteredUser);

        // Return the HTML to display the chart image
        return '<img src="' . $chartImageUrl . '" alt="Physical Progress Chart">';
    }

    //TODO creare il metodio uploadFileError per gestire gli errori di caricamento dei file
    public static function showPhysicalDataForm() {
        // Check if the personal trainer is logged in
        if (CPersonalTrainer::isLogged()) {
            // Get the current logged in personal trainer
            $personalTrainerId = USession::getInstance()->getSessionElement('user');

            // Load the personal trainer and their profile picture
            $personalTrainer = FPersistentManager::getInstance()->loadUsers($personalTrainerId);

            // Get the view
            $view = new VPersonalTrainer();

            // Show the form for creating a new physical data
            $view->showCreatePhysicalDataForm($personalTrainer);
        }
    }


    public static function deletePhysicalData($emailRegisteredUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPhysicalData::getPhysicalDataByEmail($emailRegisteredUser);

        // Delete the PhysicalData object from the database
        $result = FPhysicalData::deletePhysicalDataInDb($physicalData->getIdPhysicalData());

        // Check if the delete operation was successful
        if (!$result) {
            // If not successful, show an error message
            echo "Error: The PhysicalData could not be deleted. Please try again.";
            return;
        }

        // If successful, redirect to the physical data list page
        header('Location: /GymBuddy/PersonalTrainer/PhysicalDataList');
    }

    public static function setPhysicalData(){
        if(CPersonalTrainer::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $physicalData = FPersistentManager::getInstance()->retriveObj(EPhysicalData::getEntity(), $userId);

            $physicalData->setSex(UHTTPMethods::post('sex'));
            $physicalData->setHeight(UHTTPMethods::post('height'));
            $physicalData->setWeight(UHTTPMethods::post('weight'));
            $physicalData->setLeanMass(UHTTPMethods::post('leanMass'));
            $physicalData->setFatMass(UHTTPMethods::post('fatMass'));
            $physicalData->setBmi(UHTTPMethods::post('bmi'));
            $physicalData->setTime(UHTTPMethods::post('time'));
            FPersistentManager::getInstance()->updatePhysicalData($physicalData);

            header('Location: /Agora/User/personalProfile');
        }
    }

    //TODO Scaricare la libreia pChart e includerla nel progetto: composer require szymach/c-pchart
    //TODO il path che scrivo qui, andrà messo anche nel metodo getImageUrl che si trova in FPersitenManager
    public static function viewProgressChartInTrainer($emailRegisteredUser) {
        // Call the generatePhysicalProgressChart method of FPersistentManager
        return FPersistentManager::getChartImageUrl($emailRegisteredUser);
    }

}