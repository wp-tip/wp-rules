<?php
defined( 'ABSPATH' ) || die( 'Nothing Here!' );

/**
 * Class Rules_Autoloader.
 * Plugin autoloader, used to require needed classes files.
 */
class Rules_Autoloader {
	/**
	 * Path to search for the class on it.
	 *
	 * @var string
	 */
	private $search_path;

	/**
	 * Rules_Autoloader constructor.
	 *
	 * @param string $search_path Path to search for the class on it.
	 */
	public function __construct( $search_path ) {
		$this->search_path = $search_path;
		spl_autoload_register( [ $this, 'load' ] );
	}

	/**
	 * Load / require the files that has classes needed.
	 *
	 * @param string $class_name_with_namespace Name of class to be loaded.
	 */
	public function load( $class_name_with_namespace ) {
		$class_name_with_namespace = strtolower( $class_name_with_namespace );
		$class_name_parts          = explode( '\\', $class_name_with_namespace );
		array_shift( $class_name_parts );// Remove first item in class namespace.

		$class_name      = array_pop( $class_name_parts );// get last item in class namespace and remove it from array.
		$class_file_path = $this->search_path . trailingslashit( implode( DIRECTORY_SEPARATOR, (array) $class_name_parts ) );

		$last_folder = '';
		if ( ! empty( $class_name_parts ) ) {
			$last_folder = end( $class_name_parts );
		}

		if ( strpos( $class_name, 'rules_' ) === 0 ) {
			$class_name = strtolower( $class_name );

			if ( $last_folder === 'interfaces' ) {
				$class_file_path .= 'interface-';
			} else if ( $last_folder === 'abstracts' ) {
				$class_file_path .= 'abstract-';
			} else if ( $last_folder === 'traits' ) {
				$class_file_path .= 'trait-';
			} else {
				$class_file_path .= 'class-';
			}

			$class_file_path .= str_replace( '_', '-', $class_name ) . '.php';

			if ( file_exists( $class_file_path ) ) {
				require_once $class_file_path;
			}
		}
	}

}
