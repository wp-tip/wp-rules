<?php
namespace WP_Rules\Core\Admin\Rule;

/**
 * Class Posttype
 *
 * @package WP_Rules\Core\Admin\Rule
 */
class Posttype {

	/**
	 * Create Post type.
	 *
	 * @return \WP_Error|\WP_Post_Type WP_Error when error otherwise return post type object itself.
	 */
	public function create() {
		$labels = [
			'name'                  => __( 'WP Rules',                 'rules' ),
			'singular_name'         => __( 'Rule',                     'rules' ),
			'menu_name'             => __( 'WP Rules',                 'rules' ),
			'name_admin_bar'        => __( 'Rule',                     'rules' ),
			'add_new'               => __( 'Add New',                  'rules' ),
			'add_new_item'          => __( 'Add New Rule',             'rules' ),
			'new_item'              => __( 'New Rule',                 'rules' ),
			'edit_item'             => __( 'Edit Rule',                'rules' ),
			'all_items'             => __( 'All Rules',                 'rules' ),
			'search_items'          => __( 'Search Rules',             'rules' ),
			'not_found'             => __( 'No Rules found.',          'rules' ),
			'not_found_in_trash'    => __( 'No Rules found in Trash.', 'rules' ),
			'filter_items_list'     => __( 'Filter Rules list',        'rules' ),
			'items_list_navigation' => __( 'Rules list navigation',    'rules' ),
			'items_list'            => __( 'Rules list',               'rules' ),
		];

		$args = [
			'name'               => 'rules',
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'slug'               => 'wp-rule',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 100,
			'menu_icon'          => 'dashicons-networking',
			'supports'           => [ 'title' ],
		];

		return register_post_type( $args['name'], $args );
	}

}
