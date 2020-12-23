<?php
namespace WP_Rules\Conditions;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class Role extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return void
	 */
	protected function init() {
		$this->id        = 'role';
		$this->name      = __( 'Current logged-in user role', 'rules' );
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type' => 'text',
				'label' => 'text 1',
				'name' => 'role_text'
			]
		];
	}

}
