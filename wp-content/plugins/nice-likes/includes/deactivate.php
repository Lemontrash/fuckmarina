<?php
/**
 * Nice Likes by NiceThemes.
 *
 * This file handles processes that fire on plugin deactivation.
 *
 * @package   Nice_Likes
 * @author    NiceThemes <hello@nicethemes.com>
 * @license   GPL-2.0+
 * @link      https://nicethemes.com/product/nice-likes
 * @copyright 2016 NiceThemes
 * @since     1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_likes_remove_settings' ) ) :
add_action( 'nice_likes_deactivate', 'nice_likes_remove_settings' );
/**
 * Remove settings on plugin deactivation.
 *
 * @since 1.0
 */
function nice_likes_remove_settings() {
	/**
	 * Remove plugin data only if requested.
	 */
	$settings = nice_likes_settings();

	if ( ! empty( $settings['remove_data_on_deactivation'] ) && $settings['remove_data_on_deactivation'] ) {
		/**
		 * Remove settings holder.
		 */
		delete_option( nice_likes_settings_name() );
	}
}
endif;
