<?php namespace Visiosoft\SubscriptionsModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\ProfileModule\Events\UserActivatedByMail;
use Visiosoft\ProfileModule\Events\UserActivatedBySmsEvent;
use Visiosoft\SiteModule\Site\Event\CreateSiteOnManuel;
use Visiosoft\SiteModule\Site\Event\subscriptions\CreateSubscriptionForChangeSitePlan;
use Visiosoft\SubscriptionsModule\Console\CheckSubscriptions;
use Visiosoft\SubscriptionsModule\Log\Contract\LogRepositoryInterface;
use Visiosoft\SubscriptionsModule\Log\LogRepository;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsLogEntryModel;
use Visiosoft\SubscriptionsModule\Log\LogModel;
use Visiosoft\PaddleModule\Event\SubscriptionCancelledPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentFailedPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentRefundedPaddle;
use Visiosoft\PaddleModule\Event\SubscriptionPaymentSucceededPaddle;
use Visiosoft\SubscriptionsModule\Subscription\Contract\SubscriptionRepositoryInterface;
use Visiosoft\SubscriptionsModule\Subscription\Listener\ActivatedUserBySmsListener;
use Visiosoft\SubscriptionsModule\Subscription\Listener\ActivatedUserBySubscription;
use Visiosoft\SubscriptionsModule\Subscription\Listener\CreatedUser;
use Visiosoft\SubscriptionsModule\Subscription\Listener\paddle\SubscriptionCancelled;
use Visiosoft\SubscriptionsModule\Subscription\Listener\paddle\SubscriptionPaymentFailed;
use Visiosoft\SubscriptionsModule\Subscription\Listener\paddle\SubscriptionPaymentRefunded;
use Visiosoft\SubscriptionsModule\Subscription\Listener\paddle\SubscriptionPaymentSucceeded;
use Visiosoft\SubscriptionsModule\Subscription\Listener\site\CreateOnManuelForSite;
use Visiosoft\SubscriptionsModule\Subscription\Listener\site\NewSubscriptionForChangeSitePlan;
use Visiosoft\SubscriptionsModule\Subscription\SubscriptionRepository;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsSubscriptionsEntryModel;
use Visiosoft\SubscriptionsModule\Subscription\SubscriptionModel;
use Visiosoft\SubscriptionsModule\Feature\Contract\FeatureRepositoryInterface;
use Visiosoft\SubscriptionsModule\Feature\FeatureRepository;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsFeaturesEntryModel;
use Visiosoft\SubscriptionsModule\Feature\FeatureModel;
use Visiosoft\SubscriptionsModule\Plan\Contract\PlanRepositoryInterface;
use Visiosoft\SubscriptionsModule\Plan\PlanRepository;
use Anomaly\Streams\Platform\Model\Subscriptions\SubscriptionsPlanEntryModel;
use Visiosoft\SubscriptionsModule\Plan\PlanModel;
use Illuminate\Routing\Router;

class SubscriptionsModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Additional addon plugins.
     *
     * @type array|null
     */
    protected $plugins = [
        SubscriptionsModulePlugin::class
    ];

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [
        CheckSubscriptions::class,
    ];

    protected $schedules = [
        '* * * * *' => [
            CheckSubscriptions::class,
        ],
    ];

    /**
     * The addon API routes.
     *
     * @type array|null
     */
    protected $api = [];

    /**
     * The addon routes.
     *
     * @type array|null
     */
    protected $routes = [
        'admin/subscriptions/log' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\LogController@index',
        'admin/subscriptions/log/create' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\LogController@create',
        'admin/subscriptions/log/edit/{id}' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\LogController@edit',
        'admin/subscriptions' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\SubscriptionsController@index',
        'admin/subscriptions/create' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\SubscriptionsController@create',
        'admin/subscriptions/edit/{id}' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\SubscriptionsController@edit',
        'admin/subscriptions/features' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\FeaturesController@index',
        'admin/subscriptions/features/create' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\FeaturesController@create',
        'admin/subscriptions/features/edit/{id}' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\FeaturesController@edit',
        'admin/subscriptions/plan' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\PlanController@index',
        'admin/subscriptions/plan/create' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\PlanController@create',
        'admin/subscriptions/plan/edit/{id}' => 'Visiosoft\SubscriptionsModule\Http\Controller\Admin\PlanController@edit',
        'cron/subscriptionControl' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@subscriptionControl',
        'buy-plan' => [
            'as' => 'buy-plan',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\PlanController@index',
        ],
        'my-subscriptions' => [
            'as' => 'visiosoft.module.subscriptions::my-subscriptions',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@mySubscriptions',
        ],
        'subscription/{id}/detail' => [
            'as' => 'visiosoft.module.subscriptions::detail_subscription',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@detail',
        ],
        'subscription/{id}/upgrade' => [
            'as' => 'visiosoft.module.subscriptions::upgrade_subscription',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@renew',
        ],
        'subscription/{id}/{type}' => [
            'as' => 'visiosoft.module.subscriptions::action_subscription',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@buyOrTry',
        ],
        'subscription/{old}/{type}/{id}' => [
            'as' => 'visiosoft.module.subscriptions::upgrade_or_renew_subscription',
            'uses' => 'Visiosoft\SubscriptionsModule\Http\Controller\SubscriptionsController@upgradeOrRenew',
        ],
        'api/list-plans' => 'Visiosoft\SubscriptionsModule\Http\Controller\ApiController@listPlans',

    ];

    /**
     * The addon middleware.
     *
     * @type array|null
     */
    protected $middleware = [
        //Visiosoft\SubscriptionsModule\Http\Middleware\ExampleMiddleware::class
    ];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    protected $groupMiddleware = [
        //'web' => [
        //    Visiosoft\SubscriptionsModule\Http\Middleware\ExampleMiddleware::class,
        //],
    ];

    /**
     * Addon route middleware.
     *
     * @type array|null
     */
    protected $routeMiddleware = [];

    /**
     * The addon event listeners.
     *
     * @type array|null
     */
    protected $listeners = [
        SubscriptionCancelledPaddle::class => [
            SubscriptionCancelled::class
        ],
        SubscriptionPaymentSucceededPaddle::class => [
            SubscriptionPaymentSucceeded::class
        ],
        SubscriptionPaymentFailedPaddle::class => [
            SubscriptionPaymentFailed::class
        ],
        SubscriptionPaymentRefundedPaddle::class => [
            SubscriptionPaymentRefunded::class
        ],
        CreateSiteOnManuel::class => [
            CreateOnManuelForSite::class
        ],
        UserActivatedByMail::class => [
            ActivatedUserBySubscription::class,
        ],
        UserActivatedBySmsEvent::class => [
            ActivatedUserBySmsListener::class,
        ],
        CreateSubscriptionForChangeSitePlan::class => [
            NewSubscriptionForChangeSitePlan::class,
        ],
    ];

    /**
     * The addon alias bindings.
     *
     * @type array|null
     */
    protected $aliases = [
        //'Example' => Visiosoft\SubscriptionsModule\Example::class
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [
        SubscriptionsLogEntryModel::class => LogModel::class,
        SubscriptionsSubscriptionsEntryModel::class => SubscriptionModel::class,
        SubscriptionsFeaturesEntryModel::class => FeatureModel::class,
        SubscriptionsPlanEntryModel::class => PlanModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        LogRepositoryInterface::class => LogRepository::class,
        SubscriptionRepositoryInterface::class => SubscriptionRepository::class,
        FeatureRepositoryInterface::class => FeatureRepository::class,
        PlanRepositoryInterface::class => PlanRepository::class,
    ];

    /**
     * Additional service providers.
     *
     * @type array|null
     */
    protected $providers = [
        //\ExamplePackage\Provider\ExampleProvider::class
    ];

    /**
     * The addon view overrides.
     *
     * @type array|null
     */
    protected $overrides = [
        //'streams::errors/404' => 'module::errors/404',
        //'streams::errors/500' => 'module::errors/500',
    ];

    /**
     * The addon mobile-only view overrides.
     *
     * @type array|null
     */
    protected $mobile = [
        //'streams::errors/404' => 'module::mobile/errors/404',
        //'streams::errors/500' => 'module::mobile/errors/500',
    ];

    /**
     * Register the addon.
     */
    public function register()
    {
        // Run extra pre-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Boot the addon.
     */
    public function boot()
    {
        // Run extra post-boot registration logic here.
        // Use method injection or commands to bring in services.
    }

    /**
     * Map additional addon routes.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        // Register dynamic routes here for example.
        // Use method injection or commands to bring in services.
    }

}
