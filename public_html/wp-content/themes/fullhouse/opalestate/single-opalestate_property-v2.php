<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $fullhouse_page_layouts; 
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_single_property_sidebar_configs', null );

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>
<div class="wpo-breadcrumb single-property-breadcrumb">
	<?php do_action( 'fullhouse_template_main_before' ); ?>
</div>
	<section id="main-container" class="site-main container" role="main">
		<div class="row">			
		
			<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>
			<main id="primary" class="col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
				<div class="content content-area">
					<?php if ( have_posts() ) : ?>
						<div class="single-opalestate-container">
							<?php while ( have_posts() ) : the_post(); ?>
			                    <?php echo Opalestate_Template_Loader::get_template_part( 'content-single-property' ); ?>
							<?php endwhile; ?>
						</div>
						<?php the_posts_pagination( array(
							'prev_text'          => __( 'Previous page', 'fullhouse' ),
							'next_text'          => __( 'Next page', 'fullhouse' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'fullhouse' ) . ' </span>',
						) ); ?>



						<?php
							
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}

							do_action( 'opalestate_single_property_sameagent' );
												
						?>




					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>
				</div>
				<!-- content-area -->

			</main><!-- .site-main -->
		
		</div>
	</section><!-- .content-area -->

<?php get_footer(); ?>
