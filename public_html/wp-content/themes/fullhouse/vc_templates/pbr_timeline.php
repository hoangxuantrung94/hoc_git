<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
?>

<section class="widget wpo-timeline">
    <?php if( $title ) { ?>
        <h3 class="widget-title visual-title">
           <span><?php echo trim( $title ); ?></span>
        </h3>
    <?php } ?>

    <div class="widget-content">
        <ul class="history-timeline">

          <?php
            $line_data = array();
            $items = (array) vc_param_group_parse_atts( $items );
            foreach ( $items as $data ) {
              $new_line = $data;
              $new_line['title'] = isset( $data['title'] ) ? $data['title'] : '';
              $new_line['sub_title'] = isset( $data['sub_title'] ) ? $data['sub_title'] : '';
              $new_line['content'] = isset( $data['content'] ) ? $data['content'] : '';
              $new_line['icon'] = isset( $data['icon'] ) ? $data['icon'] : '';
              $line_data[] = $new_line;
            }
          ?>

          <?php
          if($line_data): 
            $i = 1;
            foreach ($line_data as $key => $item):
          ?>
  				  <li class="entry-timeline clearfix">
              <div class="hentry">
                <div class="icon">
                  <?php $img = wp_get_attachment_image_src($item['icon'], 'full'); ?>
                  <?php if( isset($img[0]) )  { ?>
                    <img src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $title ); ?>"  />
                  <?php } ?>  
                </div>    
  			   		  <div class="hentry-box clearfix">
                  <span class="number"><?php echo esc_html($item['title']) ?></span>
  			   			  <div class="content-inner">
                    <h4 class="title"><?php echo esc_html($item['title']) ?></h4>
                    <h5 class="sub-title"><?php echo esc_html($item['sub_title']) ?></h5>
                    <div class="content">
                      <?php echo esc_html($item['content']) ?>
                     </div>
                  </div>   
  			   		  </div>
              </div> 
  				  </li>
          <?php $i++; endforeach; endif; ?>  
				</ul>
    </div>
</section>