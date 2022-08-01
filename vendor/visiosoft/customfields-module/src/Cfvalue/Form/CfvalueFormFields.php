<?php namespace Visiosoft\CustomfieldsModule\Cfvalue\Form;


class CfvalueFormFields
{
	public function handle(CfvalueFormBuilder $builder)
	{
		$builder->setFields(($builder->getFormMode() === "create") ? [
			'custom_field_value' => [
				'type' => 'anomaly.field_type.tags'
			]
		] : [
			'custom_field_value' => [
				'type' => 'anomaly.field_type.text'
			]
		]);
	}
}
