<?php
/**
 * NiceThemes Plugin API
 *
 * @package Nice_Likes_Plugin_API
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_AdminService
 *
 * This class deals with typical operations over Nice_Likes_Admin instances.
 *
 * @since 1.0
 */
class Nice_Likes_AdminService extends Nice_Likes_Service {
	/**
	 * Create and return a new Nice_Likes_Admin instance.
	 *
	 * @since  1.0
	 *
	 * @param  array $data           Information to create the new instance.
	 *
	 * @return Nice_Likes_Admin
	 */
	public function create( array $data ) {
		return $this->setup( $data );
	}

	/**
	 * Fire all necessary internal processes before returning the new instance.
	 *
	 * @param  array                $data Information to create the new instance.
	 *
	 * @return Nice_Likes_Admin
	 */
	private function setup( array $data ) {
		/**
		 * Obtain an instance of Nice_Likes_Plugin_Admin.
		 */
		$admin = parent::create( $data );

		if ( ! $admin instanceof Nice_Likes_Admin ) {
			return null;
		}

		/**
		 * Deactivate plugin if needed.
		 */
		self::deactivate_plugin_maybe( $admin );

		/**
		 * Return instance.
		 */
		return $admin;
	}

	/**
	 * Obtain data for instance initialization.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_init_data() {
		$data = array(
			'templates_path'      => self::get_templates_path(),
			'installation_errors' => self::get_installation_errors(),
		);

		return $data;
	}

	/**
	 * Check technical requirements for this plugin.
	 *
	 * @since 1.0
	 */
	private static function get_installation_errors() {
		$errors = array(
			'wp_version'   => ! self::check_wp_version(),
			'php_version'  => ! self::check_php_version(),
			'gd_installed' => ! self::check_gd_installed(),
		);

		return $errors;
	}

	/**
	 * Schedule deactivation of plugin in case there are installation errors.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	private static function deactivate_plugin_maybe( Nice_Likes_Admin $admin ) {
		foreach ( $admin->{'installation_errors'} as $key => $value ) {
			if ( $value ) {
				// Schedule deactivation.
				add_action( 'admin_init', array( __CLASS__, 'deactivate_plugin' ) );

				// Break loop.
				break;
			}
		}
	}

	/**
	 * Deactivate this plugin.
	 *
	 * @since 1.0
	 */
	public static function deactivate_plugin() {
		/**
		 * Load required library.
		 */
		require_once nice_likes_get_admin_path() . 'includes/plugin.php';

		/**
		 * Deactivate current plugin.
		 */
		deactivate_plugins( nice_likes_plugin_basename() );
	}

