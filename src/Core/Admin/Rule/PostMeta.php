<?php
namespace WP_Rules\Core\Admin\Rule;

/**
 * Class PostMeta
 *
 * @package WP_Rules\Core\Admin\Rule
 */
class PostMeta {

	/**
	 * Save rule variables.
	 *
	 * @param int   $rule_post_id Current rule Post ID.
	 * @param array $variables Variables array to be saved.
	 *
	 * @return bool|int
	 */
	public function set_rule_variables( int $rule_post_id, array $variables = [] ) {
		return update_post_meta( $rule_post_id, 'rules_variables', $variables );
	}

	/**
	 * Get rule attached variables.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return array
	 */
	public function get_rule_variables( int $rule_post_id ): array {
		$variables = get_post_meta( $rule_post_id, 'rules_variables', true );
		if ( ! $variables ) {
			return [];
		}
		return $variables;
	}

	/**
	 * Save rule trigger.
	 *
	 * @param int    $rule_post_id Current rule Post ID.
	 * @param string $trigger_id Trigger ID.
	 *
	 * @return bool|int
	 */
	public function set_rule_trigger( int $rule_post_id, string $trigger_id ) {
		return update_post_meta( $rule_post_id, 'rule_trigger', $trigger_id );
	}

	/**
	 * Get rule attached trigger.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return mixed
	 */
	public function get_rule_trigger( int $rule_post_id ) {
		return get_post_meta( $rule_post_id, 'rule_trigger', true );
	}

	/**
	 * Save rule trigger options.
	 *
	 * @param int   $rule_post_id Current rule Post ID.
	 * @param array $trigger_options Trigger options.
	 *
	 * @return bool|int
	 */
	public function set_rule_trigger_options( int $rule_post_id, array $trigger_options ) {
		return update_post_meta( $rule_post_id, 'rule_trigger_options', $trigger_options );
	}

	/**
	 * Get rule attached trigger.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return mixed
	 */
	public function get_rule_trigger_options( int $rule_post_id ) {
		return get_post_meta( $rule_post_id, 'rule_trigger_options', true );
	}

	/**
	 * Get rule log entries.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return mixed
	 */
	public function get_rule_log( int $rule_post_id ) {
		return get_post_meta( $rule_post_id, 'rule_log', true );
	}

	/**
	 * Set rule log entries.
	 *
	 * @param int   $rule_post_id Rule Post ID.
	 * @param array $rule_log Log to be saved.
	 *
	 * @return bool|int
	 */
	public function set_rule_log( int $rule_post_id, array $rule_log ) {
		return update_post_meta( $rule_post_id, 'rule_log', $rule_log );
	}

}
