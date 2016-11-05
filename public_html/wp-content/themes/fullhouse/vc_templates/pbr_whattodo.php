<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>

<?php $img = wp_get_attachment_image_src($imagebg,'full'); ?>

<div class="pbr-whattodo<?php echo esc_attr( $el_class ).' '.esc_attr( $style ); ?>" >

	<?php 	if( isset($img[0]) )  {  ?>
	<div class="whattodo-image">
	 	<img src="<?php echo esc_url_raw( $img[0] ); ?>" title="<?php echo esc_attr( $title ); ?>"\>
	 	<?php if( $colorbg ){ ?>
	 		<div class="overlay"  style="background-color:<?php echo trim( $colorbg ); ?>"></div>
	 	<?php } ?>
	</div>
	<?php } ?>

	<?php
	if($title!=''){ ?>
		<h3 class="widget-title visual-title whattodo-heading">
	       <span><span><?php echo esc_attr( $title ); ?></span></span>
		</h3>
	<?php }
	?>

	<?php
	if($information!=''){ ?>
		<div class="whattodo-content widget-content">
			<?php echo do_shortcode( $information );?>
		</div>
	<?php }
	?>

</div>
<?php wp_reset_postdata();