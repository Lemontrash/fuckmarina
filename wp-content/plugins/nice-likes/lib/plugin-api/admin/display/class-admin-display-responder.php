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
 * Class Nice_Likes_AdminDisplayResponder
 *
 * This class takes charge of the Nice_Likes_Admin instances to be
 * displayed through WordPress APIs.
 *
 * @since 1.0
 */
class Nice_Likes_AdminDisplayResponder extends Nice_Likes_DisplayResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * Add an action link in the list of plugins pointing to the options page.
		 */
		add_filter( 'plugin_action_links_' . nice_likes_plugin_basename(), array( $this, 'add_action_links' ) );

		/**
		 * Load plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		/**
		 * Load plugin scripts.
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Add action links in list of plugins.
	 *
	 * @param  array      $links
	 *
	 * @return mixed|void
	 */
	public function add_action_links( $links ) {
		return apply_filters( 'nice_likes_admin_action_links', $links, $this->data->get_info() );
	}

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since 1.0
	 */
	public function enqueue_styles() {
		do_action( 'nice_likes_admin_enqueue_styles', $this->data->get_info() );
	}

	/**
	 * Register and enqueue public-facing JavaScript files.
	 *
	 * @since  1.0
	 */
	public function enqueue_scripts() {
		do_action( 'nice_likes_admin_enqueue_scripts', $this->data->get_info() );
	}
}
