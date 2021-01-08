<?php
namespace WP_Rules\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class AdminNotices extends AbstractAction {

	protected $notice_args = [];

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return void
	 */
	protected function init() {
		$this->id   = 'admin_notices';
		$this->name = __( 'Show admin notice.', 'rules' );
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type'  => 'textarea',
				'label' => __( 'Admin notice contents.', 'rules' ),
				'name'  => 'notice_contents',
			],
			[
				'type' => 'select',
				'label' => __( 'Notice Type', 'rules' ),
				'name' => 'notice_type',
				'options' => [
					'error' => __( 'Error', 'rules' ),
					'warning' => __( 'Warning', 'rules' ),
					'success' => __( 'Success', 'rules' ),
					'info' => __( 'Info', 'rules' ),
				]
			]
		];
	}

	protected function evaluate( $action_options, $trigger_hook_args ) {
		$this->notice_args = [
			'status' => $action_options['notice_type'],
			'message' => nl2br( $action_options['notice_contents'] )
		];

		add_action( 'admin_notices', [ $this, 'print_notice' ] );
	}

	public function print_notice() {
		?>
		<div class="notice notice-<?php echo esc_attr( $this->notice_args['status'] ); ?> is-dismissible"><p><?php echo $this->notice_args['message']; ?></p></div>
		<?php
	}

}
