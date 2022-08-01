<?php namespace Visiosoft\SubscriptionsModule\Console;

use Illuminate\Console\Command;
use Visiosoft\SubscriptionsModule\Log\Contract\LogRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\ExpiredSubscription;
use Visiosoft\SubscriptionsModule\Subscription\Event\RemainingSubscription;

class CheckSubscriptions extends Command
{
    protected $name = 'check:subscriptions';

    public function handle(SubscriptionRepositoryInterface $subscriptions, LogRepositoryInterface $log)
    {
        $subscriptions = $subscriptions->getActiveSubscriptions();

        foreach ($subscriptions as $subscription) {

            $remaining = $subscription->getRemaining();

            if (in_array((int)$remaining, [1, 3, 5])) {

                $findRemainingMail = $log->getFirstRemainingLog($subscription->getId(), $remaining);

                if (!$findRemainingMail) {

                    event(new RemainingSubscription($remaining, $subscription));

                    $log->createRemainingLog($subscription, $remaining);

                }

            } else if ($remaining < 0) {

                $findSuspendMail = $log->getFirstSuspendLog($subscription->getId());

                if (!$findSuspendMail) {

                    event(new ExpiredSubscription($subscription));

                    $subscription->suspend();

                    $log->createSuspendLog($subscription);
                }
            }
        }
    }
}
