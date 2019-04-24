<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Social links sidebar content.
 *
 * @package Nice_Likes
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
$profiles   = array(
	'Twitter'   => 'http://twitter.com/nicethemes',
	'Facebook'  => 'http://facebook.com/nicethemes',
	'WordPress' => 'https://profiles.wordpress.org/nicethemes',
);
?>

<p>
	<ul class="nice-admin-social">
		<?php foreach ( $profiles as $name => $url ) : ?>
			<li class="<?php echo esc_attr( strtolower( $name ) ); ?>">
			<a href="<?php echo esc_url( $url ); ?>" target="_blank">
				<?php if ( $is_mp6 = nice_likes_admin_ui_is_mp6() ) : ?>
					<i class="dashicons dashicons-<?php echo esc_attr( strtolower( $name ) ); ?>"></i>
				<?php else : ?>
					<?php echo $name; // WPCS: XSS ok. ?>
				<?php endif; ?>
			</a>
			</li>
			<?php if ( ! $is_mp6 ) : ?> | <?php endif; ?>
		<?php endforeach; ?>
	</ul>
</p>
