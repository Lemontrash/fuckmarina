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
 * Class Nice_Likes_Admin_UI_Registrator
 *
 * Manage registrations of Admin UI elements.
 *
 * @since   1.0
 * @package Nice_Likes_Admin_UI
 */
class Nice_Likes_Admin_UI_Registrator {
	/**
	 * Instance of Admin UI.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_Admin_UI
	 */
	protected $ui;

	/**
	 * Initialize instance of Admin UI.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_Admin_UI $ui
	 */
	function __construct( Nice_Likes_Admin_UI $ui ) {
		$this->ui = $ui;
	}

	/**
	 * Obtain the current value of a property.
	 *
	 * @since  1.0
	 *
	 * @param  string     $property Name of a property of this class.
	 * @return mixed|void           Current value for the requested property.
	 */
	public function __get( $property ) {
		if ( property_exists( $this, $property ) ) {
			return $this->{$property};
		}

		return null;
	}

	/**
	 * Update sections to given value.
	 *
	 * @since 1.0
	 *
	 * @param array $sections
	 */
	protected function update_sections( array $sections = array() ) {
		$this->ui->set_data( array( 'sections' => $sections ) );
	}

	/**
	 * Register a section for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section Name of the new section.
	 * @param array  $args    Arguments to create the section.
	 */
	public function register_section( $section, $args = array() ) {
		$args = apply_filters( 'nice_likes_admin_ui_register_section',
			$args, $section, $this
		);

		$sections = $this->ui->{'sections'};
		$sections[ $section ] = $args;

		$this->update_sections( $sections );
	}

