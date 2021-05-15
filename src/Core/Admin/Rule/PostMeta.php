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
	 * @return mixed
	 */
	public function get_rule_variables( int $rule_post_id ) {
		return get_post_meta( $rule_post_id, 'rules_variables', true );
	}

}
