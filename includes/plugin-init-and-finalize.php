<?php

/**//***************************
 * ADD CHRISTMAS PAGE
 **************************//**/

function nbx_add_christmas_calendar_page() {
	$page = array(
		'post_title'	=> 'Christmas Calendar',
		'post_content'	=> 'This is the page that gets the calendar theme.',
		'post_status'	=> 'publish',
		'post_name'		=> 'nbx-christmas-calendar',
		'post_type'		=> 'page'
	);

	wp_insert_post( $page );
}
register_activation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_add_christmas_calendar_page');

/**//****************************
 * REMOVE CHRISTMAS PAGE
 ***************************//**/

function nbx_delete_christmas_calendar_page() {
	$page_by_path	= get_page_by_path('nbx-christmas-calendar', OBJECT, 'page');

	if( isset($page_by_path) && !empty($page_by_path) ) {
		$nbx_page_id 		= $page_by_path->ID;
		$force_delete		= true;
		wp_delete_post( $nbx_page_id, $force_delete );
	}
	/*else {
		return new WP_Error( 'Could not delete page' );
	}*/
}
register_deactivation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_delete_christmas_calendar_page' );

/**//**-------------------------------------------------------------------
| DELETE FACEBOOK TEMPLATE PAGE
|--------------------------------------------------------------------*//**/

function nbx_delete_facebook_template_page() {
	$page_by_path	= get_page_by_path( 'nbx-facebook-calendar', OBJECT, 'page' );

	if( isset($page_by_path) && !empty($page_by_path) ) {
		$nbx_page_id 		= $page_by_path->ID;
		$force_delete		= true;
		wp_delete_post( $nbx_page_id, $force_delete );
	}
}
register_deactivation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_delete_facebook_template_page' );

/**//****************************
 * ADD ALL 24 DAYS
 ***************************//**/

function nbx_add_all_posts() {
	$i = 1;

	while( $i <= 24 ) {
		$server_year = date('Y');
		$nbx_day = sprintf("%02u", $i);
		$postdate = date($server_year.'-12-'.$nbx_day );
		// $postdate .= ' 00:00:01'; // un-tick for future posts

		$post = array(
		'post_title'		=> 'Day ' . $i,
		'post_name'			=> 'nbx-day-' . $i,
		'post_content'		=> 'Not long now..',
		'post_date'			=> $postdate,
		'post_status'		=> 'future', // future or publish
		'menu_order'		=> $i,
		'post_author'		=> 1,
		'post_type'			=> 'christmas_calendar'
	);
		wp_insert_post( $post );
		$i++;
	}
}
register_activation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_add_all_posts');

/**//****************************
 * REMOVE ALL 24 DAYS
 ***************************//**/

function nbx_delete_all_posts() {
if ( post_type_exists( 'christmas_calendar' ) ) {
	$args = array(
	'post_type' 		=> 'christmas_calendar',
	'posts_per_page'   	=> -1,
	'post_status' 		=> 'any'
	);
	$cal_post_count	= get_posts( $args );

	foreach ($cal_post_count as $post) {
		wp_delete_post( $post->ID, true );
		}
	}
}
register_deactivation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_delete_all_posts');

/**//**-------------------------------------------------------------------
| DELETE ALL CALENDAR SETTINGS AND POST METADATA
|--------------------------------------------------------------------*//**/

function nbx_delete_settings() {
	global $nbx_options, $wpdb;

	if( isset( $nbx_options['delete_on_deac'] ) && $nbx_options['delete_on_deac'] != '' ) {
		$sql = $wpdb->prepare("DELETE FROM wp_options WHERE option_name = %s LIMIT 1", 'nbx_settings');
		$wpdb->query($sql);
	}
}
register_deactivation_hook( NBX_PLUGIN_BASE_FILE, 'nbx_delete_settings' );