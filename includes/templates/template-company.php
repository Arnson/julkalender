<?php
/**//**-------------------------------------------------------------------
| COMPANY TEMPLATE FILE
|--------------------------------------------------------------------*//**/

get_header(); ?>
	<link href='http://fonts.googleapis.com/css?family=Lusitana' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Cardo' rel='stylesheet' type='text/css'>
<?php global $more; ?>

<div id="nbx_primary" class="nbxco_site-content" style="background-image: url(<?php //echo $nbx_options['calendar_bg']; ?>);">
	<div id="nbxco_content" role="main">

		<div id="nbxco_header">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/header_background.jpg'; ?>" class="nbxco_background-image" alt="" />
			<img src="<?php echo $nbx_options['calendar_bg']; ?>" class="nbxco_background-image" alt="" />

			<img id="nbxco_crown" src="<?php echo NBX_PLUGIN_IMAGE . '/nbxco_template/crown.png'; ?>" alt=""/>
			
			<div id="nbxco_godjul_wrapper">
				<div class="nbxco_ornament_left"><img src="<?php echo NBX_PLUGIN_IMAGE . '/nbxco_template/ornament_left.png'; ?>" alt=""/></div>
				<div class="nbxco_ornament_right"><img src="<?php echo NBX_PLUGIN_IMAGE . '/nbxco_template/ornament_right.png'; ?>" alt=""/></div>
				<div class="nbxco_godjul"><img src="<?php echo NBX_PLUGIN_IMAGE . '/nbxco_template/god_jul.png'; ?>" alt=""/></div>
			</div>

			<div id="nbxco_background_img">
				<div class="nbxco_header_img"><img src="<?php nbxco_the_header_image(); ?>" class="header_image" alt=""/></div>
				<div class="nbxco_onskar"><img src="<?php echo NBX_PLUGIN_IMAGE . '/nbxco_template/onskar.png'; ?>" alt=""/></div>
			</div>

			<div id="nbxco_company">
				<h1><?php nbxco_the_company_name(); ?></h1>
			</div>
		</div>

		<div class="teeth_top"></div>
		<div id="nbxco_posts_wrapper">
			<?php
			$args = array( 'post_type' => 'christmas_calendar', 'posts_per_page' => 24, 'order' => 'ASC');
			$loop = new WP_Query( $args );
			$i = 1;
			$i_post_count = 1;

			if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<?php
				$more = 0;

				$post_meta_data 	= get_post_custom($post->ID);
				$nbx_meta_textarea 	= (isset($post_meta_data['nbx_meta_textarea'][0]) ? $post_meta_data['nbx_meta_textarea'][0] : '');
				$nbx_meta_text 		= (isset($post_meta_data['nbx_meta_text'][0]) ? $post_meta_data['nbx_meta_text'][0] : '');
				$nbx_meta_image 	= (isset($post_meta_data['nbx_meta_image'][0]) ? $post_meta_data['nbx_meta_image'][0] : '');
				?>

				<article id="<?php echo $post->ID; ?>" class="nbxco_post-wrapper">
					<div class="nbxco_inner-wrapper">

						<a href="<?php the_permalink(); ?>">
							<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/nbxco_doors/co_door-'. $i .'.png'; ?>" class="nbxco_button <?php nbxco_lightbox(); to_hide(); ?>" value="<?php echo $post->ID; ?>" />
						</a>

						<header class="nbxco_entry-header">
							<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ( (isset( $nbx_meta_text ) && $nbx_meta_text != '') ? $nbx_meta_text : the_title() ); ?></a></h3>
						</header><!-- .entry-header -->

						<div class="nbxco_entry-content">
							<?php echo ( (isset( $nbx_meta_textarea ) && $nbx_meta_textarea != '') ? '<p>' . $nbx_meta_textarea . '</p>' : the_content( '' ) ) ; ?>
						</div><!-- .entry-content -->

					</div><!-- .nbx_inner-wrapper -->
				</article><!-- #post -->

				<?php $i++;
				$i_post_count++;
				?>
			<?php endwhile; ?>
			<?php endif; // end have_posts() check ?>
			<?php while( $i_post_count <= 24 ) { ?>

				<article class="nbxco_post-wrapper">
					<div class="nbxco_inner-wrapper">

						<a href="#"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/nbxco_closed_doors/co_door_e-'. $i_post_count . '.png'; ?>" class="ajax-closed-button <?php to_hide(); ?>" /></a>
						<header class="nbxco_entry-header">
							<h3><a href="#" rel="bookmark">Not Yet Tho</a></h3>
						</header><!-- .entry-header -->

						<div class="nbxco_entry-content">
							<p>Nothing Here Yet.</p>
						</div>

					</div><!-- .nbx_innder-wrapper -->
				</article><!-- #post -->

				<?php $i_post_count++; } ?>

		</div><!-- nbxco_posts_wrapper -->
		<div class="teeth_bottom"></div>

<!--		<div class="footer">-->
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/footer_background.jpg'; ?>" class="nbxco_footer-background-image" alt="" />
			<div class="nbxco_copyright"><p>Copyright <?php echo date('Y'); ?> <strong><?php echo $nbx_options['footer_info']; ?></strong></p></div>
<!--		</div>-->

	</div><!-- #nbx_content -->
</div><!-- #nbx_primary -->
<div class="nbx_clear" style="clear: both;"></div>
<?php get_footer(); ?>