
<?php
if ( ! function_exists( 'nice_likes_body_class' ) ) :
    add_filter( 'body_class', 'nice_likes_body_class' );
    /**
     * Modify default body class.
     *
     * @since  1.0
     *
     * @param  array            $classes
     * @return array|mixed|void
     */
    function nice_likes_body_class( $classes ) {
        $settings = nice_likes_settings();

        if ( $settings['use_ajax'] ) {
            $classes[] = 'ajax-nice-likes';
        }
        $classes = apply_filters( 'nice_likes_body_class', $classes );

        return $classes;
    }
endif;

if ( ! function_exists( 'nice_likes_content_filter' ) ) :
    add_filter( 'the_content', 'nice_likes_content_filter', 999 );
    add_filter( 'the_excerpt', 'nice_likes_content_filter', 999 );
    /**
     * Filter for `the_content()`.
     *
     * A high priority ensures likes will appear right before or after the content.
     *
     * @since  1.0
     *
     * @param  string $content
     * @return string
     */
    function nice_likes_content_filter( $content ) {
        global $wp_current_filter;

        $settings = nice_likes_settings();

        // Don't show on custom page templates.
        if ( is_page_template() ) {
            return $content;
        }

        // Excluding likes from specific custom post types.
        if ( in_array( get_post_type(), apply_filters( 'nice_likes_excluded_post_types', array() ), true ) ) {
            return $content;
        }

        if ( in_array( 'get_the_excerpt', (array) $wp_current_filter, true ) ) {
            return $content;
        }

        // Avoid adding the likes functionality to posts/pages which are excluded.
        $exclude = $settings['exclude'];
        if ( $exclude ) {
            $ids = explode( ',', $exclude );
            if ( in_array( get_the_ID(), $ids, true ) ) {
                return $content;
            }
        }

        $original_content = $content;

        // The magic :)
        $position = $settings['position'];

        $content = nice_likes_apply() ? nice_likes_in_content( $content, $position ) : $content;
        $content = apply_filters( 'nice_likes_content_filter', $content, $original_content );

        return $content;
    }
endif;

if ( ! function_exists( 'nice_likes_custom_location' ) ) :
    add_action( 'nice_likes_custom', 'nice_likes_custom_location' );
    /**
     * Show likes in a custom location.
     *
     * In order for this hook to work, `do_action( 'nice_likes_custom' );`
     * should be placed in the location where likes need to appear.
     *
     * @since 1.0
     */
    function nice_likes_custom_location() {
        $settings = nice_likes_settings();

        if ( 'custom' === $settings['position'] && nice_likes_apply() ) {
            echo nice_likes( array( get_the_ID() ) ); // WPCS: XSS ok.
        }
    }
endif;
