<?php
if ( ! function_exists( 'nice_likes_update_likes' ) ) :
/**
 * Update likes from request.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_update_likes() {
	$nonce = isset( $_REQUEST['nonce'] ) ? wp_unslash( $_REQUEST['nonce'] ) : null;

	// Check that we're inside a valid request.
	if ( ! wp_verify_nonce( $nonce, 'nice-likes-nonce' ) ) {
		return false;
	}

	if ( empty( $_REQUEST['post_id'] ) ) {
		return false;
	}

	$likes = ( $count = get_post_meta( intval( $_REQUEST['post_id'] ), '_like_count', true ) ) ? $count : 0;

	$ip_list = ( $ip = get_post_meta( intval( $_REQUEST['post_id'] ), '_like_ip', true ) ) ? $ip : array();

	if ( nice_likes_can( intval( $_REQUEST['post_id'] ) ) ) {
		$likes = $likes + 1;
		$ip_list[] = nice_likes_user_ip();
	} else {
		$key = array_search( nice_likes_user_ip(), $ip_list );
		unset( $ip_list[ $key ] );
		$likes = $likes - 1;
	}

	update_post_meta( intval( $_REQUEST['post_id'] ), '_like_ip', $ip_list );
	update_post_meta( intval( $_REQUEST['post_id'] ), '_like_count', $likes );

	return true;
}
endif;

if ( ! function_exists( 'nice_likes_update_not_ajax' ) ) :
add_action( 'init', 'nice_likes_update_not_ajax' );
/**
 * Update likes when AJAX is not being used.
 *
 * @since 1.0.0
 *
 * @return string
 */
function nice_likes_update_not_ajax() {
	// Allow bypass.
	if ( $redirect_url = apply_filters( 'nice_likes_update_redirect_url', '' ) ) {
		return $redirect_url;
	}

	$settings = nice_likes_settings();

	if ( ! nice_likes_doing_ajax() && ! $settings['use_ajax'] && nice_likes_update_likes() ) {
		$redirect_url = isset( $_GET['post_id'] ) ? get_permalink( intval( $_GET['post_id'] ) ) : '';
		$redirect_url = $redirect_url ? $redirect_url : nice_likes_get_url( array(), array( 'post_id', 'nonce' ) );

		/**
		 * Redirect to a safe location to prevent likes from being processed
		 * again when refreshing the page.
		 */
		wp_redirect( $redirect_url );
	}

	return $redirect_url;
}
endif;
