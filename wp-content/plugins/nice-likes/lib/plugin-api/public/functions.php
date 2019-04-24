<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general helper functions that allow interactions with
 * this module in an easier way.
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
 * Obtain current public-facing instance of plugin.
 *
 * @uses   nice_likes_create()
 *
 * @since  1.0
 *
 * @return Nice_Likes_Public
 */
function nice_likes_plugin_public() {
	static $public = null;

	if ( ! is_null( $public ) ) {
		return $public;
	}

	$data = apply_filters( 'nice_likes_plugin_public_data', array() );

	/**
	 * Initialize public side of plugin.
	 */
	return $public = nice_likes_create( 'Nice_Likes_Public', $data );
}

/**
 * Initialize public-facing side of plugin.
 *
 * @uses  nice_likes_plugin_public()
 * @uses  nice_likes_display()
 *
 * @since 1.0
 */
function nice_likes_plugin_public_init() {
	// Return early if we're out of public context.
	if ( is_admin() && ! nice_likes_doing_ajax() ) {
		return;
	}

	// Return early if we don't want to initialize the public side.
	if ( ! apply_filters( 'nice_likes_plugin_public_init', true ) ) {
		return;
	}

	// Initialize a counter to check if this function is being called more than once.
	static $i = 0;

	/**
	 * Trigger error if this function is being called recursively.
	 */
	if ( $i ) {
		_nice_likes_doing_it_wrong( __FUNCTION__, esc_html__( 'This function should not be called more than once. Please hook your actions to nice_likes_plugin_public_after_init in order to prevent recursion.', 'nice-likes' ) );
	}

	// Update counter.
	$i++;

	/**
	 * @hook nice_likes_plugin_public_before_init
	 *
	 * Process actions before the main public object gets initialized.
	 *
	 * Functions and methods that use internal functionality of the
	 * Nice_Likes_Public domain should not be hooked here in order to
	 * prevent recursion.
	 *
	 * @since 1.0
	 */
	do_action( 'nice_likes_plugin_public_before_init' );

	/**
	 * Initialize public instance.
	 */
	$public = nice_likes_plugin_public();

	/**
	 * @hook nice_likes_plugin_public_after_init
	 *
	 * Process actions after the main public object gets initialized.
	 *
	 * Functions and methods that use internal functionality of the
	 * Nice_Likes_Public domain are safe from recursion and can be hooked
	 * from this point on.
	 *
	 * @since 1.0
	 *
	 * Hooked here:
	 * @see nice_likes_display() - 10 (processes the views for the public-facing side of the plugin)
	 */
	do_action( 'nice_likes_plugin_public_after_init', $public );
}

/**
 * Obtain an instance of this domain's service.
 *
 * @since  1.0
 *
 * @return Nice_Likes_Service
 */
function nice_likes_public_service() {
	return nice_likes_service( 'Nice_Likes_Public' );
}

/**
 * Get the value for a property of the current plugin instance.
 *
 * @uses   nice_likes_plugin_public()
 *
 * @since  1.0
 *
 * @param  string $property Name of the property to get value from.
 *
 * @return mixed
 */
function nice_likes_plugin_public_property( $property ) {
	$public = nice_likes_plugin_public();

	if ( $property && property_exists( $public, $property ) ) {
		return $public->{$property};
	}

	return null;
}

/**
 * Check if we're running a registered shortcode.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_doing_shortcode() {
	$current_shortcode = nice_likes_current_shortcode();
	return ( ! empty( $current_shortcode ) );
}

/**
 * Obtain the name of the current shortcode, if registered.
 *
 * @since  1.0
 *
 * @return Nice_Likes_WP_Shortcode|null
 */
function nice_likes_current_shortcode() {
	return nice_likes_plugin_public_property( 'current_shortcode' );
}

/**
 * Register the name of the current shortcode.
 *
 * This function is meant to be applied as soon as possible inside the function
 * or method that processes the shortcode.
 *
 * @since 1.0
 *
 * @param string $name
 */
function nice_likes_set_current_shortcode( $name ) {
	nice_likes_update( nice_likes_plugin_public(), array( 'current_shortcode' => $name ) );
}

/**
 * Unset the current shortcode.
 *
 * This function is meant to be applied inside the function or method that
 * processes the shortcode, at some point after using
 * `nice_likes_set_current_shortcode()` and before returning its output.
 *
 * @see   nice_likes_set_current_shortcode()
 *
 * @since 1.0
 */
function nice_likes_unset_current_shortcode() {
	nice_likes_update( nice_likes_plugin_public(), array( 'current_shortcode' => null ) );
}

/**
 * Check if we're running a registered widget.
 *
 * @since  1.0
 *
 * @return bool
 */
function nice_likes_doing_widget() {
	$current_widget = nice_likes_current_widget();
	return ( ! empty( $current_widget ) );
}

/**
 * Obtain the name of the current widget, if registered.
 *
 * @since  1.0
 *
 * @return Nice_Likes_WP_Widget|null
 */
function nice_likes_current_widget() {
	return nice_likes_plugin_public_property( 'current_widget' );
}

/**
 * Register the name of the current widget.
 *
 * This function is meant to be applied as soon as possible inside the function
 * or method that processes the widget.
 *
 * @since 1.0
 *
 * @param string $name
 */
function nice_likes_set_current_widget( $name ) {
	nice_likes_update( nice_likes_plugin_public(), array( 'current_widget' => $name ) );
}

/**
 * Unset the current widget.
 *
 * This function is meant to be applied inside the function or method that
 * processes the widget, at some point after using
 * `nice_likes_set_current_widget()` and before returning its output.
 *
 * @see   nice_likes_set_current_widget()
 *
 * @since 1.0
 */
function nice_likes_unset_current_widget() {
	nice_likes_update( nice_likes_plugin_public(), array( 'current_widget' => null ) );
}
