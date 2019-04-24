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
 * Create an admin pointer.
 *
 * @uses   nice_likes_create()
 *
 * @since  1.0
 *
 * @param  array $data Information for the new pointer.
 *
 * @return Nice_Likes_Pointer
 */
function nice_likes_create_pointer( array $data ) {
	return nice_likes_create( 'Nice_Likes_Pointer', $data );
}

/**
 * Create a new collection of pointers.
 *
 * @uses   nice_likes_create()
 *
 * @since  1.0
 *
 * @param  array $pointers List of Nice_Likes_Pointer instances.
 *
 * @return Nice_Likes_Pointer_Collection
 */
function nice_likes_create_pointer_collection( array $pointers = array() ) {
	return nice_likes_create( 'Nice_Likes_Pointer_Collection', array(
			'pointers' => $pointers,
		)
	);
}

/**
 * Obtain an instance of the pointer service.
 *
 * @uses   nice_likes_service()
 *
 * @since  1.0
 *
 * @return Nice_Likes_Service
 */
function nice_likes_pointer_service() {
	return nice_likes_service( 'Nice_Likes_Pointer' );
}

/**
 * Obtain an instance of the pointer collection service.
 *
 * @uses   nice_likes_service()
 *
 * @since  1.0
 *
 * @return Nice_Likes_Pointer_CollectionService
 */
function nice_likes_pointer_collection_service() {
	return nice_likes_service( 'Nice_Likes_Pointer_Collection' );
}

/**
 * Add admin pointers to a previous list.
 *
 * @uses   nice_likes_create_pointer()
 *
 * @since  1.0
 *
 * @param  array $pointers List of pointers.
 * @param  array $data     Information to create new pointers.
 *
 * @return array|null
 */
function nice_likes_add_pointers( array $pointers = null, array $data = null ) {
	if ( empty( $data ) ) {
		return null;
	}

	/**
	 * Try to register new pointers.
	 */
	foreach ( $data as $pointer_data ) {
		// Break iteration in case the current data-set is empty.
		if ( empty( $pointer_data ) ) {
			continue;
		}

		$pointers[] = nice_likes_create_pointer( $pointer_data );
	}

	return $pointers;
}

/**
 * Add a pointer to a specific collection.
 *
 * @uses  Nice_Likes_Pointer_CollectionService::add_pointer()
 *
 * @since 1.0
 *
 * @param Nice_Likes_Pointer_Collection $collection
 * @param Nice_Likes_Pointer            $pointer
 */
function nice_likes_add_pointer( Nice_Likes_Pointer_Collection $collection, Nice_Likes_Pointer $pointer ) {
	static $collection_service = null;

	// Obtain service.
	if ( ! $collection_service ) {
		$collection_service = nice_likes_pointer_collection_service();
	}

	$collection_service->add_pointer( $collection, $pointer );
}

/**
 * Associate a list of pointers to a collection.
 *
 * @uses   nice_likes_create_pointer_collection()
 * @uses   nice_likes_add_pointer()
 *
 * @since  1.0
 *
 * @param  Nice_Likes_Pointer_Collection      $collection
 * @param  array                              $pointers
 *
 * @return Nice_Likes_Pointer_Collection|null
 */
function nice_likes_process_pointer_collection( Nice_Likes_Pointer_Collection $collection = null, array $pointers = null ) {
	if ( empty( $pointers ) ) {
		return null;
	}

	if ( ! $collection ) {
		return nice_likes_create_pointer_collection( $pointers );
	}

	foreach ( $pointers as $pointer ) {
		nice_likes_add_pointer( $collection, $pointer );
	}

	return $collection;
}
