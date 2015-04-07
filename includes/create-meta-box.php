<?php

/**//**-------------------------------------------------------------------
| CREATE META BOXES
| This gets added to the custom post meta.
| - Retrieve by $meta = get_post_meta( $post_id, 'nbx_meta_${id}', true );
|--------------------------------------------------------------------*//**/
function nbx_custom_meta_box() {

	$id 		= 'nbx_meta_box';				 // Reference ID
	$title		= 'Christmas Calendar Meta Box'; // Displayed in the handle of the box
	$callback	= 'nbx_show_meta_box';			 // Function to define the output inside the box
	$post_type	= 'christmas_calendar';			 // Custom Post Type
	$context	= 'normal';						 // Where the box will show up
	$priority	= 'high';						 // Factors of other plugins

	add_meta_box( $id, $title, $callback, $post_type, $context, $priority );
}
add_action( 'add_meta_boxes', 'nbx_custom_meta_box' );

/**//*** Field array ***//**/
$nbx_prefix = 'nbx_meta_';
$nbx_custom_meta_fields = array(
	array(
		'label'		=> 'Cal. Door Heading',
		'desc'		=> 'Heading stored inside the cal door',
		'id'		=> $nbx_prefix . 'text',
		'type'		=> 'text'
	),
	array(
		'label'		=> 'Cal. Door Text',
		'desc'		=> 'Short description stored inside the cal door',
		'id'		=> $nbx_prefix . 'textarea',
		'type'		=> 'textarea'
	),

	array(
		'label'		=> 'Image',
		'desc'		=> 'Attach an image to the post',
		'id'		=> $nbx_prefix . 'image',
		'type'		=> 'image'
	),
	array(
		'label'		=> 'File',
		'desc'		=> 'Attach a file to the post',
		'id'		=> $nbx_prefix . 'file',
		'type'		=> 'file'
	),
	array(
		'label'		=> 'youtube',
		'desc'		=> 'Copy and paste the video URL form youtube.com. <br/> Example: http://www.youtube.com/watch?v=kk5xfK0ovrk',
		'id'		=> $nbx_prefix . 'youtube',
		'type'		=> 'youtube'
	)
);

