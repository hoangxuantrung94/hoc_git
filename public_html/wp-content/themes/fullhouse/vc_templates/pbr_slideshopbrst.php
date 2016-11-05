<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
$layout = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );  
extract( $atts );
if(empty($loop)) return;
$this->getLoop($loop);
$args = $this->loop_args;
 
if( is_front_page() ){
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}   
else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args['paged'] = $paged; 
$post_per_page = $args['posts_per_page']; 

$loop = new WP_Query($args);

 
$columgrid = floor(12/$grid_columns);
if(  empty($layout) ){
    $layout = 'blog';
}
$id = rand();
$countposts = $args ['posts_per_page'];
?>


<section class="widget slideshowpost <?php echo (($el_class!='')?' '.$el_class:''); ?>">
    <?php if( $title ) { ?>
        <h3 class="widget-title">
           <span><?php echo trim($title); ?></span>
            <?php if(trim($descript)!=''){ ?>
                <span class="widget-desc">
                    <?php echo trim($descript); ?>
                </span>
            <?php } ?>
        </h3>
    <?php } ?>

    <div class="widget-content">
        <div class="owl-carousel-play">
           <div class="owl-carousel" data-slide="<?php echo esc_attr($grid_columns); ?>"  data-singleItem="true" data-pagination="true">
            <?php $i=0; while ( $loop->have_posts() ): $loop->the_post(); ?>
                <div class="item">
                    <?php $thumbsize = isset($thumbsize)? $thumbsize : 'thumbnail';?>
                    <article class="post">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php
                                if ( has_post_thumbnail() ) {
                                    ?>
                                        <figure class="entry-thumb">
                                            <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
                                                <?php the_post_thumbnail( $thumbsize );?>
                                            </a>
                                            <!-- vote    -->
                                            <?php do_action('wpopal_show_rating') ?>
                                        </figure>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="entry-date">
                                    <strong class="text-primary"><?php the_time( 'd' ); ?></strong>
                                    <span class="text-uppercase text-primary"><?php the_time( 'M' ); ?></span>
                                </div>
                                <h4 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <a class="more-link text-uppercase text-primary" href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'fullhouse'); ?></a>
                            </div>
                        </div>

                    </article>
                </div>
       
              <?php if( ++$i== $countposts){ break; } ?>
            <?php endwhile; ?>
            </div>
            <div class="carousel-controls carousel-controls-v4">
                <a class="left carousel-control carousel-md hidden" href="#carousel-<?php the_ID(); ?>" data-slide="prev">
                        <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control carousel-md hidden" href="#carousel-<?php the_ID(); ?>" data-slide="next">
                        <span class="fa fa-angle-right"></span>
                </a>
            </div>

        </div>

        <?php if( isset($show_pagination) && $show_pagination ): ?>
        <div class="w-pagination"><?php fullhouse_fnc_pagination_nav( $post_per_page,$loop->found_posts,$loop->max_num_pages ); ?></div>
        <?php endif ; ?>
    </div>
</section>
<?php wp_reset_postdata();

