<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author     WpOpal Team <opalwordpress@gmail.com>
 * @copyright  Copyright (C) 2015 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */
wp_enqueue_style( 'isotope-css' );
wp_enqueue_script( 'isotope' );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$col = floor(12/$columns_count);
$smcol = ($col > 2)? 6: $col;

$class_column= 'col-lg-'.$col.' col-md-'.$col.' col-sm-'.$smcol;

if( $nopadding ){
   $class_column .=' nopadding';
}

$terms = pbrthemer_fnc_profolio_terms();
$args = array(
    'posts_per_page' => $number
);

$loop = pbrthemer_fnc_portfolio_query( $args );

$_id = fullhouse_fnc_makeid();
$style = 'effect16';
?>

<div class="widget wpb_grid pbr-portfolio <?php echo (($el_class!='')?' '.esc_attr( $el_class ):''); ?>">
  <div class="teaser_grid_container">
    <div class="wpb_filtered_grid teaser_grid_container <?php echo (($nopadding) ? '' : 'row') ?>">
        <?php if( $title ) { ?>
            <h3 class="widget-title">
               
                <?php if(trim($descript)!=''){ ?>
                <span class="widget-desc">
                <?php echo trim( $descript ); ?>
                </span>
                <?php } ?>
                 <span><?php echo esc_html( $title ); ?></span>
            </h3>
        <?php } ?>

      <?php if( $loop->have_posts()): ?>
      <!-- filters category -->
      <div id="filters"  class="tab-v8 space-padding-20 navtabs-black">
        <div class="nav-inner">
          <ul class="nav nav-tabs isotope-filter categories_filter" data-related-grid="isotope-<?php echo esc_attr( $_id ); ?>">
            <?php
            echo '<li class="active"><a href="javascript:void(0)" title="" data-option-value=".all">'.esc_html__('All', 'fullhouse').'</a></li>';

            if ( !empty($terms) && !is_wp_error($terms) ){
              foreach ( $terms as $term ) {
                echo '<li><a href="javascript:void(0)" title="" data-option-value=".'.esc_attr( $term->slug ).'">'.esc_html($term->name).'</a></li>';
              }
            }
            ?>
          </ul>
        </div>
      </div>

    <div class="isotope-masonry portfolio-entries clearfix masonry-spaced" data-isotope-duration="400" id="isotope-<?php echo esc_attr( $_id ); ?>">
    <?php while($loop->have_posts()): $loop->the_post();

       $item_classes = 'all ';
       $item_cats = get_the_terms( $loop->post->ID, 'category_portfolio' );
       

       if($masonry==0) $thumb = 'thumbnails-large'; else $thumb = '';
        $item_classes = pbrthemer_fnc_portfolio_terms_related( $loop->post->ID );
     
       $image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id( $loop->post->ID ), 'full' );
       ?>
      <div class="portfolio-masonry-entry masonry-item <?php echo esc_attr( $class_column ); ?> all <?php echo esc_attr( implode( " ", $item_classes ) ); ?>">
        <div class="pbr-portfolio-content text-center">
          <div class="ih-item square colored effect16">
              <div class="img">
                  <?php if ( has_post_thumbnail()) {
                    the_post_thumbnail( $thumb );
                  }?>
              </div>
              <div class="info">
                <div class="info-inner">
                    <h3><a class="text-white" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <p class="description"><?php echo fullhouse_fnc_excerpt(20,'...'); ?></p>
                    <p class="created hidden"><?php echo get_the_date(); ?></p>
                    <a class="hidden zoom" href="<?php echo esc_url($image_attributes[0]) ?>" data-rel="prettyPhoto[pp_gal]"> <i class="fa fa-search radius-x space-padding-10"></i> </a>
                </div>    
              </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    </div>
    <?php 
    if($pagination == 1){
        fullhouse_fnc_pagination_nav( $number, $loop->found_posts, $loop->max_num_pages );
    }
    ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
    </div>
  </div>  
</div>