<?php
/**
 * Add and manage custom post and page columns.
 *
 * @package   Nice_Likes
 * @author    NiceThemes <hello@nicethemes.com>
 * @license   GPL-2.0+
 * @link      https://nicethemes.com/product/nice-likes
 * @copyright 2016-2017 NiceThemes
 * @since     1.0.5
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_likes_add_posts_columns' ) ) :
add_filter( 'manage_pages_columns' , 'nice_likes_add_posts_columns', 10 );
add_filter( 'manage_posts_columns' , 'nice_likes_add_posts_columns', 10, 2 );
/**
 * Add custom admin columns.
 *
 * @since 1.0.5
 *
 * @param array  $columns
 * @param string $post_type
 *
 * @return array
 */
function nice_likes_add_posts_columns( $columns, $post_type = null ) {
	$settings = nice_likes_settings();

	if ( ! (bool) $settings['show_in_lists'] ) {
		return $columns;
	}

	$context = null;

	if ( empty( $post_type ) ) {
		$context = 'pages';
	} elseif ( 'post' === $post_type ) {
		$context = 'posts';
	}

	/**
	 * @hook nice_likes_posts_custom_column_context
	 *
	 * Hook in here to modify the context where custom columns should appear.
	 *
	 * @since 1.0.5
	 */
	$context = apply_filters( 'nice_likes_posts_custom_column_context', $context, $post_type );

	if ( ! (bool) $settings['add_to'][ $context ] ) {
		return $columns;
	}

	// Add styles for custom columns.
	add_action( 'admin_footer', 'nice_likes_add_posts_custom_columns_styles' );

	return array_merge( $columns, array( 'likes num' => __( 'Likes', 'nice-likes' ) ) );
}
endif;

if ( ! function_exists( 'nice_likes_add_posts_columns_data' ) ) :
add_action( 'manage_pages_custom_column' , 'nice_likes_add_posts_columns_data', 10, 2 );
add_action( 'manage_posts_custom_column' , 'nice_likes_add_posts_columns_data', 10, 2 );
/**
 * Add data to custom admin columns.
 *
 * @since 1.0.5
 *
 * @param string $column
 * @param int    $post_id
 */
function nice_likes_add_posts_columns_data( $column, $post_id ) {
	if ( 'likes num' !== $column ) {
		return;
	}

	$settings = nice_likes_settings();

	if ( ! (bool) $settings['show_in_lists'] ) {
		return;
	}

	$post_type = get_post_type( $post_id );

	switch ( $post_type ) {
		case 'post':
			$context = 'posts';
			break;
		case 'page':
			$context = 'pages';
			break;
		default:
			$context = null;
	}

	/**
	 * @hook nice_likes_posts_custom_column_context
	 *
	 * Hook in here to modify the context where custom columns should appear.
	 *
	 * @since 1.0.5
	 */
	$context = apply_filters( 'nice_likes_posts_custom_column_context', $context, $post_type );

	if ( ! (bool) $settings['add_to'][ $context ] ) {
		return;
	}

	include_once dirname( NICE_LIKES_PLUGIN_FILE ) . '/public/functions.php';

	echo nice_likes_count( $post_id ); // WPCS: XSS ok.
}
endif;

if ( ! function_exists( 'nice_likes_add_posts_custom_columns_styles' ) ) :
/**
 * Add styles for custom columns.
 *
 * @since 1.0.5
 */
function nice_likes_add_posts_custom_columns_styles() {
	?>
	<style>
		.column-likes { width: 10%; }
	</style>
	<?php
}
endif;
