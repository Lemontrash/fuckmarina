<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Manage functionality for localization features.
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

/**
 * The following strings define translatable data that's not tied to any
 * particular output.
 *
 * @since 1.0
 */
$nice_likes_i18n_plugin_data = array(
	'plugin_name'        => esc_html__( 'Nice Likes', 'nice-likes' ),
	'plugin_name_author' => esc_html__( 'Nice Likes By NiceThemes', 'nice-likes' ),
	'plugin_description' => esc_html__( 'Add "liking" functionality to your posts, pages and custom post types on your WordPress site.', 'nice-likes' ),
);

add_filter( 'nice_likes_plugin_i18n_data', 'nice_likes_plugin_i18_domain_path' );
/**
 * Set the right location of language files.
 *
 * @since  1.0
 *
 * @param  array $data
 *
 * @return array
 */
function nice_likes_plugin_i18_domain_path( array $data = array() ) {
	return array_merge( $data, array(
			'path' => nice_likes_plugin_domain() . 'languages',
		)
	);
}
