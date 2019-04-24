<?php
/*
Template Name: Yacht Club
*/
?>
<?php get_header(); ?>

<div class="fullpage" >
    <div class="section">
        <div class="YachtClub_wrapper">
            <div class="SliderBlock">
                <div class="PostsSlider"><?php postsSlider() ?></div>
            </div>
            <div class="YHeadingBlock">

                <h1 class="YHeadingH">New and exclusive here!</h1>

                <span class="YHeadingText">
                    Our members can see the availability of yachts and place an order through the website anytime and anywhere. Enter your <br> personal account by email and phone and book your cruise
                </span>
            </div>
            <div class="YtxtBlock">
                <div class="YTextBlock">
                <h1 class="YTextBlockHeading">
                   Swim easy<img src="<?= get_bloginfo('template_url'); ?>/assets/img/Line.png" class="YTextBlockLine">
                </h1>
                <span class="YTextBlockText">
                    Yacht Club Sea Time is a family consisting of people with a common love of wind and sails. Members of the club sail on yachts, but in addition they know<br> that they always have a warm home and those who care for them on the platform seven days a week.<br><br>

You come to the network, leaving us a headache from maintenance, cleaning and fuel. Every time you come, you get a clean yacht, ready to sail, so you <br> can go out to sea without worries. Yacht Club Sea-Time gave him a flag of cleanliness and maintenance - it is important for us to always feel at home <br> comfortable. Our members are actively involved in the maintenance of yachts and equipment and are used to returning them after the voyages when they <br> are clean and ready for the next trip.<br>
                </span>
                </div>
                

          
                <div class="YTextBlock">
                <h1 class="YTextBlockHeading">
                   How does it work?<img src="<?= get_bloginfo('template_url'); ?>/assets/img/Line.png" class="YTextBlockLine">
                </h1>
                <span class="YTextBlockText">
                    After sailing with a guide to familiarize yourself with the yacht and procedures, you can sail on our yachts in Tel Aviv. You can buy a small ticket for a <br> cruise to see the quality of the club, but a card with a lot of hours will save you money and every hour of sailing will be cheaper. The club works 7 days a <br> week and 24 hours a day, when you want, you can go sailing even at night (after passing the certification). You can also rent yachts for long cruises <br> along the Israeli coast for several days. This is a special and complex experience that arouses the interest of the club members.
                </span>
                </div>
            </div>   
        </div>
    </div>        
</div>

<?php
get_footer();
?>