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

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>

<div class="wpo-breadcrumb">
	<?php do_action( 'fullhouse_template_main_before' ); ?>
</div>
<section id="main-container" class="<?php echo apply_filters( 'fullhouse_template_main_content_class', 'container' ); ?> inner">
	<div class="row">
		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">

			<div id="primary" class="content-area">
				<div id="content" class="site-content clearfix" role="main">
					<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();

							/*
							 * Include the post format-specific template for the content. If you want to
							 * use this in a child theme, then include a file called called content-___.php
							 * (where ___ is the post format) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );

							/**
							 * Share box
							 */
							// if ( fullhouse_fnc_theme_options( 'blog-show-share-post', 1 ) ) {
							// 	get_template_part( 'page-templates/parts/sharebox' );
							// }

							// About Author
							//get_template_part('page-templates/parts/author-bio');

							// Previous/next post navigation.
							fullhouse_fnc_post_nav();
							

							// Related posts
							//get_template_part('page-templates/parts/related-post');

							// If comments are open or we have at least one comment, load up the comment template.
							//if ( comments_open() || get_comments_number() ) {
							//	comments_template();
							//}
						endwhile;
					?>

				</div><!-- #content -->
			</div><!-- #primary -->
		</div>	

	</div>	
</section>
<?php
get_footer();
