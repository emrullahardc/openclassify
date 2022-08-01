<?php namespace Visiosoft\CwpModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\CwpModule\Listeners\CwpBackupChange;
use Visiosoft\CwpModule\Listeners\CwpCheckAccount;
use Visiosoft\CwpModule\Listeners\CwpSSLInstall;
use Visiosoft\CwpModule\Server\Contract\ServerRepositoryInterface;
use Visiosoft\CwpModule\Server\ServerRepository;
use Anomaly\Streams\Platform\Model\Cwp\CwpServerEntryModel;
use Visiosoft\CwpModule\Server\ServerModel;
use Visiosoft\CwpModule\Task\Contract\TaskRepositoryInterface;
use Visiosoft\CwpModule\Task\TaskRepository;
use Anomaly\Streams\Platform\Model\Cwp\CwpTaskEntryModel;
use Visiosoft\CwpModule\Task\TaskModel;
use Illuminate\Routing\Router;
use Visiosoft\SiteModule\Site\Event\BackupStatusChange;
use Visiosoft\SiteModule\Site\Event\CheckSubdomain;
use Visiosoft\SiteModule\Site\Event\InstallSSL;

class CwpModuleServiceProvider extends AddonServiceProvider
{

    /**
     * Additional addon plugins.
     *
     * @type array|null
     */
    protected $plugins = [];

    /**
     * The addon Artisan commands.
     *
     * @type array|null
     */
    protected $commands = [];

    /**
     * The addon's scheduled commands.
     *
     * @type array|null
     */
    protected $schedules = [];

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
        'admin/cwp' => 'Visiosoft\CwpModule\Http\Controller\Admin\ServerController@index',
        'admin/cwp/create' => 'Visiosoft\CwpModule\Http\Controller\Admin\ServerController@create',
        'admin/cwp/edit/{id}' => 'Visiosoft\CwpModule\Http\Controller\Admin\ServerController@edit',
        'admin/cwp/task' => 'Visiosoft\CwpModule\Http\Controller\Admin\TaskController@index',
        'admin/cwp/test' => 'Visiosoft\CwpModule\Http\Controller\Admin\TaskController@test',
        'cwp/test' => 'Visiosoft\CwpModule\Http\Controller\TaskController@test',
    ];

    /**
     * The addon middleware.
     *
     * @type array|null
     */
    protected $middleware = [
        //Visiosoft\CwpModule\Http\Middleware\ExampleMiddleware::class
    ];

    /**
     * Addon group middleware.
     *
     * @var array
     */
    protected $groupMiddleware = [
        //'web' => [
        //    Visiosoft\CwpModule\Http\Middleware\ExampleMiddleware::class,
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
        BackupStatusChange::class => [
            CwpBackupChange::class,
        ],
        InstallSSL::class => [
            CwpSSLInstall::class
        ],
        CheckSubdomain::class => [
            CwpCheckAccount::class,
        ],
    ];

    /**
     * The addon alias bindings.
     *
     * @type array|null
     */
    protected $aliases = [
        //'Example' => Visiosoft\CwpModule\Example::class
    ];

    /**
     * The addon class bindings.
     *
     * @type array|null
     */
    protected $bindings = [
        CwpServerEntryModel::class => ServerModel::class,
        CwpTaskEntryModel::class => TaskModel::class,
    ];

    /**
     * The addon singleton bindings.
     *
     * @type array|null
     */
    protected $singletons = [
        ServerRepositoryInterface::class => ServerRepository::class,
        TaskRepositoryInterface::class => TaskRepository::class,
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
