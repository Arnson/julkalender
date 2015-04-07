<?php
/**//****************************
 * Admin Scripts
 ***************************//**/

/**//*** Enqueue Scripts For Meta Boxes ***//**/
add_action('admin_enqueue_scripts', 'nbx_christmas_calendar_scripts');
function nbx_christmas_calendar_scripts() {
	wp_enqueue_media(); // Important
	wp_register_script('plugin-scripts', NBX_PLUGIN_URL . 'includes/js/plugin-scripts.js', array('jquery'));
	wp_enqueue_script('plugin-scripts');
}