<?php

namespace Rules\Admin\Rules;

use Rules\Common\Traits\Rules_Component;
use Rules\Core\Rules_Post_Type;

defined( 'ABSPATH' ) || exit;

class Rules_Manager {

	use Rules_Component;

	private $triggers_manager;

	public function __construct($triggers_manager)
	{
		$args = [
			'id' => 'rules_manager',
			'name' => 'Rules Manager'
		];
		$this->init( $args );

		$this->triggers_manager = $triggers_manager;
	}

	public function setup() {
		add_action('rules_' . $this->get_id() . '_register_post_types', [$this, 'create_rule_post_type']);
		add_filter("rules_post_type_rules_meta_box_rules_triggers_fields", [$this, 'add_trigger_admin_fields'], 10, 2);
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
			'all_items'             => __( 'All Rules',                 'wp-rules' ),
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
			'slug'              => 'wp-rule',
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => PHP_INT_MAX,
			'menu_icon'          => 'dashicons-networking',
			'supports'           => array( 'title' ),
			'meta_boxes'         => $this->meta_boxes()
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

	private function meta_boxes() {
		$meta_boxes = [
			'rules_triggers' => [
				'name' => 'Rule Trigger',
				'fields' => [
					[
						'label' => 'Reacts on event',
						'name' => 'rules_rule_trigger',
						'type' => 'select',
						'options' => rules_get_triggers_named_ids()
					],
				]
			]
		];
		return $meta_boxes;
	}

	public function add_trigger_admin_fields($fields, $post_id) {
		$active_trigger = get_post_meta($post_id, 'rules_rule_trigger', true);
		if(!empty($active_trigger)){
			$trigger = $this->triggers_manager->get_trigger( $active_trigger );
			$trigger_fields = $trigger->admin_fields();
			$fields = array_merge($fields, $trigger_fields);
		}

		return $fields;
	}

}
