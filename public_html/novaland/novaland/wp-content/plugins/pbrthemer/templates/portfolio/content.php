 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if ( has_post_thumbnail() ) { ?>
    <div class="entry-thumb">
      <?php the_post_thumbnail('');?>
    </div>
  <?php } ?>

  <div class="single-body">
     
     <div class="entry-title"><h1 class="title-post fweight-800 text-big-1"><?php the_title(); ?></h1></div>
     <div class="created"><?php the_date('M, d Y'); ?></div>
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
   </article> 