<?php
/**
 * Initialize Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_data' ) ) :
add_filter( 'nice_likes_admin_ui_data', 'nice_likes_admin_ui_data' );
/**
 * Create a new Admin UI.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_data() {
	$admin_ui = array(
		'name'           => nice_likes_plugin_slug(),
		'title'          => esc_html__( 'Likes', 'nice-likes' ),
		'textdomain'     => 'nice-likes',
		'settings_name'  => nice_likes_settings_name(),
		'templates_path' => plugin_dir_path( __FILE__ ) . 'templates/',
	);

	return $admin_ui;
}
endif;
