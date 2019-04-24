<?php
/**
 * NiceThemes Plugin API
 *
 * This file contains general functions that allow interactions with
 * this helper in an easier way.
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
 * Load the highest priority template found with the given name.
 *
 * @since 1.0
 *
 * @param string $template Name of the template (including extension) to be loaded.
 */
function nice_likes_get_template( $template ) {
	Nice_Likes_Template_Handler::get_template( $template );
}

/**
 * Retrieve a template part.
 *
 * @uses   Nice_Likes_Template_Handler::get_template_part
 *
 * @since  1.0
 *
 * @param  string $slug
 * @param  string $name Optional. Default null
 * @param  bool   $load
 *
 * @return string
 */
function nice_likes_get_template_part( $slug, $name = null, $load = true ) {
	return Nice_Likes_Template_Handler::get_template_part( $slug, $name, $load );
}

/**
 * Output a partial template.
 *
 * @since  1.0
 *
 * @uses   Nice_Likes_Admin_Template_Handler::get_template_part()
 *
 * @param  string            $template
 * @param  string            $part
 * @param  bool              $return
 * @param  array             $extract
 *
 * @return mixed|void|string           String if `$return` is set to `true`.
 */
function nice_likes_admin_get_template_part( $template, $part = '', $return = false, $extract = null ) {
	$template_part = Nice_Likes_Admin_Template_Handler::get_template_part(
		nice_likes_plugin_admin(), $template, $part, $return, $extract
	);

	if ( $return ) {
		return $template_part;
	}

	return null;
}

/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * @uses   Nice_Likes_Template_Handler::locate_template()
 *
 * @since  1.0
 *
 * @param  string|array $template_names  Template file(s) to search for, in order.
 * @param  bool         $load            If true the template file will be loaded if it is found.
 * @param  bool         $require_once    Whether to require_once or require. Default true.
 *                                       Has no effect if $load is false.
 *
 * @return string                        The template filename if one is located.
 */
function nice_likes_locate_template( $template_names, $load = false, $require_once = true ) {
	return Nice_Likes_Template_Handler::locate_template( $template_names, $load, $require_once );
}

/**
 * Load an HTML template for the admin-facing side of the plugin.
 *
 * @uses   Nice_Likes_Admin_Template_Handler::load_template(
 * @since  1.0
 *
 * @param  string $file_path
 * @param  array  $extract
 *
 * @return bool              `true` if the file could be loaded, else `false`.
 */
function nice_likes_admin_load_template( $file_path, $extract = null ) {
	return Nice_Likes_Admin_Template_Handler::load_template( $file_path, $extract );
}
