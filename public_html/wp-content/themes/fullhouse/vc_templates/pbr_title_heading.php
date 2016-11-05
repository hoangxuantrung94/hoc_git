<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $title_align 
 * @var $descript
 * @var $size
 * @var $font_color
 * @var $el_class 
 * @var $heading_style 
 * Shortcode class
 * @var $this WPBakeryShortCode_PBR_title_heading
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

?>

<div class="widget-text-heading <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $style ); ?>">
	<?php if($title!=''): ?>
        <h3 class="widget-heading" <?php if($font_color!=''): ?> style="color: <?php echo esc_attr( $font_color ); ?>;"<?php endif; ?>>
           <span><span><?php echo esc_attr( $title ); ?></span></span>
            <?php if(trim($descript)!=''){ ?>
                <span class="description">
                    <?php echo trim( $descript ); ?>
                </span>
            <?php } ?>
        </h3>
    <?php endif; ?>
</div>