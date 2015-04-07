<?php
/**//**-------------------------------------------------------------------
| ADD TEMPLATE TO PAGE
|--------------------------------------------------------------------*//**/

add_filter( 'template_include', 'rc_tc_template_chooser' );
function rc_tc_template_chooser($template) {

	// Post ID
	$post_id = get_the_ID();

	// For all other CPT
	if( get_post_type( $post_id ) != 'christmas_calendar' ) {
		return $template;
	}

	// Else use custom template
	if ( is_single() ) {
		return rc_tc_get_template_hierarchy( 'single' );
	}

}

/* Get the custom template if is set */
function rc_tc_get_template_hierarchy( $template ) {

	// Get the template slug
	$template_slug = rtrim($template, '.php');
	$template      = $template_slug . '.php';

	// Check if a custom template exists in the theme folder, if not, load the plugin template file
	if ( $theme_file = locate_template(array('plugin_template/'.$template)) ) {
		$file = $theme_file;
	}
	else {
		$file = NBX_PLUGIN_PATH . '/includes/templates/' . $template;
	}

//	return apply_filters( 'rc_repl_template_'.$template, $file); // Previous
	return apply_filters( $template, $file);
}

add_filter( 'page_template', 'wpa_page_template' );
function wpa_page_template( $page_template ) {
	global $nbx_options;

	if( isset($nbx_options['radio']) ){
		switch( $nbx_options['radio'] ) {
			case 'set1':
				$nbx_template = '/template-company.php';
				break;
			case 'set2':
				$nbx_template = '/template-christmas.php';
				break;
			case 'set3':
				$nbx_template = '/template-company-clear.php';
				break;
		}
	}

	if ( is_page( 'nbx-christmas-calendar' ) ) {
		$page_template = NBX_PLUGIN_PATH . '/includes/templates/' . ((isset($nbx_template) && $nbx_template != '') ? $nbx_template : '/template-company.php');
	} elseif ( is_page( 'nbx-facebook-calendar' ) ) {
		$page_template = NBX_PLUGIN_PATH . '/includes/templates/template-company-clear.php';
	}
	return $page_template;
}