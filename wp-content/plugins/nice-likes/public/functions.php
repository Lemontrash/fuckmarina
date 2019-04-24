<?php
/**
 * Nice Likes by NiceThemes.
 *
 * @package Nice_Likes
 * @since   1.0
 */

if ( ! function_exists( 'nice_likes_get_url' ) ) :
/**
 * Obtain URL to like a post.
 *
 * @since  1.0.0
 *
 * @param  array $args  Array of keys and values to add the query string.
 * @param  array $unset Keys to be excluded from the query string.
 *
 * @return string
 */
function nice_likes_get_url( array $args = array(), array $unset = null ) {
	// Allow bypass.
	if ( $current_url = apply_filters( 'nice_likes_get_url', '', $args, $unset ) ) {
		return $current_url;
	}

	global $wp;

	// Obtain current URL without query arguments.
	$base_url = home_url( add_query_arg( array(), $wp->request ) );

	// Obtain requested query string.
	$query_string = isset( $_SERVER['QUERY_STRING'] ) ? wp_unslash( $_SERVER['QUERY_STRING'] ) : '';

	// Throw query string values inside an array.
	parse_str( $query_string, $query_array );

	// Mix obtained query array with our given arguments.
	$query_array = wp_parse_args( $args, $query_array );

	/**
	 * Exclude specified keys from query string.
	 *
	 * @see nice_likes_update_not_ajax()
	 */
	if ( ! empty( $unset ) ) {
		foreach ( $unset as $key ) {
			if ( isset( $query_array[ $key ] ) ) {
				unset( $query_array[ $key ] );
			}
		}
	}

	// Rebuild query string.
	$query_string = http_build_query( $query_array );

	// Construct our current URL.
	$current_url = trailingslashit( $base_url );
	$current_url .= $query_string ? '?' . $query_string : '';

	return $current_url;
}
endif;

if ( ! function_exists( 'nice_likes_user_ip' ) ) :
/**
 * Get the visitor's IP address
 *
 * @since  1.0
 * @return string
 */
function nice_likes_user_ip() {
	/**
	 * @hook nice_likes_user_ip
	 *
	 * Hook in here to modify the current user's IP.
	 *
	 * @since 1.0.8
	 */
	return apply_filters( 'nice_likes_user_ip', $_SERVER['REMOTE_ADDR'] );
}
endif;

if ( ! function_exists( 'nice_likes_count' ) ) :
/**
 * Obtain the number of likes for a certain post/page/CPT.
 *
 * @since  1.0
 *
 * @param  int $id
 * @return int
 */
function nice_likes_count( $id = 0 ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}

	// Obtain number of likes.
	$likes = ( $count = get_post_meta( $id, '_like_count', true ) ) ? $count : 0;
	$likes = apply_filters( 'nice_likes_count', $likes, $id );

	return $likes;
}
endif;

if ( ! function_exists( 'nice_likes_count_text' ) ) :
/**
 * Obtain text for the Like button given a post ID and a number of likes.
 *
 * @since  1.0
 *
 * @param  int    $id
 * @param  int    $count
 * @param  bool   $show_user_postfix
 *
 * @return string
 */
function nice_likes_count_text( $id = 0, $count = 0, $show_user_postfix = true ) {
	if ( ! $id ) {
		$id = get_the_ID();
	}
	$settings = nice_likes_settings();

	$count = intval( $count ) >= 0 ? intval( $count ) : 0;

	if ( $show_user_postfix ) {
		if ( 0 == $count ) {
			$postfix = $settings['postfix_zero'];
		} elseif ( 1 == $count ) {
			$postfix = $settings['postfix_one'];
		} else {
			$postfix = $settings['postfix_more'];
		}
	} else {
		$postfix = '%s';
	}

	$postfix = apply_filters( 'nice_likes_count_text_postfix', $postfix, $count, $id );

	$text = sprintf( $postfix, '<span class="likes-count">' . $count . '</span>' );
	$text = apply_filters( 'nice_likes_count_text', $text, $id, $count );

	return $text;
}
endif;

if ( ! function_exists( 'nice_likes_can' ) ) :
/**
 * Check if the current IP already liked the content or not.
 *
 * @since 1.0
 *
 * @param  int $id
 * @return int
 */
function nice_likes_can( $id = 0 ) {
	// Return early if $id is not set.
	if ( ! $id ) {
		return false;
	}

	$ip_list = ( $ip = get_post_meta( $id, '_like_ip', true ) ) ? $ip  : array();

	if (   ( $ip_list == '' )
		|| ( is_array( $ip_list ) && ! in_array( nice_likes_user_ip(), $ip_list ) )
	) {
		return true;
	}

	return false;
}
endif;

