<?php
namespace WP_Rules\Core\Admin\Templates;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Admin\Templates
 */
class Subscriber implements SubscriberInterface {

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	private $render_field;

	/**
	 * Subscriber constructor.
	 */
	public function __construct() {
		$this->render_field = wpbr_render_fields();
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'in_admin_header'       => 'show_templates_list',
			'admin_enqueue_scripts' => 'enqueue_template_script',
		];
	}

	public function show_templates_list() {
		global $current_screen;

		if ( 'rules' !== $current_screen->id || 'add' !== $current_screen->action ) {
			return;
		}

		$data = [
			'templates' => apply_filters( 'rules_templates_list', [] ),
			'template_nonce' => wp_create_nonce( 'rule_template_nonce' ),
		];

		$this->render_field->render_admin( 'templates-list', $data, true );

	}

	/**
	 * Enqueue action JS script file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents current page.
	 */
	public function enqueue_template_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'rules_template', WP_RULES_URL . 'assets/js/template.js', [ 'jquery' ], wpbr_get_constant( 'WP_RULES_VERSION' ), true );
	}

}
