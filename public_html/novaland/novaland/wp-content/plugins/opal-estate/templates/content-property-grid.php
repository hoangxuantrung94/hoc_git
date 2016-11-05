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
		<?php echo $property->render_statuses(); ?>
	</header>
     
	<?php opalestate_get_loop_short_meta(); ?>
    	
	<div class="entry-content">
		
		<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
			
	  	<div class="entry-summary">
			<?php echo $property->get_address(); ?>
		</div>
	</div><!-- .entry-content -->

 	<div class="property-meta-bottom">	
		<div class="property-price">
			<span><?php echo  opalestate_price_format( $property->get_price() ); ?></span>

			<?php if( $property->get_sale_price() ): ?>
			<span class="property-saleprice">
				<?php echo  opalestate_price_format( $property->get_sale_price() ); ?>
			</span>
			<?php endif; ?>

			<?php if( $property->get_price_label() ): ?>
			<span class="property-price-label">
				/ <?php echo $property->get_price_label(); ?>
			</span>	
			<?php endif; ?>
		</div>
	</div>

	<div class="entry-content-bottom clearfix">
		<?php echo $property->render_author_link(); ?>
		<?php do_shortcode('[opalestate_favorite_button property_id='.get_the_ID() .']'); ?>
	</div>

	<?php  do_action( 'opalestate_after_property_loop_item' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</article><!-- #post-## -->
