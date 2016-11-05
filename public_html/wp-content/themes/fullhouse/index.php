<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner">
	<div class="row">
		<div id="main-content" class="main-content col-lg-12">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php
						if ( have_posts() ) :
							/**
							 * 1-column or n-columns layout
							 */
							get_template_part( 'content', 'gridposts' );

							// Previous/next post navigation.
							fullhouse_fnc_paging_nav();

						else :
							// If no content, include the "No posts found" template.
							get_template_part( 'content', 'none' );

						endif;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->

		<div id="sideba-1" class="sidebar col-lg-12">
			<?php get_sidebar(); ?>
		</div>	
	</div>	
</section>
<?php

get_footer();