if ( ! function_exists( 'nice_likes_in_content' ) ) :
/**
 * Obtain likes in a given position.
 *
 * @since  1.0
 *
 * @param  string $content
 * @param  int    $position
 * @return string
 */
function nice_likes_in_content( $content, $position ) {
	$the_ID = get_the_ID();

	switch ( $position ) {
		case 'before' :
			$output = nice_likes( array( 'post_id' => $the_ID ) ) . $content;
			break;
		case 'after' :
			$output = $content . nice_likes( array( 'post_id' => $the_ID ) );
			break;
		case 'custom' :
			$output = $content;
			break;
		default :
			$output = $content;
	}

	return $output;
}
endif;

if ( ! function_exists( 'nice_likes_apply' ) ) :
/**
 * Check if likes apply to the current context.
 *
 * @since  1.0
 *
 * @param  array $locations List of possible locations where to show Likes.
 *
 * @return bool
 */
function nice_likes_apply( array $locations = array() ) {
	if ( empty( $locations ) ) {
		$locations = array(
			'posts',
			'pages',
			'other',
		);
	}

	$locations = apply_filters( 'nice_likes_locations', $locations );

	$apply_here = false;

	foreach ( $locations as $location ) {
		static $apply = array();

		if ( ! empty( $apply[ $location ] ) ) {
			return $apply[ $location ];
		}

		if ( $apply_here = nice_likes_apply_to( $location ) ) {
			$apply[ $location ] = $apply_here;
			break;
		}
	}

	$apply_here = apply_filters( 'nice_likes_apply', $apply_here );

	return $apply_here;
}
endif;

if ( ! function_exists( 'nice_likes_location' ) ) :
/**
 * Obtain current location to display likes.
 *
 * @since  1.0
 *
 * @return string
 */
function nice_likes_location() {
	$location = 'posts';

	if ( is_home() || is_archive() ) {
		$location = 'other';
	}

	if ( is_page() ) {
		$location = 'pages';
	}

	return apply_filters( 'nice_likes_location', $location );
}
endif;

if ( ! function_exists( 'nice_likes_apply_to' ) ) :
/**
 * Check if likes apply to the current specific context.
 *
 * @since  1.0
 *
 * @param  string $location
 *
 * @return bool
 */
function nice_likes_apply_to( $location = 'posts' ) {
	$apply = false;

	$locations = apply_filters( 'nice_likes_apply_locations', array(
			'posts' => 'nice_likes_apply_to_posts',
			'pages' => 'nice_likes_apply_to_pages',
			'other' => 'nice_likes_apply_to_other',
		)
	);

	if ( ! empty( $locations[ $location ] ) ) {
		$apply = call_user_func( $locations[ $location ] );
	}

	return $apply;
}
endif;

if ( ! function_exists( 'nice_likes_apply_to_posts' ) ) :
/**
 * Check if likes should be applied to posts.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_apply_to_posts() {
	static $apply = null;

	if ( ! is_null( $apply ) ) {
		return $apply;
	}

	$post     = get_post();
	$settings = nice_likes_settings();
	$apply    = is_single() && ( 'post' == $post->post_type ) && (bool) $settings['add_to']['posts'];
	$apply    = apply_filters( 'nice_likes_apply_to_posts', $apply, $settings );

	return $apply;
}
endif;

if ( ! function_exists( 'nice_likes_apply_to_pages' ) ) :
/**
 * Check if likes should be applied to pages.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_apply_to_pages() {
	static $apply = null;

	if ( ! is_null( $apply ) ) {
		return $apply;
	}

	$settings = nice_likes_settings();
	$apply    = is_page() && ! is_front_page() && (bool) $settings['add_to']['pages'];
	$apply    = apply_filters( 'nice_likes_apply_to_pages', $apply );

	return $apply;
}
endif;

if ( ! function_exists( 'nice_likes_apply_to_other' ) ) :
/**
 * Check if likes should be applied to blog, archives, etc.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_apply_to_other() {
	static $apply = null;

	if ( ! is_null( $apply ) ) {
		return $apply;
	}

	$settings = nice_likes_settings();
	$apply = ( is_front_page() || is_home() || is_archive() || is_category() || is_tag() || is_author() || is_date() || is_search() ) && (bool) $settings['add_to']['posts'] && (bool) $settings['add_to']['other'];
	$apply = apply_filters( 'nice_likes_apply_to_other', $apply, $settings );

	return $apply;
}
endif;
