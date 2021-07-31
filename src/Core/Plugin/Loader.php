<?php
namespace WP_Rules\Core\Plugin;

use WP_Rules\Core\Plugin\EventManagement\EventManager;
use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Dependencies\League\Container\Container;
use WP_Rules\Dependencies\League\Container\ServiceProvider\ServiceProviderInterface;
use WP_Filesystem_Direct;
use StdClass;

class Loader {

	/**
	 * Container instance.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * EventManager instance.
	 *
	 * @var EventManager
	 */
	private $event_manager;

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
		$this->event_manager = new EventManager();
		$this->container->share( 'event_manager', $this->event_manager );

		foreach ( $this->get_service_providers() as $service_provider ) {
			$service_provider_instance = new $service_provider();
			$this->container->addServiceProvider( $service_provider_instance );

			// Load each service provider's subscribers if found.
			$this->load_subscribers( $service_provider_instance );
		}
	}

	/**
	 * Get list of service providers' classes.
	 *
	 * @return array Service providers.
	 */
	private function get_service_providers() {
		return [
			'WP_Rules\Core\Admin\ServiceProvider',
			'WP_Rules\Triggers\ServiceProvider',
			'WP_Rules\Conditions\ServiceProvider',
			'WP_Rules\Actions\ServiceProvider',
			'WP_Rules\Core\Evaluator\ServiceProvider',
			'WP_Rules\Core\General\ServiceProvider',
			'WP_Rules\ThirdParty\ServiceProvider',
		];
	}

	/**
	 * Load list of event subscribers from service provider.
	 *
	 * @param ServiceProviderInterface $service_provider_instance Instance of service provider.
	 *
	 * @return void
	 */
	private function load_subscribers( ServiceProviderInterface $service_provider_instance ) {
		if ( ! empty( $service_provider_instance->provides ) ) {
			foreach ( $service_provider_instance->provides as $subscriber ) {
				$subscriber_object = $this->container->get( $subscriber );

				if ( $subscriber_object instanceof SubscriberInterface ) {
					$this->event_manager->add_subscriber( $this->container->get( $subscriber ) );
				}
			}
		}
	}

}
