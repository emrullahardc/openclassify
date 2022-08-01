<?php namespace Visiosoft\SubscriptionsModule;

use Anomaly\FilesModule\Disk\Contract\DiskRepositoryInterface;
use Anomaly\FilesModule\Folder\Contract\FolderRepositoryInterface;
use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Chumper\Zipper\Zipper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;
use Visiosoft\SubscriptionsModule\Feature\FeatureSeeder;
use Visiosoft\SubscriptionsModule\Notifications\SubscriptionsModuleNotificationsTemplateSeeder;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Plan\PlanSeeder;


class SubscriptionsModuleSeeder extends Seeder
{

    private $plan;

    private $feature;

    public function __construct(FeatureRepositoryInterface $feature, PlanRepositoryInterface $plan)
    {
        $this->plan = $plan;
        $this->feature = $feature;
        parent::__construct();
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->call(FeatureSeeder::class);
        $this->call(PlanSeeder::class);

        //Notification Templates
        $this->call(SubscriptionsModuleNotificationsTemplateSeeder::class);
    }

}