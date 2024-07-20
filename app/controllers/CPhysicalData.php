<?php


class CPhysicalData
{

    public static function createPhysicalData()
    {
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

    public static function showPhysicalData($emailRegisteredUser)
    {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPersistentManager::getInstance()->getPhysicalDataByEmail($emailRegisteredUser);

        // Pass the PhysicalData objects to the view for display
        $view = new VPersonalTrainer();
        $view->showPhysicalData($physicalData);
    }


    public static function showPhysicalDataForm()
    {
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


    public static function deletePhysicalData($idUser)
    {
        // Retrieve the PhysicalData objects for the client
        $physicalData = FPhysicalData::getPhysicalDataByIdUser($idUser);

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






    /*
    public static function physicalDataForm($postData)
    {
        // Retrieve the selected user ID from the post data
        $selectedUserId = $postData['selected_user'];

        // Retrieve the user data from the database
    $selectedUser = FPersistentManager::retrieveUserById($selectedUserId);

        // Check if the user exists
        if (!$selectedUser) {
            // Handle the error (e.g., show an error message and exit)
            echo "Error: User not found.";
            return;
        }

        // Display the physical data form with the selected user data
        $view = new VPhysicalData();
        $view->showPhysicalDataForm($selectedUser);
    }*/


    public static function physicalDataForm($data)
    {
        USession::getInstance();
        error_log("PhysicalDataForm - Start");

        // Retrieve the selected user ID from the post data
        $selectedUser = $data['selected_user'];
        USession::setSessionElement('id_selected_user', $selectedUser);

        error_log("Stored selected_user id : " . USession::getSessionElement('id_selected_user'));

        // Add these lines to check the session status and the session data
        error_log("Session status in physicalDataForm: " . session_status());
        error_log("Session data in physicalDataForm: " . print_r($_SESSION, true));
        error_log("Session ID in physicalDataForm: " . session_id());

        $view = new VPhysicalData();

        $view->showPhysicalDataForm();

        // Debug: Log the user object after showing the physical data form
        $userId = USession::getSessionElement('personalTrainer');
        $user = FPersistentManager::retrieveUserById($userId);
        error_log("User after showing physical data form: " . print_r($user, true));

    }


    /*

      public static function compileForm()
    {
        // Ensure the session is started
        USession::getInstance();

        // Verifica se l'utente è loggato
        if (CUser::isLoggedIn()) {
            header('Location: /GymBuddy/User/Login');
            exit();
        }

        // Debug: Verifica l'utente nella sessione
        $userId = USession::getSessionElement('selected_user');
        $user = FPersistentManager::retrieveUserById($userId);

        // Verifica che $user sia un oggetto ERegisteredUser
        if (!($user instanceof ERegisteredUser)) {
            error_log("ERROR: User is not an ERegisteredUser object.");
            // Gestisci l'errore qui, ad esempio reindirizzando l'utente a una pagina di errore
            header('Location: /GymBuddy/User/error');
            exit();
        }

        // Recupera i dati del form
        $sex = UHTTPMethods::post('sex');
        $height = UHTTPMethods::post('height');
        $weight = UHTTPMethods::post('weight');
        $leanMass = UHTTPMethods::post('leanMass');
        $fatMass = UHTTPMethods::post('fatMass');
        $bmi = UHTTPMethods::post('bmi');
        $date = UHTTPMethods::post('date');

        // Crea un nuovo oggetto PhysicalData
        $physicalData = new EPhysicalData($userId, $sex, $height, $weight, $leanMass, $fatMass, $bmi);

        // Salva l'oggetto PhysicalData nel database e verifica il risultato
        $result = FPersistentManager::getInstance()->uploadObj($physicalData);

      // If the PhysicalData object was successfully saved, set a session variable and redirect the user to a confirmation page
    if ($result) {
        // Set a session variable to indicate that the physical data was saved successfully
        USession::setSessionElement('data_save_success', 'Your physical data was saved successfully!');

        // Redirect the user to the confirmation page
        header('Location: /GymBuddy/PhysicalData/confirmation');
        exit();
    } else {
        // Handle the error here, for example by redirecting the user to an error page
        header('Location: /GymBuddy/User/error');
        exit();
    }
    } */


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


    public static function showProgressChart()
    {
        if (CUser::isLoggedIn()) {
            $userId = CUser::getLoggedInUserId();
            error_log('showProgressChart - userId: ' . $userId);

            $physicalData = FPersistentManager::getInstance()->getPhysicalDataById($userId);
            error_log('showProgressChart - PhysicalData: ' . print_r($physicalData, true));

            if (!empty($physicalData)) {
                $dates = [];
                $weights = [];
                $leanMasses = [];
                $fatMasses = [];

                foreach ($physicalData as $data) {
                    $dates[] = $data->getTime()->format('Y-m-d');
                    $weights[] = $data->getWeight();
                    $leanMasses[] = $data->getLeanMass();
                    $fatMasses[] = $data->getFatMass();
                }

                // Passa i dati al template
                $view = new VPhysicalData();
                $view->showPhysicalDataInfo($dates, $weights, $leanMasses, $fatMasses);
            } else {
                error_log('showProgressChart - No Physical Data found for userId: ' . $userId);
                $view = new VPhysicalData();
                $view->showPhysicalDataInfo([], [], [], []);
            }
        } else {
            error_log('showProgressChart - User not logged in');
            header('Location: /GymBuddy/User/Login');
        }
    }

    public static function physicalDataInfo()
    {
        self::showProgressChart();
    }


}