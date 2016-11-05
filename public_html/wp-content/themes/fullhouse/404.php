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
/*
*Template Name: 404 Page
*/

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) ); ?>

<?php do_action( 'fullhouse_template_main_before' ); ?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner notfound-page">
	<div class="row">
		<div id="main-content" class="main-content col-lg-12">
			<div id="primary" class="content-area">
				 <div id="content" class="site-content" role="main">

					<header class="page-header text-center">
						<h1 class="page-title error-404"><?php esc_html_e( '404', 'fullhouse' ); ?></h1>
					</header>

					<div class="page-content text-center">
						<h3 class="error-404"><?php esc_html_e( 'Oop, that link is broken.', 'fullhouse' ); ?></h3>
						<p><?php echo esc_html_e("Page does not exist or some other error occured. Go to our",'fullhouse')?></p>
						<?php // fullhouse_fnc_categories_searchform() ?>
					</div><!-- .page-content -->

					<div class="page-action text-center">						
						<a class="text-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home page', 'fullhouse'); ?></a>
						<span><?php esc_html_e('or go back to', 'fullhouse'); ?></span>
						<a class="text-primary" href="javascript: history.go(-1)"><?php esc_html_e('Previous page', 'fullhouse'); ?></a>
					</div>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
		</div><!-- #main-content -->

		 
		<?php get_sidebar(); ?>
	 
	</div>	
</section>
<?php

get_footer();

 