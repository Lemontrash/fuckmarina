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
 * Class Nice_Likes_Admin_UI_Form_Handler
 *
 * Helper class for easier management of form elements within an Admin UI.
 *
 * @since 1.0
 */
class Nice_Likes_Admin_UI_Form_Handler {
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
	 * Obtain a text input field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_text( $option_name, $description, $current_value = null, $placeholder = null ) {
		$output = '<input id="' . $option_name . '" class="nice-text regular-text" type="text" name="' . $option_name . '" value="' . esc_attr( $current_value ) . '" placeholder="' . $placeholder . '" />';
		$output .= $description ? '<p class="description"><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_text',
			$output, $option_name, $description, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a small text input field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_text_small( $option_name, $description, $current_value = null, $placeholder = null ) {
		$output = '<input id="' . $option_name . '" class="nice-text small-text" type="text" name="' . $option_name . '" value="' . esc_attr( $current_value ) . '" placeholder="' . $placeholder . '" />';
		$output .= $description ? '<p class="description"><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_text_small',
			$output, $option_name, $description, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a password input field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_password( $option_name, $description, $current_value = null, $placeholder = null ) {
		$output = '<input id="' . $option_name . '" class="nice-password regular-text" type="text" name="' . $option_name . '" value="' . esc_attr( $current_value ) . '" placeholder="' . $placeholder . '" />';
		$output .= $description ? '<p class="description"><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_password',
			$output, $option_name, $description, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a checkbox input field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_checkbox( $option_name, $description, $current_value = null, $placeholder = null ) {
		$output = '<input type="hidden" name="' . $option_name . '" value="0" />';
		$output .= '<input id="' . $option_name . '" class="nice-checkbox" type="checkbox" name="' . $option_name . '" value="1" ' . checked( $current_value, 1, false ) . ' />';
		$output .= $description ? '<label for="' . $option_name . '"> ' . $description . '</label>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_checkbox',
			$output, $option_name, $description, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a group of checkbox input fields.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  array       $options
	 * @param  null|string $current_value
	 * @return string
	 */
	public function field_checkbox_group( $option_name, $description, $options, $current_value = null ) {
		$output = '';
		if ( ! empty( $options ) ) {
			foreach ( $options as $k => $v ) {
				if ( ( is_string( $k ) || is_integer( $k ) ) && is_string( $v ) ) {
					$_option_name = $option_name . '[' . $k . ']';
					$current = isset( $current_value[ $k ] ) ? $current_value[ $k ] : 0;
					$output .= '<input type="hidden" name="' . $_option_name . '" value="0" />';
					$output .= '<input id="' . $_option_name . '" class="nice-checkbox" type="checkbox" name="' . $_option_name . '" value="1" ' . checked( $current, 1, false ) . ' />';
					$output .= '<label for="' . $_option_name . '"> ' . $v . '</label><br />';
				}
			}
			$output .= $description ? '<p class="description"> ' . $description . '</p>' : '';
		}
		$output = apply_filters( 'nice_likes_admin_ui_field_checkbox_group',
			$output, $option_name, $description, $options, $current_value, $this
		);

		return $output;
	}

	/**
	 * Obtain a group of checkbox input fields.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  array       $options
	 * @param  null|string $current_value
	 * @return string
	 */
	public function field_radio( $option_name, $description, $options, $current_value = null ) {
		$output = '';
		if ( ! empty( $options ) ) {
			foreach ( $options as $k => $v ) {
				if ( ( is_string( $k ) || is_integer( $k ) ) && is_string( $v ) ) {
					$_option_name = $option_name . '[' . $k . ']';
					$output .= '<input id="' . $_option_name . '" class="nice-radio" type="radio" name="' . $option_name . '" value="' . esc_attr( $k ) . '" ' . checked( $current_value, $k, false ) . ' />';
					$output .= '<label for="' . $_option_name . '"> ' . $v . '</label><br />';
				}
			}
			$output .= $description ? '<p class="description"> ' . $description . '</p>' : '';
		}
		$output = apply_filters( 'nice_likes_admin_ui_field_radio',
			$output, $option_name, $description, $options, $current_value, $this
		);

		return $output;
	}

	/**
	 * Obtain a textarea field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_textarea( $option_name, $description, $current_value = null, $placeholder = null ) {
		$output = '<textarea id="' . $option_name . '" class="nice-textarea large-text" type="textarea" name="' . $option_name . '" placeholder="' . $placeholder . '">' . esc_textarea( $current_value ) . '</textarea>';
		$output .= $description ? '<p class="description"><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_textarea',
			$output, $option_name, $description, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a select field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  array       $options
	 * @param  null|string $current_value
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_select( $option_name, $description, $options = array(), $current_value = null, $placeholder = null ) {
		$output = '<select id="' . $option_name . '" class="nice-select regular-text" name="' . $option_name . '">';
		if ( $placeholder ) {
			$output .= '<option value="" disabled>' . $placeholder . '</option>';
		}
		if ( ! empty( $options ) ) {
			foreach ( $options as $k => $v ) {
				if ( ( is_string( $k ) || is_integer( $k ) ) && is_string( $v ) ) {
					$output .= '<option value="' . $k . '" ' . selected( $k, $current_value, false ) . '>' . $v . '</option>';
				}
			}
		}
		$output .= '</select>';
		$output .= $description ? '<p><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_select',
			$output, $option_name, $description, $options, $current_value, $placeholder, $this
		);

		return $output;
	}

	/**
	 * Obtain a multiple select field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  array       $options
	 * @param  null|string $current_value
	 * @return string
	 */
	public function field_select_multiple( $option_name, $description, $options = array(), $current_value = null ) {
		$output = '<select multiple id="' . $option_name . '" class="nice-select regular-text" name="' . $option_name . '[]">';
		$current_value = $current_value ? : array();
		if ( ! empty( $options ) ) {
			foreach ( $options as $k => $v ) {
				if ( ( is_string( $k ) || is_integer( $k ) ) && is_string( $v ) ) {
					$output .= '<option value="' . esc_attr( $k ) . '" ' . selected( in_array( $k, $current_value, true ), true, false ) . '>' . $v . '</option>';
				}
			}
		}
		$output .= '</select>';
		$output .= $description ? '<p><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_select_multiple',
			$output, $option_name, $description, $options, $current_value, $this
		);

		return $output;
	}

	/**
	 * Obtain a color picker field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @return string
	 */
	public function field_color( $option_name, $description, $current_value = null ) {
		$output = '<input type="text" data-default-color="#ffffff" value="' . $current_value . '" name="' . $option_name . '" id="' . $option_name . '" class="nice-color-picker">';
		$output .= $description ? '<p class="description"> ' . $description . '</p>' : '';

		$output = apply_filters( 'nice_likes_admin_ui_field_color',
			$output, $option_name, $description, $current_value, $this
		);

		return $output;
	}

	/**
	 * Obtain a file uploader field.
	 *
	 * @since  1.0
	 *
	 * @param  string      $option_name
	 * @param  string      $description
	 * @param  null|string $current_value
	 * @param  null|string $button_text
	 * @param  null|string $placeholder
	 * @return string
	 */
	public function field_upload( $option_name, $description, $current_value = null, $button_text = null, $placeholder = null ) {
		$output = '<input type="text" placeholder="' . $placeholder . '" value="' . $current_value . '" name="' . $option_name . '" id="' . $option_name . '" class="regular-text nice_likes_admin_upload_field" />';
		$output .= '<span>&nbsp;<input type="button" value="' . $button_text . '" class="nice_likes_admin_upload_button button-secondary"></span>';
		$output .= $description ? '<p class="description"><label for="' . $option_name . '"> ' . $description . '</label></p>' : '';
		$output .= '<div class="screenshot"></div>';

		$output = apply_filters( 'nice_likes_admin_ui_field_upload',
			$output, $option_name, $description, $current_value, $button_text, $placeholder, $this
		);

		return $output;
	}
}
