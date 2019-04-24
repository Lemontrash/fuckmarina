<?php
/**
 * Register settings for Admin UI.
 *
 * @package   Nice_Likes
 * @author    NiceThemes <hello@nicethemes.com>
 * @license   GPL-2.0+
 * @link      https://nicethemes.com/product/nice-likes
 * @copyright 2016 NiceThemes
 * @since     1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'nice_likes_admin_ui_settings' ) ) :
add_filter( 'nice_likes_admin_ui_settings', 'nice_likes_admin_ui_settings' );
/**
 * Create tabs.
 *
 * @since 1.0
 */
function nice_likes_admin_ui_settings() {
	// Fields for General tab.
	$general_settings = array(
		'enable'       => array(
			'id'          => 'enable',
			'title'       => esc_html__( 'Enable Likes', 'nice-likes' ),
			'description' => esc_html__( 'Get the plugin working.', 'nice-likes' ),
			'type'        => 'checkbox',
			'priority'    => 10,
		),
		'add_to'       => array(
			'id'          => 'add_to',
			'title'       => esc_html__( 'Show Likes in', 'nice-likes' ),
			'description' => esc_html__( 'Select where you want to show likes.', 'nice-likes' ),
			'type'        => 'checkbox-group',
			'options'     => apply_filters( 'nice_likes_admin_ui_add_to_options', array(
					'posts' => esc_html__( 'Posts', 'nice-likes' ),
					'pages' => esc_html__( 'Pages', 'nice-likes' ),
				)
			),
			'priority'    => 20,
		),
		'show_in_lists' => array(
			'id'          => 'show_in_lists',
			'title'       => esc_html__( 'Show in admin post lists', 'nice-likes' ),
			'description' => esc_html__( 'Display likes count for each entry in posts and pages lists in the admin side.', 'nice-likes' ),
			'type'        => 'checkbox',
			'priority'    => 25,
		),
		'exclude'      => array(
			'id'          => 'exclude',
			'title'       => esc_html__( 'Exclude by ID', 'nice-likes' ),
			'description' => esc_html__( 'Enter here the IDs (comma-separated) of posts and pages where you don\'t want to show likes.', 'nice-likes' ),
			'type'        => 'text',
			'priority'    => 30,
		),
		'position'     => array(
			'id'          => 'position',
			'title'       => esc_html__( 'Position', 'nice-likes' ),
			'description' => sprintf( esc_html__( 'Select the position where likes will appear within posts and pages. If you select a custom location, you need to add %s to your theme.', 'nice-likes' ), '<code>' . htmlentities( '<?php do_action( \'nice_likes_custom\' ); ?>' ) . '</code>' ),
			'type'        => 'radio',
			'options'     => array(
				'before' => esc_html__( 'Before the content', 'nice-likes' ),
				'after'  => esc_html__( 'After the content', 'nice-likes' ),
				'custom' => esc_html__( 'In a custom location', 'nice-likes' ),
			),
			'priority'    => 40,
		),
		'postfix_zero' => array(
			'id'          => 'postfix_zero',
			'title'       => esc_html__( 'Text format for zero likes', 'nice-likes' ),
			'description' => esc_html__( 'The text to show when there are no likes. Use "%s" for the number.', 'nice-likes' ),
			'type'        => 'text',
			'priority'    => 50,
		),
		'postfix_one'  => array(
			'id'          => 'postfix_one',
			'title'       => esc_html__( 'Text format for one like', 'nice-likes' ),
			'description' => esc_html__( 'The text to show when there\'s only one like. Use "%s" for the number.', 'nice-likes' ),
			'type'        => 'text',
			'priority'    => 60,
		),
		'postfix_more' => array(
			'id'          => 'postfix_more',
			'title'       => esc_html__( 'Text format for more than one like.', 'nice-likes' ),
			'description' => esc_html__( 'The text to show when there\'s more than one like. Use "%s" for the number.', 'nice-likes' ),
			'type'        => 'text',
			'priority'    => 70,
		),
		'unlike_text'  => array(
			'id'          => 'unlike_text',
			'title'       => esc_html__( 'Text for "unlike" link.', 'nice-likes' ),
			'description' => esc_html__( 'Text for the link that will remove the visitor\'s like. If left empty, the link will not be displayed.', 'nice-likes' ),
			'type'        => 'text',
			'priority'    => 80,
		),
		'use_ajax'     => array(
			'id'          => 'use_ajax',
			'title'       => esc_html__( 'Use AJAX', 'nice-likes' ),
			'description' => esc_html__( 'Automatically update the count of likes without reloading the page.', 'nice-likes' ),
			'type'        => 'checkbox',
			'priority'    => 90,
		),
		'avoidcss'     => array(
			'id'          => 'avoidcss',
			'title'       => esc_html__( 'Avoid Plugin CSS', 'nice-likes' ),
			'description' => esc_html__( 'Apply styles to likes elements using your own CSS.', 'nice-likes' ),
			'type'        => 'checkbox',
			'priority'    => 100,
		),
	);

	// Fields for Advanced tab.
	$advanced_settings = array(
		'remove_data_on_deactivation' => array(
			'id'          => 'remove_data_on_deactivation',
			'title'       => esc_html__( 'Remove Data On Deactivation', 'nice-likes' ),
			'description' => esc_html__( 'Delete all plugin settings once you deactivate it.', 'nice-likes' ),
			'type'        => 'checkbox',
			'priority'    => 10,
		),
	);

	// Construct settings array.
	$settings = array(
		array(
			'settings_section' => 'general-settings',
			'tab'              => 'general',
			'section'          => 'settings',
			'args'             => $general_settings,
		),
		array(
			'settings_section' => 'advanced-settings',
			'tab'              => 'advanced',
			'section'          => 'settings',
			'args'             => $advanced_settings,
		),
	);

	return $settings;
}
endif;

if ( ! function_exists( 'nice_likes_admin_ui_add_to_custom_options' ) ) :
add_filter( 'nice_likes_admin_ui_add_to_options', 'nice_likes_admin_ui_add_to_custom_options', 99 );
/**
 * Add conditional options to "add to" settings.
 *
 * @since  1.0
 *
 * @param  array $options Filterable options.
 * @return array
 */
function nice_likes_admin_ui_add_to_custom_options( $options = array() ) {
	// Add "other" as a last option, after all other possibilities have been listed.
	$options['other'] = esc_html__( 'Other (blog, categories, archives, etc.)', 'nice-likes' );

	return $options;
}
endif;
