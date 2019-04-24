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
 * Class Nice_Likes_ResponderAbstract
 *
 * This class takes charge of interactions between instances of action classes
 * and WordPress APIs.
 *
 * @since 1.0
 */
abstract class Nice_Likes_ResponderAbstract implements Nice_Likes_ResponderInterface {
	/**
	 * Current Nice_Likes_Entity instance.
	 *
	 * @var   Nice_Likes_EntityInterface
	 * @since 1.0
	 */
	protected $data;

	/**
	 * Domain name to create hooks dynamically.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $domain;

	/**
	 * Fire main responder functionality.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_EntityInterface $instance
	 */
	public function __invoke( Nice_Likes_EntityInterface $instance ) {
		/**
		 * Set responder data.
		 */
		$this->set_data( $instance );

		/**
		 * Set responder domain.
		 */
		$this->set_domain( $instance );

		/**
		 * Perform actions before setting API interactions.
		 */
		$this->before_interactions();

		/**
		 * Schedule interactions with WordPress APIs.
		 */
		$this->set_interactions();

		/**
		 * Autoload required public libraries.
		 */
		$this->load_libraries();

		/**
		 * Fire actions once everything is loaded.
		 */
		$this->loaded();

		/**
		 * Remove interactions to prevent them from loading again.
		 *
		 * @since 1.0
		 */
		$this->remove_interactions();
	}

	/**
	 * Obtain the current value of a property.
	 *
	 * @since  1.0
	 *
	 * @param  string     $property Name of a property of this class.
	 *
	 * @return mixed|void           Current value for the requested property.
	 */
	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		return null;
	}

	/**
	 * Set responder data.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_EntityInterface $data Current Nice_Likes_EntityInterface instance.
	 */
	protected function set_data( Nice_Likes_EntityInterface $data ) {
		/**
		 * Set current state of data.
		 */
		$this->data = $data;
	}

	/**
	 * Set domain.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_EntityInterface $instance
	 */
	protected function set_domain( Nice_Likes_EntityInterface $instance ) {
		/**
		 * Set current state of data.
		 */
		$this->domain = strtolower( get_class( $instance ) );
	}

	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		do_action( $this->domain . '_set_interactions', $this->data );
	}

	/**
	 * Perform actions before setting API interactions.
	 *
	 * @since 1.0
	 */
	protected function before_interactions() {
		// Nothing here yet, just a placeholder to allow this method to be extended.
	}

	/**
	 * Autoload required libraries.
	 *
	 * @since 1.0
	 */
	protected function load_libraries() {
		// Nothing here yet, just a placeholder to allow this method to be extended.
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
		do_action( $this->domain . '_loaded', $this->data );
	}

	/**
	 * Remove interactions to prevent them from loading again.
	 *
	 * @since 1.0
	 */
	protected function remove_interactions() {
		// Nothing here yet, just a placeholder to allow this method to be extended.
	}
}
