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
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_category_sidebar_configs', null ); // echo '<Pre>'.print_r($fullhouse_page_layouts,1 ); die; 

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>

<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner <?php echo fullhouse_fnc_theme_options('blog-archive-layout') ; ?>">
	<div class="row">

		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		
		<div id="main-content" class="main-content col-sm-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php if ( have_posts() ) : ?>

					<header class="archive-header">
						<h1 class="archive-title"><?php printf( esc_html__( 'Category Archives: %s', 'fullhouse' ), single_cat_title( '', false ) ); ?></h1>

						<?php
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
						?>
					</header><!-- .archive-header -->

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