<?php
/**
 * NiceThemes ADR
 *
 * This file loads all the necessary files for the Plugin API to work correctly.
 * It's the only file that you need to include in your plugin. All other
 * inclusions can be processed recursively using the autoloader class.
 *
 * @package Nice_Likes_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$plugin_api_dir_path = plugin_dir_path( __FILE__ );

/**
 * Load autoloader files.
 *
 * @since 1.0
 */
require_once $plugin_api_dir_path . 'autoloader/class-autoloader.php';
require_once $plugin_api_dir_path . 'autoloader/functions.php';
