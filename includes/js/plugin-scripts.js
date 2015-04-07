/** IMAGE UPLOADER */

jQuery(function(jQuery) {

    jQuery('.custom_upload_image_button').click(function() {
        formfield = jQuery(this).siblings('.custom_upload_image');
        preview = jQuery(this).siblings('.custom_preview_image');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            classes = jQuery('img', html).attr('class');
            id = classes.replace(/(.*?)wp-image-/, '');
            formfield.val(id);
            preview.attr('src', imgurl);
            tb_remove();
        }
        return false;
    });

    jQuery('.custom_clear_image_button').click(function() {
        var defaultImage = jQuery(this).parent().siblings('.custom_default_image').text();
        jQuery(this).parent().siblings('.custom_upload_image').val('');
        jQuery(this).parent().siblings('.custom_preview_image').attr('src', defaultImage);
        return false;
    });

});

/** File Uploader*/

jQuery(document).ready(function($){

    var custom_uploader;

    $('.upload_image_button').click(function(e) {
		var this_class = $(this).attr('name');

        e.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });

        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.' + this_class).val(attachment.url);
        });

        //Open the uploader dialog
        custom_uploader.open();

    });

});