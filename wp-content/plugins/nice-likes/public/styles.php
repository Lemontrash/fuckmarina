<?php
/**
 * Nice Likes by NiceThemes.
 *
 * This file includes actions to handle styles for the public-facing side of
 * the plugin.
 *
 * @package Nice_Likes
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_likes_enqueue_styles' ) ) :
add_action( 'nice_likes_plugin_enqueue_styles', 'nice_likes_enqueue_styles' );
/**
 * Enqueue styles for likes.
 *
 * @since 1.0
 */
function nice_likes_enqueue_styles() {
	$settings = nice_likes_settings();

	if ( ! empty( $settings['enable'] ) && ! $settings['avoidcss'] ) {
		// Enqueue likes styles.
		wp_enqueue_style(
			nice_likes_plugin_slug() . '-styles',
			nice_likes_canonicalize_url( plugins_url( 'assets/css/nice-likes.css', __FILE__ ) ),
			array(),
			nice_likes_plugin_version()
		);
		// Enqueue font styles.
		wp_enqueue_style(
			nice_likes_plugin_slug() . '-fontello-font-awesome',
			nice_likes_canonicalize_url( plugins_url( 'assets/fonts/fontello-font-awesome/css/fontello.css', __FILE__ ) ),
			array(),
			nice_likes_plugin_version()
		);
	}
}
endif;
