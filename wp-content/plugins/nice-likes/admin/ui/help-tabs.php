<?php
/**
 * Create help tabs for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_add_help_tabs' ) ) :
add_filter( 'nice_likes_admin_ui_help_tabs', 'nice_likes_admin_ui_add_help_tabs', 10, 2 );
/**
 * Create help tabs.
 *
 * @since 1.0
 *
 * @param array                   $help_tabs List of current help tabs.
 * @param Nice_Likes_Admin_UI $ui        Current Admin UI object.
 *
 * @return array
 */
function nice_likes_admin_ui_add_help_tabs( $help_tabs = array(), Nice_Likes_Admin_UI $ui ) {
	$help_tabs = ! empty( $help_tabs ) && is_array( $help_tabs ) ? $help_tabs : array();

	$help_tabs = array_merge( $help_tabs, array(
		array(
			'section' => 'settings',
			'args'    => array(
				'nice-likes-general-settings' => array(
					'id'      => 'nice-likes-general-settings',
					'title'   => esc_html__( 'General Settings', 'nice-likes' ),
					'content' => $ui->get_template_part( 'help-tab-general', '', true ),
				),
				'nice-likes-advanced-settings' => array(
					'id'      => 'nice-likes-advanced-settings',
					'title'   => esc_html__( 'Advanced Settings', 'nice-likes' ),
					'content' => $ui->get_template_part( 'help-tab-advanced', '', true ),
				),
				'nice-likes-help-support' => array(
					'id'      => 'nice-likes-help-support',
					'title'   => esc_html__( 'Help & Support', 'nice-likes' ),
					'content' => $ui->get_template_part( 'help-tab-help', '', true ),
				),
				'nice-likes-compatible-themes' => array(
					'id'      => 'nice-likes-compatible-themes',
					'title'   => esc_html__( 'Compatible Themes', 'nice-likes' ),
					'content' => $ui->get_template_part( 'help-tab-themes', '', true ),
				),
			),
		),
	) );

	return $help_tabs;
}
endif;
