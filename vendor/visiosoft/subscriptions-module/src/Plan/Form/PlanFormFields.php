<?php namespace Visiosoft\SubscriptionsModule\Plan\Form;

use Anomaly\MultipleFieldType\MultipleFieldType;
use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;

class PlanFormFields
{

    public function handle(PlanFormBuilder $builder)
    {
        $builder->setFields([
        	'icon',
            'name',
            'slug',
            'summary',
            'description',
            'feature' => [
                'type' => 'anomaly.field_type.multiple',
                'config' => [
                    "handler" => function (MultipleFieldType $fieldType, FeatureRepositoryInterface $feature) {

                        $features = $feature->newQuery()->get();

                        $values = array();

                        foreach ($features as $feature) {
                            $values[$feature['id']] = $feature['name'] . " => " . $feature['value'];
                        }

                        $fieldType->setOptions($values);
                    }
                ],
            ],
            'price',
            'currency',
            'trial_interval',
            'trial_period',
            'interval',
            'interval_period',
            'paddle_plan_id'
        ]);
    }

}
