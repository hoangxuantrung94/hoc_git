<?php 
	global $post;

	$membership = new Opalmembership_Package( $post->ID );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="package-inner<?php if( $membership->is_hightlighted() ):?> package-hightlighted<?php endif; ?>">
	<?php // prestabase_fnc_post_thumbnail(); ?>
	<div class="pricing pricing-v3">
		<div class="pricing-header">
		<span class="plan-subtitle hide"><?php _e( 'Recommend', 'opalmembership' ); ?></span>
			<?php the_title( '<h4 class="plan-title">', '</h4>' ); ?>
			<div class="plan-price">
				<?php echo $membership->get_price_html();?>
				<p>
					 <?php 
					  	$duration_unit = $membership->get_post_meta( 'duration_unit' ); 
    					$duration = absint( $membership->get_post_meta( 'duration' ) );
    					echo $duration  .' '. $duration_unit; 
					 ?>
				</p>	
			</div>
		</div>
		<div class="pricing-body">
			<div class="plain-info">
			
				<?php
					do_action( 'opalmembership_content_single_before' );
					/* translators: %s: Name of current post */
					the_content( sprintf(
						__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'prestabase' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'prestabase' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
					) );
					do_action( 'opalmembership_content_single_after' );
				?>
			</div>
		</div>
		<div class="pricing-footer">
			<?php echo Opalmembership_Template_Loader::get_template_part( 'single-package-purchase-form' , array('highlighted' => $membership->is_hightlighted()) ); ?>
		</div>
	</div>
</div>
	<!-- pricing -->
</article>