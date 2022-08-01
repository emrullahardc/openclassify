<?php namespace Visiosoft\JenkinsModule;

use Anomaly\Streams\Platform\Addon\AddonServiceProvider;
use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsAddAddon;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsAddDomainSite;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsAddMultipleAddon;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsCheckActivated;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsCheckAddonInstall;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsCreate;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsCreateSubSite;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsDelete;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsDeleteAddon;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsDeleteDomainSite;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsDeleteTrial;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsReinstall;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsSuspend;
use Visiosoft\JenkinsModule\Site\Listener\JenkinsUpdate;
use Visiosoft\JenkinsModule\Site\SiteRepository;
use Anomaly\Streams\Platform\Model\Jenkins\JenkinsSiteEntryModel;
use Visiosoft\JenkinsModule\Site\SiteModel;
use Illuminate\Routing\Router;
use Visiosoft\SiteModule\Domain\Event\CreateDomain;
use Visiosoft\SiteModule\Domain\Event\DeleteDomain;
use Visiosoft\SiteModule\Site\Event\AddAddonSite;
use Visiosoft\SiteModule\Site\Event\AddMultipleAddonSite;
use Visiosoft\SiteModule\Site\Event\BuildSite;
use Visiosoft\SiteModule\Site\Event\BuildSubSite;
use Visiosoft\SiteModule\Site\Event\CheckActivatedSite;
use Visiosoft\SiteModule\Site\Event\CheckCompletedAddonInstall;
use Visiosoft\SiteModule\Site\Event\DeleteAddonSite;
use Visiosoft\SiteModule\Site\Event\DeleteSite;
use Visiosoft\SiteModule\Site\Event\DeleteTrial;
use Visiosoft\SiteModule\Site\Event\ReinstallSite;
use Visiosoft\SiteModule\Site\Event\SuspendSite;
use Visiosoft\SiteModule\Site\Event\UpdateSite;

class JenkinsModuleServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'admin/jenkins' => 'Visiosoft\JenkinsModule\Http\Controller\Admin\SiteController@index',
        'admin/jenkins/create' => 'Visiosoft\JenkinsModule\Http\Controller\Admin\SiteController@create',
        'admin/jenkins/edit/{id}' => 'Visiosoft\JenkinsModule\Http\Controller\Admin\SiteController@edit',
        'admin/jenkins/show-log/{id}' => 'Visiosoft\JenkinsModule\Http\Controller\Admin\SiteController@showLog',

    ];

    protected $listeners = [
        CheckActivatedSite::class => [
            JenkinsCheckActivated::class
        ],
        UpdateSite::class => [
            JenkinsUpdate::class
        ],
        SuspendSite::class => [
            JenkinsSuspend::class
        ],
        BuildSite::class => [
            JenkinsCreate::class
        ],
        DeleteSite::class => [
            JenkinsDelete::class
        ],
        AddAddonSite::class => [
            JenkinsAddAddon::class
        ],
        AddMultipleAddonSite::class => [
            JenkinsAddMultipleAddon::class
        ],
        DeleteAddonSite::class => [
            JenkinsDeleteAddon::class
        ],
        CreateDomain::class => [
            JenkinsAddDomainSite::class
        ],
        DeleteDomain::class => [
            JenkinsDeleteDomainSite::class,
        ],
        CheckCompletedAddonInstall::class => [
            JenkinsCheckAddonInstall::class,
        ],
        ReinstallSite::class => [
            JenkinsReinstall::class,
        ],
        DeleteTrial::class => [
            JenkinsDeleteTrial::class
        ],
        BuildSubSite::class => [
            JenkinsCreateSubSite::class,
        ],
    ];

    protected $bindings = [
        JenkinsSiteEntryModel::class => SiteModel::class,
    ];

    protected $singletons = [
        SiteRepositoryInterface::class => SiteRepository::class,
    ];
}
