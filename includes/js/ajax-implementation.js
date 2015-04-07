/** AJAX */

jQuery(document).ready(function() {

	jQuery(".ajax-closed-button").on("click", function(event) {
		event.preventDefault();

		var image_href = jQuery(this).attr("href");
		var lightbox =  jQuery('<div id="lightbox">' +
							'<p class="nbx_lighbx_close">Click to Close</p>' +
						'</div> <!-- end of #lightbox -->' +
						'<div id="lightbox_main_content">'+
							'<h2>You seem excited</h2>' +
							'<p>You\'ll have to wait patently untill this day is available.</p>' +
						'</div> <!-- end of #lightbox_main_content -->').hide().fadeIn();

		jQuery('body').append(lightbox);
		jQuery(document).on('click', '#lightbox', function(){
			jQuery('#lightbox, #lightbox_main_content').fadeOut(300, function() {
				jQuery(this).remove();
			});
		});
	});

	jQuery(".ajax_button").click(function(){
		event.preventDefault();
		var value = jQuery(this).attr('value');

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl, // the url which the request is sent. Defined in includes/functions.php
			data: {  // string. key->value pairs
				action: 'MyAjaxFunction',
				theId: value // This is what will go out as $_POST
			},
			success: function(data, textStatus, XMLHttpRequest){
				if(jQuery('#lightbox').length > 0) { // if #lightbox exists
					jQuery('#lightbox_main_content').html(data);
					jQuery('#lightbox').fadeIn();
				} else {
					// #lightbox does not exist. Let's create and append it to the body
					var data2 = jQuery(data).fadeIn();
					jQuery('body').append(data2);
				}
			},
			error: function(MLHttpRequest, textStatus, errorThrown){
				alert(errorThrown);
			}
		});

		jQuery(document).on('click', '#lightbox', function() {
			jQuery('#lightbox, #lightbox_main_content').fadeOut(300, function() {
				jQuery(this).remove();
			});
		});
	});

});

