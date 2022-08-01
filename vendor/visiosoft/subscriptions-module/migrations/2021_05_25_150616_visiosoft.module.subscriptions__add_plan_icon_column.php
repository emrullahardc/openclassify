<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

class VisiosoftModuleSubscriptionsAddPlanIconColumn extends Migration
{
	protected $delete = false;

	protected $stream = [
		'slug' => 'plan',
	];

	protected $fields = [
		'icon' => [
			'type' => 'anomaly.field_type.file',
			"config" => [
				'folders' => ["images"],
				'mode' => 'upload'
			]
		],
	];

	protected $assignments = [
		'icon',
	];
}
