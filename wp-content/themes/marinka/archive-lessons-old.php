<?php
/*
Template Name: single-lessons
*/

get_header();
?>

<div class="lessonsWrapper">
    <h1>lesson page</h1>
    <div class="lessonPage">
        <aside>
            <?php
            global $post;
            $tmp = wp_get_post_terms( $post->ID, 'lessons_tax' );
            $terms = get_terms( array(
                'taxonomy' => 'lessons_tax',
                'hide_empty' => false,
            ) );

            foreach($terms as $t) :

                ?>
                <div class="lessonParent <?php if( $tmp[0]->term_id == $t->term_id ){ echo 'opened'; }?>">
                    <div class="lessonName"><?= $t->name; ?></div>
                    <ul>
                        <?php
                        $lessons = new WP_Query( [
                            'post_type' => 'lessons',
                            'orderby' => 'date',
                            'order' => 'ASC',
                            'tax_query' => [
                                [
                                    'taxonomy' => 'lessons_tax',
                                    'field'    => 'id',
                                    'terms'    => $t->term_id
                                ]
                            ]
                        ] );
                        if($lessons->have_posts()) {
                            while($lessons->have_posts()) {
                                $lessons->the_post();
                                ?>
                                <li><a href="<?= get_the_permalink(); ?>"><?= get_the_title();?></a></li>
                                <?php
                            }
                        }
                        ?>

                    </ul>
                </div>

            <?php endforeach; wp_reset_postdata(); ?>

        </aside>
        <div class="lessonContent">
            <?php

            while ( have_posts() ) :

                the_post();
                $headline = get_field('headline',$post->ID);
                ?>
                <h2> <?= $headline; ?></h2>
                <div class="contentWrapper">
                    <img  class="floatImageContent" src="<?= the_post_thumbnail_url($post->ID,'full') ?>" alt="">
                    <p class="contentText">
                        <?= get_the_content(); ?>
                    </p>
                </div>
                 
                <?php wpb_set_post_views(get_the_ID()); ?> 
                <div class="views"><?= nice_likes() ; ?> <?=wpb_get_post_views(get_the_ID()) ?> </div><br>
            <?php
            endwhile; // End of the loop.
            ?>
        </div>
    </div>
</div>




<?php 
get_footer(); 
?>

<script>

    $('.lessonName').on('click',function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('opened');
    })


</script>
