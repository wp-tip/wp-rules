<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class CreatePost
 *
 * @package WP_Rules\Actions
 */
class CreatePost extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'create_post',
			'name'        => __( 'Create Post', 'rules' ),
			'description' => __( 'Create new post.', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Post Type', 'rules' ),
				'name'    => 'post_type',
				'options' => $this->get_post_types_list(),
			],
			[
				'type'    => 'select',
				'label'   => __( 'Post Author', 'rules' ),
				'name'    => 'post_author',
				'options' => $this->get_users_list(),
			],
			[
				'type'  => 'text',
				'label' => __( 'Post Title', 'rules' ),
				'name'  => 'post_title',
			],
			[
				'type'  => 'textarea',
				'label' => __( 'Post Content', 'rules' ),
				'name'  => 'post_content',
			],
			[
				'type'  => 'textarea',
				'label' => __( 'Post Excerpt', 'rules' ),
				'name'  => 'post_excerpt',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Post Status', 'rules' ),
				'name'    => 'post_status',
				'options' => get_post_statuses(),
			],
			[
				'type'    => 'select',
				'label'   => __( 'Comment Status', 'rules' ),
				'name'    => 'comment_status',
				'options' => [
					0 => 'No',
					1 => 'Yes',
				],
			],
			[
				'type'  => 'text',
				'label' => __( 'Meta values (meta_key1=meta_value1&meta_key2=meta_value2)', 'rules' ),
				'name'  => 'metas',
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
		$post_array = [];

		$fields = [
			'post_author',
			'post_content',
			'post_title',
			'post_excerpt',
			'post_status',
			'post_type',
			'comment_status',
		];

		foreach ( $fields as $field ) {
			if ( empty( $action_options[ $field ] ) ) {
				continue;
			}

			$post_array[ $field ] = $action_options[ $field ];
		}

		$post_id = wp_insert_post( $post_array );

		if ( empty( $post_id ) || empty( $action_options['metas'] ) ) {
			return;
		}

		$this->save_metas( $post_id, $action_options['metas'] );
	}

	/**
	 * Save new post metas.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $post_metas Post metas string.
	 */
	private function save_metas( $post_id, $post_metas ) {
		$metas = explode( '&', $post_metas );
		foreach ( $metas as $meta ) {
			$meta_array = explode( '=', $meta );

			if ( empty( $meta_array[0] ) || empty( $meta_array[1] ) ) {
				continue;
			}

			add_post_meta( $post_id, $meta_array[0], $meta_array[1] );
		}
	}

	/**
	 * Get list of current registered post types.
	 *
	 * @return array
	 */
	private function get_post_types_list() {
		$post_types_array = get_post_types( [], 'objects' );
		$post_types_list  = [];

		foreach ( $post_types_array as $post_type ) {
			$post_types_list[ $post_type->name ] = $post_type->labels->singular_name;
		}

		return $post_types_list;
	}

	/**
	 * Get list of all system users.
	 *
	 * @return array user ID => Display name - email
	 */
	private function get_users_list() {
		$users = get_users();

		if ( empty( $users ) ) {
			return [];
		}

		$output = [];
		foreach ( $users as $user ) {
			$output[ $user->ID ] = $user->display_name . ' - ' . $user->email;
		}
		return $output;
	}

}
