<?php
/**
 * Nice Likes by NiceThemes.
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

if ( ! function_exists( 'nice_likes_update_callback' ) ) :
add_action( 'wp_ajax_nice_likes_update', 'nice_likes_update_callback' );
add_action( 'wp_ajax_nopriv_nice_likes_update', 'nice_likes_update_callback' );
/**
 * Update likes for a post when clicking on like link.
 *
 * @since 1.0
 */
function nice_likes_update_callback() {
	if ( ! isset( $_POST ) ) {
		die();
	}

	check_ajax_referer( 'nice-likes-nonce', 'nonce' );

	$posted = $_POST;
	$result = array();

	if ( isset( $posted['posts'] ) && nice_likes_update_likes() ) {
		foreach ( $posted['posts'] as $query_id => $post ) {
			$result[] = array(
				'post_id'  => $post['post_id'],
				'query_id' => $query_id,
				'content'  => nice_likes( array(
						'post_id'      => intval( $post['post_id'] ),
						'query_id'     => intval( $query_id ),
						'show_postfix' => nice_likes_bool( $post['show_postfix'] ),
						'icon'         => isset( $post['icon'] ) ? stripslashes( $post['icon'] ) : '',
					)
				),
			);
		}
	}

	echo wp_json_encode( $result );

	die();
}
endif;

if ( ! function_exists( 'nice_likes_load_callback' ) ) :
add_action( 'wp_ajax_nice_likes_load', 'nice_likes_load_callback' );
add_action( 'wp_ajax_nopriv_nice_likes_load', 'nice_likes_load_callback' );
/**
 * Load likes on background.
 *
 * @since 1.0
 */
function nice_likes_load_callback() {
	if ( ! isset( $_POST ) ) {
		die();
	}

	check_ajax_referer( 'nice-likes-nonce', 'nonce' );

	$posted = $_POST;
	$result = array();

	if ( isset( $posted['posts'] ) ) {
		foreach ( $posted['posts'] as $query_id => $post ) {
			$result[] = array(
				'post_id'  => $post['post_id'],
				'query_id' => $query_id,
				'content'  => nice_likes( array(
						'post_id'      => intval( $post['post_id'] ),
						'query_id'     => intval( $query_id ),
						'show_postfix' => nice_likes_bool( $post['show_postfix'] ),
						'icon'         => isset( $post['icon'] ) ? stripslashes( $post['icon'] ) : '',
					)
				),
			);
		}
	}

	echo wp_json_encode( $result );

	die();
}
endif;
