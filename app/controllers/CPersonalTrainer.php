<?php




class CPersonalTrainer
{

    public static function login()
    {
        if (UCookie::isSet('PHPSESSID')) {
            if (session_status() == PHP_SESSION_NONE) {
                USession::getInstance();
            }
        }
        if (USession::isSetSessionElement('user')) {
            header('Location: /GymBuddy/PersonalTrainer/Home');
        }
        $view = new VPersonalTrainer();
        $view->showLoginForm();
    }

    public static function registration()
    {
        $view = new VPersonalTrainer();
        if (FPersistentManager::getInstance()->verifyUserEmail(UHTTPMethods::post('email')) == false && FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username')) == false) {
            $user = new EPersonalTrainer(UHTTPMethods::post('first_name'), UHTTPMethods::post('last_name'), UHTTPMethods::post('email'), UHTTPMethods::post('password'), UHTTPMethods::post('username'));
            $user->setIsApproved(false); // Set the approval status to false
            FPersistentManager::getInstance()->uploadObj($user);

            $view->showLoginForm();
        } else {
            $view->registrationError();
        }
    }

    public static function isLogged()
    {
        $logged = false;

        if (UCookie::isSet('PHPSESSID')) {
            if (session_status() == PHP_SESSION_NONE) {
                USession::getInstance();
            }
        }
        if (USession::isSetSessionElement('user')) {
            $logged = true;
        }
        if (!$logged) {
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
        return true;
    }

    public static function checkLogin()
    {
        $view = new VPersonalTrainer();
        $username = FPersistentManager::getInstance()->verifyUserUsername(UHTTPMethods::post('username'));
        if ($username) {
            $user = FPersistentManager::getInstance()->retriveUserOnUsername(UHTTPMethods::post('username'));
            if (password_verify(UHTTPMethods::post('password'), $user->getPassword())) {
                if (USession::getSessionStatus() == PHP_SESSION_NONE) {
                    USession::getInstance();
                    // Salva l'intero oggetto utente nella sessione
                    USession::setSessionElement('user', $user);
                    header('Location: /GymBuddy/PersonalTrainer/Home');
                }
            } else {
                $view->loginError();
            }
        } else {
            $view->loginError();
        }
    }

    public static function logout()
    {
        USession::getInstance();
        USession::unsetSession();
        USession::destroySession();
        header('Location: /GymBuddy/PersonalTrainer/login');
    }

    public static function redirectUser()
    {
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

    //TODO implementare il metodo showFollowedUsers nella classe VPersonalTrainer per visualizzare effettivamente
    // la lista delle email sulla home page
    public static function showFollowedUsers()
    {
        // Check if the personal trainer is logged in
        if (self::isLogged()) {
            // Get the list of emails of followed users
            $followedUsersEmails = FPersonalTrainer::getListEmailsOfFollowedUsers();

            // Get the view
            $view = new VPersonalTrainer();

            // Show the followed users on the home page
            $view->showFollowedUsers($followedUsersEmails);
        } else {
            // If the personal trainer is not logged in, redirect to the login page
            header('Location: /GymBuddy/PersonalTrainer/Login');
            exit;
        }
    }

    //TODO METODO showCreateTrainingCardForm nella tua classe VPersonalTrainer che accetta un parametro per il personal
    // trainer e la loro immagine del profilo.
    public static function showCreateTrainingCardForm() {
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

    //TODO showTrainingCards DA IMPLEMENTARE IN VPERSONALTRAINER
    public static function viewTrainingCard($emailRegisteredUser) {
        // Retrieve the TrainingCard objects for the client
        $trainingCards = FTrainingCard::getTrainingCardsByEmail($emailRegisteredUser);

        // Pass the TrainingCard objects to the view for display
        $view = new VPersonalTrainer();
        $view->showTrainingCards($trainingCards);
    }

    public static function deleteTrainingCard($emailRegisteredUser) {
        // Retrieve the TrainingCard objects for the client
        $trainingCards = FTrainingCard::getTrainingCardsByEmail($emailRegisteredUser);

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

        // If successful, redirect to the training card list page
        header('Location: /GymBuddy/PersonalTrainer/TrainingCardList');
    }
//TODO creare i metodi showCreatePhysicalDataForm, showPhysicalData e uploadFileError
// nella classe VPersonalTrainer per visualizzare il form di creazione dei dati fisici,
// visualizzare i dati fisici e gestire gli errori di caricamento dei file,
// rispettivamente.
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

    public static function viewPhysicalData($emailRegisteredUser) {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPhysicalData::getPhysicalDataByEmail($emailRegisteredUser);

        // Pass the PhysicalData objects to the view for display
        $view = new VPersonalTrainer();
        $view->showPhysicalData($physicalData);
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



}