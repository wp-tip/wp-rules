<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Admin\Rule\PostMeta;

class RuleLog {

	/**
	 * PostMeta instance.
	 *
	 * @var PostMeta
	 */
	private $post_meta;

	/**
	 * Current request unique ID.
	 *
	 * @var string
	 */
	public $request_id;

	/**
	 * Constructor.
	 *
	 * @param PostMeta $post_meta PostMeta instance.
	 */
	public function __construct( PostMeta $post_meta ) {
		$this->post_meta  = $post_meta;
		$this->request_id = sprintf(
			'%08x',
			abs(
				crc32(
					sanitize_title(
						wp_unslash(
							( $_SERVER['REMOTE_ADDR'] ?? '' ) . ( $_SERVER['REQUEST_TIME_FLOAT'] ?? '' ) . ( $_SERVER['REMOTE_PORT'] ?? '' )
						)
					)
				)
			)
		);
	}

	/**
	 * Save trigger into the log
	 *
	 * @param bool   $validated Trigger status.
	 * @param string $trigger_id Trigger ID.
	 * @param array  $trigger_options Trigger options.
	 * @param int    $rule_post_id Rule Post ID.
	 *
	 * @return bool|int
	 */
	public function save_trigger( bool $validated, string $trigger_id, array $trigger_options, int $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log ) {
			$rule_log = [];
		}

		$rule_log[ $this->request_id ] = [
			'datetime'   => current_time( 'mysql' ),
			'trigger'    => [
				$trigger_id => [
					'status'  => $validated,
					'options' => $trigger_options ?? [],
				],
			],
			'conditions' => [],
			'actions'    => [],
		];

		if ( apply_filters( 'rules_log_max_entries', 5, $rule_post_id ) < count( $rule_log ) ) {
			array_shift( $rule_log );
		}

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	/**
	 * Save Condition into log.
	 *
	 * @param bool   $validated Condition status.
	 * @param string $condition_id Condition ID.
	 * @param array  $condition_options Condition options.
	 * @param int    $rule_post_id Rule Post ID.
	 *
	 * @return bool|int
	 */
	public function save_condition( bool $validated, string $condition_id, array $condition_options, int $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log || empty( $rule_log[ $this->request_id ] ) ) {
			return false;
		}

		$rule_log[ $this->request_id ]['conditions'][ $condition_id ] = [
			'status'  => $validated,
			'options' => $condition_options,
		];

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	/**
	 * Save action into log.
	 *
	 * @param string $action_id Action ID.
	 * @param array  $action_options Action Options.
	 * @param int    $rule_post_id Rule Post ID.
	 *
	 * @return bool|int
	 */
	public function save_action( string $action_id, array $action_options, int $rule_post_id ) {
		$rule_log = $this->post_meta->get_rule_log( $rule_post_id );

		if ( ! $rule_log || empty( $rule_log[ $this->request_id ] ) ) {
			return false;
		}

		$rule_log[ $this->request_id ]['actions'][ $action_id ] = [
			'options' => $action_options,
		];

		return $this->post_meta->set_rule_log( $rule_post_id, $rule_log );
	}

	/**
	 * Get rule log entries.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return array
	 */
	public function get_rule_logs( int $rule_post_id ): array {
		$logs = $this->post_meta->get_rule_log( $rule_post_id );
		return ! empty( $logs ) ? $logs : [];
	}

	/**
	 * Format one rule log entry to be key-value array.
	 *
	 * @param array $log Rule Logs.
	 *
	 * @return array
	 */
	public function format_rule_log_entry( array $log ): array {
		$table_rows                               = [];
		$table_rows[ __( 'Date/Time', 'rules' ) ] = $log['datetime'];
		$table_rows['-']                          = '-';

		$table_rows[ __( 'Conditions', 'rules' ) ] = '';
		foreach ( $log['conditions'] as $condition_id => $condition ) {
			$table_rows[ $condition_id ] = ( $condition['status'] ? __( 'Yes', 'rules' ) : __( 'No', 'rules' ) );

			if ( ! empty( $condition['options'] ) ) {
				foreach ( $condition['options'] as $option_key => $option_value ) {
					$table_rows[ $option_key ] = $option_value;
				}
			}
			$table_rows['--'] = '--';
		}

		$table_rows['--------------'] = '--------------';

		$table_rows[ __( 'Actions', 'rules' ) ] = '';
		foreach ( $log['actions'] as $action_id => $action ) {
			$table_rows[ $action_id ] = '';

			if ( ! empty( $action['options'] ) ) {
				foreach ( $action['options'] as $option_key => $option_value ) {
					$table_rows[ $option_key ] = $option_value;
				}
			}
			$table_rows['---'] = '---';
		}

		return $table_rows;
	}

	/**
	 * Remove all rule logs.
	 *
	 * @param int $rule_post_id Rule Post ID.
	 *
	 * @return bool|int
	 */
	public function remove_rule_logs( int $rule_post_id ) {
		return $this->post_meta->set_rule_log( $rule_post_id, [] );
	}

}
