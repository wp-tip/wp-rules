<?php

namespace Rules\Core;

use Rules\Core\Interfaces\Rules_Template;

defined( 'ABSPATH' ) || exit;

class Rules_Post_Type {

	private $initialized        = false;
	private $name               = '';
	private $labels             = [];
	private $public             = true;
	private $publicly_queryable = true;
	private $show_ui            = true;
	private $show_in_menu       = true;
	private $query_var          = true;
	private $slug               = '';
	private $capability_type    = 'post';
	private $has_archive        = true;
	private $hierarchical       = true;
	private $menu_position      = 0;
	private $menu_icon          = '';
	private $supports           = ['title'];

	private $meta_boxes         = [];

	public function init( $args ) {
		if(!empty($args) && !$this->initialized){
			foreach ($args as $arg_key => $arg_value) {
				if(isset($this->$arg_key)) {
					$this->$arg_key = $arg_value;
				}
			}

			$this->validate_post_type();
			$this->normalize();
			$this->create();
			$this->setup_hooks();

			$this->initialized = true;
		}
	}

	private function validate_post_type() {
		$this->validate_post_type_name();
		$this->validate_post_type_exist();
	}

	private function validate_post_type_name() {
		if(empty($this->name)){
			throw new \Exception(__('Not valid empty post name!', 'wp-rules'));
		}
	}

	private function validate_post_type_exist() {
		$created_before = post_type_exists($this->name);
		if($created_before){
			throw new \Exception(__('This post type [' . $this->name . '] is already created before!', 'wp-rules'));
		}
	}

	private function normalize() {
		//Todo: check and fill required fields if not found!
	}

	private function setup_hooks(){
		add_action( 'rules_add_meta_boxes', [$this, 'create_meta_boxes'] );
		add_action( 'rules_save_post', [$this, 'save_fields']);
		add_filter( "rules_post_type_{$this->name}_fields", [$this, 'fill_field_values'], 1, 3);
	}

	public function create() {
		$args = array(
			'labels'             => $this->labels,
			'public'             => $this->public,
			'publicly_queryable' => $this->publicly_queryable,
			'show_ui'            => $this->show_ui,
			'show_in_menu'       => $this->show_in_menu,
			'query_var'          => $this->query_var,
			'rewrite'            => array( 'slug' => $this->slug ),
			'capability_type'    => $this->capability_type,
			'has_archive'        => $this->has_archive,
			'hierarchical'       => $this->hierarchical,
			'menu_position'      => $this->menu_position,
			'menu_icon'          => $this->menu_icon,
			'supports'           => $this->supports,
		);

		register_post_type( $this->name, $args );
	}

	public function create_meta_boxes() {
		$this->meta_boxes = apply_filters("rules_post_type_{$this->name}_meta_boxes", $this->meta_boxes);
		if(!empty($this->meta_boxes)){
			foreach ($this->meta_boxes as $meta_box_id => $meta_box) {
				add_meta_box( $meta_box_id, $meta_box['name'], [$this, 'create_meta_box_fields'], 'rules', 'advanced', 'default', ['fields' => $meta_box['fields']] );
			}
		}
	}

	public function create_meta_box_fields( $post, $meta_box ) {
		$fields = $this->filter_meta_box_fields($meta_box['id'], $post->ID);
		if(!empty($fields)){
			$field_list = initiate_field_list( $fields );
			admin_render_fields($field_list);
		}
	}

	private function filter_meta_box_fields ( $meta_box_id, $post_ID ) {
		$fields = apply_filters("rules_post_type_{$this->name}_meta_box_{$meta_box_id}_fields", $this->meta_boxes[$meta_box_id]['fields'], $post_ID);
		$fields = apply_filters("rules_post_type_{$this->name}_fields", $fields, $post_ID, $this->meta_boxes[$meta_box_id]);
		return $fields;
	}

	public function save_fields( $post_ID ){
		if(!empty( $this->meta_boxes ) ) {
			foreach ($this->meta_boxes as $meta_box_id => $meta_box) {
				$fields = $this->filter_meta_box_fields($meta_box_id, $post_ID);
				if (!empty($fields)) {
					$fields = initiate_field_list( $fields );
					foreach ($fields as $field) {
						$field_name  = $field->get_name();
						$field_value = $field->sanitize( $_POST );
						update_post_meta($post_ID, $field_name, $field_value);
					}
				}
			}
		}
	}

	public function fill_field_values( $fields, $post_id, $meta_box ) {
		foreach ($fields as $field_key => $field) {
			$field_name = $field['name'];
			$field_value = get_post_meta($post_id, $field_name, true);
			$fields[$field_key]['value'] = $field_value;
		}
		return $fields;
	}
}
