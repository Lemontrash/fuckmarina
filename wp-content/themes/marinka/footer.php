<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Marinka
 */

?>

<!-- 	</div>#content -->
<div class="Footer" style="display: none">
	<div class="FooterFormRow">
		<h1 class="FooterFormHeading">להפלגת היכרות ללא תשלום מלאו את הטופס</h1>
		<div class="FooterFormItem">
    	<?php echo do_shortcode('[caldera_form id="CF5ca77516b4a73"]');?>
    	</div>
    </div>
	<div class="FooterColumsRow">
		<div class="FooterColumnItem">
			<h3 class="FCHeading">צור קשר</h3>
			<span class="FCTxt">
				מרינה תל אביב <br>
				טלפון: <a href="tel:0723719911">072-3719911</a><br>
				פקס: <a href="tel:037607896">03-7607896</a><br>
				דוא"ל: <a href="mailto:info@sea-time.co.il">info@sea-time.co.il</a>  
			</span>
		</div>
		<div class="FooterColumnItem">
			<h3 class="FCHeading">פורטל לימודים</h3>
			<span class="FCTxt">
				מאיפה מתחילים<br>
				איך משיטים כלי שייט גדול<br>
				סודות רב החובל<br>
				?מה לעשות במקרי חירום
			</span>			
		</div>
		<div class="FooterColumnItem">
			<h3 class="FCHeading">פוסטים אחרונים</h3>
			<span class="FCTxt">
				הבלוג שלנו<br>
				למה להיות סקיפר?<br>
				השטת יאכטה למי זה מתאים?<br>
				רישיון סקיפר ישראלי לעומת רישיונות זרים<br>
				לעבוד כסקיפר - כל אחד יכול<br>
				חוויות מקורס סקיפרים 
			</span>			
		</div>
		<div class="FooterColumnItem">
			<h3 class="FCHeading">קורסים</h3>
			<span class="FCTxt">
				קורס סקיפרים מקצועי<br>
				קורס ליאכטות 7 מטר<br>
				קורס סקיפרים ביוון<br>
				קורס משיט 30<br>
				חוגי שייט לילדים
			</span>			
		</div>
	</div>
	<div class="FooterLowerRow">
		<div class="FooterSocialsBlock">
			<a href="#"><i class="fab fa-instagram"></i></a>
			<a href="#"><i class="fab fa-facebook-f"></i></a>
			<a href="#"><i class="fab fa-youtube"></i></a>
		</div>
		<div class="FooterCopyrightBlock">
			<span class="FCopyright">שייט – Sea time כל הזכויות שמורות |   השכרת יאכטה,לימודי שייט</span>
		</div>
	</div>
</div>			
	
	<?php wp_footer(); ?> 
</body>
</html>
