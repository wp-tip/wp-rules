<?php
namespace WP_Rules\Actions\Backend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AddUpdateOption
 *
 * @package WP_Rules\Actions
 */
class AddUpdateOption extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'add_update_option',
			'name'        => __( 'Add/Update Option', 'rules' ),
			'description' => __( 'Add/Update site option, saved into wp_options database table. This option maybe an option at WordPress settings page or option related to a specific plugin. ', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type'  => 'text',
				'label' => __( 'Option Name', 'rules' ),
				'name'  => 'option_name',
			],
			[
				'type'  => 'text',
				'label' => __( 'Option Value', 'rules' ),
				'name'  => 'option_value',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Append', 'rules' ),
				'name'    => 'append',
				'options' => [
					'no'  => __( 'No', 'rules' ),
					'yes' => __( 'Yes', 'rules' ),
				],
			],
		];
	}

	/**
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		if ( empty( $action_options['option_name'] ) ) {
			return;
		}

		$current_option_value = get_option( $action_options['option_name'] );

		if ( $current_option_value ) {
			if ( 'yes' === $action_options['append'] ) {
				$action_options['option_value'] = $current_option_value . $action_options['option_value'];
			}

			update_option( $action_options['option_name'], $action_options['option_value'] );

			return;
		}

		add_option( $action_options['option_name'], $action_options['option_value'] );
	}

}
