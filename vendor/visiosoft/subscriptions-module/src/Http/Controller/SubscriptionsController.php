<?php namespace Visiosoft\SubscriptionsModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Illuminate\Support\Facades\Auth;
use Visiosoft\CartsModule\Cart\Command\GetCart;
use Visiosoft\SiteModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\SubscriptionsModule\Log\Contract\LogRepositoryInterface;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Event\ExpiredSubscription;
use Visiosoft\SubscriptionsModule\Subscription\Event\RemainingSubscription;
use Visiosoft\SubscriptionsModule\Subscription\Event\SubscriptionChanged;

class SubscriptionsController extends ResourceController
{
    private $subscription;
    private $plan;
    private $site;
    private $log;

    public function __construct(
        SubscriptionRepositoryInterface $subscription,
        PlanRepositoryInterface $plan,
        SiteRepositoryInterface $site,
        LogRepositoryInterface $log)
    {
        $this->subscription = $subscription;
        $this->log = $log;
        $this->site = $site;
        $this->plan = $plan;
        parent::__construct();
    }

    public function subscriptionControl()
    {
        $subscriptions = $this->subscription->getActiveSubscriptions();

        foreach ($subscriptions as $subscription) {

            $remaining = $subscription->getRemaining();

            if (in_array((int)$remaining, [1, 3, 5])) {

                $findRemainingMail = $this->log->getFirstRemainingLog($subscription->getId(), $remaining);

                if (!$findRemainingMail) {

                    event(new RemainingSubscription($remaining, $subscription));

                    $this->log->createRemainingLog($subscription, $remaining);

                }

            } else if ($remaining < 0) {

                $findSuspendMail = $this->log->getFirstSuspendLog($subscription->getId());

                if (!$findSuspendMail) {

                    event(new ExpiredSubscription($subscription));

                    $subscription->suspend();

                    $this->log->createSuspendLog($subscription);
                }
            }
        }
    }

    public function detail($id)
    {
        if ($subscription = $this->subscription->find($id)) {
            $this->template->set('meta_title', $subscription->plan->name);

            return $this->view->make('visiosoft.module.subscriptions::subscriptions.detail', compact('subscription'));
        }
        $this->messages->error(trans('visiosoft.module.subscriptions::message.found_subscriptions'));

        return $this->redirect->route('visiosoft.module.subscriptions::my-subscriptions');
    }

    public function changePlanForPaddle($subscription_id, $paddle_plan_id)
    {
        $response = null;

        $params = array_merge([
            'subscription_id' => $subscription_id,
            'plan_id' => $paddle_plan_id,
            'vendor_id' => setting_value('visiosoft.module.paddle::vendor_id'),
            'vendor_auth_code' => setting_value('visiosoft.module.paddle::vendor_auth_code'),
        ]);

        $url = "https://vendors.paddle.com/api/2.0/subscription/users/update";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_POST, 1);

        try {
            $response = curl_exec($ch);
        } catch (\Exception $exception) {
            $this->messages->error([$exception->getMessage()]);
        }
        curl_close($ch);

        return $response;
    }


    public function mySubscriptions()
    {
        $this->template->set('meta_title', trans('visiosoft.module.subscriptions::field.my_subscriptions'));

        return $this->view->make('visiosoft.module.subscriptions::subscriptions.list');
    }

    public function renew($id)
    {
        if ($subscription = $this->subscription->find($id)) {
            $plans = $this->plan->newQuery()->get();
            $this->template->set('meta_title', $subscription->plan->name);
            return $this->view->make('visiosoft.module.subscriptions::plan.upgrade', compact('plans', 'subscription'));
        }
        abort(404);
    }

    public function buyOrTry($id, $type)
    {
        if ($plan = $this->plan->find($id)) {
            if ($type == "try") {
                $all_subscriptions = $this->subscription->getByAssign(Auth::id())->pluck('plan_id')->all();
                if (!in_array($plan, $all_subscriptions)) {

                    //"payment false" means no payment has been made.
                    try {
                        $subscription = $this->subscription->createNew(Auth::id(), $plan, false);
                    } catch (\Exception $exception) {
                        $this->messages->error([$exception->getMessage()]);
                        return $this->redirect->route('buy-plan');
                    }
                    return $this->redirect->route('visiosoft.module.subscriptions::detail_subscription', ['id' => $subscription->getId()]);

                } else {

                    $this->messages->info(trans('visiosoft.module.subscriptions::message.trial_feature_user'));
                    return $this->redirect->route('buy-plan');

                }
            } else {
                try {
                    $cart = $this->dispatch(new GetCart());
                    $cart->add($plan, 1);
                } catch (\Exception $exception) {
                    $this->messages->error([$exception->getMessage()]);
                    return $this->redirect->route('buy-plan');
                }
                return redirect('cart');

            }
        }
    }

    public function upgradeOrRenew($source_subscription_id, $type, $target_plan_id)
    {
        if ($target_plan = $this->plan->find($target_plan_id) and $source_subscription = $this->subscription->find($source_subscription_id)) {
            if ($type == "renew") {
                if ($plan = $source_subscription->plan) {
                    try {
                        $cart = $this->dispatch(new GetCart());
                        $plan->related = $source_subscription;
                        $cart->add($plan, 1);
                    } catch (\Exception $exception) {
                        $this->messages->error([$exception->getMessage()]);
                        return $this->redirect->route('visiosoft.module.subscriptions::upgrade_subscription', ['id' => $source_subscription->getId()]);
                    }
                } else {
                    $this->messages->error(trans('visiosoft.module.subscriptions::message.not_found_plan'));
                    return $this->redirect->route('visiosoft.module.subscriptions::upgrade_subscription', ['id' => $source_subscription->getId()]);
                }
            } else {
                try {
                    $cart = $this->dispatch(new GetCart());
                    $target_plan->related = $source_subscription;
                    $cart->add($target_plan, 1);
                } catch (\Exception $exception) {
                    $this->messages->error([$exception->getMessage()]);
                    return $this->redirect->route('visiosoft.module.subscriptions::upgrade_subscription', ['id' => $source_subscription->getId()]);
                }
            }
            return redirect('cart');
        }
    }
}
