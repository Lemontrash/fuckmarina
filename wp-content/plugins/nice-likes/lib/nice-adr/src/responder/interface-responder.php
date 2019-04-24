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
 * Interface Nice_Likes_ResponderInterface
 *
 * @package Nice_Likes_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
interface Nice_Likes_ResponderInterface {
	/**
	 * Fire main responder functionality.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_EntityInterface $instance
	 */
	public function __invoke( Nice_Likes_EntityInterface $instance );
}
