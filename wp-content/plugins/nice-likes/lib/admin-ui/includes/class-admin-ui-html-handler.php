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
 * Class Nice_Likes_Admin_UI_HTML_Handler
 *
 * Helper class for easier management of printable HTML elements for an Admin UI.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UI_HTML_Handler {
	/**
	 * Instance of Admin UI.
	 *
	 * @since 1.0
	 * @var   Nice_Likes_Admin_UI
	 */
	protected $ui;

	/**
	 * Initialize form handler.
	 *
	 * @param $ui Nice_Likes_Admin_UI
	 */
	public function __construct( Nice_Likes_Admin_UI $ui ) {
		$this->ui = $ui;
	}

	/**
	 * Display a tooltip button.
	 *
	 * @since  1.0
	 * @param  string $button_text
	 * @param  string $tooltip_text
	 * @param  string $url
	 */
	public function button_tooltip( $button_text, $tooltip_text, $url = '#' ) {
		$button = '<a class="nice-admin-button tooltip" title="' . $tooltip_text . '" href="' . $url . '">' . $button_text . '</a>';
		$button = apply_filters( 'nice_likes_admin_ui_button_tooltip',
			$button, $button_text, $tooltip_text, $url, $this
		);

		echo $button; // WPCS: XSS ok.
	}

	/**
	 * Display a tooltip button.
	 *
	 * @since  1.0
	 * @param  string $button_text
	 * @param  string $url
	 */
	public function button_modal( $button_text, $url = '#' ) {
		$button = '<a class="nice-admin-button modal-open" href="' . $url . '">' . $button_text . '</a>';
		$button = apply_filters( 'nice_likes_admin_ui_button_modal',
			$button, $button_text, $url, $this
		);

		echo $button; // WPCS: XSS ok.
	}

	/**
	 * Display an accordion.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param array  $items
	 */
	public function accordion( $id = 'nice-likes-accordion', $items = array() ) {
		if ( ! empty( $items ) ) {
			$output = '<div id="' . $id . '" class="nice-accordion ui-accordion ui-widget ui-helper-reset" role="tablist">';
			$i = 0;

			foreach ( $items as $header => $text ) {
				if ( is_string( $header ) && is_string( $text ) ) {
					$output .= '<h3 class="nice-accordion-toggle ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-accordion-header-active ui-state-active ui-corner-top" role="tab" id="ui-accordion-' . $id . '-header-' . $i . '" aria-controls="ui-accordion-' . $id . '-panel-' . $i . '" aria-selected="true" aria-expanded="true" tabindex="' . $i . '"><span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>' . $header . '</h3>';
					$output .= '<div class="nice-accordion-inner ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active" style="display: block;" id="ui-accordion-nice-accordion-panel-' . $i . '" aria-labelledby="ui-accordion-' . $id . '-header-' . $i . '" role="tabpanel" aria-hidden="false">' . $text . '</div>';
					$i++;
				}
			}
			$output .= '</div>';

			// Allow modifications.
			$output = apply_filters( 'nice_likes_admin_ui_accordion', $output, $id, $items, $this );

			echo $output; // WPCS: XSS ok.
		}
	}

	/**
	 * Display a group of tabs.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param array  $items
	 */
	public function tabs( $id = 'nice-likes-tabs', $items = array() ) {
		if ( ! empty( $items ) ) {
			$output = '<div id="' . $id . '" class="nice-tabs ui-tabs ui-widget ui-widget-content ui-corner-all">';
			$output .= '<div class="nice-tab-inner">';

			$header = '<ul class="nice-nav nice-clearfix ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">';

			$content = '';

			$i = 0;

			foreach ( $items as $title => $text ) {
				if ( is_string( $title ) && is_string( $text ) ) {
					$active   = $i ? '' : 'ui-tabs-active ui-state-active';
					$tabindex = $i ? '-1' : '0';
					$display  = $i ? 'block' : 'none';
					$header .= '<li class="ui-state-default ui-corner-top ' . $active . '" role="tab" tabindex="' . $tabindex . '" aria-controls="' . $id . '-tab-' . $i . '" aria-labelledby="ui-id-' . $i . '" aria-selected="true"><a id="ui-id-' . $i . '" class="ui-tabs-anchor" href="#' . $id . '-tab-' . $i . '" role="presentation" tabindex="-1">' . $title . '</a></li>';
					$content .= '<div id="' . $id . '-tab-' . $i . '" class="nice-tab ui-tabs-panel ui-widget-content ui-corner-bottom" aria-labelledby="ui-id-' . $i . '" role="tabpanel" aria-expanded="true" aria-hidden="false" style="display: ' . $display . ';">' . $text . '</div>';

					$i++;
				}
			}
			$header .= '</ul>';
			$output .= $header . $content;
			$output .= '</div>';
			$output .= '</div>';

			// Allow modifications.
			$output = apply_filters( 'nice_likes_admin_ui_tabs', $output, $id, $items, $header, $content, $this );

			echo $output; // WPCS: XSS ok.
		}
	}

	/**
	 * Display a warning message.
	 *
	 * @since 1.0
	 *
	 * @param string $title
	 * @param string $message
	 */
	public function message_warning( $title, $message ) {
		$output  = '<div class="nice-notice nice-notice-warning fade in">';
		$output .= '<button type="button" class="close" data-dismiss="alert">×</button>';
		$output .= '<h6 class="heading">' . $title . '</h6>';
		$output .= $message;
		$output .= '</div>';

		// Allow modifications.
		$output = apply_filters( 'nice_likes_admin_ui_message_warning',
			$output, $title, $message, $this
		);

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Display a search module.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param string $action
	 * @param string $method
	 */
	public function module_search( $id = 'nice-likes-search', $action = '', $method = 'post' ) {
		$output  = '<form id="module-search" action="' . $action . '" method="' . $method . '">';
		$output .= '<input type="search" id="' . $id . '" class="module-search" placeholder="' . esc_attr__( 'Search', 'nice-likes' ) . '"><label for="' . $id . '">' . esc_html__( 'Search', 'nice-likes' ) . '</label>';
		$output .= '</form>';

		// Allow modifications.
		$output = apply_filters( 'nice_likes_admin_ui_module_search', $output, $id, $action, $method, $this );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Display a set of filter buttons.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param array  $buttons
	 */
	public function filters( $id = 'nice-likes-filters', $buttons = array() ) {
		if ( ! empty( $buttons ) ) {

			$output = '<div id="' . $id . '" class="nice-admin-filter">';
			foreach ( $buttons as $button_id => $values ) {
				$url      = empty( $values['url'] ) ? '' : $values['url'];
				$filter   = empty( $values['filter'] ) ? '' : $values['filter'];
				$text     = empty( $values['text'] ) ? '' : $values['text'];
				$selected = ! empty( $values['selected'] ) ? 'selected' : '';

				$output .= '<a href="' . $url . '" id="' . $button_id . '" data-filter="' . $filter . '" class="' . $selected . '">' . $text . '</a>&nbsp;';
			}
			$output .= '</div>';
		}
		// Allow modifications.
		$output = apply_filters( 'nice_likes_admin_ui_filters',
			$output, $id, $buttons, $this
		);

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Display a module box for features.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $text
	 * @param array  $args
	 */
	public function module_box( $id, $title, $text, $args = array() ) {
		$defaults = array(
			'class'      => '',
			'height'     => '92px',
			'data_index' => '0',
			'icon'       => 'dashicons-admin-generic',
			'url'        => '',
		);
		$args = wp_parse_args( $args, $defaults );

		$output = '<div id="' . $id . '" style="height: ' . $args['height'] . ';" href="' . $args['url'] . '" data-index="' . $args['data_index'] . '" data-name="' . $title . '" class="module ' . $args['class'] . '">';
		$output .= '<h3 class="icon dashicons ' . $args['icon'] . '">' . $title . '</h3>';
		$output .= $text;
		$output .= '</div>';

		// Allow modifications.
		$output = apply_filters( 'nice_likes_admin_ui_module_box', $output, $id, $title, $text, $args, $this );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Display a mini box for extensions, promotions, etc.
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 * @param string $title
	 * @param string $text
	 * @param array  $args
	 */
	public function mini_box( $id, $title, $text, $args = array() ) {
		$defaults = array(
			'class' => '',
			'image' => '',
			'url'   => '',
		);
		$args = wp_parse_args( $args, $defaults );

		// Obtain image.
		$image_html = $args['image'] ? '<img src="' . $args['image'] . '" />' : '';

		$output = '<div id="' . $id . '" class="feature">';
		$output .= '<a href="' . $args['url'] . '" data-name="' . $title . '" class="f-img"><div class="feature-img ' . $args['class'] . '">' . $image_html . '</div></a>';
		$output .= '<a href="' . $args['url'] . '" data-name="' . $title . '" class="feature-description">';
		$output .= '<h3>' . $title . '</h3>';
		$output .= $text;
		$output .= '</a>';
		$output .= '</div>';

		// Allow modifications.
		$output = apply_filters( 'nice_likes_admin_ui_mini_box',
			$output, $id, $title, $text, $args, $this
		);

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Generate HTML output for links in footer.
	 *
	 * @since 1.0
	 */
	public function footer_links() {
		$output = '';
		$footer_links = $this->ui->{'footer_links'};

		if ( ! empty( $footer_links ) ) {
			$link_defaults = array(
				'before' => '',
				'after'  => '',
				'href'   => '',
				'target' => '',
				'id'     => '',
				'class'  => '',
				'text'   => '',
			);

			foreach ( $footer_links as $link ) {
				$link = wp_parse_args( $link, $link_defaults );

				$output .= $link['before'];
				$output .= '<a href="' . $link['href'] . '"';
				$output .= $link['target'] ? ' target="' . $link['target'] . '"' : '';
				$output .= $link['id'] ? ' id="' . $link['target'] . '"' : '';
				$output .= $link['class'] ? ' class="' . $link['class'] . '"' : '';
				$output .= '>' . $link['text'] . '</a>';
				$output .= $link['after'];
			}
		}
		$output = apply_filters( 'nice_likes_admin_ui_footer_links_html', $output, $this );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Generate HTML output for boxes in sidebar.
	 *
	 * @since 1.0
	 */
	public function sidebar_boxes() {
		$output = '';
		$sidebar_boxes = $this->ui->{'sidebar_boxes'};

		if ( ! empty( $sidebar_boxes ) ) {
			$box_defaults = array(
				'class'   => '',
				'id'      => '',
				'title'   => '',
				'content' => '',
			);

			foreach ( $sidebar_boxes as $box ) {
				$box = wp_parse_args( $box, $box_defaults );

				$class = $box['class'] ? $box['class'] : 'sidebar-box';

				$output .= '<div ';
				$output .= $box['id'] ? ' id="' . $box['id'] . '"' : '';
				$output .= ' class="' . $class . '"';
				$output .= '>';
				$output .= $box['title'] ? '<h3>' . $box['title'] . '</h3>' : '';
				$output .= $box['content'] . '</div>';
			}
		}
		$output = apply_filters( 'nice_likes_admin_ui_sidebar_boxes_html', $output, $this );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Generate HTML output for WordPress' notices.
	 *
	 * @since 1.0
	 */
	public function wp_notices() {
		$output = '';

		if ( apply_filters( 'nice_likes_admin_ui_show_wp_notices', false ) ) {
			$wp_notices         = $this->ui->{'wp_notices'};
			$wp_settings_errors = $this->ui->{'wp_settings_errors'};

			if ( ! ( empty( $wp_notices ) && empty( $wp_settings_errors ) ) ) {
				$class = 'nice-likes-wp-notices clearfix';

				if ( ! apply_filters( 'nice_likes_admin_ui_show_wp_notices_third_parties', false ) ) {
					$class .= ' hide-third-parties';
				}

				$output .= '<div id="nice_likes_wp_notices" class="' . $class . '">';

				$output .= $wp_notices;
				$output .= $wp_settings_errors;

				$output .= '</div><!-- #nice_likes_wp_notices -->';
			}

			$output = apply_filters( 'nice_likes_admin_ui_wp_notices_html', $output, $this );

			echo $output; // WPCS: XSS ok.
		}
	}

	/**
	 * Generate HTML output for WordPress' settings updated notices.
	 *
	 * @since 1.0
	 */
	public function wp_settings_updated_notices() {
		$output = '';

		$wp_settings_updated = $this->ui->{'wp_settings_updated'};

		if ( ! ( empty( $wp_settings_updated ) && empty( $wp_settings_errors ) ) ) {
			$class = 'nice-likes-wp-notices clearfix hide-third-parties';

			$output .= '<div id="nice_likes_wp_settings_updated_notices" class="' . $class . '">';

			$output .= $wp_settings_updated;

			$output .= '</div><!-- #nice_likes_wp_settings_updated_notices -->';
		}

		$output = apply_filters( 'nice_likes_admin_ui_wp_settings_updated_notices_html', $output, $this );

		echo $output; // WPCS: XSS ok.
	}

	/**
	 * Obtain the URL of a section.
	 *
	 * @since  1.0
	 *
	 * @param  string  $section_id
	 * @param  bool    $display
	 * @return string
	 */
	public function section_url( $section_id, $display = true ) {
		$section = $this->ui->{'sections'}[ $section_id ];
		$location = $this->ui->{'submenu_parent_slug'};

		$check_location = ( stripos( $location, '?' ) === false );
		$check_custom_url = empty( $section['custom_url'] );

		$location = $check_location ? $location . '?' : $location . '&';

		$default_url = $location . 'page=' . $this->ui->{'name'} . '&section=' . $section_id;

		$section_url = $check_custom_url ? $default_url : $section['custom_url'];
		$section_url = apply_filters( 'nice_likes_admin_ui_section_url',
			$section_url, $section_id, $display, $this
		);

		if ( $display ) {
			echo esc_url( $section_url );
		}

		return $section_url;
	}

	/**
	 * Obtain the target for the link of a section.
	 *
	 * @since  1.0
	 *
	 * @param  string $section_id
	 * @param  bool   $display
	 * @return string
	 */
	public function section_target( $section_id, $display = true ) {
		$section = $this->ui->{'sections'}[ $section_id ];
		$check = empty( $section['target'] );

		$section_target = $check ? '' : 'target="' . $section['target'] . '"';
		$section_target = apply_filters( 'nice_likes_admin_ui_section_target',
			$section_target, $section_id, $display, $this
		);

		if ( $display ) {
			echo $section_target; // WPCS: XSS ok.
		}
		return $section_target;
	}

	/**
	 * Obtain the URL of a tab.
	 *
	 * @since  1.0
	 *
	 * @param  string $section_id
	 * @param  string $tab_id
	 * @param  bool   $display
	 * @return string
	 */
	public function tab_url( $section_id, $tab_id, $display = true ) {
		$location = $this->ui->{'submenu_parent_slug'};
		$check_separator = ( stripos( $location, '?' ) === false );

		$location = $check_separator ? $location . '?' : $location . '&';

		$section_tab_url = $location . 'page=' . $this->ui->{'name'} . '&section=' . $section_id . '&tab=' . $tab_id;
		$section_tab_url = apply_filters( 'nice_likes_admin_ui_section_tab_url',
			$section_tab_url, $section_id, $tab_id, $this
		);

		if ( $display ) {
			echo $section_tab_url; // WPCS: XSS ok.
		}

		return $section_tab_url;
	}

	/**
	 * Obtain class for section link.
	 *
	 * @since 1.0
	 *
	 * @param  string $section_id
	 * @param  bool   $display
	 * @return string
	 */
	public function section_class( $section_id, $display = true ) {
		$section_class = '';
		if ( $section_id === $this->ui->{'current_section'} ) {
			$section_class = 'current';
		}
		$section_class = apply_filters( 'nice_likes_admin_ui_section_class',
			$section_class, $section_id, $this
		);

		if ( $display ) {
			echo esc_attr( $section_class );
		}
		return $section_class;
	}

	/**
	 * Obtain class for tab link.
	 *
	 * @since 1.0
	 *
	 * @param  string $section_id
	 * @param  string $tab_id
	 * @param  bool   $display
	 * @return string
	 */
	public function tab_class( $section_id, $tab_id, $display = true ) {
		$tab_class = 'nav-tab';
		if (   $section_id === $this->ui->{'current_section'}
			&& $tab_id === $this->ui->{'current_tab'}
		) {
			$tab_class .= ' nav-tab-active';
		}
		$tab_class = apply_filters( 'nice_likes_admin_ui_tab_class',
			$tab_class, $section_id, $tab_id, $this
		);

		if ( $display ) {
			echo $tab_class; // WPCS: XSS ok.
		}
		return $tab_class;
	}
}
