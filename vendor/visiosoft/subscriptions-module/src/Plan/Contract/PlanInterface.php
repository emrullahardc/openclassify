<?php namespace Visiosoft\SubscriptionsModule\Plan\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

interface PlanInterface extends EntryInterface
{
    public function getName();

    public function getTrial();

    public function getTrialPeriod();

    public function getInterval();

    public function getIntervalPeriod();
}
