<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();

$layout = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(empty($loop)) return;
$this->getLoop($loop);
$args = $this->loop_args;

if(is_front_page()){
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
}
else{
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}
$args['paged'] = $paged; 
$post_per_page = $args['posts_per_page']; 
 
$loop = new WP_Query($args);
?>

<section class="widget  widget-style  pbr-grid-posts layout-<?php echo esc_attr($layout); ?>  <?php echo (($el_class!='')?' '.$el_class:''); ?>">
    <?php
        if($title!=''){ ?>
            <h3 class="widget-title visual-title">
                <span><?php echo trim($title); ?></span>
            </h3>
        <?php }
    ?>
    <div class="widget-content"> 
      <?php
        /**
         * $loop
         * $class_column
         *
         */

        $_count =0;

        $colums = $grid_columns;
        $bscol = floor( 12/$colums );

        ?>
         
        <div class="posts-grid">
            <?php
                $i =0; while($loop->have_posts()){  $loop->the_post(); ?>
                 <?php $thumbsize = isset($thumbsize)? $thumbsize : 'thumbnail';?>

                 <?php if(  $i++%$colums==0 ) {  ?>
                <div class="post-item"><div class="row">
                <?php } ?>
                <div class="col-sm-<?php echo esc_attr($bscol); ?>">
                    <article class="post">
                        <?php
                        if ( has_post_thumbnail() ) {
                            ?>
                                <figure class="entry-thumb">
                                    <a href="<?php the_permalink(); ?>" title="" class="entry-image zoom-2">
                                        <?php the_post_thumbnail( $thumbsize );?>
                                    </a>
                                    <!-- vote    -->
                                    <?php do_action('fullhouse_fnc_rating') ?>
                                </figure>
                            <?php
                        }
                        ?>
                        <div class="entry-content">
                           
                            <?php if (get_the_title()) { ?>
                                <h5 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h5>
                            <?php  } ?>
                            
	                        <div class="entry-excerpt">
	                        	<?php echo fullhouse_fnc_excerpt(28,'...');; ?>
	                        </div>

                            </div>
                    </article>
                </div>
                <?php if(  ($i%$colums==0) || $i == $loop->post_count) {  ?>
                </div></div>
                <?php } ?>
            <?php   }  ?>
        </div>
         


    </div>
        <?php if( isset($show_pagination) && $show_pagination ): ?>
        <div class="w-pagination"><?php fullhouse_fnc_pagination_nav( $post_per_page,$loop->found_posts,$loop->max_num_pages ); ?></div>
        <?php endif ; ?>
</section>
<?php wp_reset_postdata(); ?>