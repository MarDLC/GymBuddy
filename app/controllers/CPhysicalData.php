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







    public static function physicalDataForm($data)
    {
        USession::getInstance();

        // Retrieve the selected user ID from the post data
        $selectedUser = $data['selected_user'];
        USession::setSessionElement('id_selected_user', $selectedUser);

        $view = new VPhysicalData();

        $view->showPhysicalDataForm();

        $userId = USession::getSessionElement('personalTrainer');
        $user = FPersistentManager::retrieveUserById($userId);
    }




  public static function compileForm()
{
    // Ensure the session is started
    USession::getInstance();

    if (!CPersonalTrainer::isLoggedIn()) {
        header('Location: /GymBuddy/User/Login');
        exit();
    }

    $selectedUserId = USession::getSessionElement('id_selected_user');

    $sex = UHTTPMethods::post('sex');
    $height = UHTTPMethods::post('height');
    $weight = UHTTPMethods::post('weight');
    $leanMass = UHTTPMethods::post('leanMass');
    $fatMass = UHTTPMethods::post('fatMass');
    $bmi = UHTTPMethods::post('bmi');

    $physicalData = new EPhysicalData(  $selectedUserId, $sex, $height, $weight, $leanMass, $fatMass, $bmi);

    FPersistentManager::getInstance()->uploadObj($physicalData);

    USession::setSessionElement('data_save_success', 'Your physical data was saved successfully!');
    header('Location: /GymBuddy/PhysicalData/confirmation');
    exit();
}

    public static function confirmation()
    {

        $message = USession::getSessionElement('data_save_success');

        USession::unsetSessionElement('selected_user');
        USession::unsetSessionElement('data_save_success');

        $redirect = '<script>setTimeout(function(){ window.location.href = "/GymBuddy/PersonalTrainer/homePT"; }, 1000);</script>';

        $view = new VPhysicalData();
        $view->showConfirmation($message, $redirect);

    }


    public static function showProgressChart()
    {
        if (CUser::isLoggedIn()) {
            $userId = CUser::getLoggedInUserId();

            $physicalData = FPersistentManager::getInstance()->getPhysicalDataById($userId);

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

                $view = new VPhysicalData();
                $view->showPhysicalDataInfo($dates, $weights, $leanMasses, $fatMasses);
            } else {

                $view = new VPhysicalData();
                $view->showPhysicalDataInfo([], [], [], []);
            }
        } else {
            header('Location: /GymBuddy/User/Login');
        }
    }

    public static function physicalDataInfo()
    {
        self::showProgressChart();
    }


}