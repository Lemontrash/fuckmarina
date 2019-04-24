<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Handle initial templating processes for admin-facing side of the plugin.
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

if ( ! function_exists( 'nice_likes_admin_templates_path' ) ) :
add_filter( 'nice_likes_admin_templates_path', 'nice_likes_admin_templates_path' );
/**
 * Obtain the template path for admin-facing side.
 *
 * @since  1.0
 *
 * @return string
 */
function nice_likes_admin_templates_path() {
	return trailingslashit( realpath( plugin_dir_path( __FILE__ ) . '../templates' ) );
}
endif;
