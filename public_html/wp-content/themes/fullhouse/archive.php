<?php
/**
 * The template for displaying Category pages
 *
 * @link http://wpopal.com/themes/mode
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
global $fullhouse_page_layouts;  
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_archive_sidebar_configs', null );

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner <?php echo fullhouse_fnc_theme_options('blog-archive-layout') ; ?>">
	<div class="row">

		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		
		<div id="main-content" class="main-content  col-sm-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
			 <div id="content" class="site-content" role="main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<h1 class="page-title">
								<?php
									if ( is_day() ) :
										printf( esc_html__( 'Daily Archives: %s', 'fullhouse' ), get_the_date() );

									elseif ( is_month() ) :
										printf( esc_html__( 'Monthly Archives: %s', 'fullhouse' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'fullhouse' ) ) );

									elseif ( is_year() ) :
										printf( esc_html__( 'Yearly Archives: %s', 'fullhouse' ), get_the_date( _x( 'Y', 'yearly archives date format', 'fullhouse' ) ) );

									else :
										esc_html_e( 'Archives', 'fullhouse' );

									endif;
								?>
							</h1>
						</header><!-- .page-header -->

						<?php
								/**
								 * 1-column or n-columns layout
								 */
								get_template_part( 'content', 'gridposts' );

								// Previous/next page navigation.
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


 
	</div>	
</section>
<?php
get_footer();
 
