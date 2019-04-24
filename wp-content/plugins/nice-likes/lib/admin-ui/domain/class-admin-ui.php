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
 * Class Nice_Likes_Admin_UI
 *
 * Main Admin UI Class.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UI extends Nice_Likes_Entity {
	/**
	 * Internal name for the admin UI.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $name = 'nice-likes-admin-ui';

	/**
	 * Title for admin UI.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $title = 'NiceThemes Admin UI';

	/**
	 * Text domain for the admin UI.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $textdomain = 'nice-likes-admin-ui';

	/**
	 * Current version of the plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $version = '1.0';

	/**
	 * Access capability.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $capability = 'manage_options';

	/**
	 * URL of the logo image.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $logo = '';

	/**
	 * Settings sections for the admin UI.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $sections = array();

	/**
	 * Slug for settings page.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $settings_page_slug = '';

	/**
	 * Slug for parent page of submenu (optional).
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $submenu_parent_slug = 'options-general.php';

	/**
	 * Apparition order of link in admin submenu section.
	 *
	 * @since 1.0
	 * @var   int
	 */
	protected $submenu_order = 100;

	/**
	 * Settings saved in the admin UI.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $settings = array();

	/**
	 * Name of the option that stores the admin UI settings.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $settings_name = 'nice_likes_admin_ui_settings';

	/**
	 * Full path to the folder where templates are located.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $templates_path = '';

	/**
	 * Currently active section.
	 *
	 * @since 1.0
	 * @var   null|string
	 */
	protected $current_section = null;

	/**
	 * Currently active tab.
	 *
	 * @since 1.0
	 * @var   null|string
	 */
	protected $current_tab = null;

	/**
	 * Group of tabs for the current section.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $current_tab_group = array();

	/**
	 * Boxes to be displayed in the sidebar of the UI.
	 *
	 * @var array
	 */
	protected $sidebar_boxes = array();

	/**
	 * Links to display in footer.
	 *
	 * @since 1.0
	 * @var   array
	 */
	protected $footer_links = array();

	/**
	 * WordPress' notices.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $wp_notices = '';

	/**
	 * WordPress' settings errors.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $wp_settings_errors = ''; // WPCS: override ok.

	/**
	 * WordPress' settings "errors" for a successful settings update.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $wp_settings_updated = '';

	/**
	 * Helper object for easier management of form elements.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_Admin_UI_Form_Handler
	 */
	protected $form_handler = null;

	/**
	 * Helper object for easier management of printable HTML elements.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_Admin_UI_HTML_Handler
	 */
	protected $html_handler = null;

	/**
	 * Set instance values, and add hooks to capture WordPress' notices.
	 *
	 * @since 1.0
	 *
	 * @param array $data Information for instance properties.
	 */
	public function __construct( array $data ) {
		parent::__construct( $data );

		if ( ! nice_likes_doing_ajax() ) {
			add_action( 'current_screen', array( $this, 'add_wp_notices_hooks' ) );
		}
	}

	/**
	 * Add hooks to capture WordPress' notices.
	 *
	 * @since 1.0
	 */
	public function add_wp_notices_hooks() {
		if ( apply_filters( 'nice_likes_admin_ui_capture_wp_notices', false ) ) {
			add_action( 'network_admin_notices', array( $this, 'wp_notices_start' ), -9999 );
			add_action( 'user_admin_notices',    array( $this, 'wp_notices_start' ), -9999 );
			add_action( 'admin_notices',         array( $this, 'wp_notices_start' ), -9999 );
			add_action( 'all_admin_notices',     array( $this, 'wp_notices_start' ), -9999 );

			add_action( 'network_admin_notices', array( $this, 'wp_notices_end' ), 9999 );
			add_action( 'user_admin_notices',    array( $this, 'wp_notices_end' ), 9999 );
			add_action( 'admin_notices',         array( $this, 'wp_notices_end' ), 9999 );
			add_action( 'all_admin_notices',     array( $this, 'wp_notices_end' ), 9999 );

			add_action( 'all_admin_notices', array( $this, 'set_wp_settings_errors' ), 10000 );
		}
	}

	/**
	 * Start capturing WordPress' notices.
	 *
	 * @since  1.0
	 */
	public function wp_notices_start() {
		ob_start();
	}

	/**
	 * Finish capturing WordPress' notices.
	 *
	 * @since  1.0
	 */
	public function wp_notices_end() {
		$this->wp_notices .= ob_get_contents();
		ob_end_clean();
	}

	/**
	 * Capture WordPress' settings errors, and unset them to avoid displaying them twice.
	 *
	 * @since 1.0
	 */
	public function set_wp_settings_errors() {
		get_settings_errors();
		global $wp_settings_errors;

		$wp_settings_updated = array();
		foreach ( (array) $wp_settings_errors as $key => $details ) {
			if ( 'settings_updated' === $details['code'] ) {
				$details['type'] .= ' nice-wp-notice';
				$wp_settings_updated[ $key ] = $details;
				unset( $wp_settings_errors[ $key ] );
			}
		}

		ob_start();
		settings_errors();
		$this->wp_settings_errors = ob_get_contents();
		ob_end_clean();

		foreach ( (array) $wp_settings_errors as $key => $details ) {
			unset( $wp_settings_errors[ $key ] );
		}

		if ( ! empty( $wp_settings_updated ) ) {
			foreach ( $wp_settings_updated as $key => $details ) {
				$wp_settings_errors[ $key ] = $details;
			}

			ob_start();
			settings_errors();
			$this->wp_settings_updated = ob_get_contents();
			ob_end_clean();

			foreach ( $wp_settings_errors as $key => $details ) {
				unset( $wp_settings_errors[ $key ] );
			}
		}
	}

	/**
	 * Output a partial template.
	 *
	 * @since  1.0
	 *
	 * @uses   Nice_Likes_Admin_UIService::get_template_part()
	 *
	 * @param  string $template
	 * @param  string $part
	 * @param  bool $return
	 *
	 * @return string If `$return` is set to `true`.
	 */
	public function get_template_part( $template, $part = '', $return = false ) {
		$service = nice_likes_admin_ui_service();
		return $service::get_template_part( $this, $template, $part, $return );
	}
}
