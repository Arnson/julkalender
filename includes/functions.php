<?php
/**//**-------------------------------------------------------------------
| CUSTOM PLUGIN FIELDS
|--------------------------------------------------------------------*//**/
// This gets sent to template-company.php
function nbxco_the_company_name() {
	global $nbx_options;

	echo $nbx_options['company_name'];
}

function nbxco_the_header_image() {
	global $nbx_options;

	if( isset($nbx_options['logo_img']) && $nbx_options['logo_img'] != '') {
		echo $nbx_options['logo_img'];
	} else {
		echo NBX_PLUGIN_IMAGE . '/nbxco_template/header_image.png';
	}
}

function nbxco_lightbox() {
	global $nbx_options;

	if( isset($nbx_options['lightbox']) && $nbx_options['lightbox'] != '') {
		echo 'Lightbox Disabled';
	} else {
		echo 'ajax_button';
	}
}

function nbxco_social_media() {
	global $nbx_options;
	global $social_media;

	if( isset($nbx_options['google_plus']) && $nbx_options['google_plus'] != '') {
		$social_media .= '<a href="' . $nbx_options['google_plus'] . '"><img src="'. NBX_PLUGIN_URL . "includes/images/social_icons/nbx_google_plus_icon.png" .'" alt="christmas-media-icons"/></a>';
	}
	if( isset($nbx_options['twitter']) && $nbx_options['twitter'] != '') {
		$social_media .= '<a href="' . $nbx_options['twitter'] . '"><img src="'. NBX_PLUGIN_URL . "includes/images/social_icons/nbx_twitter_icon.png" .'" alt="christmas-media-icons"/></a>';
	}
	if( isset($nbx_options['facebook']) && $nbx_options['facebook'] != '') {
		$social_media .= '<a href="' . $nbx_options['facebook'] . '"><img src="'. NBX_PLUGIN_URL . "includes/images/social_icons/nbx_facebook_icon.png" .'" alt="christmas-media-icons"/></a>';
	}
	return $social_media;
}

/**//**-------------------------------------------------------------------
| MANAGE POSTS COLUMNS
| This is for the dashboard post columns.
| Found under: Dashboard -> Xmas Calendar -> All Days.
|--------------------------------------------------------------------*//**/
add_filter( 'manage_edit-christmas_calendar_columns', 'add_new_columns' );
function add_new_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'Day',
		'nbx_meta_box' => 'Meta Content',
		'nbx_meta_attachments' => 'Meta Attachments',
		'author' => 'Author',
		'date' => 'Date'
	);
	return $columns;
}

//add_action( 'manage_${post_type}_posts_custom_column', '{function_hook()}' );
add_action( 'manage_christmas_calendar_posts_custom_column', 'nbx_custom_columns', 10, 2 );
function nbx_custom_columns( $column, $post_id ) {
	global $nbx_custom_meta_fields;

	switch( $column ) {
		case 'nbx_meta_box':
			foreach ($nbx_custom_meta_fields as $field) {
				$meta = get_post_meta( $post_id, $field['id'], true );

				switch( $field['type'] ) {
					case 'text':
						if( $meta != '' ) {
							echo 'Text input: ' . $meta . ' | ';
						}
						break;
					case 'textarea':
						if( $meta != '' ) {
							echo 'Textarea: ' . $meta;
						}
						break;
				}
			}
		break;

		case 'nbx_meta_attachments':
			foreach ($nbx_custom_meta_fields as $field) {
				$meta = get_post_meta( $post_id, $field['id'], true );

				switch( $field['type'] ) {
					case 'image':
						if( $meta != '' ) {
							$image = wp_get_attachment_image_src($meta, 'small');
							echo '<a href="' . $image[0] . '"><img src="' . $image[0] . '" height="43"/></a> ';
						}
						break;
					case 'file':
						if( $meta != '' ) {
							echo '<a href="' . $meta . '"><img src="' . NBX_PLUGIN_IMAGE  . '/folder.jpg" height="43"/></a> ';
						}
						break;
					case 'youtube':
						if( $meta != '' ) {
							echo '<a href="' . $meta . '"><img src="' . NBX_PLUGIN_IMAGE  . '/youtube.jpg" height="43"/></a>';
						}
						break;
				}
			}
			break;
	}
}


/**//**-------------------------------------------------------------------
| CALENDAR DOORS
| @ function to_hide() – Checks if the doors shall disappear on hover.
|--------------------------------------------------------------------*//**/

function to_hide() {
	global $nbx_options;

	if( isset($nbx_options['to-hide']) ) {
		echo '';
	} else {
		echo ' to-hide';
	}
}


/**//**-------------------------------------------------------------------
| ADD CLEAR FACEBOOK TEMPLATE PAGE
|--------------------------------------------------------------------*//**/

add_action( 'init', 'nbx_add_facebook_page' );
function nbx_add_facebook_page() {
	global $nbx_options;
	$page_by_path = get_page_by_path( 'nbx-facebook-calendar', OBJECT, 'page');

	if( isset( $nbx_options['facebook_template'] ) && !empty($nbx_options['facebook_template']) && $nbx_options['facebook_template'] == 'activated' ) {
		if( empty($page_by_path) && !isset($page_by_path) ) {
			$nbx_page = array(
				'post_title'	=> 'Calendar Facebook Page',
				'post_content'	=> 'This is the page for the facebook specific page. You can remove it from the menu and still keep the URL',
				'post_status'	=> 'publish',
				'post_name'		=> 'nbx-facebook-calendar',
				'post_type'		=> 'page'
			);

			wp_insert_post( $nbx_page );
		}
	} elseif ( !isset( $nbx_options['facebook_template'] ) && empty( $nbx_options['facebook_template'] ) ) {
		if( !empty($page_by_path) && isset($page_by_path) ) {
			$nbx_page_id 	= $page_by_path->ID;
			$force_delete	= true;
			wp_delete_post( $nbx_page_id, $force_delete );
		}
	}
}