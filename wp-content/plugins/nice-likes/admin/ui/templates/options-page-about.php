<?php
/**
 * Nice Likes by NiceThemes.
 *
 * Template for About section.
 *
 * @package Nice_Likes
 * @since   1.0
 */
?>
	<?php if ( $ui instanceof Nice_Likes_Admin_UI ) : ?>
		<div class="nice-admin-wrapper about">

			<div class="nice-admin-frame">

				<div class="header">
					<nav class="header-nav drawer-nav nav-horizontal" role="navigation">
						<?php $ui->get_template_part( 'sections-menu' ); ?>
					</nav>
				</div><!-- .header -->

				<div class="container clearfix">
					<?php $ui->get_template_part( 'about-heading' ); ?>
					<?php $ui->get_template_part( 'about-content' ); ?>
					<?php $ui->get_template_part( 'footer' ); ?>
				</div><!-- .wrapper -->

			</div><!-- .nice-admin-frame -->

		</div><!-- .nice-admin-content -->
	<?php endif; ?>
