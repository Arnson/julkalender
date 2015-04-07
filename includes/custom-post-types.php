<?php

/**//****************************
 * Registers our Custom Post Type
 ***************************//**/
add_action('init', 'nbx_custom_post_type');

function nbx_custom_post_type() {

	$labels = array(
		'name'               => 'Christmas Calendar',
		'singular_name'      => 'Christmas Calendar',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Day',
		'edit_item'          => 'Edit Day',
		'new_item'           => 'New Day',
		'all_items'          => 'All Days',
		'view_item'          => 'View Day',
		'search_items'       => 'Search Days',
		'not_found'          => 'No days found',
		'not_found_in_trash' => 'No days found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Christmas Calendar'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => 'nbx_christmas_calendar', // This overwrites the default nbx_render_admin_page
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'christmas_calendar' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail'/*, 'excerpt', 'comments'*/ )
	);

	register_post_type('christmas_calendar', $args);
}

/* Add CPT to our menu_page */


/**//********** Rewrite Flush **********//**/
function my_rewrite_flush() {
	nbx_custom_post_type();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'my_rewrite_flush' );