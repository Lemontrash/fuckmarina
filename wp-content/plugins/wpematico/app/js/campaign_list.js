jQuery(document).ready(function($){


	var icon_plus = 'dashicons-visibility';
	var icon_dismis = 'dashicons-hidden';

	
	//minimize action
	$(".icon-minimize-div").click(function(){
		$('.div-wpematico-smart-notification').fadeOut();
		
	});
	
	$(".icon-close-div").click(function(){
		$(this).parent().parent().slideUp(500);
		wpematico_close_notification();
	});
	
	theclock();

	$('button[btn-href]').click(function(e) {
		location.href = $(this).attr('btn-href');
	});
	$(document).on("click", 'button.state_buttons.dashicons-controls-play', function(e) {
		var post_id = jQuery(this).parent().parent().parent().attr('id').replace('post-', '');
		run_now(post_id);
		e.preventDefault();
	});


	$('span:contains("'+wpematico_object.text_slug+'")').each(function (i) {
		$(this).parent().hide();
	});
	$('span:contains("'+wpematico_object.text_password+'")').each(function (i) {
		$(this).parent().parent().hide();
	});
	$('select[name="_status"]').each(function (i) {
		$(this).parent().parent().parent().parent().hide();
	});
	$('span:contains("'+wpematico_object.text_date+'")').each(function (i) {
		$(this).parent().hide();
	});
	$('.inline-edit-date').each(function (i) {
		$(this).hide();
	});
	$('.inline-edit-col-left').append(	$('#optionscampaign').html() );
	$('#optionscampaign').remove();
				
	$('#screen-meta-links').append('<div id="contextual-help-link-wrap" class="hide-if-no-js screen-meta-toggle"><button type="button" id="show-clock" class="button show-clock" aria-controls="clock-wrap" aria-expanded="false">'+wpematico_object.i18n_date_format+'</button></div>');
				
	$("#cb-select-all-1, #cb-select-all-2").change (function() {
		$("input[name='post[]']").each(function() {
			if($(this).is(':checked')) {
				$("tr#post-"+ $(this).val() ).css('background-color', '#dbb27e');
			} else {
				$("tr#post-"+ $(this).val() ).attr('style','');
			}
		});
	});
	$("input[name='post[]']").change(function() {
		if($(this).is(':checked')){	
			$("input[name='post[]']:checked").each(function() {
				$("tr#post-"+ $(this).val() ).css('background-color', '#dbb27e');
			});
		} else {
			$("tr#post-"+ $(this).val() ).attr('style','');
		}
	});
});
function wpematico_close_notification() {
	var data = {
		'action': 'wpematico_close_notification',
	};
	// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	jQuery.post(ajaxurl, data, function(response) {
		//response
	});
}
function run_now(c_ID) {
	jQuery('html').css('cursor','wait');
	jQuery('#post-'+c_ID+' .state_buttons.dashicons-controls-play').addClass('green');
	jQuery("div[id=fieldserror]").remove();
	var msgdev = '<p><img width="16" src="'+wpematico_object.image_run_loading+'"> <span style="vertical-align: top;margin: 10px;">'+wpematico_object.text_running_campaign+'</span></p>';
	jQuery(".subsubsub").before('<div id="fieldserror" class="updated fade">'+msgdev+'</div>');
	var data = {
		campaign_ID: c_ID ,
		action: "wpematico_run"
	};
	jQuery.post(ajaxurl, data, function(msgdev) {  //si todo ok devuelve LOG sino 0
		jQuery('#fieldserror').remove();
		if( msgdev.substring(0, 5) == 'ERROR' ){
			jQuery(".subsubsub").before('<div id="fieldserror" class="error fade">'+msgdev+'</div>');
		} else {
			jQuery(".subsubsub").before('<div id="fieldserror" class="updated fade">'+msgdev+'</div>');
			var floor = Math.floor;
			var bef_posts = floor( jQuery("tr#post-"+c_ID+" > .count").html() );
			var ret_posts = floor( bef_posts + floor(jQuery("#ret_lastposts").html()) );
			if(bef_posts == ret_posts) {
				jQuery("tr#post-"+c_ID+" > .count").attr('style', 'font-weight: bold;color:#555;');
			} else {
				jQuery("tr#post-"+c_ID+" > .count").attr('style', 'font-weight: bold;color:#F00;');
			}
			jQuery("tr#post-"+c_ID+" > .count").html( ret_posts.toString() );
			jQuery("#lastruntime").html( jQuery("#ret_lastruntime").html());
			jQuery("#lastruntime").attr( 'style', 'font-weight: bold;');
		}
		jQuery('html').css('cursor','auto');
		jQuery('#post-'+c_ID+' .state_buttons.dashicons-controls-play').removeClass('green');
	});
}

function run_all() {
	var selectedItems = 0;
	jQuery("input[name='post[]']:checked").each(function() {selectedItems++;});
	if (selectedItems == 0) {
		alert(wpematico_object.text_select_a_campaign_to_run); 
		return false; 
	}
				
	jQuery('html').css('cursor','wait');
	jQuery('#fieldserror').remove();
	var msgdev = '<p><img width="16" src="'+wpematico_object.image_run_loading+'"> <span style="vertical-align: top;margin: 10px;">'+wpematico_object.text_running_campaign+'</span></p>';
	jQuery(".subsubsub").before('<div id="fieldserror" class="updated fade ajaxstop">'+msgdev+'</div>');
	jQuery("input[name='post[]']:checked").each(function() {
		var c_ID = jQuery(this).val();
		jQuery('#post-'+c_ID+' .state_buttons.dashicons-controls-play').addClass('green');
		var data = {
				campaign_ID: c_ID ,
				action: "wpematico_run"
		};
		jQuery.post(ajaxurl, data, function(msgdev) {  //si todo ok devuelve LOG sino 0
				if( msgdev.substring(0, 5) == 'ERROR' ) {
					jQuery(".subsubsub").before('<div id="fieldserror" class="error fade">'+msgdev+'</div>');
				} else {
					jQuery(".subsubsub").before('<div id="fieldserror" class="updated fade">'+msgdev+'</div>');
					var floor = Math.floor;
					var bef_posts = floor( jQuery("tr#post-"+c_ID+" > .count").html() );
					var ret_posts = floor( bef_posts + floor(jQuery('#log_message_'+c_ID).next().next("#ret_lastposts").html()) );
					if(bef_posts == ret_posts) {
						jQuery("tr#post-"+c_ID+" > .count").attr('style', 'font-weight: bold;color:#555;');
					}
					else {
						jQuery("tr#post-"+c_ID+" > .count").attr('style', 'font-weight: bold;color:#F00;');
					}
					jQuery("tr#post-"+c_ID+" > .count").html( ret_posts.toString() );
					jQuery("#lastruntime").html( jQuery("#ret_lastruntime").html());
					jQuery("#lastruntime").attr( 'style', 'font-weight: bold;');
				}
				jQuery('#post-'+c_ID+' .state_buttons.dashicons-controls-play').removeClass('green');

		});
	}).ajaxStop(function() {
		jQuery('html').css('cursor','auto');
		jQuery('.ajaxstop').remove().ajaxStop();
	});
}
function theclock() {
	nowdate = new Date();
	now = nowdate.format(wpematico_object.date_format);
	char=(nowdate.getSeconds()%2==0 )?' ':':';
	jQuery('#show-clock').html(now.replace(':', char) );
	setTimeout("theclock()",1000);
} 