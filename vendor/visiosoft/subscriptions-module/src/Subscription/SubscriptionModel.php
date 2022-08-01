<?php namespace Visiosoft\SubscriptionsModule\Subscription;

use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionInterface;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsSubscriptionsEntryModel;

class SubscriptionModel extends SubscriptionsSubscriptionsEntryModel implements SubscriptionInterface
{
    protected $ttl = false;

    public function getUser()
    {
        return $this->getAttribute('assign');
    }

    public function getPlan()
    {
        return $this->getAttribute('plan');
    }

    public function getExpiry()
    {
        return $this->getAttribute('expires_at');
    }

    public function getRemaining()
    {
        $expiry = ($this->isEnabled()) ? $this->getExpiry() : $this->getTrialExpiry();

        $dStart = now();

        return $dStart->diff($expiry)->format('%r%a');
    }

    public function setExpiry($expiry)
    {
        $this->setAttribute('expires_at', $expiry);
        $this->save();
    }

    public function setTrial($trial)
    {
        $this->setAttribute('trial_expires_at', $trial);
        $this->save();
    }

    public function calculateExtend($trial_status = true)
    {
        $plan = $this->getPlan();

        $start = now();

        $expiry = null;

        if ($trial = $plan->getTrial() and $trial_status) {

            $trial_period = $plan->getTrialPeriod();

            $trial = $start->add($trial, $trial_period);

            $this->setTrial($trial);

            $start = $trial;

            $expiry = $trial;
        }

        if ($interval = $plan->getInterval()) {

            $interval_period = $plan->getIntervalPeriod();

            $expiry = $start->add($interval, $interval_period);
        }

        $this->setExpiry($expiry);
    }

    public function isEnabled()
    {
        return $this->getAttribute('enabled');
    }

    public function getTrialExpiry()
    {
        return $this->getAttribute('trial_expires_at');
    }

    public function getSuspend()
    {
        return $this->getAttribute('suspend_at');
    }

    public function enabled()
    {
        $this->setAttribute('enabled', true);
        $this->setAttribute('suspend_at', null);
        $this->save();
    }

    public function isActive()
    {
        $remaining = $this->getRemaining();

        return (int)$remaining > -1 and $remaining !== "-0";
    }

    public function suspend()
    {
        $this->setAttribute('enabled', false);
        $this->setAttribute('suspend_at', now());
        $this->save();
    }

    public function renew()
    {
        $this->enabled();
        return $this->calculateExtend(false);
    }
}
