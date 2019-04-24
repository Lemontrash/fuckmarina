<?php
/*
Template Name: AboutUs
*/

get_header();

?>

    <div class="aboutus_wrapper first" style="direction: ltr;">
        <div class="SecondBlock">
            <div class="SBTxtBlock" style="background-size:cover; background-image:url(<?= get_bloginfo('template_url'); ?>/assets/img/SecondBlock1Back.png">
                <div class="SBTxtSection0">
                    <h2 class="SBTxtHeading">קצת עלינו</h2>
                    <div class="SBTxtHr">
                    </div>
                </div>
                <div class="SBTxtSection1">
							<span class="SBTxt">
								בית הספר ומועדון השייט Sea Time הוקם בשנת 2010 במרינה תל אביב ושם לעצמו למטרה להפוך את עולם השייט והיאכטות לנגיש יותר עבור כל אחד ואחת המבקשים להגשים חלום ולהשיט יאכטה בים. אנו מאמינים שלהפליג לומדים בים ולכן כבר מהרגע הראשון נפליג על היאכטה בכדי ללמוד ולהכיר את המפרשים והרוח בים+. לימודי השייט מתאימים לכולם והקורסים השונים בבית הספר מיועדים הן לשייטים מתחילים מהרמה הבסיסית ביותר ועד לקורסים מתקדמים לסקיפרים מקצועיים
							</span>
                </div>
                <div class="SBTxtSection2">
							<span class="SBTxt">
								כל התלמידים הם חלקממועדון היאכטות והם נהניםמהפלגות על מגוון היאכטות שיש למועדוןבמרינה תל אביב. חלק ניכר מפעילות המועדוןמבוצע בחו"ל, כולל קורסים לסקיפרים, טיולי יאכטות מאורגנים, תחרויות שייט בעולם ועוד. אנו מתגאים בכך שתמיד יש לנו מה להציע לכל סקיפר המחפש בית חם ורוצה להפליג, ללמוד ולהתמקצע, מועדון היאכטות מציע בנוסף הפלגות מקצועיות ומודרכות וכן הפלגות חברים פתוחות. מועדון היאכטותSea Timeמשקיע את מרב האמצעים על מנת לשמר את היאכטות ברמת תחזוקה גבוהה המאפשרת חווית שייט אידאלית הן לתלמידים והן לחברי המועדון.
							</span>
                </div>
            </div>

            <div class="SBImgBlock" style="background-size:cover; background-image:url(<?= get_bloginfo('template_url'); ?>/assets/img/SecondBlock2Back.png">
                <div class="SBTxtLine">קצת עלינו</div>
            </div>
        </div>
    </div>
        <h1 class="AboutUsHeading">הצוות שלנו</h1>

        <div class="aboutus_wrapper second">
            <div class="MembersBlock">
            <?= ourTeam(); ?>
            </div>
            <a href="#more" class="TBTButton" onclick="show()">קרא עוד</a>
        </div>

    </div>




<?php
get_footer();
?>