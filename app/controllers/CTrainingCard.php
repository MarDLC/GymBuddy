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



    public static function trainingCardInfo()
    {
        $view = new VTrainingCard();
        $view->showTrainingCardInfo();
    }


    public static function trainingCardForm($data)
    {
        USession::getInstance();


        // Retrieve the selected user ID from the post data
        $selectedUser = $data['selected_user'];
        USession::setSessionElement('id_selected_user', $selectedUser);

        error_log("Stored selected_user id : " . USession::getSessionElement('id_selected_user'));

        // Add these lines to check the session status and the session data
        error_log("Session status in physicalDataForm: " . session_status());
        error_log("Session data in physicalDataForm: " . print_r($_SESSION, true));
        error_log("Session ID in physicalDataForm: " . session_id());

        $view = new VTrainingCard();

        $view->showTrainingCardForm();

        // Debug: Log the user object after showing the physical data form
        $userId = USession::getSessionElement('personalTrainer');
        $user = FPersistentManager::retrieveUserById($userId);
        error_log("User after showing physical data form: " . print_r($user, true));

    }


    public static function compileForm()
    {
        // Ensure the session is started
        USession::getInstance();
        error_log("Session started");

        // Debug: Log the value of 'id_selected_user' at the start of the method
        error_log("id_selected_user at start: " . USession::getSessionElement('id_selected_user'));

        // Verifica se l'utente è loggato
        if (!CPersonalTrainer::isLoggedIn()) {
            error_log("User is not logged in, redirecting to login page.");
            header('Location: /GymBuddy/User/Login');
            exit();
        }

        $selectedUserId = USession::getSessionElement('id_selected_user');

        // Recupera l'ID utente selezionato dalla sessione
        //$selectedUser = intval(USession::getSessionElement('id_selected_user'));



        // Recupera i dati di physical data dal form
        $sex = UHTTPMethods::post('sex');
        $height = UHTTPMethods::post('height');
        $weight = UHTTPMethods::post('weight');
        $leanMass = UHTTPMethods::post('leanMass');
        $fatMass = UHTTPMethods::post('fatMass');
        $bmi = UHTTPMethods::post('bmi');

        // Crea un nuovo oggetto PhysicalData
        $physicalData = new EPhysicalData(  $selectedUserId, $sex, $height, $weight, $leanMass, $fatMass, $bmi);

        error_log("Created EPhysicalData object: " . print_r($physicalData, true));

        // Salva l'oggetto PhysicalData nel database e verifica il risultato
        FPersistentManager::getInstance()->uploadObj($physicalData);

        USession::setSessionElement('data_save_success', 'Your physical data was saved successfully!');
        header('Location: /GymBuddy/PhysicalData/confirmation');
        exit();
    }

    public static function confirmation()
    {
        // Log the start of the method
        error_log("Confirmation - Start");


        // Get the payment success message from the session
        $message = USession::getSessionElement('data_save_success');

        // Destroy the session (mantiene il login)
        USession::unsetSessionElement('selected_user');
        USession::unsetSessionElement('data_save_success');

        // Set a JavaScript redirect to the home page after 1 second
        $redirect = '<script>setTimeout(function(){ window.location.href = "/GymBuddy/PersonalTrainer/homePT"; }, 1000);</script>';

        // Pass the message and the redirect script to the view
        $view = new VPhysicalData();
        $view->showConfirmation($message, $redirect);

        // Log the end of the method
        error_log("Confirmation - End");
    }




}