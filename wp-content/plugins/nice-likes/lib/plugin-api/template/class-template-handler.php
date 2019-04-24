<?php
/**
 * NiceThemes Plugin API
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
 * Class Nice_Likes_Template_Handler
 *
 * Set of methods for template management.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Template_Handler {
	/**
	 * Retrieves a template part.
	 *
	 * Taken from bbPress & EDD.
	 *
	 * @since 1.0
	 *
	 * @param  string $slug
	 * @param  string $name Optional. Default null
	 * @param  bool   $load
	 * @return string
	 */
	public static function get_template_part( $slug, $name = null, $load = true ) {
		// Execute code for this part.
		do_action( 'nice_likes_get_template_part_' . $slug, $slug, $name );

		// Setup possible parts.
		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = $slug . '-' . $name . '.php';
		}
		$templates[] = $slug . '.php';

		// Allow template parts to be filtered
		$templates = apply_filters( 'nice_likes_get_template_part', $templates, $slug, $name );

		$located_template = self::locate_template( $templates, $load, false );
		$located_template = apply_filters( 'nice_likes_located_template', $located_template );

		return $located_template;
	}

	/**
	 * Load the highest priority template found with the given name.
	 *
	 * @since 1.0
	 *
	 * @param string $template Name of the template (including extension) to be loaded.
	 */
	public static function get_template( $template ) {
		self::locate_template( $template, true, false );
	}

	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
	 * inherit from a parent theme can just overload one file. If the template is
	 * not found in either of those, it looks in the theme-compat folder last.
	 *
	 * Taken from bbPress & EDD.
	 *
	 * @since  1.0
	 *
	 * @param  string|array $template_names  Template file(s) to search for, in order.
	 * @param  bool         $load            If true the template file will be loaded if it is found.
	 * @param  bool         $require_once    Whether to require_once or require. Default true.
	 *                                       Has no effect if $load is false.
	 * @return string                        The template filename if one is located.
	 */
	public static function locate_template( $template_names, $load = false, $require_once = true ) {
		// Try to find a template file
		foreach ( (array) $template_names as $template_name ) {

			// Continue if template is empty
			if ( empty( $template_name ) ) {
				continue;
			}

			// Trim off any slashes from the template name.
			$template_name = ltrim( $template_name, '/' );

			// Try locating this template file by looping through the template paths.
			foreach ( self::get_theme_template_paths() as $template_path ) {
				if ( file_exists( $template_path . $template_name ) ) {
					$located = $template_path . $template_name;
					break;
				}
			}

			if ( isset( $located ) ) {
				break;
			}
		}

		if ( ( true === $load ) && ! empty( $located ) ) {
			load_template( $located, $require_once );
		}

		return $located;
	}

	/**
	 * Returns a list of paths to check for template locations.
	 *
	 * @since 1.0
	 */
	public static function get_theme_template_paths() {
		$template_dir = self::get_theme_template_dir_name();

		$file_paths = array(
			1   => trailingslashit( get_stylesheet_directory() ) . $template_dir,
			10  => trailingslashit( get_template_directory() ) . $template_dir,
			100 => self::get_templates_dir(),
		);

		$file_paths = apply_filters( 'nice_likes_template_paths', $file_paths );

		// sort the file paths based on priority
		ksort( $file_paths, SORT_NUMERIC );

		$template_paths = array_map( 'trailingslashit', $file_paths );
		$template_paths = apply_filters( 'nice_likes_template_paths', $template_paths );

		return $template_paths;
	}

	/**
	 * Returns the path to the plugin templates directory
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function get_templates_dir() {
		// Allow by-pass.
		if ( $templates_path = apply_filters( 'nice_likes_get_templates_dir', '' ) ) {
			return trailingslashit( $templates_path );
		}

		if ( defined( 'NICE_LIKES_TEMPLATES_PATH' ) && NICE_LIKES_TEMPLATES_PATH ) {
			return trailingslashit( NICE_LIKES_TEMPLATES_PATH );
		}

		$templates_path = realpath( plugin_dir_path( __FILE__ ) . '../public/templates' );

		return $templates_path;
	}

	/**
	 * Returns the template directory name.
	 *
	 * Themes can filter this by using the nice_likes_templates_dir filter.
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	public static function get_theme_template_dir_name() {
		$templates_dir = apply_filters( 'nice_likes_templates_dir', nice_likes_textdomain() );
		return trailingslashit( $templates_dir );
	}
}
