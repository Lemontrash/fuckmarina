<?php
/**
 * Nice Likes by NiceThemes.
 *
 * This file includes actions to handle scripts for the public-facing side of
 * the plugin.
 *
 * @package Nice_Likes
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_likes_enqueue_scripts' ) ) :
add_action( 'nice_likes_plugin_enqueue_scripts', 'nice_likes_enqueue_scripts' );
/**
 * Enqueue scripts for likes functionality.
 *
 * @since 1.0
 */
function nice_likes_enqueue_scripts() {
	$settings = nice_likes_settings();

	if ( ! empty( $settings['enable'] ) && $settings['use_ajax'] ) {
		$post = get_post();

		// If not debugging, use minified scripts.
		$scripts = array(
			'likes' => nice_likes_debug() ? 'assets/js/nice-likes.js' : 'assets/js/min/nice-likes.min.js',
		);

		$slug = nice_likes_plugin_slug();

		// Enqueue handler file.
		wp_enqueue_script(
			$slug . '-script',
			nice_likes_canonicalize_url( plugins_url( $scripts['likes'], __FILE__ ) ),
			array( 'jquery' ),
			nice_likes_plugin_version(),
			true
		);

		wp_localize_script( $slug . '-script', 'nice_likes_vars', apply_filters( 'nice_likes_vars', array(
				'ajaxurl'  => admin_url( 'admin-ajax.php' ),
				'fromurl'  => nice_likes_get_url(),
				'singular' => ( $post instanceof WP_Post ) ? is_singular( $post->post_type ) : false,
				'nonce'    => wp_create_nonce( 'nice-likes-nonce' ),
			)
		) );
	}
}
endif;
