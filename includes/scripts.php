<?php
/**//**-------------------------------------------------------------------
| SCRIPT CONTROL
|--------------------------------------------------------------------*//**/

function nbx_calendar_load_scripts() {
	// Add custom style to the calendar ONLY when on calendar pages
	if( is_page( 'nbx-christmas-calendar' ) || is_page( 'nbx-facebook-calendar' ) || get_post_type() == 'christmas_calendar' ){
		wp_enqueue_style( 'nbx-styles', plugin_dir_url( __FILE__ ) . 'css/plugin_styles.css' );
	}
}
add_action('wp_enqueue_scripts', 'nbx_calendar_load_scripts');

// Add custom style to the dashboard – The calendar day posts
function nbx_admin_scripts() {
	wp_register_style( 'custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'css/custom_admin_styles.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'nbx_admin_scripts' );