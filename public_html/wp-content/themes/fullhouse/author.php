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
global $fullhouse_page_layouts; 
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_page_sidebar_configs', null );

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) );
?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> container inner">
	<div class="row">
		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>	
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php  if(  in_array( 'opal-estate/opal-estate.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ): ?>
					<?php get_template_part( 'opalestate/author'  ); ?>
					<?php else : ?>
						<?php if ( have_posts() ) : ?>

						<header class="archive-header">
							<h1 class="archive-title">
								<?php
									/*
									 * Queue the first post, that way we know what author
									 * we're dealing with (if that is the case).
									 *
									 * We reset this later so we can run the loop properly
									 * with a call to rewind_posts().
									 */
									the_post();

									printf( esc_html__( 'All posts by %s', 'fullhouse' ), get_the_author() );
								?>
							</h1>
							<?php if ( get_the_author_meta( 'description' ) ) : ?>
							<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
							<?php endif; ?>
						</header><!-- .archive-header -->

						<?php
								/*
								 * Since we called the_post() above, we need to rewind
								 * the loop back to the beginning that way we can run
								 * the loop properly, in full.
								 */
								rewind_posts();

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
					<?php endif; ?>	
				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
			
		</div><!-- #main-content -->
		
	</div>	
</section>
<?php

get_footer();
