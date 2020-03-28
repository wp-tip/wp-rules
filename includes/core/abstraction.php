<?php

function rules_register_post_types() {
	do_action( 'rules_register_post_types' );
}

function rules_register_taxonomies() {
	do_action( 'rules_register_taxonomies' );
}

function rules_admin_enqueue() {
	do_action('rules_admin_enqueue');
}

function rules_admin_menu() {
	do_action('rules_admin_menu');
}

function rules_add_meta_boxes() {
	do_action('rules_add_meta_boxes');
}
