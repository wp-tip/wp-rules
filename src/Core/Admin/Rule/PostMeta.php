<?php
namespace WP_Rules\Core\Admin\Rule;

/**
 * Class PostMeta
 *
 * @package WP_Rules\Core\Admin\Rule
 */
class PostMeta {

	public function set_rule_variables( int $rule_post_id, array $variables = [] ) {
		return update_post_meta( $rule_post_id, 'rules_variables', $variables );
	}

	public function get_rule_variables( int $rule_post_id ) {
		return get_post_meta( $rule_post_id, 'rules_variables' );
	}

}
