<?php

namespace WP_Rules\Core\Plugin\EventManagement;

/**
 * The WordPress event manager manages events using the WordPress plugin API.
 *
 * @author Carl Alexander <contact@carlalexander.ca>
 */
class EventManager {

	/**
	 * Adds a callback to a specific hook of the WordPress plugin API.
	 *
	 * @uses add_filter()
	 *
	 * @param string   $hook_name Hook name.
	 * @param callable $callback Callback method.
	 * @param int      $priority Hook Priority.
	 * @param int      $accepted_args Hook accepted arguments.
	 */
	public function add_callback( $hook_name, $callback, $priority = 10, $accepted_args = 1 ) {
		add_filter( $hook_name, $callback, $priority, $accepted_args );
	}

	/**
	 * Add an event subscriber.
	 *
	 * The event manager registers all the hooks that the given subscriber
	 * wants to register with the WordPress Plugin API.
	 *
	 * @param SubscriberInterface $subscriber Subscriber class to be registered.
	 */
	public function add_subscriber( SubscriberInterface $subscriber ) {
		foreach ( $subscriber->get_subscribed_events() as $hook_name => $parameters ) {
			$this->add_subscriber_callback( $subscriber, $hook_name, $parameters );
		}
	}

	/**
	 * Get the name of the hook that WordPress plugin API is executing. Returns
	 * false if it isn't executing a hook.
	 *
	 * @uses current_filter()
	 *
	 * @return string|bool
	 */
	public function get_current_hook() {
		return current_filter();
	}

	/**
	 * Checks the WordPress plugin API to see if the given hook has
	 * the given callback. The priority of the callback will be returned
	 * or false. If no callback is given will return true or false if
	 * there's any callbacks registered to the hook.
	 *
	 * @uses has_filter()
	 *
	 * @param string $hook_name Hook name.
	 * @param mixed  $callback Callback method.
	 *
	 * @return bool|int
	 */
	public function has_callback( $hook_name, $callback = false ) {
		return has_filter( $hook_name, $callback );
	}

	/**
	 * Removes the given callback from the given hook. The WordPress plugin API only
	 * removes the hook if the callback and priority match a registered hook.
	 *
	 * @uses remove_filter()
	 *
	 * @param string   $hook_name Hook name.
	 * @param callable $callback Callback method.
	 * @param int      $priority Hook priority.
	 *
	 * @return bool
	 */
	public function remove_callback( $hook_name, $callback, $priority = 10 ) {
		return remove_filter( $hook_name, $callback, $priority );
	}

	/**
	 * Remove an event subscriber.
	 *
	 * The event manager removes all the hooks that the given subscriber
	 * wants to register with the WordPress Plugin API.
	 *
	 * @param SubscriberInterface $subscriber Subscriber class to be de-registered.
	 */
	public function remove_subscriber( SubscriberInterface $subscriber ) {
		foreach ( $subscriber->get_subscribed_events() as $hook_name => $parameters ) {
			$this->remove_subscriber_callback( $subscriber, $hook_name, $parameters );
		}
	}

	/**
	 * Adds the given subscriber's callback to a specific hook
	 * of the WordPress plugin API.
	 *
	 * @param SubscriberInterface $subscriber Subscriber class.
	 * @param string              $hook_name Hook name.
	 * @param mixed               $parameters Parameters passed to this hook.
	 */
	private function add_subscriber_callback( SubscriberInterface $subscriber, $hook_name, $parameters ) {
		if ( is_string( $parameters ) ) {
			$this->add_callback( $hook_name, [ $subscriber, $parameters ] );
		} elseif ( is_array( $parameters ) && count( $parameters ) !== count( $parameters, COUNT_RECURSIVE ) ) {
			foreach ( $parameters as $parameter ) {
				$this->add_subscriber_callback( $subscriber, $hook_name, $parameter );
			}
		} elseif ( is_array( $parameters ) && isset( $parameters[0] ) ) {
			$this->add_callback( $hook_name, [ $subscriber, $parameters[0] ], isset( $parameters[1] ) ? $parameters[1] : 10, isset( $parameters[2] ) ? $parameters[2] : 1 );
		}
	}

	/**
	 * Removes the given subscriber's callback to a specific hook
	 * of the WordPress plugin API.
	 *
	 * @param SubscriberInterface $subscriber Subscriber class.
	 * @param string              $hook_name Hook name.
	 * @param mixed               $parameters Parameters passed to this hook.
	 */
	private function remove_subscriber_callback( SubscriberInterface $subscriber, $hook_name, $parameters ) {
		if ( is_string( $parameters ) ) {
			$this->remove_callback( $hook_name, [ $subscriber, $parameters ] );
		} elseif ( is_array( $parameters ) && isset( $parameters[0] ) && is_array( $parameters[0] ) ) {
			foreach ( $parameters[0] as $parameter ) {
				$this->remove_subscriber_callback( $subscriber, $hook_name, $parameter );
			}
		} elseif ( is_array( $parameters ) && isset( $parameters[0] ) ) {
			$this->remove_callback( $hook_name, [ $subscriber, $parameters[0] ], isset( $parameters[1] ) ? $parameters[1] : 10 );
		}
	}
}
