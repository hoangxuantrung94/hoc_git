<?php
	if( $relates->have_posts() ): ?>
	    <div class="widget">
            <h3 class="widget-title separator_align_left related-post-title space-padding-top-40 font-size-md">
                <span><?php echo __( 'You may also like', 'edubase' ); ?></span>
            </h3>
        </div>
        <div class="related-posts-content space-30">
            <div class="row">
    		    <?php
                $column = get_option('post-number-columns', 3) ;
                $col = floor(12/$column);
                $smcol = ($col > 4)? 6: $col;
                $class_column='col-lg-'.$col.' col-md-'.$col.' col-sm-'.$smcol;

        		while ( $relates->have_posts() ) : $relates->the_post();
              ?>
        			     <div class="portfolio-masonry-entry masonry-item <?php echo esc_attr( $class_column ); ?>">
	                        <div class="wpo-portfolio-content text-center">
	                          <div class="ih-item square colored effect16">
	                              <div class="img">
	                                  <?php if ( has_post_thumbnail()) {
	                                    the_post_thumbnail('post-thumbnail');
	                                  }?>
	                              </div>
	                              <div class="info">
	                                <div class="info-inner">
	                                    <h3><a class="text-success" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	                                    <div class="description hidden"><?php echo the_excerpt(20,'...'); ?></div>
	                                    <div class="created hidden"><?php echo get_the_date(); ?></div>
	                                    <a class="hidden zoom" href="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ) ); ?>" data-rel="prettyPhoto[pp_gal]"> <i class="fa fa-search radius-x space-padding-10"></i> </a>
	                                </div>    
	                              </div>
	                          </div>
	                        </div>
                      </div>
                    <?php
                endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
        <?php
    endif;