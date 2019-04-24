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
 * Class Nice_Likes_i18n
 *
 * This class takes charge of internationalization processes, such as loading
 * the plugin's text domain from language files and assigning the right domain.
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_i18n extends Nice_Likes_Entity {
	/**
	 * The domain specified for this plugin.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $domain = '';

	/**
	 * Path to the folder containing files for the current text domain.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $path = '';

	/**
	 * Locale data for text domain.
	 *
	 * @since 1.0
	 * @var   string
	 */
	protected $locale = '';
}
