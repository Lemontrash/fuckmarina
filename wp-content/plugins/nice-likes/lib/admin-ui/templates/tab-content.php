<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for tab contents.
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
		<?php $class = empty( $sidebar_boxes ) ? 'full-width' : 'content-sidebar'; ?>
		<div class="page-content <?php echo esc_attr( $class ); ?> clearfix">

			<div class="content">
				<?php $ui->get_template_part( 'section-tabs' ); ?>
				<?php $ui->get_template_part( 'tab-settings' ); ?>
			</div>

			<?php if ( ! empty( $sidebar_boxes ) ) : ?>
				<?php $ui->get_template_part( 'sidebar' ); ?>
			<?php endif; ?>

		</div>
	<?php endif; ?>
