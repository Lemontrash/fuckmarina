<?php
/**
 * NiceThemes Plugin API
 *
 * @package Nice_Likes_Plugin_API
 * @license GPL-2.0+
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Nice_Likes_WP_Shortcode
 *
 * This class serves as a model for shortcodes.
 *
 * @since 1.0
 *
 * @property-read $output
 * @property-read $atts
 * @property-read $query_args
 */
abstract class Nice_Likes_WP_Shortcode {
	/**
	 * Name of the shortcode.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $name = '';

	/**
	 * Unique ID of the current instance.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $id = '';

	/**
	 * Attributes to construct the output.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $atts = array();

	/**
	 * Name of the template that will be used to display the output.
	 *
	 * @since 1.0
	 * @var   null
	 */
	public $template = null;

	/**
	 * Content entered by the user.
	 *
	 * @since 1.0
	 * @var   null
	 */
	protected $content = null;

	/**
	 * HTML to be printed publicly.
	 *
	 * @since 1.0
	 * @var   null
	 */
	protected $output = null;

	/**
	 * Set up initial data.
	 *
	 * @since 1.0
	 *
	 * @param array  $atts
	 * @param null   $content
	 * @param string $name
	 */
	public function __construct( array $atts = array(), $content = null, $name = '' ) {
		$this->name    = $name;
		$this->id      = sanitize_title( $name ) . '-' . rand( 1000, 9999 ). '-' . rand( 1000, 9999 );
		$this->atts    = $this->sanitize_atts( $atts );
		$this->content = $content;
	}

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
	 * Sanitize attributes to construct the output.
	 *
	 * @since  1.0
	 *
	 * @param  array            $atts
	 *
	 * @return array|mixed|void
	 */
	protected function sanitize_atts( array $atts = array() ) {
		$default_atts = $this->get_default_atts();

		$atts = shortcode_atts( ! empty( $default_atts ) ? $default_atts : $atts, $atts, $this->name );

		return $atts;
	}

	/**
	 * Obtain default attributes to generate the output.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected function get_default_atts() {
		return array();
	}

	/**
	 * Obtain the output of the shortcode.
	 *
	 * @since  1.0
	 *
	 * @return null|string
	 */
	public function get_output() {
		if ( is_null( $this->output ) ) {
			$this->set_output();
		}

		return $this->output;
	}

	/**
	 * Generate the output of the shortcode.
	 *
	 * @since  1.0
	 *
	 * @return null|string
	 */
	protected function set_output() {
		/**
		 * Indicate that a shortcode is being processed, so we can execute
		 * processes in a different context during the output runtime.
		 */
		nice_likes_set_current_shortcode( $this );

		/**
		 * We're gonna print HTML directly, so we need to buffer the output.
		 */
		ob_start();

		/**
		 * Load template for the shortcode.
		 */
		nice_likes_get_template( $this->template );

		// Save contents and free buffer.
		$this->output = ob_get_contents();
		ob_end_clean();

		/**
		 * Unset the shortcode.
		 */
		nice_likes_unset_current_shortcode();
	}
}
