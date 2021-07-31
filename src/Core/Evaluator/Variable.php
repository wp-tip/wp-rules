<?php
namespace WP_Rules\Core\Evaluator;

/**
 * Class Variable
 *
 * @package WP_Rules\Core\Evaluator
 */
class Variable {

	/**
	 * List of all variables.
	 *
	 * @var array
	 */
	private $variables = [];

	/**
	 * Variable constructor.
	 */
	public function __construct() {
		$this->insert_common_variables();
	}

	/**
	 * Get all available variables array.
	 *
	 * @return array
	 */
	public function get_all() {
		return $this->variables;
	}

	/**
	 * Insert common variables between all rules.
	 */
	private function insert_common_variables() {
		$common_variables = [
			'now_datetime' => current_time( 'mysql' ),
		];

		$this->insert( $common_variables );

		$additional_variables = (array) apply_filters( 'rules_variables', [] );

		if ( empty( $additional_variables ) ) {
			return;
		}

		$this->insert( $additional_variables );
	}

	/**
	 * Insert Array of variables.
	 *
	 * @param array $variables Variables list.
	 */
	public function insert( array $variables ) {
		foreach ( $variables as $variable_name => $variable_value ) {
			$this->parse_insert( $variable_name, $variable_value );
		}
	}

	/**
	 * Parse the variable value to detect its type and parse levels.
	 *
	 * @param string $variable_name  Variable name.
	 * @param mixed  $variable_value Variable value.
	 */
	private function parse_insert( string $variable_name, $variable_value ) {
		$filtered_variable_value = apply_filters( 'rules_variable_value', null, $variable_name, $variable_value );
		if ( ! is_null( $filtered_variable_value ) ) {
			$this->parse_insert( $variable_name, $filtered_variable_value );
			return;
		}

		if ( is_string( $variable_value ) || is_int( $variable_value ) ) {
			$this->variables[ $variable_name ] = $variable_value;
			return;
		}

		if ( is_array( $variable_value ) ) {
			foreach ( $variable_value as $item_key => $item ) {
				$this->parse_insert( $variable_name . '.' . $item_key, $item );
			}
			return;
		}

		if ( is_object( $variable_value ) ) {
			$this->parse_insert( $variable_name, get_object_vars( $variable_value ) );
		}
	}

	/**
	 * Bulk evaluate strings.
	 *
	 * @param array $items Items to be evaluated.
	 *
	 * @return array|string[] Array of input items with replaced variables.
	 */
	public function evaluate_all( array $items = [] ) {
		if ( empty( $items ) ) {
			return [];
		}
		return array_map(
			function ( $item ) {
					return $this->evaluate_string( $item );
			},
			$items
		);
	}

	/**
	 * Evaluate string to replace found variables with their values.
	 *
	 * @param string $content Content to be parsed.
	 *
	 * @return string New string with replaced variables.
	 */
	public function evaluate_string( string $content ) {
		// {{variable}}, {{variable.item}}, {{variable.item.item2.item3....}}
		// Get the variable name.
		return preg_replace_callback( '#{{(?<variable>.*)}}#imU', [ $this, 'parse_variable' ], $content );
	}

	/**
	 * Parse found variables here.
	 *
	 * @param array $match Matched variable element array.
	 *
	 * @return string Variable value if found or the same variable name if not found.
	 */
	public function parse_variable( array $match ) {
		if ( empty( $match['variable'] ) ) {
			return $match[0];
		}

		if ( ! isset( $this->variables[ $match['variable'] ] ) ) {
			return $match[0];
		}

		return $this->variables[ $match['variable'] ];
	}

}
