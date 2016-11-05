<div class="testimonials-body">
	<div class="row">
		
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="media">
				<div class="media-left">
					<a href="#"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?></a>
				</div>
				<div class="media-body">
					<h5 class="testimonials-name">
				        <?php the_title(); ?>
				    </h5>  
				    <div class="testimonials-position"><?php the_excerpt(); ?></div>
				</div>
			</div>
		</div>

		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
			<div class="testimonials-description"><?php the_content() ?></div>
		</div>

	</div>
    
</div>