<?php
/**//**-------------------------------------------------------------------
| AJAX FOR POSTS
|--------------------------------------------------------------------*//**/

function add_myjavascript(){
	?>
	<script type="text/javascript">
		var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	</script>
	<?php
	wp_register_script( 'ajax-implementation.js', NBX_PLUGIN_URL . "includes/js/ajax-implementation.js", array( 'jquery' ) );
	wp_enqueue_script( 'ajax-implementation.js' );
}
add_action( 'wp_enqueue_scripts', 'add_myjavascript' );


function MyAjaxFunction(){
	add_action( 'init', 'nbx_ajax_url' );
	global $nbx_options;
	//get the data from ajax() call
	$the_post_id = $_POST['theId'];
	$the_post = get_post($the_post_id);

	$post_meta_data = get_post_custom($the_post_id);
	$nbx_meta_image = (isset($post_meta_data['nbx_meta_image'][0]) ? $post_meta_data['nbx_meta_image'][0] : '');
	$nbx_meta_file 	= (isset($post_meta_data['nbx_meta_file'][0]) ? $post_meta_data['nbx_meta_file'][0] : '');
	$nbx_meta_youtube = (isset($post_meta_data['nbx_meta_youtube'][0]) ? $post_meta_data['nbx_meta_youtube'][0] : '');

	/* Check for image */
	if( isset($nbx_meta_image) ) { $nbx_lighbx_image = '<div class="nbx_post-image-container">' . wp_get_attachment_image($nbx_meta_image, array('350','350') ) . '</div>'; }
	/* Check for Youtube */
	if ( isset($nbx_meta_youtube) && $nbx_meta_youtube != '' ) {
		$url = $nbx_meta_youtube;
		parse_str(parse_url( $url, PHP_URL_QUERY ), $vars );
		$nbx_lighbx_youtube =  '<div class="nbx_post-youtube-container"><iframe width="480" height="360" src="http://www.youtube.com/embed/'. $vars['v'] . '?feature=oembed" frameborder="0" allowfullscreen=""></iframe></div>'; }
	/* Check for file download link */
	if( isset($nbx_meta_file) && $nbx_meta_file != '' ) {
		$nbx_lighbx_file = '<div class="nbx_meta_file"><a href="'. $post_meta_data['nbx_meta_file'][0] .'">DOWNLOAD LINK</a></div>';
	}
	$results = '<div id="lightbox">
					<p class="nbx_lighbx_close">Click to Close</p>
				</div>'; // end of #lightbox
	$results .=	'<div id="lightbox_main_content">';

	$results .=		'<h2>' . $the_post->post_title .'</h2>';
	$results .= 	$nbx_lighbx_image;
	$results .=		(isset($nbx_lighbx_youtube) ? $nbx_lighbx_youtube : '');
	$results .=		'<p>' . $the_post->post_content .'</p>';
	$results .=		'<a href="' . get_permalink( $the_post->ID ) . '">View Post on Page</a>';
	$results .= 	(isset($nbx_lighbx_file) ? $nbx_lighbx_file : '');

	$results .=		'<div class="nbx_social_media_icons">';
	$results .=		nbxco_social_media();
	$results .=		'</div>
				</div>'; // end of #lightbox_main_content

	// Return the String
	die($results);
}
// creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_MyAjaxFunction', 'MyAjaxFunction' );
add_action( 'wp_ajax_MyAjaxFunction', 'MyAjaxFunction' );
