<?php
/**
 *
 * Template Name: Property Search Results
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
global $fullhouse_layouts; 

get_header( apply_filters( 'fullhouse_fnc_get_header_layout', null ) );
$fullhouse_layouts = apply_filters( 'fullhouse_fnc_get_page_sidebar_configs', null )
?>
<?php do_action( 'fullhouse_template_main_before' ); ?>
<?php do_shortcode( '[opalestate_search_properties]' ) ;?>
<section id="main-container" class="<?php echo apply_filters('fullhouse_template_main_container_class','container');?> inner">
	<div class="row">
		
		<div id="main-content" class="main-content col-xs-12 col-lg-12 col-md-12">
			<div id="primary" class="content-area">
				<div id="content" class="site-content" role="main">

					 <?php do_shortcode( '[opalestate_search_properties_result]' ) ;?>

				</div><!-- #content -->
			</div><!-- #primary -->
			<?php get_sidebar( 'content' ); ?>
			
		</div><!-- #main-content -->
		 
		<?php get_sidebar('left'); ?>
 
	</div>	
</section>
<?php

get_footer();
