<?php
namespace Rules\Common\Traits;

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

if ( ! trait_exists( 'Rules_Component' ) ) {

	trait Rules_Component {


		/**
		 * @var string Component name.
		 * @internal
		 */
		private $name;

		/**
		 * @var string ID for Identifying the component.
		 */
		private $id;

		/**
		 * if this component has ajax request
		 *
		 * @var bool
		 */
		private $has_ajax = false;

		/**
		 * wp-rules Component loader
		 *
		 * @param array $args Required. Supports these args:
		 *  - name: Component name.
		 *  - id: Unique ID for Identifying the component.
		 *  - has_ajax: Boolean if this component has ajax requests.
		 * @since 1.0.0 wp-rules
		 */
		public function init( $args = [] ) {
			if ( empty( $args ) ) {
				return;
			}

			$this->setup_globals( $args );
			$this->includes();
			$this->setup_actions();
		}

		private function set_id( $id ) {
			$this->id = $id;
		}
		public function get_id() {
			return $this->id;
		}

		private function set_name( $name ) {
			$this->name = $name;
		}
		public function get_name() {
			return $this->name;
		}

		private function set_has_ajax( $has_ajax ) {
			$this->has_ajax = $has_ajax;
		}
		public function get_has_ajax() {
			return $this->has_ajax;
		}

		/**
		 * Component global variables
		 *
		 * @param array $args Required. Supports these args:
		 *  - name: Component name.
		 *  - id: Unique ID for Identifying the component.
		 * @since 1.0.0 wp-rules
		 *
		 * @access private
		 */
		private function setup_globals( $args = [] ) {
			$this->set_id($args['id']);
			if( isset($args['name']) ){
				$this->set_name( apply_filters( 'rules_' . $this->id . '_name', $args['name'] ) );
			}
			if( isset($args['has_ajax']) ){
				$this->has_ajax     = apply_filters( 'rules_' . $this->id . '_has_ajax', $args['has_ajax'] );
			}
		}

		/**
		 * Include required files
		 *
		 * @since 1.0.0 wp-rules
		 *
		 * @access private
		 */
		private function includes() {
			do_action( 'rules_' . $this->name . 'includes' );
		}

		/**
		 * Setup the actions
		 *
		 * @since 1.0.0 wp-rules
		 *
		 * @access private
		 */
		private function setup_actions() {
			add_action( 'rules_register_post_types', [ $this, 'register_post_types' ] ); // Register post types
			add_action( 'rules_register_taxonomies', [ $this, 'register_taxonomies' ] ); // Register taxonomies

			//include ajax actions if has_ajax is true
			if( $this->has_ajax ) {
				add_action( 'wp_ajax_rules_'        . $this->id .'_ajax', [$this, 'ajax'] );
				add_action( 'wp_ajax_nopriv_rules_' . $this->id .'_ajax', [$this, 'ajax'] );
			}

			// Additional actions can be attached here
			do_action( 'rules_' . $this->id . 'setup_actions' );
		}

		/**
		 * Setup the component post types
		 *
		 * @since 1.0.0 wp-rules
		 */
		public function register_post_types() {
			 do_action( 'rules_' . $this->id . '_register_post_types' );
		}

		/**
		 * Register component specific taxonomies
		 *
		 * @since 1.0.0 wp-rules
		 */
		public function register_taxonomies() {
			 do_action( 'rules_' . $this->id . '_register_taxonomies' );
		}

		/**
		 * Initiate ajax action to be hooked.
		 */
		public function ajax() {
			do_action( 'rules_' . $this->id . '_ajax' );
		}

	}
} // Rules_Component
