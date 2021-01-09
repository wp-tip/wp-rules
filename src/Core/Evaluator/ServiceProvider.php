<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Core\Evaluator
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'core_evaluator_rule',
		'core_evaluator_subscriber',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();
		$container->add( 'core_evaluator_rule', '\WP_Rules\Core\Evaluator\Rule' );
		$container->share( 'core_evaluator_subscriber', '\WP_Rules\Core\Evaluator\Subscriber' )
				->addArgument( $container->get( 'core_evaluator_rule' ) );
	}
}
