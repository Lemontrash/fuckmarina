<?php
/**
 * Set help pointers for admin-facing side.
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

if ( ! function_exists( 'nice_likes_admin_pointers_data' ) ) :
add_filter( 'nice_likes_admin_pointers_data', 'nice_likes_admin_pointers_data' );
/**
 * Register help pointers.
 *
 * @since  1.0
 *
 * @param  array $pointers Current lis of help pointers.
 *
 * @return array
 */
function nice_likes_admin_pointers_data( array $pointers = null ) {
	$pointers[] = array(
		'id'       => 'nice_likes_help_pointer',
		'screen'   => 'settings_page_' . nice_likes_plugin_slug(),
		'target'   => '#navtabs a:first-child',
		'title'    => nice_likes_plugin_name(),
		'content'  => esc_html__( 'Thank you for installing this plugin :) In this page you can set all the available options to display your likes the way you want.', 'nice-likes' ),
		'position' => array(
			'edge'  => 'left',  // top, bottom, left, right
			'align' => 'middle', // top, bottom, left, right, middle
		),
	);

	return $pointers;
}
endif;
