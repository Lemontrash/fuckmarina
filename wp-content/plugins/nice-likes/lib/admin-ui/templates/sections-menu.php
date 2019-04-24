<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for sections menu.
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
 * @package   Nice_Likes_Admin_UI
 * @license   GPL-2.0+
 */

?>
	<?php if ( $ui instanceof Nice_Likes_Admin_UI ) : ?>
		<ul class="main-nav">

			<li class="nice-logo">
				<?php if ( $logo ) : ?>
					<span class="title image-title"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $title ); ?>" /></span>
				<?php else : ?>
					<span class="title">
						<?php echo $title; // WPCS: XSS ok. ?>
					</span>
				<?php endif; ?>
			</li>

			<?php foreach ( $sections as $id => $section ) : ?>
				<li class="nice-page">
					<a class="<?php $html->section_class( $id ); ?>" <?php $html->section_target( $id ); ?> href="<?php $html->section_url( $id ); ?>">
						<i class="dashicons <?php echo esc_attr( $section['icon'] ); ?>"></i>
						<?php echo $section['title']; // WPCS: XSS ok. ?>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>
	<?php endif; ?>
