<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Admin\Rule\PostMeta;

/**
 * Class Rule
 *
 * @package WP_Rules\Core\Evaluator
 */
class Rule {

	/**
	 * Variable instance.
	 *
	 * @var Variable
	 */
	private $variable;

	private $post_meta;

	/**
	 * Rule constructor.
	 *
	 * @param Variable $variable Variable instance.
	 */
	public function __construct( Variable $variable, PostMeta $post_meta ) {
		$this->variable = $variable;
		$this->post_meta = $post_meta;
	}

	/**
	 * Evaluate rule.
	 *
	 * @param int   $rule_post_id Rule post ID.
	 * @param array $trigger_hook_args Trigger hook arguments.
	 */
	public function evaluate( int $rule_post_id, array $trigger_hook_args = [] ) {
		// This is the main entry point for evaluation so we will here evaluate conditions and fire actions.

		$this->variable->insert( $trigger_hook_args );
		$this->post_meta->set_rule_variables( $rule_post_id, $this->variable->get_all() );

		// Get Rule Conditions.
		$conditions           = get_post_meta( $rule_post_id, 'rule_conditions', true );
		$conditions_validated = true;
		if ( ! empty( $conditions ) ) {
			foreach ( $conditions as $condition ) {
				$condition_id      = array_keys( $condition )[0];
				$condition_options = $this->variable->evaluate_all( $condition[ $condition_id ] );

				$conditions_validated &= apply_filters( 'rules_condition_validated', false, $condition_id, $condition_options, $trigger_hook_args );
			}
		}

		if ( ! apply_filters( 'rules_conditions_validated', $conditions_validated, $rule_post_id, $trigger_hook_args ) ) {
			return;
		}

		// Get Rule Actions.
		$actions = get_post_meta( $rule_post_id, 'rule_actions', true );
		if ( ! empty( $actions ) ) {
			foreach ( $actions as $action ) {
				$action_id      = array_keys( $action )[0];
				$action_options = $this->variable->evaluate_all( $action[ $action_id ] );

				do_action( 'rules_action_fired', $action_id, $action_options, $trigger_hook_args );
			}
		}

	}

	public function get_variables( $rule_post_id ) {
		return $this->post_meta->get_rule_variables( $rule_post_id );
	}

}
