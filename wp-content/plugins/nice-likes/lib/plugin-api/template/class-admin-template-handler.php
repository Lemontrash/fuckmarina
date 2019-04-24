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
 * Class Nice_Likes_Admin_Template_Handler
 *
 * Set of methods for template management.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Admin_Template_Handler {
	/**
	 * Output a partial template.
	 *
	 * @since  1.0
	 *
	 * @uses   Nice_Likes_Admin_Template_Handler::load_template()
	 *
	 * @param  Nice_Likes_Admin $admin
	 * @param  string               $template
	 * @param  string               $part
	 * @param  bool                 $return
	 * @param  array                $extract
	 *
	 * @return mixed|void|string              String if `$return` is set to `true`.
	 */
	public static function get_template_part( Nice_Likes_Admin $admin, $template, $part = '', $return = false, $extract = null ) {
		$templates_path = $admin->{'templates_path'};

		// Run actions before loading template.
		do_action( 'nice_likes_before_template_' . $template, $part );

		/**
		 * Set and check supposed path for template part. If it fails, get path
		 * for template only.
		 */
		$file_path = $templates_path . $template . '-' . $part . '.php';
		if ( ! file_exists( $file_path ) ) {
			$file_path = $templates_path . $template . '.php';
		}

		// Allow path modifications.
		$file_path = apply_filters( 'nice_likes_template_part_file_path', $file_path, $template, $part );

		if ( $return ) {
			ob_start();
		}

		self::load_template( $file_path, $extract );

		// Run actions after loading template.
		do_action( 'nice_likes_after_template_' . $template, $part );

		if ( $return ) {
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}

		return null;
	}

	/**
	 * Load an HTML template.
	 *
	 * @since 1.0
	 *
	 * @param  string $file_path
	 * @param  array  $extract
	 * @return bool              `true` if the file could be loaded, else `false`.
	 */
	public static function load_template( $file_path, $extract = null ) {
		$file_path = apply_filters( 'nice_likes_admin_template_path', $file_path );

		if ( file_exists( $file_path ) ) {
			if ( is_array( $extract ) ) {
				// Extract array keys, so they can be used inside the loaded template.
				extract( $extract );
			}

			require $file_path;

			return true;
		}

		return false;
	}
}