	/**
	 * Unregister a section for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section Name of the section to be removed.
	 */
	public function unregister_section( $section ) {
		$sections = $this->ui->{'sections'};

		if ( isset( $sections[ $section ] ) ) {
			unset( $sections[ $section ] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register sections for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param array $sections
	 */
	public function register_sections( $sections ) {
		$sections = apply_filters( 'nice_likes_admin_ui_register_sections',
			$sections, $this
		);
		if ( ! empty( $sections ) ) {
			foreach ( $sections as $id => $section ) {
				$this->register_section( $id, $section );
			}
		}
	}

	/**
	 * Register a help tab for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $id      Internal identifier for the new help tab.
	 * @param string $section Name of the section where the help tab should be displayed.
	 * @param array  $args    Arguments to create the help tab.
	 */
	public function register_help_tab( $id, $section, $args = array() ) {
		if ( ! isset( $this->ui->{'sections'}[ $section ] ) ) {
			return;
		}
		$args = apply_filters( 'nice_likes_admin_ui_register_help_tab',
			$args, $id, $section, $this
		);
		$sections = $this->ui->{'sections'};
		$sections[ $section ]['help_tabs'][ $id ] = $args;

		$this->update_sections( $sections );
	}

	/**
	 * Unregister a help tab from a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $id      Internal identifier of the help tab to be removed.
	 * @param string $section Name of the section where the help tab displays.
	 */
	public function unregister_help_tab( $id, $section ) {
		$sections = $this->ui->{'sections'};

		if ( isset( $sections[ $section ]['help_tabs'][ $id ] ) ) {
			unset( $sections[ $section ]['help_tabs'][ $id ] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register a help tab for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section   Name of the section where the help tab should be displayed.
	 * @param array  $help_tabs Arguments to create the help tab.
	 */
	public function register_help_tabs( $section, $help_tabs ) {
		$help_tabs = apply_filters( 'nice_likes_admin_ui_register_help_tabs',
			$help_tabs, $section, $this
		);
		if ( ! empty( $help_tabs ) ) {
			foreach ( $help_tabs as $id => $help_tab ) {
				$this->register_help_tab( $id, $section, $help_tab );
			}
		}
	}

	/**
	 * Register a help sidebar for a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section Name of the section where the help sidebar should be displayed.
	 * @param string $content HTML content of the new sidebar.
	 */
	public function register_help_sidebar( $section, $content = '' ) {
		if ( ! isset( $this->ui->{'sections'}[ $section ] ) ) {
			return;
		}

		$sections = $this->ui->{'sections'};
		$sections[ $section ]['help_sidebar'] = $content;

		$this->update_sections( $sections );
	}

	/**
	 * Unregister a help sidebar from a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section Internal identifier of the help sidebar to be removed.
	 */
	public function unregister_help_sidebar( $section ) {
		$sections = $this->ui->{'sections'};

		if ( isset( $sections[ $section ]['help_sidebar'] ) ) {
			unset( $sections[ $section ]['help_sidebar'] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $tab     Name of the new tab.
	 * @param string $section Name of the section where the tab should be displayed.
	 * @param array  $args    Arguments to create the new tab.
	 */
	public function register_tab( $tab, $section, $args = array() ) {
		if ( ! isset( $this->ui->{'sections'}[ $section ] ) ) {
			return;
		}
		$args = apply_filters( 'nice_likes_admin_ui_register_tab',
			$args, $tab, $section, $this
		);
		$sections = $this->ui->{'sections'};
		$sections[ $section ]['tabs'][ $tab ] = $args;

		$this->update_sections( $sections );
	}

	/**
	 * Unregister a tab from a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $tab     Name of the tab to be removed.
	 * @param string $section Name of the section where the tab displays.
	 */
	public function unregister_tab( $tab, $section ) {
		$sections = $this->ui->{'sections'};

		if ( isset( $sections[ $section ]['tabs'][ $tab ] ) ) {
			unset( $sections[ $section ]['tabs'][ $tab ] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register a group of tabs within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $section Name of the section where the tab should be displayed.
	 * @param array  $tabs    List of tabs to register.
	 */
	public function register_tabs( $section, $tabs ) {
		$tabs = apply_filters( 'nice_likes_admin_ui_register_tabs',
			$tabs, $section, $this
		);
		if ( ! empty( $tabs ) ) {
			foreach ( $tabs as $id => $tab ) {
				$this->register_tab( $id, $section, $tab );
			}
		}
	}

	/**
	 * Register a settings section into a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $settings_section Name of the new settings section.
	 * @param string $tab              Name of the tab where the settings section should be displayed.
	 * @param string $section          Name of the section where the tab should be displayed.
	 * @param array  $args             Arguments to create the new settings section.
	 */
	public function register_settings_group( $settings_section, $tab, $section, $args = array() ) {
		if ( ! isset( $this->ui->{'sections'}[ $section ]['tabs'][ $tab ] ) ) {
			return;
		}
		$args = apply_filters( 'nice_likes_admin_ui_register_settings_group',
			$args, $settings_section, $tab, $section, $this
		);
		$sections = $this->ui->{'sections'};
		$sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ] = $args;

		$this->update_sections( $sections );
	}

	/**
	 * Unregister a settings section from a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $settings_section Name of the settings section to be removed.
	 * @param string $tab              Name of the tab where the settings section is displayed.
	 * @param string $section          Name of the section where the tab is displayed.
	 */
	public function unregister_settings_group( $settings_section, $tab, $section ) {
		$sections = $this->ui->{'sections'};

		if ( isset( $sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ] ) ) {
			unset( $sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register a list of settings groups into a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $tab              Name of the tab where the settings section should be displayed.
	 * @param string $section          Name of the section where the tab should be displayed.
	 * @param array  $settings_groups  List of settings groups to be registered.
	 */
	public function register_settings_groups( $tab, $section, $settings_groups ) {
		$settings_groups = apply_filters( 'nice_likes_admin_ui_register_settings_groups',
			$settings_groups, $tab, $section, $this
		);
		if ( ! empty( $settings_groups ) ) {
			foreach ( $settings_groups as $id => $settings_group ) {
				$this->register_settings_group( $id, $tab, $section, $settings_group );
			}
		}
	}

	/**
	 * Register a settings section into a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $field            Name of the new field.
	 * @param string $settings_section Name of the settings section where the field should be displayed.
	 * @param string $tab              Name of the tab where the settings section should be displayed.
	 * @param string $section          Name of the section where the tab should be displayed.
	 * @param array  $args             Arguments to create the new field.
	 */
	public function register_setting( $field, $settings_section, $tab, $section, $args = array() ) {
		if ( ! isset( $this->ui->{'sections'}[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ] ) ) {
			return;
		}
		$args = apply_filters( 'nice_likes_admin_ui_register_setting',
			$args, $field, $settings_section, $tab, $section, $this
		);
		$sections = $this->ui->{'sections'};
		$sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ]['fields'][ $field ] = $args;

		$this->update_sections( $sections );
	}

	/**
	 * Register a settings section into a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $field            Name of the field to be removed.
	 * @param string $settings_section Name of the settings section where the field is displayed.
	 * @param string $tab              Name of the tab where the settings section is displayed.
	 * @param string $section          Name of the section where the tab is displayed.
	 */
	public function unregister_setting( $field, $settings_section, $tab, $section ) {
		$sections = $this->ui->{'sections'};
		if ( isset( $sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ]['fields'][ $field ] ) ) {
			unset( $sections[ $section ]['tabs'][ $tab ]['settings'][ $settings_section ]['fields'][ $field ] );
			$this->update_sections( $sections );
		}
	}

	/**
	 * Register a settings section into a tab within a section in a settings page.
	 *
	 * @since 1.0
	 *
	 * @param string $settings_section Name of the settings section where the field should be displayed.
	 * @param string $tab              Name of the tab where the settings section should be displayed.
	 * @param string $section          Name of the section where the tab should be displayed.
	 * @param array  $settings         List of settings to be registered.
	 */
	public function register_settings( $settings_section, $tab, $section, $settings ) {
		$settings = apply_filters( 'nice_likes_admin_ui_register_settings',
			$settings, $tab, $section, $this
		);
		if ( ! empty( $settings ) ) {
			foreach ( $settings as $id => $setting ) {
				$this->register_setting( $id, $settings_section, $tab, $section, $setting );
			}
		}
	}

	/**
	 * Register links to be displayed in the footer template.
	 *
	 * @since 1.0
	 *
	 * @param array $links
	 */
	public function register_footer_links( $links ) {
		$links = apply_filters( 'nice_likes_admin_ui_register_footer_links', $links, $this );

		if ( is_array( $links ) && ! empty( $links ) ) {
			$this->ui->set_data( array( 'footer_links' => $links ) );
		}
	}

	/**
	 * Register boxes to be displayed in the sidebar template.
	 *
	 * @since 1.0
	 *
	 * @param array $boxes
	 */
	public function register_sidebar_boxes( $boxes ) {
		$boxes = apply_filters( 'nice_likes_admin_ui_register_sidebar_boxes', $boxes, $this );

		if ( is_array( $boxes ) && ! empty( $boxes ) ) {
			$this->ui->set_data( array( 'sidebar_boxes' => $boxes ) );
		}
	}
}
