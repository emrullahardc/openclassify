<?php namespace Visiosoft\SubscriptionsModule\Feature;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;

class FeatureSeeder extends Seeder
{

    private $feature;

    public function __construct(FeatureRepositoryInterface $feature)
    {
        $this->feature = $feature;
        parent::__construct();
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->feature->create([
            'en' => [
                'name' => 'Max Storage',
                'value' => '200M',
            ],
            'slug' => str_slug('Max Storage'),
            'enabled' => true,
        ]);
        $this->feature->create([
            'en' => [
                'name' => 'Max Storage',
                'value' => '500M',
            ],
            'slug' => str_slug('Max Storage'),
            'enabled' => true,
        ]);
        $this->feature->create([
            'en' => [
                'name' => 'Max Site',
                'value' => '2',
            ],
            'slug' => str_slug('Max Site'),
            'enabled' => true,
        ]);
        $this->feature->create([
            'en' => [
                'name' => 'Max Site',
                'value' => '5',
            ],
            'slug' => str_slug('Max Site'),
            'enabled' => true,
        ]);
    }
}
