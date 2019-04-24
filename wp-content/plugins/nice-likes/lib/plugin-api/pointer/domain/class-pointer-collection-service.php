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
 * Class Nice_Likes_Pointer_CollectionService
 *
 * This class deals with typical operations over Nice_Likes_Pointer instances.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Pointer_CollectionService extends Nice_Likes_Service {
	/**
	 * Obtain data for instance initialization.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_init_data() {
		return array(
			'pointers'  => array(),
			'supported' => self::pointers_supported(),
		);
	}

	/**
	 * Check if pointers are allowed in the current environment.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	private static function pointers_supported() {
		global $wp_version;

		/**
		 * Check if the current version of WordPress supports admin pointers.
		 */
		if ( version_compare( $wp_version, '3.3', '<' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Add a pointer to a given collection.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Pointer_Collection $instance
	 * @param Nice_Likes_Pointer            $pointer
	 */
	public function add_pointer(
		Nice_Likes_Pointer_Collection $instance,
		Nice_Likes_Pointer $pointer
	) {
		$data = $instance->get_info( true );
		$data['pointers'][] = $pointer;

		$this->update( $instance, $data );
	}
}
