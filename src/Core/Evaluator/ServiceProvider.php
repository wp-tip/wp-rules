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
		'core_evaluator_variable',
		'core_evaluator_rule',
		'core_evaluator_subscriber',
		'core_evaluator_rule_log',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->add( 'core_evaluator_variable', '\WP_Rules\Core\Evaluator\Variable' );
		$container->add( 'core_evaluator_rule', '\WP_Rules\Core\Evaluator\Rule' )
				->addArgument( $container->get( 'core_evaluator_variable' ) )
				->addArgument( $container->get( 'core_admin_rule_postmeta' ) );

		$container->share( 'core_evaluator_rule_log', '\WP_Rules\Core\Evaluator\RuleLog' )
				->addArgument( $container->get( 'core_admin_rule_postmeta' ) );
		$container->share( 'core_evaluator_subscriber', '\WP_Rules\Core\Evaluator\Subscriber' )
				->addArgument( $container->get( 'core_evaluator_rule' ) )
				->addArgument( $container->get( 'core_evaluator_rule_log' ) );
	}
}
