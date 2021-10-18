<?php
namespace WP_Rules\Templates\Backend;

use WP_Rules\Core\Admin\Templates\AbstractTemplate;

class NoticeSavePost extends AbstractTemplate {

	/**
	 * Template unique ID, also used when initiate inside service provider.
	 *
	 * @var string
	 */
	protected $id = 'save_post_notice';

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
	protected $thumbnail = 'https://via.placeholder.com/300x300/588aa3/fff?text=Save+Post+Notice';

	/**
	 * Template's trigger.
	 *
	 * @var string
	 */
	protected $trigger = 'wp_insert_post';

	/**
	 * Template's list of condition IDs.
	 *
	 * @var string[]
	 */
	protected $conditions = [];

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
			'name'        => __( 'Show admin notice when save post (New/Updated)', 'rules' ),
			'description' => __( 'Show admin notice When saving a new post or updating it.', 'rules' ),
		];
	}
}
