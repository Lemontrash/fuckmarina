<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Create help sidebars for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_add_help_sidebars' ) ) :
add_filter( 'nice_likes_admin_ui_help_sidebars', 'nice_likes_admin_ui_add_help_sidebars', 10, 2 );
/**
 * Create help sidebars.
 *
 * @since  1.0
 *
 * @param  array                   $help_sidebars List of current help sidebars.
 * @param  Nice_Likes_Admin_UI $ui                Current Admin UI object.
 *
 * @return array
 */
function nice_likes_admin_ui_add_help_sidebars( $help_sidebars = array(), Nice_Likes_Admin_UI $ui ) {
	$help_sidebars  = ! empty( $help_sidebars ) && is_array( $help_sidebars ) ? $help_sidebars : array();

	$help_sidebars = array_merge( $help_sidebars, array(
		array(
			'section' => 'settings',
			'content' => apply_filters( 'nice_likes_admin_ui_help_sidebar', $ui->get_template_part( 'help-sidebar', '', true ) ),
		),
	) );

	return $help_sidebars;
}
endif;
