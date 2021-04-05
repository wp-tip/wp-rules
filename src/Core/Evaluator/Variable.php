<?php
namespace WP_Rules\Core\Evaluator;

class Variable {

	private $variables = [];

	public function __construct() {
		$this->insert_common_variables();

	}

	public function get_all() {
		return $this->variables;
	}

	private function insert_common_variables() {
		$common_variables = [
			'now_timestamp' => current_time( 'timestamp' ),
			'now_datetime'  => current_time( 'mysql' ),
		];

		$this->insert( $common_variables );

		$additional_common_variables = (array) apply_filters( 'rules_variables_common', [] );

		if ( empty( $additional_common_variables ) ) {
			return;
		}

		$this->insert( $additional_common_variables );
	}

	public function insert( array $variables ) {
		if ( empty( $variables ) ) {
			return;
		}

		foreach ( $variables as $variable_name => $variable_value ) {
			$this->variables[ $variable_name ] = $variable_value;
		}
	}

	public function evaluate_string() {
		//{{variable}}, {{variable.item}}
	}

}
