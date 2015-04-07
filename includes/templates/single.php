<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="nbx_primary" class="nbx_post-site-content">
		<img src="<?php echo plugin_dir_url( __FILE__ ) . '../images/nbx_post_background.png'; ?>" class="nbx_background-image" alt=""/>

		<div id="nbx_post-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					$post_meta_data = get_post_custom($post->ID);
					$nbx_meta_image = (isset($post_meta_data['nbx_meta_image'][0]) ? $post_meta_data['nbx_meta_image'][0] : '');
					$nbx_meta_file  = (isset($post_meta_data['nbx_meta_file'][0]) ? $post_meta_data['nbx_meta_image'][0] : '');
					$nbx_meta_youtube = (isset($post_meta_data['nbx_meta_youtube'][0]) ? $post_meta_data['nbx_meta_youtube'][0] : '');
//					echo the_meta();

	/*				// For the checkbox group
					$custom_repeatable = unserialize($post_meta_data['nbx_meta_checkbox_group'][0]);
					foreach( $custom_repeatable as $repeatble ) {
						echo $repeatble;
					}*/

					/*$custom_checkbox = $post_meta_data['nbx_custom_checkbox'][0];
					if( $custom_ceckbox == 'on' ) {
						// do stuff
					}*/

				?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


					<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
						<div class="featured-post">
							<?php _e( 'Featured post', 'twentytwelve' ); ?>
						</div>
					<?php endif; ?>

					<!-- .entry-header -->
					<div class="nbx_post-logo-placeholder">
						<header class="nbx_post-header">
							<h1><?php the_title(); ?></h1>
						</header>
						<img src="<?php echo plugin_dir_url(__FILE__) . '../images/nbx_page_header.png'; ?>" alt="christmas-post-calendar-logo"/>
					</div>


					<div class="nbx_post-entry-content">

						<!-- Meta Box Image -->
						<?php if ( isset($nbx_meta_image) ) {
							ob_start(); ?>
							<div class="nbx_post-image-container">
								<?php echo wp_get_attachment_image($nbx_meta_image, array('350','350') ); ?>
							</div>
							<?php echo ob_get_clean(); } ?>

						<!-- Youtube Video -->
						<?php if ( isset($nbx_meta_youtube) && $nbx_meta_youtube != '' ) {
							$url = $nbx_meta_youtube;
							parse_str(parse_url( $url, PHP_URL_QUERY ), $vars );
							ob_start(); ?>
							<div class="nbx_post-youtube-container">
								<iframe width="480" height="360" src="http://www.youtube.com/embed/<?php echo $vars['v']; ?>?feature=oembed" frameborder="0" allowfullscreen=""></iframe>
							</div>
						<?php echo ob_get_clean(); } ?>

						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>

						<div class="nbx_social_media_icons">
							<a href=""><img src="<?php echo plugin_dir_url(__FILE__) . '../images/social_icons/nbx_google_plus_icon.png'; ?>" alt="christmas-media-icons"/></a>
							<a href=""><img src="<?php echo plugin_dir_url(__FILE__) . '../images/social_icons/nbx_twitter_icon.png'; ?>" alt="christmas-media-icons"/></a>
							<a href=""><img src="<?php echo plugin_dir_url(__FILE__) . '../images/social_icons/nbx_facebook_icon.png'; ?>" alt="christmas-media-icons"/></a>
						</div>

					</div><!-- .entry-content -->


					<!-- Download Link -->
					<?php if ( isset($nbx_meta_file) && $nbx_meta_file != '' ) { ?>
						<div class="nbx_meta_file"><a href="<?php echo $post_meta_data['nbx_meta_file'][0]; ?>">DOWNLOAD LINK</a></div>
					<?php } ?>


				</article><!-- #post -->

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>