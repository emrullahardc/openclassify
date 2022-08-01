<?php namespace Visiosoft\SubscriptionsModule\Subscription\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface SubscriptionInterface extends EntryInterface
{
    public function getUser();

    public function getPlan();

    public function getExpiry();

    public function getRemaining();

    public function setExpiry($expiry);

    public function setTrial($trial);

    public function calculateExtend($trial_status = true);

    public function isEnabled();

    public function getTrialExpiry();

    public function getSuspend();

    public function enabled();

    public function isActive();

    public function suspend();

    public function renew();
}
