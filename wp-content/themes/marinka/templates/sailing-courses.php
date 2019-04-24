<?php
/*
Template Name: sailing-courses
*/

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
        .blogContent h3{
            text-transform: capitalize;
            color: #1D9FB3;
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
            <h2> BLOG ENTRY </h2>
            <div class="contentWrapper">
                <img  class="floatImageContent" src="http://qnimate.com/wp-content/uploads/2014/03/images2.jpg" alt="">
                <p class="contentText">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam aut beatae consequuntur cum distinctio dolor dolore eaque exercitationem id, illo illum itaque maiores minima minus mollitia non perferendis perspiciatis praesentium quidem quos reiciendis, rem repudiandae rerum sapiente veniam voluptatem voluptatum.
                    <h3>Accusantium aliquam aliquid beatae debitis</h3> dicta dignissimos dolor ea esse inventore iure maxime, officia placeat quae, recusandae reprehenderit! Alias aliquam aliquid, aspernatur atque blanditiis doloribus ea eos excepturi incidunt ipsam itaque iusto laboriosam laborum libero mollitia necessitatibus nemo neque, nulla pariatur perferendis placeat quam quasi qui quos repellat, sapiente sequi <h3>sit soluta vel voluptatem! </h3>A asperiores aspernatur dignissimos error et excepturi exercitationem facere fugit ipsam nobis nostrum, officia voluptate! Adipisci asperiores assumenda atque aut culpa distinctio, dolorum harum illo libero, magnam odit officia officiis praesentium quam, quasi quibusdam ratione recusandae. Nam, obcaecati praesentium? A, ab accusamus aliquam amet beatae consequuntur dolorem doloremque eaque illum iusto maxime nam nulla perferendis quidem quo saepe tempore voluptates? Accusamus accusantium amet asperiores at consequuntur corporis doloremque doloribus, error, eum eveniet excepturi expedita illum ipsum iusto maiores nemo nisi nostrum optio perferendis praesentium quia similique vero. Ab blanditiis cupiditate, eius, eligendi hic libero maxime minima omnis pariatur similique totam, vero! Dignissimos dolorum excepturi facere, hic iste magni saepe sed ullam voluptas! Debitis, doloremque explicabo illum iure labore minus odio odit officiis perferendis quia, ratione repellendus? Deleniti earum esse in iure iusto laborum, modi nulla repellendus unde. Ad, beatae consequuntur cum cumque cupiditate dignissimos distinctio eaque eius enim eos error esse facilis in nesciunt numquam odit placeat repellat similique. Dicta minus nulla perferendis quia! Atque beatae cupiditate deleniti doloremque, et iure mollitia necessitatibus optio provident repellat tempore ullam vitae. Aut eaque enim molestiae necessitatibus nobis, possimus provident quasi qui? Amet deleniti distinctio dolores, doloribus ea eveniet fugit hic iure iusto mollitia nostrum possimus praesentium provident quam quo totam veritatis? Animi consequatur dolorem, earum iste nostrum vitae? Aspernatur, consequuntur corporis cumque delectus doloremque esse eum facilis illo iste iusto maiores natus nostrum omnis quas sunt! Ab accusantium culpa deserunt, dolor dolore ducimus eius eum ex harum, incidunt ipsam laboriosam mollitia, nemo odio quisquam reiciendis repellat vero voluptatum? Consequuntur dolorem explicabo officia porro, similique sunt? Accusamus aliquid at beatae corporis dolorem eligendi, est et facere fuga id, ipsa maxime modi nulla numquam perferendis placeat porro quaerat quis rerum, sint unde ut voluptatibus. Autem delectus distinctio impedit ipsa ipsum laboriosam modi reprehenderit? Corporis delectus explicabo impedit incidunt tempore, voluptate?
                </p>
            </div>

            <?php wpb_set_post_views(get_the_ID()); ?>
           <div class="views"><?= nice_likes() ; ?> <?=wpb_get_post_views(get_the_ID()) ?> </div>
    </div>

<?php get_footer();
