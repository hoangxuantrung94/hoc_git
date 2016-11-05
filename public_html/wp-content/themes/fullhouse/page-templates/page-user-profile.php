<?php
/**
 * Template Name: User Profile Page
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
		<?php if( isset($fullhouse_page_layouts['sidebars']) && !empty($fullhouse_page_layouts['sidebars']) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>	
		<div id="main-content" class="main-content col-xs-12 <?php echo esc_attr($fullhouse_page_layouts['main']['class']); ?>">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					<?php do_shortcode( '[opalestate_user_profile]' ); ?>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
			
		</div><!-- #main-content -->
		
	</div>	
</section>
<?php

get_footer();