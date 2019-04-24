<?php


get_header();
?>
    <style>
        .blogContent img{
            margin-right: 18px;
            float: left;
        }
        .blogContent p{
            line-height: 22px;
            text-align: justify;
            word-break: break-word;
        }
        .blogContent p:first-letter{
            font-size: 38px;
        }
        .blogContent{
            direction: ltr;
            margin: 0 80px 0 80px;
        }
        .blogContent h2{
            text-transform: capitalize;
            color: #2e312a;
            margin: 24px 0 0 24px;
        }
        .blogContent h2:after{
            content: '';
            display: inline-block;
            background-color: #2e312a;
            margin-left: 16px;
            margin-bottom: 6px;
            width: 150px;
            height: 1px;
        }
    </style>
    <div class="blogContent">
            <h2> <?= the_title() ?> </h2>
            <div class="contentWrapper">
                <img  class="floatImageContent" src="<?= the_post_thumbnail_url($post->ID)?>" alt="">
                <p class="contentText">
                    <?= get_post_field('post_content', $post->ID);  ?>
                </p>
            </div>

            <?php wpb_set_post_views(get_the_ID()); ?>
           <div class="views"><?= nice_likes() ; ?> <?=wpb_get_post_views(get_the_ID()) ?> </div>
    </div>

<?php get_footer();
