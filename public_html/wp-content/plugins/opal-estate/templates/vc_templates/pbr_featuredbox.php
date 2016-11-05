<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$img = wp_get_attachment_image_src($photo,'full');
$style = $style ? 'feature-box-'.$style:""; 
$color = $color?'style="color:'. $color .';"' : "";
$title_color = $title_color?'style="color:'. $title_color .';"' : "";
?>
<div class="feature-box <?php echo esc_attr($style); ?> <?php echo esc_attr($el_class) ?> <?php echo esc_attr($title_align); ?>">
	<?php if(isset($img[0]) && $img[0]){?>
	<div class="fbox-image">
		<img src="<?php echo esc_url_raw($img[0]);?>" alt="<?php echo esc_attr($title); ?>" />
	</div>
	<?php } ?>
	<?php if($icon){ ?>
    <div class="fbox-icon">
        <i class="icons <?php echo esc_attr($icon); ?> <?php echo esc_attr($background); ?> radius-x" <?php echo trim( $color); ?>></i>
    </div>
    <?php } ?>
      <div class="fbox-content">  
         <div class="fbox-body">                            
            <h4 <?php echo trim( $title_color); ?>><?php echo trim($title); ?></h4> 
            <?php if( $subtitle ) { ?>
            <small><?php echo esc_html($subtitle); ?></small>  
            <?php } ?>                       
         </div>
         <?php if(trim($information)!=''){ ?>
           <p class="description"><?php echo trim( $information );?></p>  
         <?php } ?>
      </div>      
</div>

