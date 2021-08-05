<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Admin\Rule\PostMeta;

class RuleLog {

	private $post_meta;

	public $request_id;

	public function __construct( PostMeta $post_meta ) {
		$this->post_meta = $post_meta;
		$this->request_id = sprintf("%08x", abs(crc32($_SERVER['REMOTE_ADDR'] . $_SERVER['REQUEST_TIME_FLOAT'] . $_SERVER['REMOTE_PORT'])));
	}

	public function save_trigger( $validated, $trigger_id, $trigger_options, $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log ) {
			$rule_log = [];
		}

		$rule_log[ $this->request_id ] = [
			'trigger' => [
				$trigger_id => [
					'status' => $validated,
					'options' => $trigger_options ?? [],
				]
			],
			'conditions' => [],
			'actions' => [],
		];

		if ( apply_filters( 'rules_log_max', 5, $rule_post_id ) < count( $rule_log ) ) {
			array_shift( $rule_log );
		}

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	public function save_condition( $validated, $condition_id, $condition_options, $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log || empty( $rule_log[ $this->request_id ] ) ) {
			return false;
		}

		$rule_log[ $this->request_id]['conditions'][$condition_id] = [
			'status' => $validated,
			'options' => $condition_options,
		];

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	public function save_action( $action_id, $action_options, $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log || empty( $rule_log[ $this->request_id ] ) ) {
			return false;
		}

		$rule_log[ $this->request_id]['actions'][$action_id] = [
			'options' => $action_options,
		];

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	public function get_rule_logs( $rule_post_id ) {
		return $this->post_meta->get_rule_log( $rule_post_id ) ?? [];
	}

	public function remove_rule_logs( $rule_post_id ) {
		return $this->post_meta->set_rule_log( $rule_post_id, [] );
	}

}
