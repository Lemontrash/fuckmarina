<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Newsletter sidebar content.
 *
 * @package Nice_Likes
 * @since   1.0
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<p><?php esc_html_e( 'If you would like to keep up to date regarding Nice Likes and other plugins by NiceThemes, subscribe to the newsletter:', 'nice-likes' ); ?></p>

<!-- Begin MailChimp Signup Form -->
<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
<style type="text/css">
	/*
	 Add your own MailChimp form style overrides in your site stylesheet or in this style block.
	 We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */

	#mc_embed_signup form {
		padding: 0;
	}
</style>

<div id="mc_embed_signup">
<form action="//nicethemes.us2.list-manage.com/subscribe/post?u=8ed99a5242b1ff3a1d7dcbe13&amp;id=b2a4bfaac0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
<div id="mc_embed_signup_scroll">

<div class="mc-field-group">
	<label for="mce-EMAIL"><?php esc_html_e( 'Email Address', 'nice-likes' ); ?></label>
	<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="you@domain.com">
</div>
	<div id="mce-responses" class="clear">
		<div class="response" id="mce-error-response" style="display:none"></div>
		<div class="response" id="mce-success-response" style="display:none"></div>
	</div>
	<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->

	<div style="position: absolute; left: -5000px;"><input type="text" name="b_8ed99a5242b1ff3a1d7dcbe13_b2a4bfaac0" tabindex="-1" value=""></div>
	<div><input type="submit" value="<?php esc_html_e( 'Get me in!', 'nice-likes' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
	</div>
</form>
</div>

<!--End mc_embed_signup-->