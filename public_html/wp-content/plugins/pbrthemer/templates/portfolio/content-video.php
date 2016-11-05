<?php
  


 $video = get_post_meta(get_the_ID(), 'portfolio_video_link',true);
 

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="row content-video">
   <div class="col-sm-6 col-xs-12">
      <?php if( $video ): ?>
      	<div class="entry-thumb post-type-video">
      		<div class="video-thumb video-responsive">
      			<?php echo  wp_oembed_get( $video ); ?>
      		</div>
      	</div>
      <?php endif; ?>
   </div>

   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <div class="single-body space-padding-top-20">
         <div class="created"><?php the_date('M, d Y'); ?></div>
         <div class="entry-title">
            <h1 class="title-post fweight-800 text-big-1"><?php the_title(); ?></h1>
         </div>
         <div class="post-area single-portfolio">
           
               <div class="post-container">
                  <div class="entry-content no-border">
                     <?php the_content(); ?>

                     <?php pbr_fnc_portfolio_information(); ?>  
                
                     <?php get_template_part( 'page-templates/parts/sharebox' ); ?>

                     <?php wp_link_pages(); ?>
                  </div>
               </div>
           
         </div>
      </div>   
   </div>
    <div class="col-lg-2 col-md-2 hidden-sm hidden-xs">
   </div> 
</div>     
 </article>