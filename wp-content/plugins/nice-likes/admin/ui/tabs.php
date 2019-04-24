<?php
/**
 * Register section tabs for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_tabs' ) ) :
add_filter( 'nice_likes_admin_ui_tabs', 'nice_likes_admin_ui_tabs' );
/**
 * Create tabs.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_tabs() {
	$tabs = array(
		array(
			'section' => 'settings',
			'args'    => array(
				'general' => array(
					'title'    => esc_html__( 'General', 'nice-likes' ),
					'icon'     => 'dashicons-admin-generic',
					'priority' => 10,
				),
			),
		),
		array(
			'section' => 'settings',
			'args'    => array(
				'advanced' => array(
					'title'    => esc_html__( 'Advanced', 'nice-likes' ),
					'icon'     => 'dashicons-admin-settings',
					'priority' => 30,
				),
			),
		),
	);

	return $tabs;
}
endif;
