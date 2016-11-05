<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $property, $post;
$property = opalesetate_property( get_the_ID() );
?>
<article itemscope itemtype="http://schema.org/Property" <?php post_class(); ?>>
	
	<?php do_action( 'opalestate_before_property_loop_item' ); ?>
	<header>
	 	<?php opalestate_get_loop_thumbnail( opalestate_get_option('loop_image_size','large') ); ?>
		<?php //echo $property->render_statuses(); ?>
	</header>
     
	<?php //opalestate_get_loop_short_meta(); ?>
    	
	<div class="entry-content">
		
		<?php the_title( '<h4 class="entry-title" style="font-size: 14px; text-align: center;"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
	
	</div><!-- .entry-content -->
	<?php  do_action( 'opalestate_after_property_loop_item' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
