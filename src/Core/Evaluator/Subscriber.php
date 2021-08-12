<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Post;
use WP_Rules\Core\Template\RenderField;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Evaluator
 */
class Subscriber implements SubscriberInterface {

	/**
	 * Rule Instance.
	 *
	 * @var Rule
	 */
	private $rule;

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	private $render_field;

	/**
	 * RuleLog class instance.
	 *
	 * @var RuleLog
	 */
	private $rule_log;

	/**
	 * Subscriber constructor.
	 *
	 * @param Rule    $rule Rule instance.
	 * @param RuleLog $rule_log RuleLog instance.
	 */
	public function __construct( Rule $rule, RuleLog $rule_log ) {
		$this->rule         = $rule;
		$this->render_field = wpbr_render_fields();
		$this->rule_log     = $rule_log;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_trigger_fired'       => [ 'evaluate_trigger', 10, 2 ],
			'save_post_rules'           => 'removed_cached_trigger_rules',
			'rules_trigger_validated'   => [ 'log_rule_trigger', 10, 4 ],
			'rules_condition_validated' => [ 'log_rule_conditions', 10, 5 ],
			'rules_action_fired'        => [ 'log_rule_actions', 10, 4 ],
			'rules_after_trigger_save'  => 'reset_rule_logs',
			'rules_metabox_logs'        => 'show_rule_logs',
		];
	}

	/**
	 * Evaluate trigger code.
	 *
	 * @param string $trigger_id Trigger ID to be evaluated.
	 * @param array  $trigger_options Trigger hook arguments.
	 */
	public function evaluate_trigger( $trigger_id, $trigger_options ) {
		// Get this trigger rules.
		$rules_results = wp_cache_get( 'cached_trigger_rules_' . $trigger_id, 'rules' );

		if ( false === $rules_results ) {
			global $wpdb;

			$rules_results = $wpdb->get_results(// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
				$wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s", 'rule_trigger', $trigger_id )
			);

			wp_cache_set( 'cached_trigger_rules_' . $trigger_id, $rules_results, 'rules' );
		}

		if ( empty( $rules_results ) ) {
			return;
		}

		foreach ( $rules_results as $rule ) {
			if ( 'publish' !== get_post_status( $rule->post_id ) ) {
				continue;
			}

			if ( ! apply_filters( 'rules_trigger_validated', true, $trigger_id, $trigger_options, $rule->post_id ) ) {
				continue;
			}

			$this->rule->evaluate( $rule->post_id, $trigger_options );
		}
	}

	/**
	 * Remove trigger rules from cache with saving rule.
	 *
	 * @param int $post_id Post ID being saved.
	 */
	public function removed_cached_trigger_rules( $post_id ) {
		wp_cache_delete( 'cached_trigger_rules', 'rules' );
	}

	/**
	 * Log rule trigger.
	 *
	 * @param bool   $validated Trigger status.
	 * @param string $trigger_id Trigger ID.
	 * @param array  $trigger_options Trigger options.
	 * @param int    $rule_post_id Rule Post ID.
	 *
	 * @return mixed
	 */
	public function log_rule_trigger( $validated, $trigger_id, $trigger_options, $rule_post_id ) {
		$this->rule_log->save_trigger( $validated, $trigger_id, $trigger_options, $rule_post_id );
		return $validated;
	}

	/**
	 * Save Condition into log.
	 *
	 * @param bool   $validated Condition status.
	 * @param string $condition_id Condition ID.
	 * @param array  $condition_options Condition options.
	 * @param array  $trigger_hook_args Trigger hook arguments.
	 * @param int    $rule_post_id Rule Post ID.
	 *
	 * @return bool
	 */
	public function log_rule_conditions( $validated, $condition_id, $condition_options, $trigger_hook_args, $rule_post_id ) {
		$this->rule_log->save_condition( $validated, $condition_id, $condition_options, $rule_post_id );
		return $validated;
	}

	/**
	 * Save action into log.
	 *
	 * @param string $action_id Action ID.
	 * @param array  $action_options Action Options.
	 * @param array  $trigger_hook_args Trigger hook arguments.
	 * @param int    $rule_post_id Rule Post ID.
	 */
	public function log_rule_actions( $action_id, $action_options, $trigger_hook_args, $rule_post_id ) {
		$this->rule_log->save_action( $action_id, $action_options, $rule_post_id );
	}

	/**
	 * Remove all rule logs.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 */
	public function reset_rule_logs( $rule_post_id ) {
		$this->rule_log->remove_rule_logs( $rule_post_id );
	}

	/**
	 * Show rule formatted logs.
	 *
	 * @param WP_Post $post Rule post object.
	 */
	public function show_rule_logs( WP_Post $post ) {
		$logs = $this->rule_log->get_rule_logs( $post->ID );
		if ( empty( $logs ) ) {
			return;
		}

		foreach ( $logs as $log ) {
			$this->render_field->tableKeyValue( $this->rule_log->format_rule_log_entry( $log ), [ 'class' => 'rule_log_table' ] );
		}
	}

}
