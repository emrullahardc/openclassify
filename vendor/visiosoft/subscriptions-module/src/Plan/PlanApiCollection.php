<?php namespace Visiosoft\SubscriptionsModule\Plan;

class PlanApiCollection extends PlanRepository
{
    public function list()
    {
        return $this->newQuery();
    }
}
