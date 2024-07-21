<?php



class VSubscription {
    /**
     * @var Smarty
     */
    private $smarty;

    public function __construct() {
        $this->smarty = StartSmarty::configuration();
    }

    /**
     * Mostra il form di sottoscrizione
     *
     * @throws SmartyException
     */
    public function showSubscriptionForm() {
        $this->smarty->display('subscriptionForm.tpl');
    }


    public function showSubscription($path)
    {
        error_log("Path: " . $path);  // Log the path

        $this->smarty->assign('homePath',$path);

        $this->smarty->display('subscription.tpl');
    }


 public function showSubscriptionInfo($subscription) {

    $subscriptionData = [
        'id' => $subscription->getIdSubscription(),
        'user_id' => $subscription->getIdUser()->getId(), // Get the user's ID
        'type' => $subscription->getType(),
        'duration' => $subscription->getDuration(),
        'price' => $subscription->getPrice(),
    ];

    // Assign the prepared data to the Smarty template
    $this->smarty->assign('subscription', $subscriptionData);

    // Display the template
    $this->smarty->display('viewSubscription.tpl');
}
}
