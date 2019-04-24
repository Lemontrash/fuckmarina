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
 * Class Nice_Likes_Plugin
 *
 * Plugin main class. This class should ideally be used to work with
 * functionality shared between public and admin facing sides of the plugin.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Plugin extends Nice_Likes_Entity {
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $version = '1.0';

	/**
	 * The minimum required version of WordPress to run this plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $wp_required_version = '3.6';

	/**
	 * The minimum required version of PHP to run this plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $php_required_version = '5.2';

	/**
	 * Absolute location of the main file of the plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $plugin_file = '';

	/**
	 * Absolute location of the plugin's domain path.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $plugin_domain = '';

	/**
	 * Basename of the plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $plugin_basename = '';

	/**
	 * Name of the plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $name = '';

	/**
	 * Whether the active theme is from NiceThemes or not.
	 *
	 * @since 1.0
	 * @var   bool
	 */
	protected $using_nicetheme = false;

	/**
	 * Name of the active theme template.
	 *
	 * @since 1.0
	 * @var   null|string
	 */
	protected $theme_template = null;

	/**
	 * List of natively supported integrations with other plugins and themes.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $supported_integrations = array();

	/**
	 * Unique identifier for this plugin.
	 *
	 * @var    string
	 * @since  1.0
	 */
	protected $plugin_slug = '';

	/**
	 * The name of the option that stores the settings for this plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $settings_name = 'nice_likes_settings';

	/**
	 * Current settings for this plugin, stored in the options table.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $settings = array();

	/**
	 * Locale information.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_i18n
	 */
	protected $i18n = null;

	/**
	 * List of Nice_Likes_Post_Type instances.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $post_types = array();

	/**
	 * Check whether the plugin is using AJAX or not.
	 *
	 * @since 1.0
	 * @var   bool
	 */
	protected $doing_ajax = false;
}
