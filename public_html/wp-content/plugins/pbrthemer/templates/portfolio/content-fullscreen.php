<?php

  $files = get_post_meta(get_the_ID(), 'portfolio_file_advanced');

  $galleries = array();
  
  foreach( $files as $id ){
      $img_src = wp_get_attachment_image_src( $id, 'post-thumbnail');
      if( $img_src){
        $galleries[] = $img_src[0];
      }
  }
  

  if($galleries):
      if(count( $galleries) >1){
        $class_col_1 = 'col-lg-8 col-md-8 col-sm-8 col-xs-12';
        $class_col_2 = 'col-lg-4 col-md-4 col-sm-4 col-xs-12';
      }else{
        $class_col_1 = '';
        $class_col_2 = '';
      }
  endif;
  //wp_enqueue_script( 'edubase-prettyPhoto_js', EDUBASE_WPO_THEME_URI.'/js/jquery.prettyPhoto.js');
  //wp_enqueue_style('edubase-perttyPhoto_css', EDUBASE_WPO_THEME_URI.'/css/prettyPhoto.css');

  $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edubase-thumbnails-medium' );

  $number = 1; $_id  = rand();
?>

 <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<div class="row-full">

      <?php if( count($galleries) <= 0  ): ?>
      <div class="portfolio-fullscreen">
        <?php if( has_post_thumbnail() ): ?>
          <div class="entry-thumb">
            <a href="<?php echo esc_url( $image_url[0]); ?>" data-rel="prettyPhoto[pp_gal]">
              <?php the_post_thumbnail('full');?>
            </a>
          </div>
        <?php endif; ?>
      </div>
      <?php else: ?>
      
      <div class="gallery-thumb"> 

        <div id="carousel-<?php echo esc_attr($_id); ?>" class="widget-content text-center  owl-carousel-play" data-ride="owlcarousel">
          <div class="owl-carousel " data-slide="<?php echo esc_attr($number); ?>" data-pagination="true" data-navigation="true" data-desktop="[1199,2]" data-desktopsmall="[980,1]" data-tablet="[768,1]">


                <?php foreach( $galleries as $_img ){ ?>
                  <div class="gallery-item">
                    <a href="<?php echo esc_url( $_img); ?>" data-rel="prettyPhoto[pp_gal]">
                      <img src="<?php echo esc_url_raw( $_img ) ?>" alt="<?php echo get_the_title(); ?>">
                    </a>
                  </div>
                <?php } ?>
          </div>
           <?php if( $number  < count($galleries) ) { ?>
            <div class="carousel-controls carousel-controls-v3 carousel-hidden">
              <a class="left carousel-control carousel-md" href="#carousel-<?php echo esc_attr($_id); ?>" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
              </a>
              <a class="right carousel-control carousel-md" href="#carousel-<?php echo esc_attr($_id); ?>" data-slide="next">
                  <span class="fa fa-angle-right"></span>
              </a>
            </div>
            <?php } ?>

        </div>  
      </div>  
      <?php endif; ?>

</div>

<div class="container">
      <div class="single-body">
         <div class="created"><?php the_date('M, d Y'); ?></div>
         <div class="entry-title"><h1 class="title-post fweight-800 text-big-1"><?php the_title(); ?></h1></div>
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
 </article>   