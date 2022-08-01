<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleJenkinsCreateSiteStream extends Migration
{

    /**
     * This migration creates the stream.
     * It should be deleted on rollback.
     *
     * @var bool
     */
    protected $delete = true;

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'site',
        'title_column' => 'subdomain',
        'translatable' => false,
        'versionable' => false,
        'trashable' => true,
        'searchable' => false,
        'sortable' => false,
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'subdomain',
        'domain',
        'email',
        'username',
        'password',
        'create',
        'suspend',
        'update',
        'delete',
        'addon',
        'queueId',
        'addonName',
        'addonType',
        'type',
    ];

}
