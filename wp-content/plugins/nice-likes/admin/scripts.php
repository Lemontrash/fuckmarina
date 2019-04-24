<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Enqueue scripts for admin-facing side.
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

if ( ! function_exists( 'nice_likes_admin_enqueue_scripts' ) ) :
add_action( 'nice_likes_admin_enqueue_scripts', 'nice_likes_admin_enqueue_scripts' );
/**
 * Register and enqueue admin-specific JavaScript.
 *
 * @since 1.0
 */
function nice_likes_admin_enqueue_scripts() {
	// Obtain plugin slug and version.
	$slug    = nice_likes_plugin_slug();
	$version = nice_likes_plugin_version();

	// Obtain whether or not we're in debug mode.
	$debug = ( nice_likes_debug() || nice_likes_development_mode() );

	// Define script URLs.
	$scripts = array(
		$slug . '-admin-notices-script' => NICE_LIKES_ADMIN_ASSETS_URL . ( $debug ? 'js/nice-likes-admin-notices.js' : 'js/min/nice-likes-admin-notices.min.js' ),
	);

	/**
	 * Admin notices script.
	 */
	if ( nice_likes_admin_is_update_notice_enabled() ) {
		wp_register_script( $slug . '-admin-notices-script', $scripts[ $slug . '-admin-notices-script' ], array( 'jquery' ), $version );
		wp_enqueue_script( $slug . '-admin-notices-script' );

		wp_localize_script( $slug . '-admin-notices-script', 'nice_likes_admin_notices_vars', array(
			'ajax_url' => admin_url() . 'admin-ajax.php',
			'nonce'    => wp_create_nonce( 'nice-likes-admin-notices-nonce' ),
		) );
	}
}
endif;
