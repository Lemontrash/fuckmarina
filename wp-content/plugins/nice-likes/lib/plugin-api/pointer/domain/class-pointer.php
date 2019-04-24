<?php
class Nice_Likes_Pointer extends Nice_Likes_Entity {
	/**
	 * Unique ID for this pointer.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $id = 'nice_likes_pointer';

	/**
	 * Page hook we want our pointer to show in.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $screen = 'options.php';

	/**
	 * CSS selector for the pointer to be tied to.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $target = '#menu-settings';

	/**
	 * Title for this pointer.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $title = 'This is the title of a pointer';

	/**
	 * Text for this pointer.
	 *
	 * @var   string
	 * @since 1.0
	 */
	protected $content = 'This is the content of the pointer';

	/**
	 * Location of this pointer.
	 *
	 * @var   array
	 * @since 1.0
	 */
	protected $position = array(
		'edge'  => 'left',   // Available options: top, bottom, left, right.
		'align' => 'middle', // Available options: top, bottom, left, right, middle.
	);
}
