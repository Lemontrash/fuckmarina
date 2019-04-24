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
 * Class Nice_Likes_Settings_Handler
 *
 * Set of methods for settings management.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Settings_Handler {
	/**
	 * Import plugin settings.
	 *
	 * @since  1.0
	 *
	 * @param $file_path
	 *
	 * @return bool
	 */
	public static function import( $file_path ) {
		/**
		 * Initialize WordPress' filesystem.
		 */
		WP_Filesystem();

		/**
		 * @var WP_Filesystem_Base $wp_filesystem
		 */
		global $wp_filesystem;

		// Obtain settings from the provided file.
		$new_settings = json_decode( $wp_filesystem->get_contents( $file_path ), true );

		if ( ! $new_settings ) {
			return false;
		}

		// Make sure this is a valid backup file.
		if ( ! isset( $new_settings['nice_likes_settings_backup_validator'] ) ) {
			return false;
		}

		// Remove the custom marker.
		unset( $new_settings['nice_likes_settings_backup_validator'] );

		// Obtain current settings.
		$settings_name = nice_likes_settings_name();
		$settings      = nice_likes_settings();

		// Process and save new settings.
		$settings = nice_likes_wp_parse_args( $new_settings, $settings );
		update_option( $settings_name, $settings );

		return true;
	}

	/**
	 * Export plugin settings.
	 *
	 * @since  1.0
	 */
	public static function export() {
		$settings = nice_likes_settings();

		if ( ! $settings ) {
			return;
		}

		// Add a custom marker.
		$settings['nice_likes_settings_backup_validator'] = date( 'Y-m-d h:i:s' );

		// Generate the export file.
		$output = wp_json_encode( (array) $settings );

		header( 'Content-Description: File Transfer' );
		header( 'Cache-Control: public, must-revalidate' );
		header( 'Pragma: hack' );
		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="nice-plugin-settings-' . date( 'Y-m-d-His' ) . '.json"' );
		header( 'Content-Length: ' . strlen( $output ) );

		// Print out JSON.
		echo $output; // WPCS: XSS ok.

		exit;
	}
}
