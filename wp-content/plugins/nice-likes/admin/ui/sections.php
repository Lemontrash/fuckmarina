<?php
/**
 * Register sections for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_add_sections' ) ) :
add_filter( 'nice_likes_admin_ui_sections', 'nice_likes_admin_ui_add_sections' );
/**
 * Create sections.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_add_sections() {
	$sections = array(
		'settings' => array(
			'title'         => esc_html__( 'Settings', 'nice-likes' ),
			'heading_title' => esc_html__( 'Nice Likes Settings', 'nice-likes' ),
			'icon'          => 'dashicons-admin-settings',
			'description'   => '<p>' . esc_html__( 'Welcome to the Settings Panel. Here you can set up and configure all of the different options for this magnificent plugin.', 'nice-likes' ) . '</p>',
			'priority'      => 10,
		),
		'about' => array(
			'title'         => esc_html__( 'About', 'nice-likes' ),
			'heading_title' => esc_html__( 'About Nice Likes', 'nice-likes' ),
			'icon'          => 'dashicons-info',
			'priority'      => 20,
		),
	);

	return $sections;
}
endif;
