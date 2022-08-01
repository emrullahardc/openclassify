<?php namespace Visiosoft\SubscriptionsModule\Plan;

use Anomaly\FilesModule\File\Command\GetFile;
use Anomaly\Streams\Platform\Image\Command\MakeImageInstance;
use Anomaly\Streams\Platform\Support\Decorator;
use Visiosoft\AdvsModule\Support\Command\Currency;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanInterface;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsPlanEntryModel;

class PlanModel extends SubscriptionsPlanEntryModel implements PlanInterface
{
    protected $appends = [
        'thumbnail',
        'currency_price',
    ];

    public function getThumbnailAttribute()
    {
        if ($this->icon) {
            return $this->icon->make()->url();
        }
        return null;
    }

    public function getCurrencyPriceAttribute()
    {
        return app(Currency::class)->format($this->price, $this->currency);
    }

    protected $ttl = false;

    public function getName()
    {
        return $this->getAttribute('name');
    }

    public function getTrial()
    {
        return $this->getAttribute('trial_interval');
    }

    public function getTrialPeriod()
    {
        return $this->getAttribute('trial_period');
    }

    public function getInterval()
    {
        return $this->getAttribute('interval');
    }

    public function getIntervalPeriod()
    {
        return $this->getAttribute('interval_period');
    }
}
