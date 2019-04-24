<?php
/**
 * Nice Likes by NiceThemes.
 *
 * This file handles functionality related to plugin settings.
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

if ( ! function_exists( 'nice_likes_set_default_settings' ) ) :
add_filter( 'nice_likes_default_settings', 'nice_likes_set_default_settings' );
/**
 * Set default plugin settings.
 *
 * @see    nice_likes_default_settings()
 *
 * @since  1.0
 *
 * @return array
 */
function nice_likes_set_default_settings() {
	$defaults = array(
		'remove_data_on_deactivation' => false,
		'avoidcss'                    => false,
		'enable'                      => true,
		'show_in_lists'               => false,
		'add_to'                      => array( 'posts' => 1, 'pages' => 1, 'other' => 1 ),
		'exclude'                     => '',
		'position'                    => 'before',
		'postfix_zero'                => esc_html__( '%s Likes', 'nice-likes' ),
		'postfix_one'                 => esc_html__( '%s Like', 'nice-likes' ),
		'postfix_more'                => esc_html__( '%s Likes', 'nice-likes' ),
		'unlike_text'                 => esc_html__( 'I don\'t like this anymore', 'nice-likes' ),
		'use_ajax'                    => true,
	);

	return $defaults;
}
endif;
