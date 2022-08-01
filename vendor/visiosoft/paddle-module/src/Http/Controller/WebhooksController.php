<?php namespace Visiosoft\PaddleModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Visiosoft\PaddleModule\Event\SubscriptionCancelledPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionCreatedPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentFailedPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentRefundedPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentSucceededPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionUpdatedPaddle;
use Visiosoft\PaddleModule\Task\Contract\TaskRepositoryInterface;

/**
 * Class WebhooksController
 *
 * @link          https://openclassify.com/
 * @author        Visiosoft, LTD.. <support@visiosoft.com.tr>
 * @author        Vedat Akdoğan <vedat@visiosoft.com.tr>
 */
class WebhooksController extends ResourceController
{
    /**
     * @param TaskRepositoryInterface $repository
     * Alerts are notifications Paddle sends out after an event occurs.
     */
    public function webhooks(TaskRepositoryInterface $repository)
    {
        if (isset($this->request->alert_name)) {
            $type = $this->request->alert_name;
            $response = json_encode($this->request->all());

            $repository->create([
                'response_type' => $type,
                'paddle_response' => $response,
            ]);

            /**
             * The subscription_created alert is fired when a
             * new subscription is created, and a user has
             * successfully subscribed.
             */
            if ($type == "subscription_created") {
                event(new SubscriptionCreatedPaddle($response));
            }

            /**
             * The subscription_updated alert is fired when a
             * subscription changes (e.g. a customer changes
             * plan via upgrade or downgrade).
             */
            if ($type == "subscription_updated") {
                event(new SubscriptionUpdatedPaddle($response));
            }

            /**
             * The subscription_cancelled alert is fired when a
             * subscription is cancelled/ended.
             */
            if ($type == "subscription_cancelled") {
                event(new SubscriptionCancelledPaddle($response));
            }

            /**
             * The subscription_payment_succeeded alert is fired when a
             * payment for a subscription is received successfully.
             */
            if ($type == "subscription_payment_succeeded") {
                event(new SubscriptionPaymentSucceededPaddle($response));
            }

            /**
             * The subscription_payment_failed alert is fired when a
             * payment for a subscription fails.
             */
            if ($type == "subscription_payment_failed") {
                event(new SubscriptionPaymentFailedPaddle($response));
            }

            /**
             * The subscription_payment_refunded alert is fired when a
             * refund for a subscription payment is issued.
             */
            if ($type == "subscription_payment_refunded") {
                event(new SubscriptionPaymentRefundedPaddle($response));
            }
        }
    }
}
