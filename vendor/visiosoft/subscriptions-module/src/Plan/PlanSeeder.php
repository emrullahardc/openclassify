<?php namespace Visiosoft\SubscriptionsModule\Plan;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;

class PlanSeeder extends Seeder
{

    private $plan;

    public function __construct(PlanRepositoryInterface $plan)
    {
        $this->plan = $plan;
        parent::__construct();
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->plan->create([
            'en' => [
                'name' => 'OpenClassify Cloud Usage Basic Plan'
            ],
            'slug' => str_slug(strtolower('OpenClassify Cloud Usage Basic Plan')),
            'price' => '29,00',
            'currency' => 'USD',
            'trial_interval' => 14,
            'trial_period' => 'day',
            'interval' => 1,
            'interval_period' => 'month',
            'paddle_plan_id' => 613079
        ]);

        $this->plan->create([
            'en' => [
                'name' => 'OpenClassify Cloud Usage Basic Plan (Yearly)'
            ],
            'slug' => str_slug(strtolower('OpenClassify Cloud Usage Basic Plan (Yearly)')),
            'price' => '190,00',
            'currency' => 'USD',
            'trial_interval' => 0,
            'interval' => 12,
            'interval_period' => 'month',
            'paddle_plan_id' => 613197
        ]);
    }
}
