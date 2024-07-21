<?php


class CTrainingCard
{


    public static function trainingCardForm($data)
    {
        USession::getInstance();

        // Retrieve the selected user ID from the post data
        $selectedUser = $data['selected_user'];
        USession::setSessionElement('id_selected_user', $selectedUser);

        $view = new VTrainingCard();

        $view->showTrainingCardForm();

        $userId = USession::getSessionElement('personalTrainer');
        $user = FPersistentManager::retrieveUserById($userId);
        error_log("User after showing physical data form: " . print_r($user, true));

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

        $exercises = UHTTPMethods::post('exercises');
        $repetition = UHTTPMethods::post('repetition');
        $recovery = UHTTPMethods::post('recovery');

        $exercises = is_array($exercises) ? $exercises : [$exercises];
        $repetition = is_array($repetition) ? $repetition : [$repetition];
        $recovery = is_array($recovery) ? $recovery : [$recovery];

        $maxLength = max(count($exercises), count($repetition), count($recovery));

        for ($i = 0; $i < $maxLength; $i++) {
            $exercise = $exercises[$i] ?? null;
            $reps = $repetition[$i] ?? 0;
            $recov = $recovery[$i] ?? 0;

            $trainingCard = new ETrainingCard($selectedUserId, $exercise, $reps, $recov);

            FPersistentManager::getInstance()->uploadObj($trainingCard);
        }

        USession::setSessionElement('data_save_success', 'Your physical data was saved successfully!');
        header('Location: /GymBuddy/TrainingCard/confirmation');
        exit();
    }

    public static function confirmation()
    {

        // Get the payment success message from the session
        $message = USession::getSessionElement('data_save_success');

        // Destroy the session
        USession::unsetSessionElement('selected_user');
        USession::unsetSessionElement('data_save_success');

        // Set a JavaScript redirect to the home page after 1 second
        $redirect = '<script>setTimeout(function(){ window.location.href = "/GymBuddy/PersonalTrainer/homePT"; }, 1000);</script>';

        // Pass the message and the redirect script to the view
        $view = new VTrainingCard();
        $view->showConfirmation($message, $redirect);
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

    $view = new VTrainingCard();

    $view->showTrainingCards($trainingCards);
}


}