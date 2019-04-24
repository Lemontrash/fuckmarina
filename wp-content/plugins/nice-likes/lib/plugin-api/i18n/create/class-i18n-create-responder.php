<?php
/**
 * NiceThemes Plugin API
 *
 * @package Nice_Likes_Plugin_API
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_i18nDisplayResponder
 *
 * This class takes charge of the Nice_Likes_i18n instances to be
 * displayed through WordPress APIs.
 *
 * @since 1.0
 */
class Nice_Likes_i18nCreateResponder extends Nice_Likes_CreateResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * Load text domain.
		 */
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Load the a text domain for translation.
	 *
	 * @since 1.0
	 */
	public function load_textdomain() {
		// Obtain data for text domain loading.
		$data = $this->data->get_info( true );

		// Construct name of compiled language file.
		$mofile = trailingslashit( WP_LANG_DIR ) . $data['domain'] . '/' . $data['domain'] . '-' . $data['locale'] . '.mo';

		// Load global textdomain.
		load_textdomain( $data['domain'], $mofile );

		// Load bundled textdomain.
		load_plugin_textdomain( $data['domain'], false, $data['path'] );
	}
}
