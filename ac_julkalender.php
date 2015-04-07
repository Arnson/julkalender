<?php
/**
 * Plugin Name:		Christmas Calendar Plugin
 * Description:		Christmas calendar created by Cristoffer Arn
 * Author:			Cristoffer Arn
 * Author URI:		http://arncreative.com
 */

/**//**-------------------------------------------------------------------
| GLOBAL VARIABLES + CONSTANTS
|--------------------------------------------------------------------*//**/

//$nbx_plugin_name = 'ArnCreative Christmas Calendar';
define( 'NBX_PLUGIN_PATH', plugin_dir_path(__FILE__) ); // Create absolute server path
define( 'NBX_PLUGIN_URL', plugin_dir_url(__FILE__) ); 	// Create absolute plugin url path
define( 'NBX_PLUGIN_BASE_FILE', __FILE__ );

/* This is used for the add-tempaltes.php. Please edit it. */
if ( !defined( 'RC_TC_BASE_FILE' ) )		define( 'RC_TC_BASE_FILE', __FILE__ ); // Used for the plugin-init-and-finalize.php

define( 'NBX_PLUGIN_IMAGE', NBX_PLUGIN_URL . 'includes/images' );   // images path. Don't forget to add /before.file. Plz fix and change everywhere this is used.

$nbx_options = get_option('nbx_settings');

/**//**-------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------*//**/

// Load globally
include( NBX_PLUGIN_PATH . 'includes/functions.php' );
include( NBX_PLUGIN_PATH . 'includes/plugin-init-and-finalize.php' );
include( NBX_PLUGIN_PATH . 'includes/add-templates.php' );
include( NBX_PLUGIN_PATH . 'includes/post-ajax.php');
include( NBX_PLUGIN_PATH . 'includes/scripts.php' ); 			 	// this controls all JS / CSS
include( NBX_PLUGIN_PATH . 'includes/custom-post-types.php' );   	// Loads our custom post types
//include( NBX_PLUGIN_PATH . 'includes/data-processing.php' ); 		// controls all saving of data
//include( NBX_PLUGIN_PATH . 'includes/display-functions.php' ); 	// Display content functions


if( is_admin() ) {
	include( NBX_PLUGIN_PATH . 'includes/plugin-settings-menu.php' );			// Adds pages to the admin menu
	include( NBX_PLUGIN_PATH . 'includes/admin-scripts.php' );		//
	include( NBX_PLUGIN_PATH . 'includes/create-meta-box.php' ); 	// Adds meta-boxes to the calendar days
} else { // Front-end of the website

}