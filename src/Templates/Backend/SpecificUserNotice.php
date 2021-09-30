<?php
namespace WP_Rules\Templates\Backend;

use WP_Rules\Core\Admin\Templates\AbstractTemplate;

class SpecificUserNotice extends AbstractTemplate {

	protected $id = 'specific_user_notice';

	protected $group = 'backend';

	protected $thumbnail = '';

	protected $trigger = 'admin_init';

	protected $conditions = [];

	protected $actions = [];

	/**
	 * @inheritDoc
	 */
	protected function init() {
		return [
			'name' => __( 'Show admin notice to specific user.', 'rules' ),
			'description' => '',
		];
	}
}
