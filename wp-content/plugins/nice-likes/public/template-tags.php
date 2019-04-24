<?php
/**
 * Nice Likes by NiceThemes.
 *
 * @package Nice_Likes
 * @since   1.0
 */

if ( ! function_exists( 'nice_likes' ) ) :
    /**
     * Process and print likes.
     *
     * @since  1.0
     *
     * @param  array $args
     * @return string
     */
    function nice_likes( $args = array() ) {
        $settings = nice_likes_settings();

        // Check if the plugin is ready to work.
        if ( ! $settings['enable'] ) {
            return null;
        }

        $defaults = apply_filters( 'nice_likes_default_args', array(
                'echo'         => false,
                'before'       => '',
                'after'        => '',
                'post_id'      => '',
                'class'        => '',
                'icon'         => '<i class="nice-likes-icon-heart"></i>',
                'loading_text' => esc_html__( '', 'nice-likes' ),
                'show_postfix' => true,
                'query_id'     => rand( 0, 9999 ),
            )
        );
        $args = wp_parse_args( $args, $defaults );
        $args = apply_filters( 'nice_likes_args', $args );

        do_action( 'nice_likes_before', $args );

        $post_id = ( '' === $args['post_id'] ) ? get_the_ID() : $args['post_id'];

        $likes_count = nice_likes_count( $post_id );

        // Check if likes should load via AJAX.
        $waiting_ajax = $settings['use_ajax'] && ! nice_likes_doing_ajax();

        // Check if visitor can like the current post.
        $can_like = nice_likes_can( $post_id );

        // Check if visitor can unlike the current post.
        $can_unlike = ! $can_like && $settings['unlike_text'] && ! $waiting_ajax;

        $output = '';

        $output .= $args['before'] . "\n";

        $like_url = $settings['use_ajax'] ? '#' : nice_likes_get_url( array( 'post_id' => $post_id, 'nonce' => wp_create_nonce( 'nice-likes-nonce' ) ) );
        $like_tpl_content = '%%ICON%%%%COUNT%%';

        $like_tpl = '<a id="like-' . $post_id . '" class="nice-likes %%CLASS%%" href="' . $like_url . '" data-id="' . $post_id . '" data-postfix="' . intval( nice_likes_bool( $args['show_postfix'] ) ) . '" data-query="' . intval( $args['query_id'] ) . '">' . $like_tpl_content . '</a>';
        $like_tpl = apply_filters( 'nice_likes_like_template', $like_tpl, $args );

        $unlike_tpl = '<a class="nice-likes-unlike" href="' . $like_url . '" data-id="' . $post_id . '" data-postfix="' . intval( nice_likes_bool( $args['show_postfix'] ) ) . '" data-query="' . intval( $args['query_id'] ) . '">%%UNLIKE%%</a>';
        $unlike_tpl = apply_filters( 'nice_likes_unlike_template', $unlike_tpl, $args );

        $html  = $like_tpl;
        $html .= $can_unlike ? $unlike_tpl : '';

        $class  = $args['class'];
        $class .= $waiting_ajax ? ' waiting' : '';
        $class .= ! $waiting_ajax && ! nice_likes_can( $post_id ) ? ' ' : '';
        $class .= ! $waiting_ajax ? ' ' . $likes_count . '' : '';

        $html = str_replace( '%%CLASS%%', $class, $html );

        $icon = $args['icon'];
        $html = str_replace( '%%ICON%%', $icon, $html );

        if ( $waiting_ajax ) {
            $count = $args['loading_text'];
            $count = apply_filters( 'nice_likes_loading_text', $count );
        } else {
            $count = nice_likes_count_text( $post_id, $likes_count, nice_likes_bool( $args['show_postfix'] ) ) . "\n";
        }
        $html  = str_replace( '%%COUNT%%', $count, $html );

        if ( $can_unlike ) {
            $html = str_replace( '%%UNLIKE%%', $settings['unlike_text'], $html );
        }

        $html = apply_filters( 'nice_likes_html', $html, $post_id );

        $output .= $html;

        $output .= $args['after'] . "\n";

        // Allow extensions to filter here.
        $output = apply_filters( 'nice_likes_output', $output, $post_id, $args );

        if ( true === $args['echo'] ) {
            echo $output; // WPCS: XSS ok.
        }

        do_action( 'nice_likes_after', $args );

        return $output;
    }
endif;
