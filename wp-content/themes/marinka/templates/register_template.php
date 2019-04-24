<?php
/*
Template Name: Register
*/
?>
<?php get_header(); ?>

<div class="fullpage" >
	<div class="section">
		<div class="register_wrapper" style="background-size:cover; background-image:url(<?= get_bloginfo('template_url'); ?>/assets/img/RegisterBack.png">
			<div class="RegisterBlock">
				<?php echo do_shortcode('[user_registration_form id="95"]');?>
			</div>
		</div>
	</div>        
</div>

<?php
get_footer();
?>