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
 * Class Nice_Likes_PluginService
 *
 * This class deals with typical operations over Nice_Likes_Plugin instances.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_PluginService extends Nice_Likes_Service {
	/**
	 * Obtain data for instance initialization.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_init_data() {
		/**
		 * Obtain plugin header data.
		 */
		$headers = nice_likes_plugin_headers();

		/**
		 * Prepare plugin data.
		 */
		$data['version']                = $headers['Version'];
		$data['wp_required_version']    = '3.6';
		$data['php_required_version']   = '5.2';
		$data['plugin_file']            = nice_likes_plugin_file( true );
		$data['plugin_domain']          = nice_likes_plugin_domain( true );
		$data['plugin_basename']        = plugin_basename( $data['plugin_file'] );
		$data['plugin_slug']            = $headers['TextDomain'];
		$data['name']                   = $headers['Name'];
		$data['theme_template']         = get_option( 'template' );
		$data['using_nicetheme']        = nice_likes_is_nicetheme( $data['theme_template'] );
		$data['settings_name']          = 'nice_likes_settings';
		$data['settings']               = get_option( $data['settings_name'] );
		$data['doing_ajax']             = defined( 'DOING_AJAX' ) && DOING_AJAX;

		return $data;
	}

	/**
	 * Reload plugin settings if required. This is useful if the option entry
	 * has been modified at some point during the runtime of other plugin or
	 * theme.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Plugin|null $plugin
	 */
	public static function refresh_settings( $plugin = null ) {
		if ( ! $plugin instanceof Nice_Likes_Plugin ) {
			$plugin = nice_likes_plugin();
		}

		/**
		 * Update plugin instance.
		 */
		nice_likes_update( $plugin, array(
				'settings' => get_option( $plugin->settings_name ),
			)
		);
	}

	/**
	 * Add supported integrations to the given object.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Plugin $plugin
	 */
	public static function set_supported_integrations( Nice_Likes_Plugin $plugin ) {
		/**
		 * Update plugin instance.
		 */
		nice_likes_update( $plugin, array(
				'supported_integrations' => self::get_supported_integrations(),
			)
		);
	}

	/**
	 * Initialize and obtain the list of supported integrations.
	 *
	 * @uses  nice_likes_integration_create()
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected static function get_supported_integrations() {
		/**
		 * @hook nice_likes_supported_integrations
		 *
		 * All custom integrations should be hooked here to be loaded
		 * automatically.
		 *
		 * @since 1.0
		 */
		$integrations = apply_filters( 'nice_likes_supported_integrations', array() );

		// Initialize array to collect integrations.
		$supported_integrations = array();

		if ( ! empty( $integrations ) ) {
			foreach ( $integrations as $data ) {
				/**
				 * Create instances of `Nice_Likes_Integration` with the
				 * received data and add them to our collection.
				 *
				 * @see Nice_Likes_Integration
				 */
				$supported_integrations[] = nice_likes_integration_create( $data );
			}
		}

		return $supported_integrations;
	}

	/**
	 * Set i18n instance.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Plugin $plugin
	 */
	public static function set_i18n( Nice_Likes_Plugin $plugin ) {
		/**
		 * Update plugin instance.
		 */
		nice_likes_update( $plugin, array(
				'i18n' => self::get_i18n(),
			)
		);
	}

	/**
	 * Obtain i18n object for the current instance.
	 *
	 * @since  1.0
	 *
	 * @return Nice_Likes_i18n
	 */
	protected static function get_i18n() {
		/**
		 * Obtain plugin data from plugin file headers.
		 */
		$headers = nice_likes_plugin_headers();

		/**
		 * Create i18n instance.
		 */
		return nice_likes_i18n_create( apply_filters( 'nice_likes_plugin_i18n_data', array(
					'domain' => $headers['TextDomain'],
					'path'   => nice_likes_plugin_domain( true ),
					'locale' => get_locale(),
				)
		) );
	}

	/**
	 * Set post types.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Plugin $plugin
	 */
	public static function set_post_types( $plugin = null ) {
		if ( ! $plugin instanceof Nice_Likes_Plugin ) {
			$plugin = nice_likes_plugin();
		}

		/**
		 * Update admin instance.
		 */
		nice_likes_update( $plugin, array(
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
		$post_types_data = apply_filters( 'nice_likes_post_types', array() );
		$post_types      = array();

		if ( ! empty( $post_types_data ) ) {
			foreach ( $post_types_data as $data ) {
				$post_types[] = nice_likes_post_type_create( $data );
			}
		}

		return $post_types;
	}
}
