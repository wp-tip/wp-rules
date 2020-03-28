<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Output the URL to use for theme-side wp-rules AJAX requests
 *
 * @since 1.0.0 wp-rules
 */
function rules_ajax_url() {
	echo esc_url( rules_get_ajax_url() );
}
/**
 * Return the URL to use for theme-side wp-rules AJAX requests
 *
 * @since 1.0.0 wp-rules
 *
 * @global WP $wp
 * @return string
 */
function rules_get_ajax_url() {
	global $wp;

	$ssl      = rules_get_url_scheme();
	$url      = trailingslashit( $wp->request );
	$base_url = home_url( $url, $ssl );
	$ajaxurl  = add_query_arg( [ 'rules-ajax' => 'true' ], $base_url );

	// Filter & return
	return apply_filters( 'rules_get_ajax_url', $ajaxurl );
}

/**
 * Is this a wp-rules AJAX request?
 *
 * @since 1.0.0 wp-rules
 *
 * @return bool Looking for rules-ajax
 */
function rules_is_ajax() {
	return (bool) ( ( isset( $_GET['rules-ajax'] ) || isset( $_POST['rules-ajax'] ) ) && ! empty( $_REQUEST['action'] ) );
}

/**
 * Hooked to the 'rules_template_redirect' action, this is also the custom
 * theme-side AJAX handler.
 *
 * This is largely taken from admin-ajax.php, but adapted specifically for
 * theme-side rules-only AJAX requests.
 *
 * @since 1.0.0 wp-rules
 *
 * @param string $action Sanitized action from rules_post_request/rules_get_request
 *
 * @return If not a wp-rules AJAX request
 */
function rules_do_ajax( $action = '' ) {

	// Bail if not a wp-rules specific AJAX request
	if ( ! rules_is_ajax() ) {
		return;
	}

	// Set WordPress core AJAX constant for back-compat
	if ( ! defined( 'DOING_AJAX' ) ) {
		define( 'DOING_AJAX', true );
	}

	// Setup AJAX headers
	rules_ajax_headers();

	// Compat for targeted action hooks (without $action param)
	$action = empty( $action )
		? sanitize_key( $_REQUEST['action'] ) // isset checked by rules_is_ajax()
		: $action;

	// Setup action key
	$key = "rules_ajax_{$action}";

	// Bail if no action is registered
	if ( empty( $action ) || ! has_action( $key ) ) {
		wp_die( '0', 400 );
	}

	// Everything is 200 OK.
	rules_set_200();

	// Execute custom rules AJAX action
	do_action( $key );

	// All done
	wp_die( '0' );
}

/**
 * Send headers for AJAX specific requests
 *
 * This was abstracted from rules_do_ajax() for use in custom theme-side AJAX
 * implementations.
 *
 * @since 1.0.0 wp-rules
 */
function rules_ajax_headers() {

	// Set the header content type
	@header( 'Content-Type: ' . get_option( 'html_type' ) . '; charset=' . get_option( 'blog_charset' ) );
	@header( 'X-Robots-Tag: noindex' );

	// Disable content sniffing in browsers that support it
	send_nosniff_header();

	// Disable browser caching for all AJAX requests
	nocache_headers();
}

/**
 * Helper method to return JSON response for wp-rules AJAX calls
 *
 * @since 1.0.0 wp-rules
 *
 * @param bool   $success
 * @param string $content
 * @param array  $extras
 */
function rules_ajax_response( $success = false, $content = '', $status = -1, $extras = [] ) {

	// Set status to 200 if setting response as successful
	if ( ( true === $success ) && ( -1 === $status ) ) {
		$status = 200;
	}

	// Setup the response array
	$response = [
		'success' => $success,
		'status'  => $status,
		'content' => $content,
	];

	// Merge extra response parameters in
	if ( ! empty( $extras ) && is_array( $extras ) ) {
		$response = array_merge( $response, $extras );
	}

	// Send back the JSON
	@header( 'Content-type: application/json' );
	echo json_encode( $response );
	die();
}
