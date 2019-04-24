<?php
/**
 * NiceThemes Admin UI.
 *
 * Default template for section tabs.
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
		<?php do_action( 'nice_likes_admin_ui_before_navtabs' ); ?>

		<?php if ( is_array( $current_tab_group ) and ! empty( $current_tab_group ) ) : ?>

			<h2 id="navtabs" class="nav-tab-wrapper">
				<?php foreach ( $current_tab_group as $id => $tab ) : ?>
					<a class="<?php $html->tab_class( $current_section, $id ); ?>" title="<?php echo esc_attr( $tab['title'] ); ?>" href="<?php $html->tab_url( $current_section, $id ); ?>">
						<i class="dashicons <?php echo esc_attr( $tab['icon'] ); ?>"></i>
						<?php echo $tab['title']; // WPCS: XSS ok. ?>
					</a>
				<?php endforeach; ?>
			</h2>

			<?php
				$html->wp_settings_updated_notices();
			?>

		<?php endif; ?>
		<?php do_action( 'nice_likes_admin_ui_after_navtabs' ); ?>

	<?php endif; ?>
