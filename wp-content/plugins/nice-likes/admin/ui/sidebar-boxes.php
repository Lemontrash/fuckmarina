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

if ( ! function_exists( 'nice_likes_admin_ui_add_sidebar_boxes' ) ) :
add_filter( 'nice_likes_admin_ui_sidebar_boxes', 'nice_likes_admin_ui_add_sidebar_boxes', 10, 2 );
/**
 * Create sidebar boxes.
 *
 * @since  1.0
 *
 * @param  array                   $sidebar_boxes List of current help tabs.
 * @param  Nice_Likes_Admin_UI $ui                Current Admin UI object.
 *
 * @return array
 */
function nice_likes_admin_ui_add_sidebar_boxes( array $sidebar_boxes = array(), Nice_Likes_Admin_UI $ui ) {
	$sidebar_boxes = array_merge( $sidebar_boxes, array(
			array(
				'title'   => esc_html__( 'Subscribe to our Newsletter', 'nice-likes' ),
				'content' => $ui->get_template_part( 'widget-newsletter', '', true ),
			),
			array(
				'title'   => esc_html__( 'Need help with this plugin?', 'nice-likes' ),
				'content' => $ui->get_template_part( 'widget-help', '', true ),
			),
			array(
				'title'   => esc_html__( 'Like this plugin?', 'nice-likes' ),
				'content' => $ui->get_template_part( 'widget-rate-plugin', '', true ),
			),
			array(
				'title'   => esc_html__( 'Join us on', 'nice-likes' ),
				'content' => $ui->get_template_part( 'widget-social', '', true ),
			),
		)
	);

	return $sidebar_boxes;
}
endif;
