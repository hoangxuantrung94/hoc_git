<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

 $style = array();
?>

<?php $img = wp_get_attachment_image_src($imagebg,'full'); ?>
<?php

	if( $colorbg ){
		$style[] = "background-color:".$colorbg;
	}
?>

<div class="widget-vc nopadding">
		<div class="pbr-inforbox <?php echo esc_attr($el_class);?> clearfix <?php echo esc_attr($inforbox_style); ?> <?php echo esc_attr($inforbox_alight); ?>"  style="<?php echo  implode(';', $style); ?>">
			<div class="inforbox-left ">
				<div class="inforbox-inner">
					<?php if($title!=''): ?>
				    	<h3 class="widget-title inforbox-heading <?php echo esc_attr($title_align).' '.esc_attr( $size ); ?>">
							<span><?php echo trim($title); ?></span>
						</h3>
				    <?php endif; ?>
				    <?php if( $information ){ ?>
				    	<p><?php echo trim($information); ?></p>
				    <?php } ?>
				</div>
			</div>		
			<div class="inforbox-inner inforbox-right">
				<?php if(isset($img[0]) && $img[0]) { ?>
					<img src="<?php echo esc_url_raw($img[0]); ?>" alt=""/>
				<?php } ?>	
			</div>	
		</div>	
</div>