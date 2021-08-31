<?php
namespace WP_Rules\Actions\Backend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Actions
 */
class AdminNotices extends AbstractAction {

	/**
	 * Notice arguments.
	 *
	 * @var array
	 */
	protected $notice_args = [];

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'admin_notices',
			'name'        => __( 'Show admin notice.', 'rules' ),
			'description' => __( 'Prints admin screen notices.', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Notice Type', 'rules' ),
				'name'    => 'notice_type',
				'options' => [
					'error'   => __( 'Error', 'rules' ),
					'warning' => __( 'Warning', 'rules' ),
					'success' => __( 'Success', 'rules' ),
					'info'    => __( 'Info', 'rules' ),
				],
			],
			[
				'type'    => 'select',
				'label'   => __( 'Dismissable', 'rules' ),
				'name'    => 'notice_dismissable',
				'options' => [
					1 => __( 'Yes', 'rules' ),
					0 => __( 'No', 'rules' ),
				],
			],
			[
				'type'    => 'select',
				'label'   => __( 'Use transient', 'rules' ),
				'name'    => 'use_transient',
				'options' => [
					1 => __( 'Yes', 'rules' ),
					0 => __( 'No', 'rules' ),
				],
			],
			[
				'type'  => 'textarea',
				'label' => __( 'Admin notice contents.', 'rules' ),
				'name'  => 'notice_contents',
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
		$this->notice_args = [
			'status'        => $action_options['notice_type'],
			'message'       => $action_options['notice_contents'],
			'dismissable'   => $action_options['notice_dismissable'],
			'use_transient' => $action_options['use_transient'] ?? 0,
		];

		if ( ! empty( $action_options['use_transient'] ) ) {
			set_transient( 'rules_admin_notice', $this->notice_args );
		}

		add_action( 'admin_notices', [ $this, 'print_notice' ] );
	}

	/**
	 * Print notice HTML
	 */
	public function print_notice() {
		if ( empty( $this->notice_args ) ) {
			return;
		}

		if ( ! empty( $this->notice_args['use_transient'] ) ) {
			delete_transient( 'rules_admin_notice' );
		}

		printf(
				'<div class="notice notice-%s %s"><p>%s</p></div>',
				esc_attr( $this->notice_args['status'] ),
				( $this->notice_args['dismissable'] ? 'is-dismissible' : '' ),
				nl2br( esc_textarea( $this->notice_args['message'] ) )
		);
	}

}
