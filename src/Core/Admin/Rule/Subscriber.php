<?php
namespace WP_Rules\Core\Admin\Rule;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;

class Subscriber implements SubscriberInterface {

	/**
	 * Posttype instance.
	 *
	 * @var Posttype
	 */
	private $post_type;

	/**
	 * MetaBox instance.
	 *
	 * @var MetaBox
	 */
	private $meta_box;

	/**
	 * Subscriber constructor.
	 *
	 * @param Posttype $post_type Post type instance.
	 * @param MetaBox  $meta_box MetaBox instance.
	 */
	public function __construct( Posttype $post_type, MetaBox $meta_box ) {
		$this->post_type = $post_type;
		$this->meta_box  = $meta_box;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'init'                  => 'create_rules_post_type',
			'add_meta_boxes'        => 'create_metaboxes',
			'admin_enqueue_scripts' => 'enqueue_style',
			'wp_kses_allowed_html'  => 'allow_form_elements',
		];
	}

	/**
	 * Create rules post type.
	 */
	public function create_rules_post_type() {
		$this->post_type->create();
	}

	/**
	 * Create rules metaboxes.
	 */
	public function create_metaboxes() {
		$this->meta_box->create();
	}

	/**
	 * Enqueue main CSS file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents current page.
	 */
	public function enqueue_style( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
			return;
		}

		wp_enqueue_style( 'rules_admin_styles', wpbr_get_constant( 'WP_RULES_URL' ) . 'assets/css/wp-rules.css', false, '1.0.0' );
	}

	/**
	 * Allow form input html tags.
	 *
	 * @param array $allowed Array of allowed tags.
	 *
	 * @return array
	 */
	public function allow_form_elements( array $allowed = [] ): array {
		$allowed['input'] = [
			'class'   => [],
			'id'      => [],
			'name'    => [],
			'value'   => [],
			'type'    => [],
			'checked' => [],
		];

		$allowed['select'] = [
			'class'    => [],
			'id'       => [],
			'name'     => [],
			'value'    => [],
			'type'     => [],
			'multiple' => [],
		];

		$allowed['optgroup'] = [
			'label' => [],
		];

		$allowed['option'] = [
			'class'    => [],
			'id'       => [],
			'value'    => [],
			'selected' => [],
		];

		$allowed['textarea'] = [
			'class' => [],
			'id'    => [],
			'name'  => [],
		];

		return $allowed;
	}
}
