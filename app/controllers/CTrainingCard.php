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

    // Recupera i dati di physical data dal form
    $exercises = UHTTPMethods::post('exercises');
    $repetition = UHTTPMethods::post('repetition');
    $recovery = UHTTPMethods::post('recovery');

    // Check if the form data is not null
    if ($exercises === null || $repetition === null || $recovery === null) {
        error_log("Form data is missing.");
        USession::setSessionElement('data_save_error', 'There was an error saving your data. Please try again.');
        header('Location: /GymBuddy/TrainingCard/confirmation');
        exit();
    }

    // Verifica che i dati abbiano la stessa lunghezza
    if (count($exercises) === count($repetition) && count($repetition) === count($recovery)) {
        for ($i = 0; $i < count($exercises); $i++) {
            // Crea un nuovo oggetto ETrainingCard per ogni set di dati
            $trainingCard = new ETrainingCard($selectedUserId, $exercises[$i], $repetition[$i], $recovery[$i]);
            error_log("Created ETrainingCard object: " . print_r($trainingCard, true));

            // Salva l'oggetto ETrainingCard nel database
            FPersistentManager::getInstance()->uploadObj($trainingCard);
        }

        USession::setSessionElement('data_save_success', 'Your physical data was saved successfully!');
    } else {
        error_log("Mismatch in the number of exercises, repetitions, and recoveries.");
        USession::setSessionElement('data_save_error', 'There was an error saving your data. Please try again.');
    }

    header('Location: /GymBuddy/TrainingCard/confirmation');
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
        $view = new VTrainingCard();
        $view->showConfirmation($message, $redirect);

        // Log the end of the method
        error_log("Confirmation - End");
    }

    public static function trainingCardInfo()
    {
        self::viewTrainingCard();
    }


    public static function viewTrainingCard() {
    // Ensure the session is started
    USession::getInstance();

    // Check if the user is logged in
    if (!CUser::isLoggedIn()) {
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    // Get the user ID from the session
    $userId = USession::getSessionElement('user');

    // Retrieve the training card data for the user
    $trainingCards = FPersistentManager::getTrainingCardsById($userId);

    // Check if any training cards were retrieved
    if (!$trainingCards) {
        error_log("No training cards found for user ID: $userId");
        return;
    }

    // Get the view
    $view = new VTrainingCard();

    // Show the training cards
    $view->showTrainingCards($trainingCards);
}


}