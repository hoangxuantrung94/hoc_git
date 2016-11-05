<?php global $property, $post; 
	$property = opalesetate_property( get_the_ID() );

?> 
<article id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Property" <?php post_class(); ?>>
	<?php do_action( 'opalestate_single_property_before' );  ?>
	<header>
		<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
			<div class="col-lg-9" style="text-align: center;">
					<?php the_title( '<h1 class="entry-title pull-left">', '</h1>' ); ?>
					
			</div>
			
		</div>

		
	</header>		
		<div class="summary entry-summary opalestate-rows">
		<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
			
			<div class="col-lg-8 col-md-7">	
				<?php 
					echo opalestate_property_content();
				?>
				
			</div>
		</div>
		
	</div><!-- .summary -->
	<meta itemprop="url" content="<?php the_permalink(); ?>" />
	<?php 
		/**
		 * opalestate_after_single_property_summary hook
		 *
		 * @hooked opalestate_output_product_data_tabs - 10
		 * @hooked opalestate_upsell_display - 15
		 * @hooked opalestate_output_related_products - 20
		 */
		do_action( 'opalestate_after_single_property_summary' );

	?>

</article><!-- #post-## -->

