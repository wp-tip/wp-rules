<?php
namespace WP_Rules\Core\Plugin;

use WP_Rules\Core\Plugin\EventManagement\EventManager;
use WP_Rules\Dependencies\League\Container\Container;

class Loader {

	private $container;

	private $event_manager;

	public function __construct( Container $container ) {
		$this->container = $container;
	}

	public function get_container() {
		return $this->container;
	}

	public function load() {
		$this->event_manager = new EventManager();
		$this->container->share( 'event_manager', $this->event_manager );

		$this->container->add( 'template_dir', WP_RULES_VIEWS_PATH );

		foreach ( $this->get_service_providers() as $service_provider ) {
			$this->container->addServiceProvider( $service_provider );
		}

		foreach ( $this->get_subscribers() as $subscriber ) {
			$this->event_manager->add_subscriber( $this->container->get( $subscriber ) );
		}
	}

	private function get_service_providers() {
		return [];
	}

	private function get_subscribers() {
		return [];
	}

}
