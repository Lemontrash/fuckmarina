<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for tab header.
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
		<div class="heading">

			<div class="masthead">
				<?php if ( $section['header'] ) : ?>
					<div class="head">
						<?php echo $section['header']; // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
				<?php if ( $section['subheader'] ) : ?>
					<div class="subhead">
						<?php echo $section['subheader']; // WPCS: XSS ok. ?>
					</div>
				<?php endif; ?>
				<div class="section-description">
					<h1>
						<?php echo $section['heading_title'] ? : $section['title']; // WPCS: XSS ok. ?>
					</h1>
					<?php echo $section['description']; // WPCS: XSS ok. ?>
				</div>
			</div>

		</div>
	<?php endif; ?>
