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
 * Class Nice_Likes_Integration
 *
 * This class is meant to be used as a container/descriptor of third party
 * applications (plugins or themes) that are natively supported by this plugin.
 * The code for these integrations should be loaded conditionally in separated
 * processes that check if they need to be fired.
 *
 * @see Nice_Likes_IntegrationCreateResponder
 *
 * @package Nice_Likes_Plugin_API
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
class Nice_Likes_Integration extends Nice_Likes_Entity {
	/**
	 * Internal handler for the integration.
	 *
	 * @var   null|string
	 * @since 1.0
	 */
	protected $name = null;

	/**
	 * Integration type (optional).
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $type = 'plugin';

	/**
	 * Full path to the file or folder containing PHP code for the integration.
	 *
	 * @var   null|string
	 * @since 1.0
	 */
	protected $path = null;

	/**
	 * Name of the action where the integration should be hooked (optional).
	 *
	 * @var   null|string
	 * @since 1.0
	 */
	protected $action = null;

	/**
	 * Execution priority of the action (optional).
	 *
	 * @var   int
	 * @since 1.0
	 */
	protected $priority = 10;

	/**
	 * Callback to validate the loading process (optional).
	 *
	 * @see call_user_func()
	 *
	 * @var   null|string|array
	 * @since 1.0
	 */
	protected $callback = null;

	/**
	 * Property for the integration to be forced to load (or not) in case an
	 * action has not been declared (optional).
	 *
	 * @var   bool
	 * @since 1.0
	 */
	protected $load = false;

	/**
	 * The name of a function of the third party application. It will be used
	 * to check if the application has been loaded.
	 *
	 * @var   null|string
	 * @since 1.0
	 */
	protected $function_exists = null;

	/**
	 * The name of a class of the third party application. It will be used to
	 * check if the application has been loaded.
	 *
	 * @var   null|string
	 * @since 1.0
	 */
	protected $class_exists = null;
}
