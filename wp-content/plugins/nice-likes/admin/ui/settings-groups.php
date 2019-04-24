<?php
/**
 * Register groups of settings for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_settings_groups' ) ) :
add_filter( 'nice_likes_admin_ui_settings_groups', 'nice_likes_admin_ui_settings_groups' );
/**
 * Create groups of settings.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_settings_groups() {
	$general_settings = array(
		'general-settings' => array(
			'title'       => esc_html__( 'General Settings', 'nice-likes' ),
			'description' => esc_html__( 'Configure how your Likes will be displayed.', 'nice-likes' ),
		),
	);

	$advanced_settings = array(
		'advanced-settings' => array(
			'title'       => esc_html__( 'Advanced Settings', 'nice-likes' ),
			'description' => esc_html__( 'Options presented here are for advanced users only, so you must use them carefully.', 'nice-likes' ),
		),
	);

	$settings_groups = array(
		array(
			'tab'     => 'general',
			'section' => 'settings',
			'args'    => $general_settings,
		),
		array(
			'tab'     => 'advanced',
			'section' => 'settings',
			'args'    => $advanced_settings,
		),
	);

	return $settings_groups;
}
endif;
