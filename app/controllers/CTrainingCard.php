<?php


class CTrainingCard
{

    public static function createTrainingCard() {
        if (CPersonalTrainer::isLogged()) {
            $view = new VPersonalTrainer();

            $personalTrainerId = USession::getInstance()->getSessionElement('user');
            $personalTrainer = FPersistentManager::getInstance()->retriveObj(EPersonalTrainer::getEntity(), $personalTrainerId);

            // Create new TrainingCard Obj and upload it in the db
            $trainingCard = new ETrainingCard(UHTTPMethods::post('emailRegisteredUser'), UHTTPMethods::post('exercises'), UHTTPMethods::post('repetition'), UHTTPMethods::post('recovery'));
            $trainingCard->setPersonalTrainer($personalTrainer);
            $lastId = FPersistentManager::getInstance()->uploadObj($trainingCard);
            $trainingCard->setIdTrainingCard($lastId);

            // Check for any errors that occurred while saving the TrainingCard object
            if (!$lastId) {
                $view->uploadFileError($lastId);
            }

            header('Location: /GymBuddy/PersonalTrainer/TrainingCardView');
        }
    }

    //TODO METODO showCreateTrainingCardForm nella tua classe VPersonalTrainer che accetta un parametro per il personal
    // trainer e la loro immagine del profilo.
    public static function showTrainingCardForm() {
        // Check if the personal trainer is logged in
        if (CPersonalTrainer::isLogged()) {
            // Get the current logged in personal trainer
            $personalTrainerId = USession::getInstance()->getSessionElement('user');

            // Load the personal trainer and their profile picture
            $personalTrainer = FPersistentManager::getInstance()->loadUsers($personalTrainerId);

            // Get the view
            $view = new VPersonalTrainer();

            // Show the form for creating a new training card
            $view->showCreateTrainingCardForm($personalTrainer);
        }
    }

    //Allow the PT to insert TrainingCard Data in db
    public static function setTrainingCardData(){
        if(CPersonalTrainer::isLogged()){
            $userId = USession::getInstance()->getSessionElement('user');
            $physicalData = FPersistentManager::getInstance()->retriveObj(EPhysicalData::getEntity(), $userId);

            $physicalData->setSex(UHTTPMethods::post('exercises'));
            $physicalData->setHeight(UHTTPMethods::post('repetition'));
            $physicalData->setWeight(UHTTPMethods::post('recovery'));
            $physicalData->setTime(UHTTPMethods::post('time'));
            FPersistentManager::getInstance()->updateTrainingCard($physicalData);

            header('Location: /Agora/User/personalProfile');
        }
    }

    public static function deleteTrainingCard($idUser) {
        // Retrieve the TrainingCard objects for the client
        $trainingCards = FTrainingCard::getTrainingCardsByIdUserl($idUser);

        // Delete each TrainingCard object from the database
        foreach ($trainingCards as $trainingCard) {
            $result = FTrainingCard::deleteTrainingCardInDb($trainingCard->getIdTrainingCard());

            // Check if the delete operation was successful
            if (!$result) {
                // If not successful, show an error message
                echo "Error: The TrainingCard could not be deleted. Please try again.";
                return;
            }
        }
    }


    public static function showTrainingCard($idUser) {
        // Retrieve the TrainingCard objects for the client
        $trainingCards = FTrainingCard::getTrainingCardsByIdUserl($idUser);

        // Pass the TrainingCard objects to the view for display
        $view = new VPersonalTrainer();
        $view->showTrainingCards($trainingCards);
        // If successful, redirect to the training card list page
        header('Location: /GymBuddy/PersonalTrainer/TrainingCardList');
    }





}