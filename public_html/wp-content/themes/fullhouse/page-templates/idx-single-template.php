<?php
/**
 * Template Name: IDX Single
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
global $fullhouse_page_layouts; 
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_page_sidebar_configs', null );

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) );
?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner">
	<div class="row">	
		<div id="main-content" class="main-content idx-template-file col-xs-12 col-lg-9 col-md-9 col-sm-12">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							// Include the page content template.
							get_template_part( 'content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
			
		</div><!-- #main-content -->

		<div class="col-xs-12 col-lg-3 col-md-3 col-sm-12">
			<div class="sidebar">
				<?php dynamic_sidebar( 'idx-sidebar' ); ?>
			</div>	
		</div>
		
	</div>	
</section>
<?php

get_footer();
