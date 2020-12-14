<?php
namespace WP_Rules\Core\Admin\Rule;

use WP_Post;

/**
 * Class Metabox
 *
 * @package WP_Rules\Core\Admin\Rule
 */
class MetaBox {

	/**
	 * Create main meta boxes for rules post type.
	 */
	public function create() {
		add_meta_box( 'trigger',    'Rule trigger',    [ $this, 'create_trigger_fields' ],   'rules' );
		add_meta_box( 'conditions', 'Rule Conditions', [ $this, 'create_condition_fields' ], 'rules' );
		add_meta_box( 'actions',    'Rule Actions',    [ $this, 'create_action_fields' ],    'rules' );
	}

	/**
	 * Create fields for trigger meta box.
	 *
	 * @param WP_Post $post Current post object.
	 * @param array   $meta_box Metabox array that has all items.
	 */
	public function create_trigger_fields( $post, $meta_box ) {
		do_action( 'rules_metabox_trigger_fields', $post, $meta_box );
	}

	/**
	 * Create fields for condition meta box.
	 *
	 * @param WP_Post $post Current post object.
	 * @param array   $meta_box Metabox array that has all items.
	 */
	public function create_condition_fields( $post, $meta_box ) {
		do_action( 'rules_metabox_condition_fields', $post, $meta_box );
	}

	/**
	 * Create fields for action meta box.
	 *
	 * @param WP_Post $post Current post object.
	 * @param array   $meta_box Metabox array that has all items.
	 */
	public function create_action_fields( $post, $meta_box ) {
		do_action( 'rules_metabox_action_fields', $post, $meta_box );
	}

}
