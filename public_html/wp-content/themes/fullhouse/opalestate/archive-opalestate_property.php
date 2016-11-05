<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $fullhouse_page_layouts; 
$fullhouse_page_layouts = apply_filters( 'fullhouse_fnc_get_archive_property_sidebar_configs', null );

get_header(); ?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
	<section id="main-container" class="site-main container" role="main">
		

		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

		<main id="primary" class="content content-area col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
			<?php if ( have_posts() ) : ?>
				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title hide">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->
				<div class="opalesate-archive-top">
						<?php echo Opalestate_Template_Loader::get_template_part( 'collection-navigator', array('mode'=>'list' ) ); ?>
					</div>	

				<div class="opaleslate-archive-container">

					<div class="opalesate-archive-bottom opalestate-rows">
						<div class="row">
							<?php if ( (isset($_COOKIE['opalestate_displaymode']) && $_COOKIE['opalestate_displaymode'] == 'list') || (!isset($_COOKIE['opalestate_displaymode']) && opalestate_options('displaymode', 'grid') == 'list') ):?>
								<?php while ( have_posts() ) : the_post(); ?>
									<div class="col-lg-12 col-md-12 col-sm-12">
				                    	<?php echo Opalestate_Template_Loader::get_template_part( 'content-property-list' ); ?>
				                	</div>
				                <?php endwhile; ?>
							<?php else : ?>
								<?php 
								$column = 4; 
								$cnt = 0;
								while ( have_posts() ) : the_post(); 
								$cls = '';
								if( $cnt++%$column==0 ){
									$cls .= ' first-child';
								}
								?>
									<div class="<?php echo esc_attr($cls); ?> col-lg-4 col-md-4 col-sm-6">
				                    	<?php echo Opalestate_Template_Loader::get_template_part( 'content-property-grid' ); ?>
				                	</div>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
					</div>	

				</div>
				<?php the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'fullhouse' ),
					'next_text'          => __( 'Next page', 'fullhouse' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'fullhouse' ) . ' </span>',
				) ); ?>
				
			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->


<?php get_footer(); ?>
