<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general helper functions that allow interactions with
 * the Plugin API in an easier way.
 *
 * @package Nice_Likes_Plugin_API
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Obtain data from plugin headers.
 *
 * @uses  get_plugin_data()
 *
 * @since 1.0
 */
function nice_likes_plugin_headers() {
	static $headers = null;

	if ( ! is_null( $headers ) ) {
		return $headers;
	}

	// Load required library.
	require_once( nice_likes_get_admin_path() . 'includes/plugin.php' );

	$headers = get_plugin_data( nice_likes_plugin_file( true ) );

	return $headers;
}

/**
 * Check if we're in debug context.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_debug() {
	return ( defined( 'WP_DEBUG' ) && true === WP_DEBUG );
}

/**
 * Check if we're in debug context.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_development_mode() {
	return ( defined( 'NICETHEMES_DEVELOPMENT_MODE' ) && true === NICETHEMES_DEVELOPMENT_MODE );
}

/**
 * Obtain canonicalized absolute URL.
 *
 * @since  1.0
 *
 * @param  string $url Relative URL.
 *
 * @return string
 */
function nice_likes_canonicalize_url( $url ) {
	$url = explode( '/', $url );
	$keys = array_keys( $url, '..' );

	foreach ( $keys as $keypos => $key ) {
		array_splice( $url, $key - ( $keypos * 2 + 1 ), 2 );
	}

	$url = implode( '/', $url );
	$url = str_replace( './', '', $url );

	return $url;
}

/**
 * Convert a given value to true or false.
 *
 * @since  1.0
 *
 * @param  mixed $value
 *
 * @return bool
 */
function nice_likes_bool( $value = false ) {
	if ( is_string( $value ) ) {
		return ( $value && strtolower( $value ) !== 'false' );
	}

	return ( $value ? true : false );
}

/**
 * Convert the given value to a positive or negative integer.
 *
 * @since  1.0
 *
 * @param  mixed $value
 *
 * @return bool
 */
function nice_likes_intval( $value = false ) {
	return filter_var( $value, FILTER_SANITIZE_NUMBER_INT );
}

/**
 * Similar to wp_parse_args() just a bit extended to work with multidimensional arrays :)
 *
 * @see wp_parse_args()
 *
 * @since 1.0
 *
 * @param array $args     Value to merge with $defaults
 * @param array $defaults Optional. Array that serves as the defaults. Default empty.
 *
 * @return array
 */
function nice_likes_wp_parse_args( array &$args = array(), array $defaults = array() ) {
	$args     = (array) $args;
	$defaults = (array) $defaults;
	$result   = $defaults;

	if ( empty( $args ) ) {
		return null;
	}

	foreach ( $args as $k => &$v ) {
		if ( is_array( $v ) && isset( $result[ $k ] ) ) {
			$result[ $k ] = nice_likes_wp_parse_args( $v, $result[ $k ] );
		} else {
			$result[ $k ] = $v;
		}
	}

	return $result;
}

/**
 * Obtain the path to the admin directory.
 *
 * @uses   get_bloginfo()
 * @uses   get_admin_url()
 *
 * @since  1.0
 *
 * @return string
 */
function nice_likes_get_admin_path() {
	static $admin_path = null;

	if ( ! is_null( $admin_path ) ) {
		return $admin_path;
	}

	// Admin path should be constructed with ABSPATH and wp-admin folder.
	$admin_path = ABSPATH . 'wp-admin/';

	// If the standard admin path does not exist, let's try to calculate it.
	// This is not guaranteed to work in all scenarios, specially for weird setups.
	if ( ! is_dir( $admin_path ) ) {
		$admin_url = get_admin_url();
		$site_url  = get_bloginfo( 'url' );

		if ( is_ssl() ) {
			$admin_url = str_replace( 'https://', 'http://', $admin_url );
			$site_url  = str_replace( 'https://', 'http://', $site_url );
		}

		$admin_path = str_replace( $site_url . '/', ABSPATH, $admin_url );
	}

	$admin_path = apply_filters( 'nice_likes_get_admin_path', $admin_path );

	return $admin_path;
}

/**
 * Get the icon path for the CPTs/etc.
 * Since WP 3.8, the dashboard changed completely, so now
 * different skins are available and the icons can be light or dark.
 *
 * @since  1.0
 *
 * @param  string $nice_likes_icon Icon file or slug.
 *
 * @return string
 */
function nice_likes_admin_menu_icon( $nice_likes_icon = 'btn-nicethemes.png' ) {
	global $wp_version;

	$nice_likes_plugin_domain_file = defined( 'NICE_LIKES_PLUGIN_DOMAIN_FILE' ) ? NICE_LIKES_PLUGIN_DOMAIN_FILE : __FILE__;

	// Obtain path of images folder.
	$img_dir_path = realpath( plugin_dir_path( $nice_likes_plugin_domain_file ) . 'admin/assets/images/' ) . '/';

	// Obtain URL of images folder.
	$img_dir_url = nice_likes_canonicalize_url( plugin_dir_url( $nice_likes_plugin_domain_file ) . 'admin/assets/images/' );

	// if WP is higher than 3.8 alpha and the admin color is not light, return the white icons
	if (   version_compare( $wp_version, '3.8-alpha', '>' )
	       && ( $admin_color = get_user_option( 'admin_color' ) !== 'light' )
	       && file_exists( $img_dir_path . 'light/' . $nice_likes_icon )
	) {
		$icon = $img_dir_url . 'light/' . $nice_likes_icon;
	} elseif ( file_exists( $img_dir_path . $nice_likes_icon ) ) {
		$icon = $img_dir_url . $nice_likes_icon;
	} else {
		$icon = $nice_likes_icon;
	}

	return $icon = apply_filters( 'nice_likes_admin_menu_icon', $icon, $nice_likes_icon );
}

/**
 * Trigger a warning when a function or method is used incorrectly.
 *
 * @since 1.0
 *
 * @param string $function The function that was called.
 * @param string $message  A message explaining what has been done incorrectly.
 * @param string $version  The version of the plugin where the message was added (optional).
 */
function _nice_likes_doing_it_wrong( $function, $message, $version = null ) {
	/**
	 * @hook nice_likes_doing_it_wrong_run
	 *
	 * Fires when the given function is being used incorrectly.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_likes_doing_it_wrong_run', $function, $message, $version );

	/**
	 * Trigger error.
	 *
	 * @since 1.0
	 */
	if ( nice_likes_debug() && nice_likes_development_mode() ) {
		$version = is_null( $version ) ? '' : sprintf( esc_html__( '(This message was added in %s version %s.)', 'nice-likes' ), nice_likes_plugin_name(), $version );
		trigger_error( sprintf( esc_html__( '%1$s was called <strong>incorrectly</strong>. %2$s %3$s', 'nice-likes' ), $function, $message, $version ), E_USER_WARNING ); // WPCS: XSS ok.
	}
}
