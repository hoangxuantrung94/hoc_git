<?php 

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$enddays = strtotime( $input_datetime );
$style = '';
$fstyle = '';
$dfstyle = '';
$lfstyle = '';

if( $image ){
	$img = wp_get_attachment_image_src( $image,'full' );
	if( isset($img[0]) ){
		$style = 'style="background-image:url(\''.$img[0].'\')"';
	}
}
if( $font_color ){
	$fstyle = 'style="color:'.$font_color.'"';
}
if( $description_font_color ){
	$dfstyle = 'style="color:'.$description_font_color.'"';
}
if( $link_font_color ){
	$lfstyle = 'style="color:'.$link_font_color.'"';
}
?>
<div class="banner-countdown-widget" <?php echo trim($style); ?>>
	<div class="inner text-center space-padding-tb-30" <?php echo trim($fstyle); ?>>
		<div class="heading heading-light">
			<?php if( isset($title) && $title ) : ?>
			<h3 <?php echo trim($fstyle); ?>><?php echo trim($title); ?></h3>
			<?php endif; ?>	

			<?php if( isset($descript) && $descript ) : ?>
			<h4 <?php echo trim($dfstyle); ?>><?php echo trim($descript); ?></h4>
		<?php endif; ?>	
		</div>

		 <div class="countdown-wrapper">
		    <div class="pbr-countdown countdown-v2" data-countdown="countdown"
		         data-date="<?php echo date('m',$enddays).'-'.date('d',$enddays).'-'.date('Y',$enddays).'-'. date('H',$enddays) . '-' . date('i',$enddays) . '-' .  date('s',$enddays) ; ?>">
		    </div>
		</div>
		<?php if( $link && $text_link ) : ?>	
			<a href="<?php echo esc_url($link); ?>" <?php echo trim($lfstyle); ?>><?php echo trim( $text_link ); ?></a>
		<?php endif; ?>
	</div>	
</div>