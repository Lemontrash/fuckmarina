<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for the footer of the admin UI.
 *
 * You can use the following helper variables here:
 *
	$ui                = (Nice_Likes_Admin_UI)              $ui;
	$name              = (string)                     $ui->name;
	$title             = (string)                     $ui->title;
	$logo              = (string)                     $ui->logo;
	$sidebar_boxes     = (array)                      $ui->sidebar_boxes;
	$footer_links      = (array)                      $ui->footer_links;
	$sections          = (array)                      $ui->sections;
	$current_section   = (string)                     $ui->current_section;
	$current_tab       = (string)                     $ui->current_tab;
	$current_tab_group = (array)                      $ui->current_tab_group;
	$section           = (array)                      $ui->sections[ $current_section ];
	$html              = (Nice_Likes_Admin_UI_HTML_Handler) $ui->html_handler;
 *
 * @package Nice_Likes_Admin_UI
 * @since   1.0
 */
?>
	<?php if ( $ui instanceof Nice_Likes_Admin_UI ) : ?>
		<div class="footer">

			<nav class="primary nav-horizontal">
				<div class="nicethemes-copyright">
					<span>Made with <?php if ( nice_likes_admin_ui_is_mp6() ) : ?><i class="dashicons dashicons-heart" data-code="f487"></i><?php else : ?>love<?php endif; ?> by <a href="http://nicethemes.com/" target="_blank">NiceThemes</a></span>
				</div>
			</nav><!-- .primary -->

			<nav class="secondary nav-horizontal">
				<div class="secondary-footer">
					<?php $html->footer_links(); ?>
				</div>
			</nav><!-- .secondary -->

		</div><!-- .footer -->
	<?php endif; ?>
