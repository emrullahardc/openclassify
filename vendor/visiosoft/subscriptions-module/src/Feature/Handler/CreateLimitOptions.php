<?php namespace Visiosoft\SubscriptionsModule\Feature\Handler;

use Anomaly\CheckboxesFieldType\CheckboxesFieldType;
use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;

class CreateLimitOptions
{
    public function handle(CheckboxesFieldType $fieldType, FeatureRepositoryInterface $feature)
    {
        $features = $feature->newQuery()->get();

        $values = array();

        foreach ($features as $feature) {
            $values[$feature['id']] = $feature['name'] . " => " . $feature['value'];
        }

        $fieldType->setOptions($values);
    }
}