<?php
/**
 * Register footer links for Admin UI.
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

if ( ! function_exists( 'nice_likes_admin_ui_footer_links' ) ) :
add_filter( 'nice_likes_admin_ui_footer_links', 'nice_likes_admin_ui_footer_links' );
/**
 * Create footer links.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_footer_links() {
	$footer_links = array(
		array(
			'id'   => 'nice-admin-ui-link-themes',
			'text' => esc_html__( 'Themes', 'nice-likes' ),
			'href' => 'http://nicethemes.com/themes/',
			'target' => '_blank',
		),
		array(
			'id'   => 'nice-admin-ui-link-plugins',
			'text' => esc_html__( 'Plugins', 'nice-likes' ),
			'href' => 'http://nicethemes.com/plugins/',
			'target' => '_blank',
		),
		array(
			'id'     => 'nice-admin-ui-link-support',
			'text'   => esc_html__( 'Help & Support', 'nice-likes' ),
			'href'   => 'http://nicethemes.com/support/',
			'target' => '_blank',
		),
		array(
			'id'     => 'nice-admin-ui-link-rate',
			'text'   => esc_html__( 'Rate this plugin', 'nice-likes' ),
			'href'   => 'https://wordpress.org/support/view/plugin-reviews/nice-likes?rate=5#postform',
			'target' => '_blank',
		),
	);

	return $footer_links;
}
endif;
