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
 * Class Nice_Likes_Plugin_Public
 *
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-admin.php`
 *
 * @index   1.  Properties and Constructor.
 *          2.  Getters.
 *          3.  Basic Implementation of WordPress APIs.
 *          4.  Templating.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Public extends Nice_Likes_Entity {
	/**
	 * Name of the current shortcode being processed.
	 *
	 * @var Nice_Likes_WP_Shortcode|null
	 */
	protected $current_shortcode = null;

	/**
	 * Name of the current widget being processed.
	 *
	 * @var Nice_Likes_WP_Widget|null
	 */
	protected $current_widget = null;
}
