<?php
/********************************
 * CHRISTMAS PAGE TEMPLATE FILE
 *******************************/

get_header(); ?>
<?php global $more; ?>

<div id="nbx_primary" class="nbx_site-content" style="background-image: url(<?php echo $nbx_options['calendar_bg']; ?>);">
	<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/nbx_background.jpg'; ?>" class="nbx_background-image" alt=""/>

	<div id="nbx_content" role="main">

		<div class="nbx_decorations_left">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/decorations_left.png'; ?>" alt="decorations-left"/>
		</div>
		<div class="nbx_decorations_center">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/decorations_center.png'; ?>" alt="decorations-center"/>
		</div>
		<div class="nbx_decorations_right">
			<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/decorations_right.png'; ?>" alt="decorations-right"/>
		</div>
		<div class="nbx_logo-placeholder">
			<header id="nbx_header">
				<h1><?php echo ((isset($nbx_options['company_name']) && $nbx_options['company_name'] != '') ? $nbx_options['company_name'] : 'Company Name' ); ?></h1>
			</header>
			<img src="<?php echo plugin_dir_url(__FILE__) . '../images/nbx_logo_placeholder.png'; ?>" alt="christmas-calendar-logo"/>
		</div>

		<div class="super_wrapper">
		<?php
		$args = array( 'post_type' => 'christmas_calendar', 'posts_per_page' => 24, 'order' => 'ASC');
		$loop = new WP_Query( $args );
		$i = 1;
		$i_post_count = 1;

		if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post(); ?>
			<?php
			$more = 0;

			$post_meta_data = get_post_custom($post->ID);
			$nbx_meta_text = $post_meta_data['nbx_meta_text'][0];
			$nbx_meta_textarea = $post_meta_data['nbx_meta_textarea'][0];
			?>

			<article id="<?php echo $post->ID; ?>" class="nbx_post-wrapper">
				<div class="nbx_inner-wrapper">

<!--					<input type="submit" class="nbx_button" value="--><?php //echo $post->ID; ?><!--" />-->

					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/doors_active/door_'. $i .'.png'; ?>" class="nbx_button ajax_button to-hide" value="<?php echo $post->ID; ?>" alt=""/>
					</a>

					<header class="nbx_entry-header">
						<h3><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ( (isset( $nbx_meta_text ) && $nbx_meta_text != '') ? $nbx_meta_text : the_title() ); ?></a></h3>
					</header><!-- .entry-header -->

					<div class="nbx_entry-content">
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


			<article class="nbx_post-wrapper">
				<div class="nbx_inner-wrapper">

					<a href="#"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/doors_inactive/door_e_'. $i_post_count . '.png'; ?>" class="to-hide" alt=""/></a>
						<header class="nbx_entry-header">
							<h3><a href="#" rel="bookmark">Not Yet Tho</a></h3>
					</header><!-- .entry-header -->

					<div class="nbx_entry-content">
						<p>Nothing Here Yet.</p>
					</div>

				</div><!-- .nbx_innder-wrapper -->
			</article><!-- #post -->

		<?php $i_post_count++; } ?>

		</div><!-- Super Wrapper -->

	</div><!-- #nbx_content -->
</div><!-- #nbx_primary -->
<div class="nbx_clear" style="clear: both;"></div>
<?php get_footer(); ?>