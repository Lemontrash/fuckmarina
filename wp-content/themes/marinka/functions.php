<?php
/**
 * Marinka functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Marinka
 */

if ( ! function_exists( 'marinka_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function marinka_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Marinka, use a find and replace
		 * to change 'marinka' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'marinka', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
// 		register_nav_menus( array(
// 			'menu-1' => esc_html__( 'Primary', 'marinka' ),
// 		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'marinka_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'marinka_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function marinka_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'marinka_content_width', 640 );
}
add_action( 'after_setup_theme', 'marinka_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function marinka_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'marinka' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'marinka' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'marinka_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
//add_filter('json_enabled', '__return_false');
//add_filter('json_jsonp_enabled', '__return_false');


function marinka_scripts() {
	wp_enqueue_style( 'marinka-style', get_stylesheet_uri() );
    wp_enqueue_style( 'marinka-bootslider-css','https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.css' );
    wp_enqueue_script( 'marinka-bootslider', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.js', array(), '20151215', true );
	wp_enqueue_style( 'coelix-assistant-font','https://fonts.googleapis.com/css?family=Rubik:400,400i,500,700,900&subset=hebrew' );
	wp_enqueue_style( 'coelix-font-awesome','https://use.fontawesome.com/releases/v5.6.3/css/all.css' );
	wp_enqueue_style( 'coelix-animate-css',get_template_directory_uri().'/assets/css/animate.css' );
	wp_enqueue_style( 'coelix-slick-css','//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css' );
	wp_enqueue_script( 'coelix-jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', array(), '20151215', true );	
	wp_enqueue_script( 'coelix-slick-js', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array(), '20151215', true );
	wp_enqueue_script( 'coelix-particles-js', 'https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js', array(), '20151215', true );
	wp_enqueue_script( 'marinka-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );
    wp_enqueue_script( 'marinka-main', get_template_directory_uri() . '/assets/js/main.js', array(), '20151215', true );

	wp_enqueue_script( 'marinka-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'marinka_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

add_action( 'after_setup_theme', 'theme_register_nav_menu' );
function theme_register_nav_menu() {
	register_nav_menu( 'HLMenu', 'Header Left Menu' );
	register_nav_menu( 'HRMenu', 'Header Right Menu' );
	register_nav_menu( 'HMMenu', 'Header Main Menu' );
}
add_action( 'init', 'register_post_types' );


//function true_register_wp_sidebars() {
//
//    /* В боковой колонке - первый сайдбар */
//    register_sidebar(
//        array(
//            'id' => 'true_side', // уникальный id
//            'name' => 'Боковая колонка', // название сайдбара
//            'description' => 'Перетащите сюда виджеты, чтобы добавить их в сайдбар.', // описание
//            'before_widget' => '<div id="%1$s" class="side widget %2$s">', // по умолчанию виджеты выводятся <li>-списком
//            'after_widget' => '</div>',
//            'before_title' => '<h3 class="widget-title">', // по умолчанию заголовки виджетов в <h2>
//            'after_title' => '</h3>'
//        )
//    );
//
//    /* В подвале - второй сайдбар */
//    register_sidebar(
//        array(
//            'id' => 'true_foot',
//            'name' => 'Футер',
//            'description' => 'Перетащите сюда виджеты, чтобы добавить их в футер.',
//            'before_widget' => '<div id="%1$s" class="foot widget %2$s">',
//            'after_widget' => '</div>',
//            'before_title' => '<h3 class="widget-title">',
//            'after_title' => '</h3>'
//        )
//    );
//}








function register_post_types(){
    register_post_type('testimonials', array(
        'label'  => null,
        'labels' => array(
            'name'               => 'testimonials', // основное название для типа записи
            'singular_name'      => 'testimonial', // название для одной записи этого типа
            'add_new'            => 'Добавить testimonial', // для добавления новой записи
            'add_new_item'       => 'Добавление testimonial', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование testimonial', // для редактирования типа записи
            'new_item'           => 'Новое testimonial', // текст новой записи
            'view_item'          => 'Смотреть testimonialов', // для просмотра записи этого типа.
            'search_items'       => 'Искать testimonials', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'testimonial', // название меню
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui'             => null, // зависит от public
        'show_in_menu'        => null, // показывать ли в меню адмнки
        'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null, // зависит от public
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );
    register_post_type('our_team', array(
        'label'  => null,
        'labels' => array(
            'name'               => 'Our Team', // основное название для типа записи
            'singular_name'      => 'Our Team', // название для одной записи этого типа
            'add_new'            => 'Добавить Our Team', // для добавления новой записи
            'add_new_item'       => 'Добавление Our Team', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование Our Team', // для редактирования типа записи
            'new_item'           => 'Новое Our Team', // текст новой записи
            'view_item'          => 'Смотреть Our Team', // для просмотра записи этого типа.
            'search_items'       => 'Искать Our Team', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Our Team', // название меню
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui'             => null, // зависит от public
        'show_in_menu'        => null, // показывать ли в меню адмнки
        'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null, // зависит от public
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor','thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );
    register_post_type('yacht', array(
        'label'  => null,
        'labels' => array(
            'name'               => 'yacht', // основное название для типа записи
            'singular_name'      => 'yacht', // название для одной записи этого типа
            'add_new'            => 'Добавить yacht', // для добавления новой записи
            'add_new_item'       => 'Добавление yacht', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование yacht', // для редактирования типа записи
            'new_item'           => 'Новое yacht', // текст новой записи
            'view_item'          => 'Смотреть yacht', // для просмотра записи этого типа.
            'search_items'       => 'Искать yacht', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'yacht', // название меню
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => null, // зависит от public
        'exclude_from_search' => null, // зависит от public
        'show_ui'             => null, // зависит от public
        'show_in_menu'        => null, // показывать ли в меню адмнки
        'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
        'show_in_nav_menus'   => null, // зависит от public
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => array('title','editor', 'thumbnail'), // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array(),
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ) );
}



function wptp_create_post_type() {
    $labels = array(
        'name' => __( 'Lessons' ),
        'singular_name' => __( 'Lessons' ),
        'add_new' => __( 'New Lesson' ),
        'add_new_item' => __( 'Add New Lesson' ),
        'edit_item' => __( 'Edit Lesson' ),
        'new_item' => __( 'New Lesson' ),
        'view_item' => __( 'View Lesson' ),
        'search_items' => __( 'Search Lessons' ),
        'not_found' =>  __( 'No Lessons Found' ),
        'not_found_in_trash' => __( 'No Articles found in Trash' ),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail'
        ),
    );
    register_post_type( 'lessons', $args );
}

add_action( 'init', 'wptp_create_post_type' );



function wptp_register_taxonomy() {
    register_taxonomy( 'lessons_tax', 'lessons',
        array(
            'labels' => array(
                'name'              => 'Article Categories',
                'singular_name'     => 'Article Category',
                'search_items'      => 'Search Article Categories',
                'all_items'         => 'All Article Categories',
                'edit_item'         => 'Edit Article Categories',
                'update_item'       => 'Update Article Category',
                'add_new_item'      => 'Add New Article Category',
                'new_item_name'     => 'New Article Category Name',
                'menu_name'         => 'Lessons',
            ),
            'hierarchical' => true,
            'sort' => true,
            'args' => array( 'orderby' => 'term_order' ),
            'show_admin_column' => true
        )
    );

}
add_action( 'init', 'wptp_register_taxonomy' );

function wpb_set_post_views($postID) {  // views counter
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    wpb_set_post_views($post_id);
}
function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

add_action( 'wp_head', 'wpb_track_post_views');
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);


function postsSlider(){
    $args = array(
        'posts_per_page' =>-1,
        'post_type' => 'post',
    );

    $query = new WP_Query( $args );

    // Цикл
    if ( $query->have_posts() ) {
        

        while ( $query->have_posts() ) {

            $query->the_post();
            $age = get_field('job',$post->ID);
            $testimonial_image_url = get_field('testimonials_photo',$post->ID);

            ?>
            <div class="FBPostSliderItem">
                <img src="<?= get_bloginfo('template_url'); ?>/assets/img/SliderItem1.png" class="FBPostSliderImg">
                <h4 class="FBPostSliderHeading"><?= get_the_title(); ?></h4>
                <span class="FBPostSliderTxt"> <?= the_excerpt(); ?> </span>
                <a href="#toPost" class="FBPostSliderButton">קרא עוד</a>
            </div>
            <?php
        }
    }
    wp_reset_postdata();
}







function visibleTestimonialContent(){
    $args = array(
        'posts_per_page' =>2,
        'post_type' => 'testimonials',
        'orderby' => 'date',
        'order' => 'ASC',
    );
    $query = new WP_Query( $args );
    // Цикл
    if ( $query->have_posts() ) {
        $counter = 0;
        while ( $query->have_posts() ) {
            $query->the_post();
            $job = get_field('job',$post->ID);
            $testimonial_image_url = get_field('testimonials_photo',$post->ID);
            ?>
            <div class="TBTestimonialRow">
                <img class="TBTestimonialImg" src="<?= $testimonial_image_url; ?>">
                <div class="TBTTxtBlock">
                    <span class="TBTestimonialTxt"><?= get_the_content(); ?></span>
                    <span class="TBTestimonialCredentials"><?= $job; ?></span>
                </div>
            </div>
            <?php
        }
    }

    wp_reset_postdata();
}



function hiddenContentOnButton(){
    $args = array(
        'posts_per_page' =>3,
        'post_type' => 'testimonials',
        'orderby' => 'date',
        'order' => 'DESC',
    );

    $query = new WP_Query( $args );

    // Цикл
    if ( $query->have_posts() ) {
        $counter = 0;

        while ( $query->have_posts() ) {

            $query->the_post();
            $job = get_field('job',$post->ID);
            $testimonial_image_url = get_field('testimonials_photo',$post->ID);

            ?>
            <div class="TBTestimonialRow">
                <img class="TBTestimonialImg" src="<?= $testimonial_image_url; ?>">
                <div class="TBTTxtBlock">
                    <span class="TBTestimonialTxt"><?= get_the_content(); ?></span>
                    <span class="TBTestimonialCredentials"><?= $job; ?></span>
                </div>
            </div>
            <?php
        }
    }

    wp_reset_postdata();
}

function ourTeam(){
    $args = array(
        'posts_per_page' =>4,
        'post_type' => 'our_team',
    );

    $query = new WP_Query( $args );

    // Цикл
    if ( $query->have_posts() ) {
        $counter = 0;

        while ( $query->have_posts() ) {

            $query->the_post();

            ?>

            <div class="our-team-element">
                <div class="photo">
                    <img class="floatImageContent" src="<?= the_post_thumbnail_url($post->ID) ?>" >
                </div>
                <h2>
                    <?= get_the_title(); ?>
                </h2>
                <h3>
                    <?= get_field('position',$post->ID); ?>
                </h3>
                <div class="text">
                    <?= the_content() ?>
                </div>
            </div>


            <?php
        }
    }

    wp_reset_postdata();
}

function filterYachts(){
    $args = array(
        'posts_per_page' -1,
        'post_type' => 'yacht',
    );

    $query = new WP_Query( $args );

    // Цикл
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {

            $query->the_post();
            $name = get_field('name',$post->ID);
            $email = get_field('email',$post->ID);
            $bio = get_field('bio',$post->ID);
//            $testimonial_image_url = get_field('testimonials_photo',$post->ID);

            ?>

            <?= get_the_title(); ?>
            <?= $name; ?>
            <?= $email; ?>
            <?= $bio; ?>


            <?php
        }
    }

    wp_reset_postdata();
}

do_action( 'nice_likes_custom' );