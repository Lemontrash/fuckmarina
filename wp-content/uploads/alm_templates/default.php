<?php function ourTeam(){
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
                    <img class="floatImageContent" src="<?php the_post_thumbnail_url($post->ID) ?>" >
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
} ?>