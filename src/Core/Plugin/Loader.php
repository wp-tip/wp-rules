<?php
namespace WP_Rules\Core\Plugin;

use WP_Rules\Core\Plugin\EventManagement\EventManager;
use WP_Rules\Dependencies\League\Container\Container;

class Loader {

	/**
	 * Container instance.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Loader constructor.
	 *
	 * @param Container $container Container instance.
	 */
	public function __construct( Container $container ) {
		$this->container = $container;
	}

	/**
	 * Get the container instance.
	 *
	 * @return Container
	 */
	public function get_container() {
		return $this->container;
	}

	/**
	 * Load subscribers and service provider.
	 */
	public function load() {
		$event_manager = new EventManager();
		$this->container->share( 'event_manager', $event_manager );

		$this->container->add( 'template_dir', WP_RULES_VIEWS_PATH );

		foreach ( $this->get_service_providers() as $service_provider ) {
			$this->container->addServiceProvider( $service_provider );
		}

		foreach ( $this->get_subscribers() as $subscriber ) {
			$event_manager->add_subscriber( $this->container->get( $subscriber ) );
		}
	}

	/**
	 * Get list of service providers' classes.
	 *
	 * @return array Service providers.
	 */
	private function get_service_providers() {
		return [];
	}

	/**
	 * Get list of event subscribers.
	 *
	 * @return array Subscribers.
	 */
	private function get_subscribers() {
		return [];
	}

}
