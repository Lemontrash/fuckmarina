<?php
/**
 * NiceThemes Plugin API
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
 * Class Nice_Likes_Context_Handler
 *
 * This class allows to know the context where a process is being executed.
 *
 * @property-read string $context
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Context_Handler {
	/**
	 * Name of the object's context.
	 *
	 * @since 1.0
	 *
	 * @var null|string
	 */
	protected $context = null;

	/**
	 * Obtain the value of a property.
	 *
	 * @since  1.0
	 *
	 * @param  string $property
	 *
	 * @return null|string
	 */
	public function __get( $property ) {
		if ( method_exists( $this, 'get_' . $property ) ) {
			return call_user_func( array( $this, 'get_' . $property ) );
		}

		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		return null;
	}

	/**
	 * Obtain the current context, and update if necessary.
	 *
	 * @since 1.0
	 *
	 * @return null|string
	 */
	protected function get_context() {
		$current_context = $this->get_current_context();

		/**
		 * Update context if the saved value and the actual current context are
		 * different.
		 */
		if ( $this->context !== $current_context ) {
			$this->context = $current_context;
		}

		return $this->context;
	}

	/**
	 * Obtain the current actual context.
	 *
	 * @since  1.0
	 *
	 * @return null|string
	 */
	protected function get_current_context() {
		$context = null;

		if ( function_exists( 'nice_likes_doing_shortcode' ) && nice_likes_doing_shortcode() ) {
			$context = 'shortcode';
		}

		if ( is_null( $context ) && function_exists( 'nice_likes_doing_widget' ) && nice_likes_doing_widget() ) {
			$context = 'widget';
		}

		if ( is_null( $context ) ) {
			$context = 'global';
		}

		return $context;
	}
}
