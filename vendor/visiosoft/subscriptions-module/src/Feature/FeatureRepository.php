<?php namespace Visiosoft\SubscriptionsModule\Feature;

use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;
use Anomaly\Streams\Platform\Entry\EntryRepository;

class FeatureRepository extends EntryRepository implements FeatureRepositoryInterface
{

    /**
     * The entry model.
     *
     * @var FeatureModel
     */
    protected $model;

    /**
     * Create a new FeatureRepository instance.
     *
     * @param FeatureModel $model
     */
    public function __construct(FeatureModel $model)
    {
        $this->model = $model;
    }
}
