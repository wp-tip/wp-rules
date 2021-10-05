<?php
namespace WP_Rules\Templates\Backend;

use WP_Rules\Core\Admin\Templates\AbstractTemplate;

class SpecificUserNotice extends AbstractTemplate {

	protected $id = 'specific_user_notice';

	protected $group = 'backend';

	protected $thumbnail = 'https://via.placeholder.com/300x300/588aa3/fff?text=Specific+User+Admin+Notice';

	protected $trigger = 'admin_init';

	protected $conditions = [
		'loggedin-user',
	];

	protected $actions = [
		'admin_notices',
	];

	/**
	 * @inheritDoc
	 */
	protected function init() {
		return [
			'name'        => __( 'Specific user admin notice.', 'rules' ),
			'description' => __( 'Show admin notice to specific pre-defined user.', 'rules' ),
		];
	}
}
