<?php
/*
Template Name: israel-cruise
*/
get_header();
?>
    <style>
        .blog-wrapper h1{
            text-transform: capitalize;
        }
        a, a:visited{
            text-decoration: none;
            color: #6d7282;
        }
        .blog-wrapper{
            max-width: 900px;
            margin: 0 auto;
            direction: ltr;
            height: 100%;
            flex-wrap: wrap;
        }
        .blog-wrapper h1{
            margin-bottom: 0;
            color: #1D9FB3;
            font-size: 46px;
        }
        .blog-wrapper .content{
            display: flex;
            flex-wrap: wrap;
            flex-basis: 100%;
            flex-direction: row;
            justify-content: space-between;
        }
        .blog-wrapper .content p{
            overflow: hidden;
            max-height: 44px;
            margin-bottom: 0;
        }
        .blog-wrapper .content .element{
            flex-direction: column;
            flex-wrap: wrap;
            transition: 1.3s;
            text-align: center;
            max-width: 250px;
            max-height: 270px;
        }
        .blog-wrapper .content .image{
            /*background-color: #ff3324;*/
            width: 250px;
            height: 150px;
        }

        .blog-wrapper .content .element:hover .image-bgc{
            background-color: transparent;
            background: -moz-linear-gradient(top, rgba(53,165,168,0) 0%, rgba(53,165,168,0) 39%, rgba(53,165,168,1) 100%);
            background: -webkit-linear-gradient(top, rgba(53,165,168,0) 0%,rgba(53,165,168,0) 39%,rgba(53,165,168,1) 100%);
            background: linear-gradient(to bottom, rgba(53,165,168,0) 0%,rgba(53,165,168,0) 39%,rgba(53,165,168,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0035a5a8', endColorstr='#35a5a8',GradientType=0 );
            opacity: 1;
            transition: 0.5s;
        }
        .blog-wrapper .content .element .image-bgc{
            transition: 1.3s;
            background-color: transparent;
            width: 100%;
            height: 100%;
            opacity: 0;
        }
        .blog-wrapper .content .element .title{
            color: #1D9FB3;
            font-size: 20px;
        }
        .blog-wrapper .content .element .text{

        }
        .blog-wrapper .content .element button{
            width: 80px;
            padding: 2px 12px;
            background-color: white;
            border: solid #d5d6db 2px;
            border-radius: 20PX;
            margin-bottom: 30px;
            margin-top: 15px;
            /*vertical-align: center;*/
            /*transition: 1.2s;*/
        }
        .blog-wrapper .content .element:hover button{
            background-color: #1D9FB3;
            border:solid transparent 2px;;
            transition: 1.2s;
        }
    </style>
    <div class="blog-wrapper">
        <h1>
            cruises in Israel
        </h1>
        <div class="content">

            <?php
            $args = array(
                'posts_per_page'    => -1,
                'post_type'         => 'post',
                'orderby'           => 'date',
                'order'             => 'DESC',
                'category_name'     => 'cruises-in-israel',
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();
                    $title = get_the_title();
                    $content = get_the_content();
                    ?>
                    <div class="element">
                        <div class="image" style="background-image:url(<?= the_post_thumbnail_url($post->ID)?>);">
                            <div class="image-bgc"></div>
                        </div>
                        <div class="title">
                            <?= $title ?>
                        </div>
                        <div class="text">
                            <?= the_excerpt()?>
                        </div>
                        <button>
                            <a href="<?= get_permalink() ?>"> < קרא עוד </a>
                        </button>
                    </div>


                <?php
                endwhile;
            endif;

            wp_reset_postdata();
            ?>
<!--            <div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div>-->
<!--            <div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div><div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div><div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div><div class="element">-->
<!--                <div class="image">-->
<!--                    <div class="image-bgc"></div>-->
<!--                </div>-->
<!--                <div class="title">-->
<!--                    title-->
<!--                </div>-->
<!--                <div class="text">-->
<!--                    text-->
<!--                </div>-->
<!--                <button>-->
<!--                    <a href=""> GO </a>-->
<!--                </button>-->
<!--            </div>-->

        </div>
    </div>

<?php
get_footer();