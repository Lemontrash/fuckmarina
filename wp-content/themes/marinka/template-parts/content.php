<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Marinka
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			//the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			//the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
		
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-image">
		<?php marinka_post_thumbnail(); ?>
	</div>
	<div class="entry-excerpt">
		<?= the_excerpt(); ?> 
	</div>

	<div class="entry-content">
		<?php
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'marinka' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );

		// wp_link_pages( array(
		// 	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'marinka' ),
		// 	'after'  => '</div>',
		// ) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
        <div class="entry-lower">
        	<?php wpb_set_post_views(get_the_ID()); ?> 
			<div class="entry-socialActive">
        		<?= nice_likes() ; ?> 
       			<?= wpb_get_post_views(get_the_ID()) ?>
			</div>
       		<div class="entry-time">
				<?= marinka_posted_on(); ?>
			</div>
        </div>
		
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
