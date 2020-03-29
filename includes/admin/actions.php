<?php

add_action('admin_enqueue_scripts', 'rules_admin_enqueue');
add_action('admin_menu', 'rules_admin_menu');
add_action( 'add_meta_boxes', 'rules_add_meta_boxes' );
add_action('save_post', 'rules_save_post', 10, 3);
