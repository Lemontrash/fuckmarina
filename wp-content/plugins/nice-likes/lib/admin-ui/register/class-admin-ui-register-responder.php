<?php
/**
 * NiceThemes Admin UI
 *
 * @package Nice_Likes_Admin_UI
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_Admin_UIRegisterResponder
 *
 * This class takes charge of interactions between instances of register actions
 * and WordPress APIs.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UIRegisterResponder extends Nice_Likes_ResponderAbstract {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * @hook nice_likes_admin_ui_register_set_interactions
		 *
		 * Actions that need to interact with the WordPress API should be
		 * hooked here.
		 *
		 * @since 1.0
		 */
		do_action( 'nice_likes_admin_ui_register_set_interactions', $this->data );
	}

	/**
	 * Allow other plugins to hook in here.
	 *
	 * @since 1.0
	 */
	protected function loaded() {
		/**
		 * @hook nice_likes_admin_ui_registered
		 *
		 * All actions that need to be fired after all the logic of the
		 * domain's responder has been processed should be hooked here.
		 *
		 * @since 1.0
		 */
		do_action( 'nice_likes_admin_ui_registered', $this->data );
	}
}
