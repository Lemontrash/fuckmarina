<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Likes_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Interface Nice_Likes_FactoryInterface
 *
 * @package Nice_Likes_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
interface Nice_Likes_FactoryInterface {
	/**
	 * Create an instance instance of a given class.
	 *
	 * @since  1.0
	 *
	 * @param  array                          $data Information for the new instance.
	 *
	 * @return Nice_Likes_EntityInterface
	 */
	public static function create( array $data );
}
