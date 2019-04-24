<?php
/**
 * NiceThemes ADR
 *
 * @package Nice_Likes_ADR
 * @license GPL-2.0+
 * @since   1.0
 */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Nice_Likes_ActionAbstract
 *
 * This class takes charge of the plugin activation process and the preparation
 * of the related responder.
 *
 * @package Nice_Likes_ADR
 * @author  NiceThemes <hello@nicethemes.com>
 * @since   1.0
 */
abstract class Nice_Likes_ActionAbstract implements Nice_Likes_ActionInterface {
	/**
	 * @var   Nice_Likes_ServiceInterface
	 * @since 1.0
	 */
	protected $domain;

	/**
	 * @var   Nice_Likes_ResponderInterface
	 * @since 1.0
	 */
	protected $responder;

	/**
	 * Set up initial state of action.
	 *
	 * @since 1.0
	 *
	 * @param Nice_Likes_ServiceInterface   $domain
	 * @param Nice_Likes_ResponderInterface $responder
	 */
	public function __construct(
		Nice_Likes_ServiceInterface $domain,
		Nice_Likes_ResponderInterface $responder
	) {
		$this->domain    = $domain;
		$this->responder = $responder;
	}

	/**
	 * Create new Nice_Likes_EntityInterface instance and fire responder.
	 *
	 * @since  1.0
	 *
	 * @param  array                          $data Data to create the new instance.
	 *
	 * @return Nice_Likes_EntityInterface
	 */
	public function __invoke( array $data ) {}

	/**
	 * Prepare instance to be displayed or updated.
	 *
	 * @since  1.0
	 *
	 * @param  array $data Data to prepare the instance.
	 */
	public function prepare( array $data ) {}
}
