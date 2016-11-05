<?php 
	$args = array();
	$loop = pbr_fnc_team_query( $args ); 

	
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	extract( $atts );


	$scolumns = ($column > 0 ? floor(12/$column) : 3);
?>
<div class="widget-nostyle">
	<?php if( $title ){ ?> 
	 <div class="widget-heading clearfix">
			<h3 class="widget-title">
		       <span><?php echo trim($title); ?></span>
			</h3>
	</div>		
	<?php } ?>
	<div class="widget-content">
		<div class="row">
			<?php   while( $loop->have_posts() ): $loop->the_post();

				$data = array( 'google', 'job', 'phone_number', 'facebook', 'twitter', 'pinterest' );
				foreach( $data as $item ){
					$$item =  get_post_meta( get_the_ID(), 'team_'.$item, true ); 
				}
			?>
			<div class="col-md-<?php echo trim($scolumns); ?> col-sm-<?php echo trim($scolumns); ?>">

				<div class="team-v1">
				    <div class="team-header">
				      <a href="<?php echo esc_url( get_permalink() );?>"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?> </a>
				    </div>     
				    <div class="team-body">
				        <div class="team-body-content">
				          <h3 class="team-name"><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title(); ?></a></h3>
				            <p><?php echo esc_html( $job ); ?></p>
				        </div>      
				        <div class="bo-social-icons">
				        	<?php if( $facebook ){  ?>
							<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
								<?php } ?>
							<?php if( $twitter ){  ?>
							<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
							<?php } ?>
							<?php if( $pinterest ){  ?>
							<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
							<?php } ?>
							<?php if( $google ){  ?>
							<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
							<?php } ?>		                              
				        </div>                        
				    </div>  
				    <div class="team-info">
				        <?php the_excerpt(); ?>
				    </div>                                      
				</div>
			</div>	
			<?php endwhile; ?>
		</div>	
	</div>
</div>	
	<?php wp_reset_postdata(); ?>