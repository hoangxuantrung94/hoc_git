
<div class="property-listing my-favorite">
 	<div class="panel panel-default">
 		<div class="panel-body">
				<?php if( $loop->have_posts() ): ?>
					<div class="opalestate-rows">	
						<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
						<?php $cnt=0; while ( $loop->have_posts() ) : $loop->the_post(); global $post;  ?>
							
				 					
			 				<div class="col-lg-12">
		                    	<?php echo Opalestate_Template_Loader::get_template_part( 'content-property-list' ); ?>
		                	</div>
						
						<?php endwhile; ?>
						</div>
					</div>	
						<?php opalestate_pagination( $loop->max_num_pages ); ?>

				<?php else : ?>	
				<?php echo Opalestate_Template_Loader::get_template_part( 'content-none' ); ?>
				<?php endif; ?>
		</div>	
 	</div>
</div>
<?php wp_reset_postdata(); ?>