<?php
/**
 * Nice Likes by NiceThemes.
 *
 * About Page Header for Admin UI.
 *
 * @package Nice_Likes_Admin_UI
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
	<div class="heading">
		<div class="masthead about">
			<h1><?php printf( esc_html__( 'Nice Likes %s', 'nice-likes' ), esc_attr( nice_likes_plugin_version() ) ); ?></h1>
			<h2><?php esc_html_e( 'A simple and customizable Likes plugin for your website', 'nice-likes' ); ?></h2>
		</div>
	</div>
