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
 * Class Nice_Likes_Admin_UIDisplayResponder
 *
 * This class takes charge of the Nice_Likes_Admin_UI instances to be
 * displayed through WordPress APIs.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UIDisplayResponder extends Nice_Likes_DisplayResponder {
	/**
	 * Name of internal hook for the admin page.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $settings_page_slug;

	/**
	 * Schedule interactions with WordPress APIs.
	 *
	 * @since 1.0
	 */
	protected function set_interactions() {
		/**
		 * Schedule creation of submenu page.
		 */
		add_action( 'admin_menu', array( $this, 'add_submenu_page' ) );

		/**
		 * Register settings via the WordPress Settings API.
		 */
		add_action( 'admin_init', array( $this, 'register_api_settings' ) );

		/**
		 * Enqueue scripts.
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_scripts' ) );

		/**
		 * Add special class to body if we're running the MP6 UI.
		 */
		add_filter( 'admin_body_class', array( $this, 'add_body_class' ) );

		/**
		 * Fire default functionality.
		 */
		parent::set_interactions();
	}

	/**
	 * Add plugin options link.
	 *
	 * @since 1.0
	 */
	public function add_submenu_page() {
		$data = $this->data->get_info();

		/**
		 * Add admin page.
		 */
		$this->settings_page_slug = call_user_func_array( 'add_submenu_page', array(
				'parent_slug' => $data->submenu_parent_slug,
				'page_title'  => $data->title,
				'menu_title'  => $data->title,
				'capability'  => $data->capability,
				'menu_slug'   => $data->name,
				'callback'    => array( $this, 'load_settings_page' ),
			)
		);

		/**
		 * Add hook for help tabs.
		 */
		add_action( 'load-' . $this->settings_page_slug, array( $this, 'add_help_tabs' ) );
	}

	/**
	 * Render admin UI options page.
	 *
	 * @since 1.0
	 */
	public function load_settings_page() {
		// Obtain needed data.
		/**
		 * @var Nice_Likes_Admin_UI $data
		 */
		$data    = $this->data;
		$info    = $data->get_info();
		$service = nice_likes_admin_ui_service();

		/**
		 * Load template part using slug of current section.
		 */
		$service::get_template_part( $data, 'options-page', $info->current_section );
	}

	/**
	 * Enqueue back-end scripts and styles into footer.
	 *
	 * @since 1.0
	 */
	public function load_admin_scripts() {
		global $wp_version, $plugin_page, $post;

		/**
		 * Obtain instance data.
		 */
		$data = $this->data->get_info();

		if ( $data->name === $plugin_page ) {
			$plugin_dir_url = plugin_dir_url( __FILE__ );

			/**
			 * Load jQuery if not set yet.
			 */
			wp_enqueue_script( 'jquery' );

			/**
			 * Load jQuery libraries.
			 */
			wp_enqueue_script( 'jquery-ui-accordion' );
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-ui-tooltip' );
			wp_enqueue_script( 'jquery-ui-datepicker' );

			/**
			 * Load color picker.
			 */
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );

			/**
			 * Load media uploader.
			 */
			if (   function_exists( 'wp_enqueue_media' )
			    && version_compare( $wp_version, '3.5', '>=' )
			) {
				// Call for new media manager.
				wp_enqueue_media();
			}
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_style( 'thickbox' );

			/**
			 * Load admin UI script.
			 */
			if ( nice_likes_debug() ) {
				$script = 'nice-likes-admin-ui-script';
				wp_enqueue_script(
					$script,
					nice_likes_canonicalize_url( $plugin_dir_url . '../assets/js/nicethemes-admin-ui.js' ),
					array( 'jquery' )
				);
			} else {
				$script = 'nice-likes-admin-ui-script-min';
				wp_enqueue_script(
					$script,
					nice_likes_canonicalize_url( $plugin_dir_url . '../assets/js/min/nicethemes-admin-ui.min.js' ),
					array( 'jquery' )
				);
			}
			wp_localize_script( $script, 'nice_likes_admin_ui_vars', array(
					'post_id'                => isset( $post->ID ) ? $post->ID : null,
					'nice_likes_version' => $data->version,
					'wp_version'             => $wp_version,
					'use_this_file'          => esc_html__( 'Use This File', 'nice-likes' ),
					'new_media_ui'           => apply_filters( 'nice_likes_admin_ui_use_35_media_ui', 1, $data ),
					'remove_text'            => esc_html__( 'Remove', 'nice-likes' ),
				)
			);

			/**
			 * Load admin UI styles.
			 */
			wp_register_style(
				'nice_likes_admin_ui_style',
				nice_likes_canonicalize_url( $plugin_dir_url . '../assets/css/nice-admin-ui.css' ),
				false,
				$data->version
			);
			wp_enqueue_style( 'nice_likes_admin_ui_style' );

			/**
			 * Load extra styles.
			 *
			 * @since 1.0
			 */
			if ( $extra_styles = apply_filters( 'nice_likes_admin_ui_style_extra', '' ) ) {
				wp_register_style( 'nice_likes_admin_ui_style_extra', $extra_styles, false, $data->version );
				wp_enqueue_style( 'nice_likes_admin_ui_style_extra' );
			}
		}
	}

	/**
	 * Add help tabs to the admin UI.
	 *
	 * @since 1.0
	 */
	public function add_help_tabs() {
		$data = $this->data->get_info();

		$section    = $data->current_section;
		$tabs_added = 0;

		if ( ! empty( $data->sections[ $section ]['help_tabs'] ) ) {
			$screen = get_current_screen();

			foreach ( $data->sections[ $section ]['help_tabs'] as $help_tab ) {
				if ( ! $help_tab['id'] || ! $help_tab['title'] ) {
					continue;
				}

				unset( $help_tab['priority'] );

				$screen->add_help_tab( $help_tab );

				$tabs_added++;
			}

			if ( $tabs_added && $screen ) {
				$this->add_help_sidebar( $screen );
			}
		}
	}

	/**
	 * Add a help sidebar for the current section.
	 *
	 * @since 1.0
	 *
	 * @param WP_Screen $screen
	 */
	private function add_help_sidebar( WP_Screen $screen ) {
		$data = $this->data->get_info();

		if ( ! empty( $data->sections[ $data->current_section ]['help_sidebar'] ) ) {
			$screen->set_help_sidebar( $data->sections[ $data->current_section ]['help_sidebar'] );
		}
	}

	/**
	 * Obtain the callback name of a dynamically created function to retrieve
	 * the description of a section.
	 *
	 * In an ideal and happy world, this should be done using an anonymous
	 * function. However, anonymous functions are only available since PHP 5.3.
	 *
	 * @since  1.0
	 *
	 * @param  string  $description Description text for the section.
	 * @param  integer $i           Order of the section.
	 *
	 * @return string               Name of the the declared function.
	 */
	public static function settings_section_description( $description, $i ) {
		// Obtain callback function name.
		$callback = 'nice_likes_admin_ui_section_description_' . $i . '_' . time();
		$callback = apply_filters( 'nice_likes_admin_ui_settings_section_description_callback', $callback );

		// Create function.
		$function = 'function ' . $callback . '() { echo \'' . $description . '\'; }';

		// Run function declaration.
		eval( $function );

		return $callback;
	}

	/**
	 * Print the HTML of a setting field.
	 *
	 * @since 1.0
	 *
	 * @param $args
	 */
	public function settings_field( $args ) {
		// Obtain needed values.
		$data         = $this->data->get_info();
		$form_handler = $data->form_handler;
		$option_name  = $data->settings_name . '[' . $args['field']['id'] . ']';

		if ( ! $form_handler instanceof Nice_Likes_Admin_UI_Form_Handler ) {
			return;
		}

		$field = isset( $args['field'] ) ? $args['field'] : null;
		$value = isset( $args['value'] ) ? $args['value'] : '';

		if ( ! is_array( $field ) || ! isset( $field['type'] ) ) {
			return;
		}

		switch ( $field['type'] ) {
			case 'text':
				$output = $form_handler->field_text(
					$option_name, $field['description'], $value, $field['placeholder']
				);
				break;

			case 'text-small':
				$output = $form_handler->field_text_small(
					$option_name, $field['description'], $value, $field['placeholder']
				);
				break;

			case 'password':
				$output = $form_handler->field_password(
					$option_name, $field['description'], $value, $field['placeholder']
				);
				break;

			case 'textarea':
				$output = $form_handler->field_textarea(
					$option_name, $field['description'], $value, $field['placeholder']
				);
				break;

			case 'select':
				$output = $form_handler->field_select(
					$option_name, $field['description'], $field['options'], $value, $field['placeholder']
				);
				break;

			case 'select-multiple':
				$output = $form_handler->field_select_multiple(
					$option_name, $field['description'], $field['options'], $value
				);
				break;

			case 'checkbox':
				$output = $form_handler->field_checkbox(
					$option_name, $field['description'], $value, $field['placeholder']
				);
				break;

			case 'checkbox-group':
				$output = $form_handler->field_checkbox_group(
					$option_name, $field['description'], $field['options'], $value
				);
				break;

			case 'radio':
				$output = $form_handler->field_radio(
					$option_name, $field['description'], $field['options'], $value
				);
				break;

			case 'color':
				$output = $form_handler->field_color(
					$option_name, $field['description'], $value
				);
				break;

			case 'upload':
				$output = $form_handler->field_upload(
					$option_name, $field['description'], $value, esc_html__( 'Upload file', 'nice-likes' )
				);
				break;

			default :
				$output = '';
				break;
		}

		// Allow general filters.
		$output = apply_filters( 'nice_likes_admin_ui_setting_field', $output, $args, $this );

		// Allow type-specific filters.
		$output = apply_filters( 'nice_likes_admin_ui_setting_field_' . $args['field']['type'], $output, $args );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Register settings via the WordPress Settings API.
	 *
	 * @since 1.0
	 */
	public function register_api_settings() {
		// Obtain necessary values.
		$data            = $this->data->get_info();
		$current_section = $data->current_section;
		$current_tab     = $data->current_tab;

		// Return if we don't have an array for the current tab.
		if ( empty( $data->sections[ $current_section ]['tabs'][ $current_tab ] ) ) {
			return;
		}

		// Obtain current tab as array.
		$tab = $data->sections[ $current_section ]['tabs'][ $current_tab ];

		// Register settings for the admin UI.
		register_setting( $data->name, $data->settings_name );

		// Add settings for the current tab.
		if ( ! empty( $tab['settings'] ) ) {
			$this->add_settings( $tab['settings'] );
		}
	}

	/**
	 * Add settings using the WordPress Settings API
	 *
	 * @since 1.0
	 *
	 * @param array $settings
	 */
	protected function add_settings( $settings ) {
		/**
		 * Initialize counter.
		 */
		$i = 0;

		/**
		 * Obtain needed values.
		 */
		$service = nice_likes_admin_ui_service();
		$data    = $this->data->get_info();

		foreach ( $settings as $settings_section_id => $settings_section ) {
			$settings_section = $service::format_settings_group( $settings_section_id, $settings_section );

			/**
			 * Add settings through WordPress API.
			 */
			call_user_func_array( 'add_settings_section', $arr = array(
					'id'       => $data->name,
					'title'    => $settings_section['title'],
					'callback' => $this->settings_section_description( $settings_section['description'], $i ),
					'page'     => $data->name,
				)
			);

			/**
			 * Add fields.
			 */
			if ( ! empty( $settings_section['fields'] ) ) {
				$this->add_settings_fields( $settings_section_id, $settings_section['fields'] );
			}

			$i++;
		}
	}

	/**
	 * Add settings fields using the WordPress Settings API.
	 *
	 * @since 1.0
	 *
	 * @param string $group_id
	 * @param array  $fields
	 */
	protected function add_settings_fields( $group_id, $fields ) {
		/**
		 * Obtain needed values.
		 */
		$service = nice_likes_admin_ui_service();
		$data    = $this->data->get_info();
		$fields  = $service::format_fields( $group_id, $fields );

		/**
		 * Add settings through WordPress API.
		 */
		foreach ( $fields as $field_id => $field ) {
			call_user_func_array( 'add_settings_field', array(
					'id'       => $field['id'],
					'title'    => $field['title'],
					'callback' => array( $this, 'settings_field' ),
					'page'     => $data->name,
					'section'  => $data->name,
					'args'     => array(
						'group'   => $group_id,
						'field'   => $field,
						'section' => $data->current_section,
						'tab'     => $data->current_tab,
						'value'   => empty( $data->settings[ $field['id'] ] ) ? '' : $data->settings[ $field['id'] ],
					),
				)
			);
		}
	}

	/**
	 * Add class names to body class.
	 *
	 * @param  string $class
	 *
	 * @return string
	 */
	public function add_body_class( $class ) {
		$data = $this->data->get_info();

		global $plugin_page;

		if ( ( $data->name === $plugin_page ) && nice_likes_admin_ui_is_mp6() ) {
			$class .= ' is-mp6';
		}

		return $class;
	}
}
