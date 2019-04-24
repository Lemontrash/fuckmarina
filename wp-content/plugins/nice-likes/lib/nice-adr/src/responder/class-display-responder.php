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
 * Class Nice_Likes_DisplayResponder
 *
 * This class takes charge of interactions between instances of action classes
 * and WordPress APIs. It's meant to be used as a default class for domains
 * that, while needing to implement a Display action, don't need any specific
 * functionality for it.
 *
 * @since 1.0
 */
class Nice_Likes_DisplayResponder extends Nice_Likes_ResponderAbstract {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		do_action( $this->domain . '_display_set_interactions', $this->data );
	}

	/**
	 * Allow other plugins to hook in here.
	 *
	 * @since 1.0
	 */
	protected function loaded() {
		/**
		 * Hook actions here.
		 */
		do_action( $this->domain . '_display', $this->data );
	}
}