	/**
	 * Deactivate the plugin if the current version of WordPress is lower than
	 * the required one.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	private static function check_wp_version() {
		if ( ! apply_filters( 'nice_likes_check_wp_version', true ) ) {
			return true;
		}

		global $wp_version;

		if ( version_compare( $wp_version, nice_likes_wp_required_version(), '<' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Deactivate the plugin if the current version of PHP is lower than the
	 * required one.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	private static function check_php_version() {
		if ( ! apply_filters( 'nice_likes_check_php_version', true ) ) {
			return true;
		}

		if ( version_compare( phpversion(), nice_likes_php_required_version(), '<' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Deactivate the plugin if GD Library for PHP is not installed in the server.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	private static function check_gd_installed() {
		if ( ! apply_filters( 'nice_likes_check_gd_installed', false ) ) {
			return true;
		}

		if ( ! extension_loaded( 'gd' ) && ! function_exists( 'gd_info' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Set templates path.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	public static function set_templates_path( Nice_Likes_Admin $admin ) {
		/**
		 * Update admin instance.
		 */
		nice_likes_update( $admin, array(
				'templates_path' => self::get_templates_path(),
			)
		);
	}

	/**
	 * Obtain path to the templates folder.
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function get_templates_path() {
		if ( $templates_path = apply_filters( 'nice_likes_admin_templates_path', '' ) ) {
			return trailingslashit( $templates_path );
		}

		if ( defined( 'NICE_LIKES_ADMIN_TEMPLATES_PATH' ) && NICE_LIKES_ADMIN_TEMPLATES_PATH ) {
			return trailingslashit( NICE_LIKES_ADMIN_TEMPLATES_PATH );
		}

		return trailingslashit( realpath( plugin_dir_path( __FILE__ ) . 'templates/' ) );
	}

	/**
	 * Set post types.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	public static function set_post_types( $admin = null ) {
		if ( ! $admin instanceof Nice_Likes_Admin ) {
			$admin = nice_likes_plugin_admin();
		}

		/**
		 * Update admin instance.
		 */
		nice_likes_update( $admin, array(
				'post_types' => self::get_post_types(),
			)
		);
	}

	/**
	 * Obtain post types for this domain.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_post_types() {
		$plugin           = nice_likes_plugin();
		$plugin_data      = $plugin->get_info();
		$post_types       = $plugin_data->post_types;
		$post_types_admin = array();

		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				if ( ! $post_type instanceof Nice_Likes_Post_Type ) {
					continue;
				}

				// Obtain information from post type.
				$post_type_data = $post_type->get_info();

				/**
				 * Create new instance.
				 */
				$post_types_admin[] = nice_likes_post_type_admin_create( array(
						'post_type'  => $post_type,
						'textdomain' => $post_type_data->textdomain,
					)
				);
			}
		}

		return $post_types_admin;
	}

	/**
	 * Set metaboxes.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	public static function set_metaboxes( $admin = null ) {
		if ( nice_likes_doing_ajax() ) {
			return;
		}

		if ( ! $admin instanceof Nice_Likes_Admin ) {
			$admin = nice_likes_plugin_admin();
		}

		/**
		 * Update admin instance.
		 */
		nice_likes_update( $admin, array(
				'metaboxes' => self::get_metaboxes(),
			)
		);
	}

	/**
	 * Obtain post types for this domain.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_metaboxes() {
		$metaboxes_data = apply_filters( 'nice_likes_metaboxes', array() );
		$metaboxes      = array();

		if ( ! empty( $metaboxes_data ) ) {
			foreach ( $metaboxes_data as $data ) {
				$metaboxes[] = nice_likes_metabox_create( $data );
			}
		}

		return $metaboxes;
	}

	/**
	 * Initialize admin pointers.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	public static function set_pointer_collection( Nice_Likes_Admin $admin ) {
		/**
		 * Update admin instance.
		 */
		nice_likes_update( $admin, array(
				'pointer_collection' => self::get_pointer_collection(),
			)
		);
	}

	/**
	 * Obtain list of pointers.
	 *
	 * @uses   nice_likes_create_pointer()
	 * @uses   nice_likes_register_pointer_collection()
	 *
	 * @since  1.0
	 *
	 * @return Nice_Likes_Pointer_Collection
	 */
	protected static function get_pointer_collection() {
		static $pointer_collection = null;

		if ( ! is_null( $pointer_collection ) ) {
			return $pointer_collection;
		}

		/**
		 * @hook nice_likes_admin_pointers_data
		 *
		 * Obtain data for new pointers. All filters declaring pointers data
		 * should hook in here.
		 *
		 * @since 1.0
		 */
		$pointers_data = apply_filters( 'nice_likes_admin_pointers_data', array() );

		/**
		 * @hook nice_likes_admin_pointers
		 *
		 * Process new pointers with given data.
		 *
		 * @since 1.0
		 *
		 * Hooked here:
		 * @see nice_likes_add_pointers()
		 */
		$pointers = apply_filters( 'nice_likes_admin_pointers', null, $pointers_data );

		/**
		 * @hook nice_likes_admin_pointer_collection
		 *
		 * Process new collection with pointers.
		 *
		 * @since 1.0
		 *
		 * Hooked here:
		 * @see nice_likes_process_pointer_collection()
		 */
		return $pointer_collection = apply_filters( 'nice_likes_admin_pointer_collection', null, $pointers );
	}

	/**
	 * Initialize Admin UI.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin $admin
	 */
	public static function set_admin_ui( Nice_Likes_Admin $admin ) {
		/**
		 * Update admin instance.
		 */
		nice_likes_update( $admin, array(
				'ui' => self::get_admin_ui(),
			)
		);
	}

	/**
	 * Register elements to construct our custom Admin UI.
	 *
	 * @since  1.0
	 *
	 * @return Nice_Likes_Admin_UI
	 */
	public static function get_admin_ui() {
		static $admin_ui = null;

		if ( ! is_null( $admin_ui ) ) {
			return $admin_ui;
		}

		$data = apply_filters( 'nice_likes_admin_ui_data', null );
		$admin_ui = nice_likes_create( 'Nice_Likes_Admin_UI', $data );

		return $admin_ui;
	}

	/**
	 * Update Admin UI sections using external data.
	 *
	 * @since 1.0
	 */
	public static function register_admin_ui_sections() {
		if ( ! ( $ui = nice_likes_plugin_admin_ui() ) ) {
			return;
		}

		nice_likes_admin_ui_register( $ui, array(
				'sections'        => apply_filters( 'nice_likes_admin_ui_sections', array(), $ui ),
				'tabs'            => apply_filters( 'nice_likes_admin_ui_tabs', array(), $ui ),
				'settings_groups' => apply_filters( 'nice_likes_admin_ui_settings_groups', array(), $ui ),
				'settings'        => apply_filters( 'nice_likes_admin_ui_settings', array(), $ui ),
			)
		);
	}

	/**
	 * Update other Admin UI elements using external data.
	 *
	 * @since 1.0
	 */
	public static function register_admin_ui_extra() {
		if ( ! ( $ui = nice_likes_plugin_admin_ui() ) ) {
			return;
		}

		nice_likes_admin_ui_register( $ui, array(
				'help_tabs'       => apply_filters( 'nice_likes_admin_ui_help_tabs', array(), $ui ),
				'help_sidebars'   => apply_filters( 'nice_likes_admin_ui_help_sidebars', array(), $ui ),
				'footer_links'    => apply_filters( 'nice_likes_admin_ui_footer_links', array(), $ui ),
				'sidebar_boxes'   => apply_filters( 'nice_likes_admin_ui_sidebar_boxes', array(), $ui ),
			)
		);
	}
}
