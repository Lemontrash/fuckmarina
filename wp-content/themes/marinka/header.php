<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Marinka
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url'); ?>/assets/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?= get_bloginfo('template_url'); ?>/assets/slick/slick-theme.css"/>
	<?php wp_head(); ?>
</head>
<body>
	<div class="Header">
		<div class="HeaderUpperRow"> 
			<nav class="HeaderULeftMenu">
			<?php	wp_nav_menu( [
				'theme_location'  => 'HLMenu',
				'container'       => 'div', 
				'container_class' => 'HLMenu', 
				'menu_class'      => 'menu', 
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				] ); ?>
			</nav>	<!-- content : '\f0b2';font-family: 'Font Awesome\ 5 Free'; -->
				<div class="HeaderLogoBlock">
					<div class="HeaderLogoImg"><?php the_custom_logo( $blog_id ); ?></div>
				</div>
			<nav class="HeaderURightMenu">
				<?php	wp_nav_menu( [
				'theme_location'  => 'HRMenu',
				'container'       => 'div', 
				'container_class' => 'HRMenu', 
				'menu_class'      => 'menu', 
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				] ); ?>
			</nav>	
		</div>
		<div class="HeaderLowerRow">
			<nav class="HeaderLMenu">
				<?php	wp_nav_menu( [
				'theme_location'  => 'HMMenu',
				'container'       => 'div', 
				'container_class' => 'HMMenu', 
				'menu_class'      => 'menu', 
				'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
				] ); ?>
			</nav>
		</div>
	</div>