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
 * Class Nice_Likes_DisplayAction
 *
 * This class takes charge of the display process of
 * Nice_Likes_EntityInterface instances, and the preparation of the related
 * responder. It's meant to be used as a default class for domains that, while
 * needing to implement a Display action, don't need any specific functionality
 * for it.
 *
 * @since 1.0
 */
class Nice_Likes_DisplayAction extends Nice_Likes_DisplayActionAbstract {}
