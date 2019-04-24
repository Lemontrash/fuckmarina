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
 * Class Nice_Likes_Pointer_CollectionDisplayResponder
 *
 * This class takes charge of the Nice_Likes_Pointer_Collection instances
 * to be displayed through WordPress APIs.
 *
 * @since   1.0
 */
class Nice_Likes_Pointer_CollectionDisplayResponder extends Nice_Likes_DisplayResponder {
	/**
	 * List of valid pointers to be displayed in the current screen.
	 *
	 * @since 1.0
	 * @var   array
	 */
	private $valid;

	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * Populate internal data.
		 */
		add_action( 'current_screen', array( $this, 'process_pointers' ) );

		/**
		 * Return early if pointers are not supported. All internal data was
		 * already initialized at this point.
		 */
		if ( ! self::pointers_supported() ) {
			return;
		}

		/**
		 * Enqueue scripts at a late point.
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), 1000 );

		/**
		 * Add custom scripts.
		 */
		add_action( 'admin_head', array( $this, 'add_scripts' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Check if pointers are allowed in the current environment.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	private static function pointers_supported() {
		global $wp_version;

		/**
		 * Check if the current version of WordPress supports admin pointers.
		 */
		if ( version_compare( $wp_version, '3.3', '<' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Set the list of pointers to show in the current screen.
	 *
	 * @see    Nice_Likes_Pointer_CollectionCreateResponder::get_formatted_pointers()
	 *
	 * @since  1.0
	 *
	 * @param  WP_Screen $current_screen
	 */
	public function process_pointers( WP_Screen $current_screen ) {
		$data = $this->data->get_info();

		// Return null if we don't have pointers.
		if ( empty( $data->pointers ) ) {
			return;
		}

		$pointers = $this->get_formatted_pointers( $current_screen );

		/**
		 * Get dismissed pointers.
		 */
		$dismissed = self::get_dismissed();

		/**
		 * Initialize list holder.
		 */
		$valid_pointers = array();

		/**
		 * Check pointers and remove dismissed ones.
		 */
		foreach ( $pointers as $pointer_id => $pointer ) {
			/**
			 * Check if the current pointer has data or has been dismissed.
			 */
			if (   in_array( $pointer_id, $dismissed, true )
			       || empty( $pointer )
			       || empty( $pointer_id )
			       || empty( $pointer['target'] )
			       || empty( $pointer['options'] )
			) {
				continue;
			}

			$pointer['pointer_id'] = $pointer_id;

			// Add the pointer to $valid_pointers array.
			$valid_pointers['pointers'][] = $pointer;
		}

		// No valid pointers? Stop here.
		if ( empty( $valid_pointers ) ) {
			return;
		}

		$this->valid = $valid_pointers;
	}

	/**
	 * Add scripts to handle front-end functionality.
	 *
	 * @since 1.0
	 */
	public function enqueue_scripts() {
		// Return early if we don't have any valid pointers.
		if ( empty( $this->valid ) ) {
			return;
		}

		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_style( 'wp-pointer' );
	}

	/**
	 * Print custom scripts to handle pointers.
	 *
	 * @since 1.0
	 */
	public function add_scripts() {
		// Return early if we don't have any valid pointers.
		if ( empty( $this->valid ) ) {
			return;
		}

		?>
		<script>
			jQuery( document ).ready( function( $ ) {
				var WPHelpPointer = <?php echo wp_json_encode( $this->valid ); ?>;

				$.each( WPHelpPointer.pointers, function ( i ) {
					wp_help_pointer_open( i );
				} );

				function wp_help_pointer_open( i ) {
					var pointer = WPHelpPointer.pointers[ i ],
					    options = $.extend( pointer.options, {
						    close: function() {
							    $.post( ajaxurl, {
								    pointer: pointer.pointer_id,
								    action: 'dismiss-wp-pointer'
							    } );
						    }
					    } );

					$( pointer.target ).pointer( options ).pointer( 'open' );
				}
			} );
		</script>
	<?php
	}

	/**
	 * Obtain list of pointers dismissed by the current user.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	private static function get_dismissed() {
		return explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	}

	/**
	 * Obtain a list of well-formatted pointers to be processed and displayed.
	 *
	 * @since  1.0
	 *
	 * @param  WP_Screen $current_screen
	 *
	 * @return array
	 */
	private function get_formatted_pointers( WP_Screen $current_screen ) {
		$data = $this->data->get_info();

		if ( empty( $data->pointers ) ) {
			return null;
		}

		$pointers = array();

		foreach ( $data->pointers as $pointer ) {
			if ( $pointer->screen === $current_screen->id ) {
				$pointers[ $pointer->id ] = array(
					'screen' => $pointer->screen,
					'target' => $pointer->target,
					'options' => array(
						'content' => sprintf( '<h3> %s </h3> <p> %s </p>',
							$pointer->title,
							$pointer->content
						),
						'position' => $pointer->position,
					),
				);
			}
		}

		return $pointers;
	}
}
