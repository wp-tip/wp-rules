<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AddPostStatus
 *
 * @package WP_Rules\Actions
 */
class AddPostStatus extends AbstractAction {

	/**
	 * Current action options.
	 *
	 * @var array
	 */
	private $action_options;

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'add_post_status',
			'name'        => __( 'Add New post status', 'rules' ),
			'description' => __( 'Register a post status. Do not use before init.', 'rules' ),
			'group'       => __( 'Posts', 'rules' ),
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
				'label' => __( 'Label Text', 'rules' ),
				'name'  => 'label',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Public', 'rules' ),
				'name'    => 'public',
				'options' => [
					1 => __( 'Yes', 'rules' ),
					0 => __( 'No', 'rules' ),
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
		if ( empty( $action_options['label'] ) ) {
			return;
		}

		$this->action_options = $action_options;

		register_post_status(
			sanitize_title( $action_options['label'] ),
			[
				'label'                     => $action_options['label'],
				'public'                    => $action_options['public'] ?? true,
				'exclude_from_search'       => false,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'label_count'               => _n_noop( "{$action_options['label']} <span class='count'>(%s)</span>", "{$action_options['label']} <span class='count'>(%s)</span>", 'rules' ), // phpcs:ignore WordPress.WP.I18n.InterpolatedVariablePlural,WordPress.WP.I18n.InterpolatedVariableSingle, WordPress.WP.I18n.MissingTranslatorsComment
			]
		);

		add_action( 'admin_footer-edit.php', [ $this, 'add_status_quick_edit' ] );
	}

	/**
	 * Add the new status to quick edit select box.
	 */
	public function add_status_quick_edit() {
		printf(
			'<script>
		        jQuery(document).ready( function() {
		            let status = jQuery( \'select[name="_status"]\' );
		            if ( status.length > 0 ){
		                status.append( \'<option value="%s">%s</option>\' );
		            }
		        });
		    </script>',
			esc_attr( sanitize_title( $this->action_options['label'] ) ),
			esc_attr( $this->action_options['label'] )
		);
	}

}
