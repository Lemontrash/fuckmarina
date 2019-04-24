<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general functions that allow interactions with
 * this helper in an easier way.
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
 * Import plugin settings.
 *
 * @since 1.0
 *
 * @param $file_path
 *
 * @return bool
 */
function nice_likes_import_settings( $file_path ) {
	Nice_Likes_Settings_Handler::import( $file_path );
}

/**
 * Export plugin settings.
 *
 * @since 1.0
 *
 */
function nice_likes_export_settings() {
	Nice_Likes_Settings_Handler::export();
}
