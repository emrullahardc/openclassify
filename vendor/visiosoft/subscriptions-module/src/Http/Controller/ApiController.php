<?php namespace Visiosoft\SubscriptionsModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\ResourceController;
use Visiosoft\ConnectModule\Resource\ResourceBuilder;

class ApiController extends ResourceController
{
    public function listPlans(ResourceBuilder $resources)
    {
        return $resources
            ->setFunction('list')
            ->setOption('read', true)
            ->setOption('parameters', $this->request->all())
            ->response('subscriptions', 'plan');
    }
}
