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
 * Class Nice_Likes_Admin_UIService
 *
 * This class deals with typical operations over Nice_Likes_Admin_UI instances.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UIService extends Nice_Likes_Service {
	/**
	 * Register an instance of the current domain and return it.
	 *
	 * @since  1.0
	 *
	 * @param  array $data
	 *
	 * @return Nice_Likes_EntityInterface
	 */
	public function get_registered( array $data ) {
		$this->register( ( $entity = $this->prepare( $data ) ), $data );

		return $entity;
	}

	/**
	 * Perform registrations on an instance of the current domain.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_EntityInterface $ui
	 * @param array $data
	 */
	public function register( Nice_Likes_EntityInterface $ui, array $data = array() ) {
		if ( ! $ui instanceof Nice_Likes_Admin_UI ) {
			return;
		}

		$registrator = new Nice_Likes_Admin_UI_Registrator( $ui );
		extract( $data );

		/**
		 * Register sections.
		 */
		if ( ! empty( $sections ) && is_array( $sections ) ) {
			$registrator->register_sections( $sections );
		}

		/**
		 * Register help tabs.
		 */
		if ( ! empty( $help_tabs ) && is_array( $help_tabs ) ) {
			foreach ( $help_tabs as $_help_tabs ) {
				$registrator->register_help_tabs( $_help_tabs['section'], $_help_tabs['args'] );
			}
		}

		/**
		 * Register help sidebars.
		 */
		if ( ! empty( $help_sidebars ) && is_array( $help_sidebars ) ) {
			foreach ( $help_sidebars as $_help_sidebars ) {
				$registrator->register_help_sidebar( $_help_sidebars['section'], $_help_sidebars['content'] );
			}
		}

		/**
		 * Register tabs.
		 */
		if ( ! empty( $tabs ) && is_array( $tabs ) ) {
			foreach ( $tabs as $_tabs ) {
				$registrator->register_tabs( $_tabs['section'], $_tabs['args'] );
			}
		}

		/**
		 * Register groups.
		 */
		if ( ! empty( $settings_groups ) && is_array( $settings_groups ) ) {
			foreach ( $settings_groups as $_settings_groups ) {
				$registrator->register_settings_groups(
					$_settings_groups['tab'],
					$_settings_groups['section'],
					$_settings_groups['args']
				);
			}
		}

		/**
		 * Register settings.
		 */
		if ( ! empty( $settings ) && is_array( $settings ) ) {
			foreach ( $settings as $_settings ) {
				$registrator->register_settings(
					$_settings['settings_section'],
					$_settings['tab'],
					$_settings['section'],
					$_settings['args']
				);
			}
		}

		/**
		 * Register footer links.
		 */
		if ( ! empty( $footer_links ) && is_array( $footer_links ) ) {
			$registrator->register_footer_links( $footer_links );
		}

		/**
		 * Register sidebar boxes.
		 */
		if ( ! empty( $sidebar_boxes ) && is_array( $sidebar_boxes ) ) {
			$registrator->register_sidebar_boxes( $sidebar_boxes );
		}
	}

	/**
	 * Obtain default arguments to construct the instance.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	protected static function get_init_data() {
		return array(
			'logo'           => self::get_default_logo(),
			'templates_path' => self::get_default_templates_path(),
		);
	}

	/**
	 * Obtain URL of the default logo.
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	protected static function get_default_logo() {
		$logo = nice_likes_canonicalize_url( plugin_dir_url( __FILE__ ) . '../assets/images/logo.png' );
		return apply_filters( 'nice_likes_admin_ui_default_logo', $logo );
	}

	/**
	 * Obtain path to the default templates folder.
	 *
	 * @since  1.0
	 *
	 * @return string
	 */
	protected static function get_default_templates_path() {
		$templates_path = realpath( plugin_dir_path( __FILE__ ) . '../templates/' );
		$templates_path = apply_filters( 'nice_likes_admin_ui_default_templates_path', $templates_path );

		return trailingslashit( $templates_path );
	}

	/**
	 * Obtain the currently active section.
	 *
	 * @since  1.0
	 *
	 * @param  array $sections
	 *
	 * @return string
	 */
	protected static function get_current_section( array $sections ) {
		$section = '';

		if (   isset( $_GET['section'] )
		    && array_key_exists( $_GET['section'], $sections )
		) {
			$section = $_GET['section'];

		} elseif ( ! empty( $sections ) ) {
			/*
			 * If we don't have a specific section in the request, let's find
			 * the first one in the $sections array.
			 */
			foreach ( $sections as $id => $value ) {
				$section = $id;
				break;
			}
		}

		return $section;
	}

	/**
	 * Obtain the currently active tab.
	 *
	 * @since  1.0
	 *
	 * @param  string $current_section
	 * @param  array  $sections
	 *
	 * @return string
	 */
	protected static function get_current_tab( $current_section = '', array $sections ) {
		if ( ! $current_section ) {
			return null;
		}

		$tabs = $sections[ $current_section ]['tabs'] ? : array();

		if ( isset( $_GET['tab'] ) && array_key_exists( $_GET['tab'], $tabs ) ) {
			$tab = $_GET['tab'];
		} elseif ( ! empty( $tabs ) ) {
			/*
			 * If we don't have a specific tab in the request, let's find the
			 * first one in the $tabs array.
			 */
			foreach ( $tabs as $id => $value ) {
				$tab = $id;
				break;
			}
		} else {
			$tab = '';
		}

		return $tab;
	}

	/**
	 * Obtain the list of tabs registered for the current section.
	 *
	 * @since  1.0
	 *
	 * @param  string $current_section
	 * @param  array $sections
	 *
	 * @return array|null
	 */
	protected static function get_current_tab_group( $current_section = '', array $sections ) {
		if ( ! empty( $sections[ $current_section ]['tabs'] ) ) {
			$callback = array( 'self', 'sort_priorities' );
			uasort( $sections[ $current_section ]['tabs'], $callback );

			return $sections[ $current_section ]['tabs'];
		}

		return null;
	}

	/**
	 * Normalize values for an options section.
	 *
	 * @since  1.0
	 *
	 * @param  array $args
	 * @return array
	 */
	protected static function normalize_section( array $args = array() ) {
		$original_args = $args;

		// Set defaults.
		$defaults = array(
			'title'            => 'Section',
			'heading_title'    => '',
			'icon'             => 'dashicons-admin-generic',
			'header'           => '',
			'subheader'        => '',
			'description'      => '',
			'tabs'             => array(),
			'help_tabs'        => array(),
			'help_sidebar'     => '',
			'custom_url'       => '',
			'target'           => '',
			'priority'         => 10,
		);
		$defaults = apply_filters( 'nice_likes_admin_ui_section_defaults', $defaults );

		// Normalize section arguments.
		$args = wp_parse_args( $args, $defaults );

		// Normalize tabs.
		if ( ! empty( $args['tabs'] ) && is_array( $args['tabs'] ) ) {
			$tabs = array();

			foreach ( $args['tabs'] as $id => $tab_args ) {
				$tabs[ $id ] = self::normalize_tab( $id, $tab_args );
			}

			$args['tabs'] = $tabs;
		}

		return apply_filters( 'nice_likes_admin_ui_normalize_section', $args, $original_args );
	}

	/**
	 * Normalize values for settings sections.
	 *
	 * @since  1.0
	 *
	 * @param  array $sections
	 * @return array
	 */
	protected static function normalize_sections( $sections = array() ) {
		$original_sections = $sections;

		if (   ! empty( $sections )
		    && is_array( $sections )
		) {
			$_sections = array();

			foreach ( $sections as $id => $section ) {
				$_sections[ $id ] = self::normalize_section( $section );
			}
			uasort( $_sections, array( 'self', 'sort_priorities' ) );

			$_sections = apply_filters( 'nice_likes_admin_ui_process_sections', $_sections );
			$sections = $_sections;
		}

		return apply_filters( 'nice_likes_admin_ui_normalize_sections', $sections, $original_sections );
	}

	/**
	 * Normalize values for a tab from an options section.
	 *
	 * @since  1.0
	 *
	 * @param  string $id
	 * @param  array  $args
	 * @return array
	 */
	protected static function normalize_tab( $id, $args = array() ) {
		$original_args = $args;

		$defaults = array(
			'title'    => $id,
			'icon'     => 'dashicons-admin-generic',
			'settings' => array(),
			'priority' => 10,
		);
		$args = wp_parse_args( $args, $defaults );

		return apply_filters( 'nice_likes_admin_ui_normalize_tab', $args, $original_args );
	}

	/**
	 * Normalize values for creation of help tabs.
	 *
	 * @since  1.0
	 *
	 * @param  array          $args
	 * @param  mixed|bool|int $priority
	 * @return array
	 */
	protected static function normalize_help_tab( $args = array(), $priority = false ) {
		$original_args = $args;

		$defaults = array(
			'id'       => '',
			'title'    => '',
			'content'  => '',
			'priority' => ( $priority === false ) ? 10 : $priority,
		);
		$args = wp_parse_args( $args, $defaults );

		return apply_filters( 'nice_likes_admin_ui_normalize_help_tab', $args, $original_args );
	}

	/**
	 * Normalize and order help tabs by priorities.
	 *
	 * @since  1.0
	 *
	 * @param  array $help_tabs
	 * @return array
	 */
	protected static function normalize_help_tabs( $help_tabs ) {
		$_help_tabs = array();
		$original_help_tabs = $help_tabs;
		$tab_default_index = 0;

		foreach ( $help_tabs as $help_tab ) {
			$_help_tabs[] = self::normalize_help_tab( $help_tab, $tab_default_index );
			$tab_default_index++;
		}
		uasort( $_help_tabs, array( 'self', 'sort_priorities' ) );
		$help_tabs = $_help_tabs;

		return apply_filters( 'nice_likes_admin_ui_normalize_help_tabs', $help_tabs, $original_help_tabs );
	}

	protected static function normalize_links( array $links ) {
		$normalized_links = array();

		if ( ! empty( $links ) ) {
			foreach ( $links as $link ) {
				$normalized_links[] = self::normalize_link( $link );
			}
		}

		return $normalized_links;
	}

	/**
	 * Normalize arguments of a link array.
	 *
	 * @param  array $link
	 * @return array
	 */
	protected static function normalize_link( $link = array() ) {
		$defaults = array(
			'text'   => '',
			'href'   => '',
			'target' => '',
			'id'     => '',
			'class'  => '',
			'before' => '',
			'after'  => '',
		);
		$defaults = apply_filters( 'nice_likes_admin_ui_link_defaults', $defaults );

		$link = wp_parse_args( $link, $defaults );
		$link = apply_filters( 'nice_likes_admin_ui_normalize_link', $link );

		return $link;
	}

	protected static function normalize_sidebar_boxes( array $sidebar_boxes ) {
		$normalized_sidebar_boxes = array();

		if ( ! empty( $sidebar_boxes ) ) {
			foreach ( $sidebar_boxes as $sidebar_box ) {
				$normalized_sidebar_boxes[] = self::normalize_sidebar_box( $sidebar_box );
			}
		}

		return $normalized_sidebar_boxes;
	}

	/**
	 * Normalize arguments of a sidebar box array.
	 *
	 * @param  array $box
	 * @return array
	 */
	protected static function normalize_sidebar_box( $box = array() ) {
		$defaults = array(
			'title'   => '',
			'content' => '',
			'id'      => '',
			'class'   => '',
		);
		$defaults = apply_filters( 'nice_likes_admin_ui_sidebar_box_defaults', $defaults );

		$box = wp_parse_args( $box, $defaults );
		$box = apply_filters( 'nice_likes_admin_ui_normalize_sidebar_box', $box );

		return $box;
	}

	/**
	 * Normalize values for a group of fields.
	 *
	 * @since  1.0
	 *
	 * @param  string           $id
	 * @param  string           $settings_section
	 * @return array|mixed|void
	 */
	public static function format_settings_group( $id, $settings_section ) {
		$original_settings_section = $settings_section;

		$defaults = array(
			'title'       => $id,
			'description' => '',
			'fields'      => array(),
		);
		$settings_section = wp_parse_args( $settings_section, $defaults );

		// Apply general filters.
		$settings_section = apply_filters( 'nice_likes_admin_ui_normalize_settings_group',
			$settings_section, $id, $original_settings_section
		);
		// Apply specific filters.
		$settings_section = apply_filters( 'nice_likes_admin_ui_normalize_settings_group_' . $id,
			$settings_section, $original_settings_section
		);

		return $settings_section;
	}

	/**
	 * Normalize values for a field.
	 *
	 * @param  string           $group_id
	 * @param  string           $field_id
	 * @param  string           $field
	 *
	 * @return array|mixed|void
	 */
	protected static function format_field( $group_id, $field_id, $field ) {
		$original_field = $field;

		$defaults = array(
			'id'          => $field_id,
			'title'       => $field_id,
			'description' => '',
			'placeholder' => '',
			'type'        => 'text',
			'options'     => array(),
			'priority'    => 10,
		);
		$field = wp_parse_args( $field, $defaults );

		// Apply general filters.
		$field = apply_filters( 'nice_likes_admin_ui_normalize_field',
			$field, $group_id, $field_id, $original_field
		);
		// Apply specific filters.
		$field = apply_filters( 'nice_likes_admin_ui_normalize_field_' . $field_id,
			$field, $group_id, $original_field
		);

		return $field;
	}

	/**
	 * Process a group of fields.
	 *
	 * @since  1.0
	 *
	 * @param  integer $group_id
	 * @param  array   $fields
	 * @return array
	 */
	public static function format_fields( $group_id, $fields ) {
		$_fields = array();
		$original_fields = $fields;

		foreach ( $fields as $field_id => $field ) {
			$_fields[] = self::format_field( $group_id, $field_id, $field );
		}
		$fields = $_fields;
		uasort( $fields, array( 'self', 'sort_priorities' ) );

		$fields = apply_filters( 'nice_likes_admin_ui_normalize_fields',
			$fields, $original_fields, $group_id
		);

		return $fields;
	}

	/**
	 * Set current state of some properties after the object has been initialized.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin_UI $ui
	 */
	public static function process_context( Nice_Likes_Admin_UI $ui ) {
		$data = $ui->get_info();

		$sections          = self::normalize_sections( $data->sections );
		$current_section   = self::get_current_section( $sections );
		$current_tab       = self::get_current_tab( $current_section, $sections );
		$current_tab_group = self::get_current_tab_group( $current_section, $sections );

		$new_data = array(
			'sections'           => $sections,
			'current_section'    => $current_section,
			'current_tab'        => $current_tab,
			'current_tab_group'  => $current_tab_group,
			'footer_links'       => self::normalize_links( $data->footer_links ),
			'sidebar_boxes'      => self::normalize_sidebar_boxes( $data->sidebar_boxes ),
			'settings'           => get_option( $data->settings_name ),
			'form_handler'       => new Nice_Likes_Admin_UI_Form_Handler( $ui ),
			'html_handler'       => new Nice_Likes_Admin_UI_HTML_Handler( $ui ),
		);

		nice_likes_update( $ui, $new_data );
	}

	/**
	 * Load an HTML template.
	 *
	 * @since 1.0
	 *
	 * @param  Nice_Likes_Admin_UI $ui
	 * @param  string $file_path
	 *
	 * @return bool `true` if the file could be loaded, else `false`.
	 */
	public static function load_template( Nice_Likes_Admin_UI $ui, $file_path ) {
		// Obtain basic data.
		$data      = $ui->get_info();
		$file_path = apply_filters( 'nice_likes_admin_ui_template_path', $file_path, $ui );

		if ( file_exists( $file_path ) ) {
			/**
			 * Set helper variables for templates.
			 */
			$new_data = array_merge( (array) $data, array(
					'section' => empty( $data->sections ) ? null : $data->sections[ $data->current_section ],
					'form' => $data->form_handler,
					'html' => $data->html_handler,
				)
			);
			unset( $new_data['form_handler'] );
			unset( $new_data['html_handler'] );
			unset( $data );
			extract( $new_data );

			/**
			 * Unset values that we don't want to be available in templates.
			 */

			unset( $new_data );

			/**
			 * Load file.
			 */
			require $file_path;

			return true;
		}
		return false;
	}

	/**
	 * Output a partial template.
	 *
	 * @since  1.0
	 *
	 * @uses   `Nice_Likes_Admin_UI::load_template()`
	 *
	 * @param  Nice_Likes_Admin_UI $admin_ui
	 * @param  string $template
	 * @param  string $part
	 * @param  bool $return
	 *
	 * @return string If `$return` is set to `true`.
	 */
	public static function get_template_part( Nice_Likes_Admin_UI $admin_ui, $template, $part = '', $return = false ) {
		// Obtain basic data.
		$data                   = $admin_ui->get_info();
		$templates_path         = $data->templates_path;
		$default_templates_path = self::get_default_templates_path();

		// Run actions before loading template.
		do_action( 'nice_likes_admin_ui_before_template_' . $template, $part, $admin_ui );

		/**
		 * Set and check supposed path for template part. If it fails, get path
		 * for template only.
		 */
		$file_path = $templates_path . $template . '-' . $part . '.php';
		// Check if the file with a specific part exists under the default path.
		if ( ! file_exists( $file_path ) && ( $templates_path != $default_templates_path ) ) {
			$file_path = $default_templates_path . $template . '-' . $part . '.php';
		}
		// Check if the file without a specific part exists.
		if ( ! file_exists( $file_path ) ) {
			$file_path = $templates_path . $template . '.php';
		}
		// Check if the file without a specific part exists under the default path.
		if ( ! file_exists( $file_path ) && ( $templates_path != $default_templates_path ) ) {
			$file_path = $default_templates_path . $template . '.php';
		}

		// Allow path modifications.
		$file_path = apply_filters( 'nice_likes_admin_ui_template_part_file_path',
			$file_path, $template, $part, $admin_ui
		);

		if ( $return ) {
			ob_start();
		}

		self::load_template( $admin_ui, $file_path );

		if ( $return ) {
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}

		// Run actions after loading template.
		do_action( 'nice_likes_admin_ui_after_template_' . $template, $part, $admin_ui );

		return null;
	}

	/**
	 * Sorting method for priorities.
	 *
	 * @param  array $a
	 * @param  array $b
	 * @return array
	 */
	private final static function sort_priorities( $a, $b ) {
		if ( $a['priority'] == $b['priority'] ) {
			return $a['priority'];
		}

		return $a['priority'] - $b['priority'];
	}
}
