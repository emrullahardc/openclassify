<?php namespace Visiosoft\SubscriptionsModule\Subscription\Event\webhook;

class SubscriptionCreatedForWebhook
{
    /**
     * @author Visiosoft LTD.
     */
    private $subscription;
    private $parameters;

    /**
     * @param $subscription
     */
    public function __construct($subscription, $parameters)
    {
        $this->subscription = $subscription;
        $this->parameters = $parameters;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    public function getParameters()
    {
        return $this->parameters;
    }


}
