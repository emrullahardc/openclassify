<?php namespace Visiosoft\SubscriptionsModule\Subscription\Listener\site;

use Visiosoft\SiteModule\Site\Event\CreateSiteOnManuel;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\CreateSubscriptionOnManuel;

class CreateOnManuelForSite
{
    private $subscription;
    private $planRepository;

    public function __construct(SubscriptionRepositoryInterface $subscription, PlanRepositoryInterface $planRepository)
    {
        $this->subscription = $subscription;
        $this->planRepository = $planRepository;
    }

    public function handle(CreateSiteOnManuel $event)
    {
        $default_plan = setting_value('visiosoft.module.subscriptions::register_default_plan');

        $plan = $this->planRepository->find($default_plan);

        $user = $event->getAssign();

        $subscription = $this->subscription->createNew($user->getId(), $plan, false);

        event(new CreateSubscriptionOnManuel($subscription));

        return $subscription;
    }
}
