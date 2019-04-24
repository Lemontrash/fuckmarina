<?php
/**
 * NiceThemes Plugin API
 *
 * This file hooks processes to internal actions within this domain.
 *
 * @package Nice_Likes_Plugin
 * @license GPL-2.0+
 * @since   1.1
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fire the display action for this domain once a collection of pointers has
 * been created.
 *
 * @since 1.0
 *
 * @uses  nice_likes_display()
 *
 * Hook origin:
 * @see Nice_Likes_Pointer_CollectionCreateResponder::loaded()
 */
add_action( 'nice_likes_pointer_collection_created', 'nice_likes_display' );
