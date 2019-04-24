<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Likes_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_AutoLoader
 *
 * Autoload a given PHP library recursively.
 *
 * @package Nice_Likes_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_AutoLoader {
	/**
	 * Absolute path to the library being loaded.
	 *
	 * It can be either a directory or a single file.
	 *
	 * @since 1.1
	 *
	 * @var   string
	 */
	private $path = '';

	/**
	 * Base folder of main namespace.
	 *
	 * Used for autoloader functionality.
	 *
	 * @since 1.1
	 *
	 * @var   string
	 */
	private $root_directory = '';

	/**
	 * List of files and directories excluded from loading.
	 *
	 * @since 1.1
	 *
	 * @var   array
	 */
	private $exclude = array();

	/**
	 * List of files loaded by the current instance.
	 *
	 * @since 1.1
	 *
	 * @var   array
	 */
	private $library = array();

	/**
	 * Load library and store it as a list of files.
	 *
	 * @since  1.0
	 *
	 * @param string $path
	 * @param string $root_directory
	 * @param array $exclude
	 */
	public function __construct( $path, $root_directory = '', array $exclude = null ) {
		try {
			/**
			 * Obtain object values and load PHP library from the given path.
			 *
			 * @since 1.1
			 */
			$this->path = $path;
			$this->root_directory = $root_directory;
			$this->exclude = $exclude;
			$this->library = $this->get_library();

			$this->load_library();

		} catch ( Exception $e ) {
			/**
			 * Catch errors and display them.
			 *
			 * @since 1.1
			 */
			wp_die( esc_html( $e->getMessage() ) );
		}
	}

	/**
	 * Load the current library.
	 *
	 * @since 1.0
	 */
	protected function load_library() {
		self::load_files( $this->library );
	}

	/**
	 * Load a list of files.
	 *
	 * @param array $files
	 */
	protected static function load_files( array $files ) {
		if ( empty( $files ) ) {
			return;
		}

		foreach ( $files as $file ) {
			/**
			 * Buffer output to avoid content to be printed.
			 */
			ob_start();

			/**
			 * Load file.
			 */
			include_once $file;

			/**
			 * Clean buffer.
			 */
			ob_end_clean();
		}
	}

	/**
	 * Load a PHP library given a file or a folder.
	 *
	 * @since  1.1
	 *
	 * @uses   Nice_Likes_AutoLoader::autoload_register()
	 *
	 * @return array List of loaded files.
	 */
	protected function get_library() {
		$library = array();
		$path    = $this->path;

		/**
		 * If the given path is a directory, implement `autoload_register()`
		 * to deal correctly with class dependencies, and then load all PHP
		 * files recursively.
		 *
		 * @since 1.0
		 */
		if ( is_dir( $path ) ) {
			/**
			 * Implement custom autoload to avoid implementing classes with
			 * undeclared dependencies.
			 *
			 * @since 1.0
			 */
			$this->autoload_register();

			/**
			 * Iterate path and load only PHP files recursively.
			 *
			 * @since 1.0
			 */
			$directory_iterator = new RecursiveDirectoryIterator( $path, RecursiveDirectoryIterator::SKIP_DOTS );
			$recursive_iterator = new RecursiveIteratorIterator( $directory_iterator );

			foreach ( $recursive_iterator as $filename => $file ) {
				if ( ( ! empty( $this->exclude ) && in_array( dirname( $filename ), $this->exclude, true ) )
					 || ( stripos( dirname( $filename ), 'templates' ) )
				) {
					$exclude = dirname( $filename );
				}

				if ( ! empty( $exclude ) && false !== stripos( $filename, $exclude ) ) {
					continue;
				}

				if ( stristr( $filename, '.php' ) !== false ) {
					$library[] = $filename;
				}
			}

		} elseif ( ( is_file( $path ) ) && ( is_readable( $path ) ) ) {
			if ( ! empty( $this->exclude ) && in_array( dirname( $path ), $this->exclude, true ) ) {
				return null;
			}

			/**
			 * Load a single PHP file.
			 *
			 * @since 1.1
			 */
			if ( stristr( $path, '.php' ) !== false ) {
				$library[] = $path;
			}
		}

		return $library;
	}

	/**
	 * Register autoload functionality.
	 *
	 * @since 1.0
	 *
	 * @uses  spl_autoload_register()
	 */
	protected function autoload_register() {
		/**
		 * Allow deactivating autoload register.
		 *
		 * Keep in mind that setting this filter to false could break things.
		 *
		 * @since 1.0
		 */
		if ( ! apply_filters( __CLASS__ . '\\use_autoload_register', true ) ) {
			return;
		}

		spl_autoload_register( apply_filters( __CLASS__ . '\\autoload_callback', array( $this, 'autoload' ) ) );
	}

	/**
	 * Load a PHP file given a fully-qualified class name.
	 *
	 * @since 1.0
	 *
	 * @uses  Loader::__construct()
	 *
	 * @param string $class_name Fully-qualified name of class to be loaded.
	 */
	protected function autoload( $class_name ) {
		$load = array();

		// Segment class by namespace separators.
		$segments = explode( '\\', $class_name );

		// Obtain number of class segments.
		$count = count( $segments );

		// Modify name of first segment using our base path.
		if ( $count > 1 ) {
			$segments[0] = $this->root_directory;
		}

		// Re-format name of segments with our custom naming strategy.
		foreach ( $segments as $key => $value ) {
			$segments[ $key ] = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $value ) );
		}

		// Add prefix and extension for our files.
		$segments[ ( $count - 1 ) ] = 'class-' . $segments[ $count - 1 ] . '.php';

		// Obtain provisional name of file.
		$file_name = implode( '/', $segments );

		// Remove prefix.
		$file_name = str_replace( 'nice_likes_', '', $file_name );

		// Replace underscores.
		$file_name = str_replace( '_', '-', $file_name );

		// Remove suffix to obtain full class name.
		$class_file_name = str_replace( '-interface.php', '.php', $file_name );

		// If the class file doesn't exist, try an interface instead.
		$interface_file_name = str_replace( 'class-', 'interface-', $class_file_name );

		/**
		 * Check for file name of interface (interfaces are implemented by
		 * classes, so they need to be loaded first).
		 */
		foreach ( $this->library as $file ) {
			if ( stripos( $file, $interface_file_name ) ) {
				$load[] = $file;
			}
		}

		/**
		 * Check for file name of class.
		 */
		foreach ( $this->library as $file ) {
			if ( stripos( $file, $class_file_name ) ) {
				$load[] = $file;
			}
		}

		self::load_files( $load );
	}
}
