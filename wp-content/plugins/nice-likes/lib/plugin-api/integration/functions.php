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

if ( ! function_exists( 'nice_likes_integration_create' ) ) :
/**
 * Create and obtain a new instance of Nice_Likes_Integration.
 *
 * @since  1.0
 *
 * @uses   nice_likes_create()
 *
 * @param  array $data Data to create the new instance.
 *
 * @return Nice_Likes_Integration
 */
function nice_likes_integration_create( array $data ) {
	return nice_likes_create( 'Nice_Likes_Integration', $data );
}
endif;
