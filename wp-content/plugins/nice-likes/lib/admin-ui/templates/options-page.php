<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for options page.
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
 *
 * @package Nice_Likes_Admin_UI
 * @since   1.0
 */
?>
	<?php if ( $ui instanceof Nice_Likes_Admin_UI ) : ?>
		<div class="nice-admin-wrapper">

			<div class="nice-admin-frame">

				<div class="header">
					<nav class="header-nav drawer-nav nav-horizontal" role="navigation">
						<?php $ui->get_template_part( 'sections-menu' ); ?>
					</nav>
				</div><!-- .header -->

				<div class="container clearfix">
					<?php $ui->get_template_part( 'tab-heading' ); ?>
					<?php $ui->get_template_part( 'notices' ); ?>
					<?php $ui->get_template_part( 'tab-content' ); ?>
					<?php $ui->get_template_part( 'footer' ); ?>
				</div><!-- .wrapper -->

			</div><!-- .nice-admin-frame -->

		</div><!-- .nice-admin-content -->
	<?php endif; ?>
