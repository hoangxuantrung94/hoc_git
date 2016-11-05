<?php
/**
 * The Template for displaying all single posts
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
global $fullhouse_page_layouts; 
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_single_sidebar_configs', null );

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) );

do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters( 'fullhouse_template_main_content_class', 'container' ); ?> inner">
	<div class="row">
		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
							do_action( 'pbr_layout_portfolio_single_template_loop_before' ) ;
							$format = get_post_meta(get_the_ID(), 'portfolio_layout',true);

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
						//	get_template_part( 'portfolio/content', get_post_format()  );
							pbr_themer_get_template_part( 'portfolio/content', $format );
						
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}

							
							do_action( 'pbr_layout_portfolio_single_template_loop_after' ) ;
							
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
		</div>	
 
	</div>	
</section>
<?php
get_footer();
