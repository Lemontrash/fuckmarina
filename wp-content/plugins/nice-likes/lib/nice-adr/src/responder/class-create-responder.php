<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Likes_ADR
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_CreateResponder
 *
 * This class takes charge of interactions between instances of action classes
 * and WordPress APIs. It's meant to be used as a default class for domains
 * that, while needing to implement a Create action, don't need any specific
 * functionality for it.
 *
 * @since 1.0
 */
class Nice_Likes_CreateResponder extends Nice_Likes_ResponderAbstract {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * @hook {domain_name}_create_set_interactions
		 *
		 * Actions that need to interact with the WordPress API should be
		 * hooked here.
		 *
		 * @since 1.0
		 */
		do_action( $this->domain . '_create_set_interactions', $this->data );
	}

	/**
	 * Autoload required libraries.
	 *
	 * @since 1.0
	 */
	protected function load_libraries() {
		nice_likes_autoload_libraries( apply_filters( $this->domain . '_libraries', array(), $this->data ) );
	}

	/**
	 * Allow other plugins to hook in here.
	 *
	 * @since 1.0
	 */
	protected function loaded() {
		/**
		 * @hook {domain_name}_created
		 *
		 * All actions that need to be fired after all the logic of the
		 * domain's responder, but before the main object of the domain has
		 * been fully initialized, should be hooked here.
		 *
		 * @since 1.0
		 */
		do_action( $this->domain . '_created', $this->data );
	}
}
