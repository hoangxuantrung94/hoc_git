<div class="testimonials-body text-center">
    <div class="testimonials-description"><?php the_content() ?></div>                
    <div class="testimonials-avatar radius-x hidden">
        <a href="#"><?php the_post_thumbnail('widget', '', 'class="radius-x"');?></a>
    </div>
    <div class="testimonials-meta">
	    <h5 class="testimonials-name">
	         <?php the_title(); ?>
	    </h5>  
	    <div class="hidden"><?php the_excerpt(); ?></div>
	</div>            
</div>