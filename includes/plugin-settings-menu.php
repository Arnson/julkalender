<?php

/**//**-------------------------------------------------------------------
| ADD MENU PAGES
|--------------------------------------------------------------------*//**/

add_action('admin_menu', 'nbx_add_menu_page');
function nbx_add_menu_page() {
	$page_title		= 'Christmas Calendar Plugin';
	$menu_title		= 'Xmas Calendar';
	$capability		= 'manage_options';
	$menu_slug		= 'nbx_christmas_calendar';
	$function		= 'nbx_render_admin_page';
	$icon_url		= false;
	$position		= '';

	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url );
}
/*function nbx_render_admin_page() {
	echo 'Admin Page';
}*/

/**//**-------------------------------------------------------------------
| ADD SETTINGS PAGE AS SUBMENU
|--------------------------------------------------------------------*//**/

add_action( 'admin_menu', 'nbx_add_submenu_page' );
function nbx_add_submenu_page() {
	$parent_slug	= 'nbx_christmas_calendar'; // where to add the page
	$page_title		= 'Plugin Settings';
	$menu_title		= 'Settings';
	$capability		= 'manage_options';
	$menu_slug		= 'nbx_christmas_calendar-settings';
	$function		= 'nbx_render_settings_page'; // used to render this page

	add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
}


// call register settings function
add_action( 'admin_init', 'register_mysettings' );
// callback function from nbx_add_submenu_page() in admin-menu.php; // call register settings function // add_action( 'admin_init', 'register_mysettings' );

function register_mysettings() {
	register_setting( 'myoption-group', 'nbx_settings' );
}

function the_radio_value( $set ) {
	global $nbx_options;
//		if(isset($nbx_options['radio'])){ echo ($nbx_options['radio'] == 'set1' ? ' checked="checked"' : '');
	if( isset($nbx_options['radio']) ){
		if( $set == $nbx_options['radio'] ){
			echo 'checked="checked"';
		}
	}
}

function nbx_the_permalink() {
	$page_by_path = get_page_by_path( 'nbx-facebook-calendar', OBJECT, 'page');
	if($page_by_path) {
		$page_id	= $page_by_path->ID;
		$facebook_permalink 	= get_permalink($page_id);
		echo 'Your FB-specific permalink: ' . $facebook_permalink;
	}
}

function nbx_render_settings_page() {
	global $nbx_options; // Retrieve Settings

	ob_start(); ?>

	<div class="wrap">
		<?php //screen_icon(); ?>
		<div id="icon-edit" class="icon32"></div>
		<h2>Christmas Calendar Settings Page</h2>

		<pre>
			<?php print_r($nbx_options); ?>
		</pre>

		<br/><hr/>

		<form action="options.php" method="post">
			<?php settings_fields( 'myoption-group' ); ?>
			<?php do_settings_sections( 'myoption-group' ); ?>

			<table class="form-table">
				<tbody>
				<tr valign="top">
					<th scope="row">
						<label>Calendar Background</label>
					</th>
					<td width="400">
						<input type="text" class="upload_image regular-text" name="nbx_settings[calendar_bg]" value="<?php echo $nbx_options['calendar_bg']; ?>" />
						<input type="button" class="upload_image_button button-secondary" name="upload_image" value="Upload Image"/>
						<p class="description">Repeating background pattern.</p>
					</td>
					<td>
						<img src="<?php echo $nbx_options['calendar_bg']; ?>" height="100" />
					</td>
				</tr>

				<tr valign="top">

					<th scope="row">
						<label>Logo Uploader</label>
					</th>
					<td>
						<input type="text" class="logo_img regular-text" name="nbx_settings[logo_img]" value="<?php echo $nbx_options['logo_img']; ?>" class="regular-text"/>
						<input type="button" class="upload_image_button button-secondary" name="logo_img" value="Upload Image"/>
						<p class="description">Remove to reset default.</p>
					</td>
					<td>
						<img src="<?php echo $nbx_options['logo_img']; ?>" height="100" />
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Company Name</label>
					</th>
					<td><input type="text" name="nbx_settings[company_name]" value="<?php echo $nbx_options['company_name']; ?>" class="regular-text"/></td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Google Plus</label>
					</th>
					<td><input type="text" name="nbx_settings[google_plus]" value="<?php echo $nbx_options['google_plus']; ?>" class="regular-text"/></td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Twitter</label>
					</th>
					<td><input type="text" name="nbx_settings[twitter]" value="<?php echo $nbx_options['twitter']; ?>" class="regular-text"/></td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Facebook</label>
					</th>
					<td><input type="text" name="nbx_settings[facebook]" value="<?php echo $nbx_options['facebook']; ?>" class="regular-text"/></td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Choose Theme</label>
					</th>
					<td>
						<input type="radio" name="nbx_settings[radio]" value="set1" <?php the_radio_value('set1'); ?>/>
						<label>Company Template</label><br/>

						<input type="radio" name="nbx_settings[radio]" value="set2" <?php the_radio_value('set2'); ?>/>
						<label>Christmas Theme</label><br/>

						<input type="radio" name="nbx_settings[radio]" value="set3" <?php the_radio_value('set3'); ?>/>
						<label>Clear Company Template</label><br/>

						<p class="description">Choose theme.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Disable Door Hover</label>
					</th>
					<td>
						<input type="checkbox" name="nbx_settings[to-hide]" value="hide_off" <?php echo (isset($nbx_options['to-hide']) ? 'checked' : ''); ?>/>
						<p class="description">Doesn't show the doors hidden content on hover.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Disable lightbox</label>
					</th>
					<td>
						<input type="checkbox" name="nbx_settings[lightbox]" value="lightbox_off" <?php echo (isset($nbx_options['lightbox']) ? 'checked' : ''); ?>/>
						<p class="description">Will link to the standard post page.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Create Facebook Template</label>
					</th>
					<td>
						<input type="checkbox" name="nbx_settings[facebook_template]" value="activated" <?php echo (isset($nbx_options['facebook_template']) ? 'checked' : ''); ?>/>
						<p><?php nbx_the_permalink(); ?></p>
						<p class="description">Will link to the standard post page.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Delete on Plugin Deactivation</label>
					</th>
					<td>
						<input type="checkbox" name="nbx_settings[delete_on_deac]" value="del_on_deac" <?php echo (isset($nbx_options['delete_on_deac']) ? 'checked' : ''); ?>/>
						<p class="description">Delete on Plugin Deactivation.</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label>Footer Info</label>
					</th>
					<td><input type="text" name="nbx_settings[footer_info]" value="<?php echo $nbx_options['footer_info']; ?>" class="regular-text"/></td>
				</tr>

				</tbody>
			</table>

			<?php submit_button(); ?>
		</form>

	</div>

<?php echo ob_get_clean();
}