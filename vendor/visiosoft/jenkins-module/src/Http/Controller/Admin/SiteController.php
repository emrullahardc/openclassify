<?php namespace Visiosoft\JenkinsModule\Http\Controller\Admin;

use Visiosoft\JenkinsModule\Site\Contract\SiteRepositoryInterface;
use Visiosoft\JenkinsModule\Site\Form\SiteFormBuilder;
use Visiosoft\JenkinsModule\Site\Table\SiteTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

class SiteController extends AdminController
{

    protected $site;

    public function __construct(SiteRepositoryInterface $siteRepository)
    {
        $this->site = $siteRepository;
        parent::__construct();
    }

    /**
     * Display an index of existing entries.
     *
     * @param SiteTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SiteTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Create a new entry.
     *
     * @param SiteFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(SiteFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Edit an existing entry.
     *
     * @param SiteFormBuilder $form
     * @param        $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(SiteFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    public function showLog($id)
    {
        if ($jenkins_log = $this->site->find($id)) {
            $rID = $jenkins_log->queueId;
            $response = $this->site->checkStatusRequest($rID);

            if ($response and isset($response['id'])) {
                header("Refresh:5");
                echo "<pre>";
                echo $this->site->showLog($response['id']);
                die;
            }
        }
        $this->messages->info(trans('visiosoft.module.jenkins::button.error_show_log'));
        return back();
    }
}
