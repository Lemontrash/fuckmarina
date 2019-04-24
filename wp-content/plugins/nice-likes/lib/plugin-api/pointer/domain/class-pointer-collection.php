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

if ( ! class_exists( 'Nice_Likes_Pointer_Collection' ) ) :
/**
 * Class Nice_Likes_Pointer_Collection
 *
 * Create admin pointers for contextual help.
 *
 * Pointers are defined in an associative array and passed to the class upon instantiation.
 *
 * How to use:
 *
	// First we hook into the 'admin_enqueue_scripts' hook with our function.
	add_action('admin_enqueue_scripts', 'add_help_pointers' );
	function add_help_pointers() {
		//First we define our pointers.
		$pointers = array(
			array(
				'id' => 'xyz123',   // unique id for this pointer
				'screen' => 'page', // this is the page hook we want our pointer to show on
				'target' => '#element-selector', // the css selector for the pointer to be tied to, best to use ID's
				'title' => 'My ToolTip',
				'content' => 'My tooltips Description',
				'position' => array(
					'edge' => 'top', //top, bottom, left, right
					'align' => 'middle', //top, bottom, left, right, middle
				),
			),
			// More as needed ...
		);
		// Now we instantiate the class and pass our pointer array to the constructor.
		$pointers = new WP_Help_Pointer( $pointers );
	}

 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @credits Original code by Tim Debo <tim@rawcreativestudios.com>
 *          https://github.com/rawcreative/wp-help-pointers
 */
class Nice_Likes_Pointer_Collection extends Nice_Likes_Entity {
	/**
	 * List of Nice_Likes_Pointer instances.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $pointers;

	/**
	 * List of valid pointers to be displayed in the current screen.
	 *
	 * @since 1.0
	 * @var   array
	 */
	private $valid;
}
endif;