/**//********** The Callback **********//**/
function nbx_show_meta_box() {
	global $nbx_custom_meta_fields, $post;

	$post_meta_data 	= get_post_custom($post->ID);
	$nbx_meta_textarea 	= (isset($post_meta_data['nbx_meta_textarea'][0]) ? $post_meta_data['nbx_meta_textarea'][0] : '');
	$nbx_meta_text 		= (isset($post_meta_data['nbx_meta_text'][0]) ? $post_meta_data['nbx_meta_text'][0] : '');

	ob_start(); ?>
	<div id="nbx_metainfo_wrapper" class="postbox">

		<div id="nbx_door_preview" class="">
			<article id="<?php echo $post->ID; ?>" class="nbxco_post-wrapper">
				<div class="nbxco_inner-wrapper">

					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/nbxco_doors/co_door-preview.png'; ?>" class="nbxco_button <?php nbxco_lightbox(); to_hide(); ?>" value="<?php echo $post->ID; ?>" />
					</a>

					<header class="nbxco_entry-header">
						<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ( (isset( $nbx_meta_text ) && $nbx_meta_text != '') ? $nbx_meta_text : the_title() ); ?></a></h3>
					</header><!-- .entry-header -->

					<div class="nbxco_entry-content">
						<?php echo ( (isset( $nbx_meta_textarea ) && $nbx_meta_textarea != '') ? '<p>' . $nbx_meta_textarea . '</p>' : apply_filters('the_content', get_post_field('post_content', $post->ID) )) ; ?>
					</div><!-- .entry-content -->

				</div><!-- .nbx_inner-wrapper -->
			</article><!-- #post -->
			Please note that changes made to the Door Heading and Door Text, only applies to the Doors content.

		</div><!-- #nbx_door_preview -->
		<div>
		</div>
	</div><!-- #nbx_metainfo_wrapper -->


	<?php echo ob_get_clean();

	// Use nonce for verification
	echo '<input type="hidden" name="nbx_meta_box_nonce" value="' . wp_create_nonce( basename(__FILE__) ) . '" />';

	// Begin the field table and the loop
	echo '<table class="form-table">';
	foreach( $nbx_custom_meta_fields as $field ) {
		// get value of this field if it exists for this post
		$meta = get_post_meta( $post->ID, $field['id'], true );

		echo '<tr>
				<th>
					<label for="' . $field['id'] . '" class="to-show">' . $field['id'] . '</label>
					<label>' . $field['label'] . '</label>
				</th>
				<td>';

		switch( $field['type'] ) {

			case 'text':
				echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" class="regular-text" />
					<br/><span class="description">' . $field['desc'] . '</span>';
				break;

			case 'textarea':
				echo '<textarea name="' . $field['id'] . '" id="' . $field['id'] . '" cols="40" rows="3">' . $meta . '</textarea>
					<br/><span class="description">' . $field['desc'] . '</label>';
				break;

			case 'image':
				$image = get_template_directory_uri().'/images/image.png';
				echo '<span class="custom_default_image" style="display:none">'.$image.'</span>';
				if ( $meta ) { $image = wp_get_attachment_image_src($meta, 'medium'); $image = $image[0]; }
				echo   '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />

							<img src="'.$image.'" class="custom_preview_image" alt="" /><br />

								<input class="custom_upload_image_button button" type="button" value="Choose Image" />

								<small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>

								<br clear="all" /><span class="description">'.$field['desc'].'';
				break;

			case 'file':
				ob_start(); ?>

				<input type="text" id="upload_image" name="<?php echo $field['id']; ?>" value="<?php echo $meta; ?>" class="upload_file regular-text"/>
				<input type="button" class="upload_image_button button" name="upload_file" value="Upload File"/>
				<label for="<?php echo $field['id']; ?>" class="description">Upload Image</label>
				<a href="<?php echo $meta; ?>">GET FILE</a>

				<?php echo ob_get_clean();
				break;

			case 'youtube':
				$url = (string)$meta;
				parse_str(parse_url( $url, PHP_URL_QUERY ), $vars );

				echo '<input type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $meta . '" size="40" />
					<br/><span class="description">' . $field['desc'] . '</span>
					<br/>
					<br/>
					youtube id = '. (isset($vars['v']) ? $vars['v'] : '') .'
					<br/>';

				if( isset($vars['v']) ) { ob_start(); ?>

				<iframe width="480" height="360" src="http://www.youtube.com/embed/<?php echo $vars['v']; ?>?feature=oembed" frameborder="0" allowfullscreen=""></iframe>

				<?php echo ob_get_clean(); }
				break;

		} // end switch

		echo '</td></tr>';

	} // end foreach
	echo '</table>'; // end table
}

/**//********** Save the Data **********//**/
function nbx_save_custom_meta( $post_id ) {
	global $nbx_custom_meta_fields;

	if( isset($_POST['nbx_meta_box_nonce']) ){
		$nbx_nonce = $_POST['nbx_meta_box_nonce'];
	} else {
		$nbx_nonce = '';
	}
	// verify nonce
	if( !wp_verify_nonce( $nbx_nonce, basename( __FILE__ ) ) )
		return $post_id;
	// check autosave
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;
	// check permission
	if( 'page' == $_POST['post_type'] ) {
		if( !current_user_can( 'edit_page', $post_id ) )
			return $post_id;
	} elseif ( !current_user_can( 'edit_post', $post_id ) ){
		return $post_id;
	}

	// loop through fields and save the data
	foreach ( $nbx_custom_meta_fields as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true ); // get the field's value if it has been saved before
		$new = $_POST[$field['id']];						  // get the current value that has been entered

		if( $new && $new != $old ) {
			update_post_meta( $post_id, $field['id'], $new );
		} elseif ( '' == $new && $old ) {
			delete_post_meta( $post_id, $field['id'], $old );
		}
	}
}
add_action( 'save_post', 'nbx_save_custom_meta' );
