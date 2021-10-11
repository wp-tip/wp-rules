<?php
namespace WP_Rules\Templates\Backend;

use WP_Rules\Core\Admin\Templates\AbstractTemplate;

class SpecificUserNotice extends AbstractTemplate {

	/**
	 * Template unique ID, also used when initiate inside service provider.
	 *
	 * @var string
	 */
	protected $id = 'specific_user_notice';

	/**
	 * Template's group.
	 *
	 * @var string
	 */
	protected $group = 'backend';

	/**
	 * Template's Thumbnail.
	 *
	 * @var string
	 */
	protected $thumbnail = 'https://via.placeholder.com/300x300/588aa3/fff?text=Specific+User+Admin+Notice';

	/**
	 * Template's trigger.
	 *
	 * @var string
	 */
	protected $trigger = 'admin_init';

	/**
	 * Template's list of condition IDs.
	 *
	 * @var string[]
	 */
	protected $conditions = [
		'loggedin-user',
	];

	/**
	 * Template's list of action IDs.
	 *
	 * @var string[]
	 */
	protected $actions = [
		'admin_notices',
	];

	/**
	 * Template details.
	 */
	protected function init() {
		return [
			'name'        => __( 'Specific user admin notice.', 'rules' ),
			'description' => __( 'Show admin notice to specific pre-defined user.', 'rules' ),
		];
	}
}
