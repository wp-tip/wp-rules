<?php

namespace Rules\Admin\Rules;

use Rules\Common\Traits\Rules_Component;
use Rules\Core\Rules_Post_Type;

defined( 'ABSPATH' ) || exit;

class Rules_Manager {

	use Rules_Component;

	public function __construct()
	{
		$args = [
			'id' => 'rules_manager',
			'name' => 'Rules Manager'
		];
		$this->init( $args );
	}

	public function setup() {
		add_action('rules_' . $this->get_id() . '_register_post_types', [$this, 'create_rule_post_type']);
	}

	public function create_rule_post_type() {
		$labels = array(
			'name'                  => __( 'WP Rules',                 'wp-rules' ),
			'singular_name'         => __( 'Rule',                     'wp-rules' ),
			'menu_name'             => __( 'WP Rules',                 'wp-rules' ),
			'name_admin_bar'        => __( 'Rule',                     'wp-rules' ),
			'add_new'               => __( 'Add New',                  'wp-rules' ),
			'add_new_item'          => __( 'Add New Rule',             'wp-rules' ),
			'new_item'              => __( 'New Rule',                 'wp-rules' ),
			'edit_item'             => __( 'Edit Rule',                'wp-rules' ),
			'all_items'             => __( 'All Rule',                 'wp-rules' ),
			'search_items'          => __( 'Search Rules',             'wp-rules' ),
			'not_found'             => __( 'No Rules found.',          'wp-rules' ),
			'not_found_in_trash'    => __( 'No Rules found in Trash.', 'wp-rules' ),
			'filter_items_list'     => __( 'Filter Rules list',        'wp-rules' ),
			'items_list_navigation' => __( 'Rules list navigation',    'wp-rules' ),
			'items_list'            => __( 'Rules list',               'wp-rules' ),
		);

		$args = [
			'name'               => 'rules',
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'wp-rule' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => PHP_INT_MAX,
			'menu_icon'          => 'dashicons-networking',
			'supports'           => array( 'title' ),
			'meta_boxes'         => [
				'first_meta_box' => [
					'name' => 'First Meta Box',
					'fields' => [
						[
							'label' => 'Test Label',
							'name' => 'test_textbox',
							'type' => 'textbox',
							'attributes' => [
								'class' => 'test-textbox-classname'
							],
							'validation_rules' => 'required'
						],
						[
							'label' => 'Test Label 2',
							'name' => 'test_select',
							'type' => 'select',
							'options' => [
								'option_1' => 'test option 1',
								'option_2' => 'test option 2',
								'option_3' => 'test option 3'
							],
							'attributes' => [
								'class' => 'test-select-classname'
							],
							'validation_rules' => 'required'
						],
					]
				]
			]
		];

		$post_type = new Rules_Post_Type();
		try{
			$post_type->init($args);
		}catch (\Exception $e){
			if(WP_DEBUG){
				die($e->getMessage());
			}
		}


	}

}
