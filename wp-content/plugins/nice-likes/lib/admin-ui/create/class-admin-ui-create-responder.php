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
 * Class Nice_Likes_Admin_UICreateResponder
 *
 * This class takes charge of the interaction of created Nice_Likes_Admin_UI
 * instances with WordPress APIs.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UICreateResponder extends Nice_Likes_CreateResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * Get instance data.
		 */
		$data = $this->data->get_info();

		/**
		 * Efficiently process settings when updating. Specially useful to
		 * prevent removal of settings from different tabs.
		 *
		 * @see update_option()
		 */
		add_filter( 'pre_update_option_' . $data->settings_name, array( __CLASS__, 'update_option' ), 10, 2 );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Prevent removal of settings from different tabs when updating.
	 *
	 * @since  1.0
	 *
	 * @param  array|mixed|void $value      Posted value.
	 * @param  array|mixed|void $old_value  Previous state of value.
	 * @return array|mixed|void             Filtered value.
	 */
	public static function update_option( $value, $old_value ) {
		return wp_parse_args( $value, $old_value );
	}
}
