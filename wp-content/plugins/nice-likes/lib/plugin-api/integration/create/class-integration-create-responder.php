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
 * Class Nice_Likes_IntegrationCreateResponder
 *
 * This class takes charge of the interaction of created
 * Nice_Likes_Integration instances with WordPress APIs.
 *
 * @see   Nice_Likes_Integration
 *
 * @since 1.0
 */
class Nice_Likes_IntegrationCreateResponder extends Nice_Likes_CreateResponder {
	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		$data = $this->data->get_info();
		$action = $this->domain . '_' . $data->name . '_created';

		/**
		 * Process the current integration and load it when needed.
		 */
		add_action( $action, array( $this, 'process_integration' ) );

		/**
		 * Fire default behavior.
		 */
		parent::set_interactions();
	}

	/**
	 * Process the newly created integration and hook it to a given action or
	 * load it directly.
	 *
	 * @since 1.0
	 */
	public function process_integration() {
		$data = $this->data->get_info();

		if ( $data->action ) {
			add_action( $data->action, array( $this, 'load_integration' ), $data->priority );

		} elseif ( function_exists( $data->function_exists ) || class_exists( $data->class_exists ) || $data->load ) {
			/**
			 * If an action has not been specified, the following cases are
			 * valid to load it directly in the current context.
			 *
			 * - The integrated application has already been loaded and a function with the given name was declared.
			 * - The integrated application has already been loaded and a class with the given name was declared.
			 * - The loading process is forced by setting the `load` property to true.
			 */
			$this->load_integration();
		}

		$processed[ $data->name ] = true;
	}

	/**
	 * Load the integration (recursively) if its path is valid.
	 *
	 * If the path is a directory, it will be loaded recursively.
	 *
	 * @uses  nice_likes_autoload()
	 *
	 * @since 1.0
	 */
	public function load_integration() {
		$data = $this->data->get_info();
		$load = false;

		/**
		 * Load directly if we don't have an action set for this integration.
		 */
		if ( ! $data->action ) {
			$load = true;
		}

		/**
		 * If an action has been specified, the following cases are valid
		 * to hook it.
		 *
		 * - The loading process is turned on using a callback that return a boolean.
		 * - The integrated application has already been loaded and a function with the given name was declared.
		 * - The integrated application has already been loaded and a class with the given name was declared.
		 * - The loading process is forced by setting the `load` property to true.
		 */
		if (    current_filter() === $data->action
		     && (   $data->callback && call_user_func( $data->callback )
		         || function_exists( $data->function_exists )
		         || class_exists( $data->class_exists )
		         || $data->load
		        )
		) {
			$load = true;
		}

		if ( $load && file_exists( $data->path ) ) {
			nice_likes_autoload( $data->path );
		}
	}

	/**
	 * Override parent loaded() method.
	 *
	 * @since 1.0
	 */
	protected function loaded() {
		$data = $this->data->get_info();
		$action = $this->domain . '_' . $data->name . '_created';

		/**
		 * Hook actions here.
		 */
		do_action( $action, $this->data );
	}
}
