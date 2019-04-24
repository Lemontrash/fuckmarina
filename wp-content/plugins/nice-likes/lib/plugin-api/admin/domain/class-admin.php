<?php
/**
* NiceThemes Plugin API
*
* @package Nice_Likes_Plugin_API
* @since   1.0
*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_Admin
 *
 * Main plugin class for admin facing side of WordPress plugins.
 *
 * @since 1.0
 */
class Nice_Likes_Admin extends Nice_Likes_Entity {
	/**
	 * List of admin-side representations of custom post types.
	 *
	 * @see   Nice_Likes_Post_Type_Admin
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $post_types = array();

	/**
	 * List of meta boxes associated to the current object.
	 *
	 * @see   Nice_Likes_Metabox
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $metaboxes = array();

	/**
	 * Instance of admin UI associated to the plugin.
	 *
	 * @var   Nice_Likes_Admin_UI
	 * @since 1.0
	 */
	protected $ui;

	/**
	 * Admin help pointers for the current instance.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_Pointer_Collection
	 */
	protected $pointer_collection;

	/**
	 * Name of the current widget being processed.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_WP_Widget|null
	 */
	protected $current_widget = null;

	/**
	 * Full path to the folder where templates are located.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $templates_path;

	/**
	 * Plugin installation info.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $installation_errors;

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since 1.0
	 *
	 * @param array $data Information for instance properties.
	 */
	public function __construct( array $data ) {
		if ( ! is_admin() ) {
			return;
		}

		parent::__construct( $data );
	}
}
