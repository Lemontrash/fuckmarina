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
 * Obtain the current context where a process is being executed.
 *
 * @since  1.0
 *
 * @return null|string
 */
function nice_likes_context() {
	static $handler = null;

	if ( is_null( $handler ) ) {
		$handler = new Nice_Likes_Context_Handler();
	}

	return apply_filters( 'nice_likes_context', $handler->context );
}
