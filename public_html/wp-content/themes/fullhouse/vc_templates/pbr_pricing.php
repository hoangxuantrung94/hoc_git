<?php

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

 $class = $featured ? "featured-plan pricing-highlight": '';
 $class .= ' ' . $el_class;
 //var_dump($content);
?>
<div class="pricing pricing-<?php echo esc_attr($skin); ?> <?php echo esc_attr($class); ?>">
    <div class="pricing-header">
        <span class="plan-subtitle"><?php echo  esc_html($subtitle); ?></span>
        <h4 class="plan-title">
            <span><?php echo  esc_html($title); ?></span>
        </h4>                        
        <?php if($skin == 'v2'){  ?>
            <div class="plan-price">
                <div class="plan-price-body">
                    <sup class="plan-currency"><?php echo esc_html($currency); ?></sup>
                    <span class="plan-figure"><?php echo esc_html($price); ?></span>
                    <p><?php echo esc_html($period); ?></p>
                </div>
            </div>    
        <?php }else{ ?>
            <div class="plan-price">
                <sup class="plan-currency"><?php echo esc_html($currency); ?></sup> 
                <span class="plan-figure"><?php echo esc_html($price); ?></span>
                <p><?php echo esc_html($period); ?></p>
            </div>
        <?php } ?>    

    </div>
    <div class="pricing-body">
        <div class="plain-info">
           <?php echo do_shortcode($content); ?>
        </div>
    </div>
    <?php if($skin == 'v2' || $skin == 'v3'){ ?>
    <div class="pricing-footer">
        <a class="btn btn-md btn-block btn-inverse btn-default radius-6x btn-3d" href="<?php echo esc_html($link); ?>"><?php echo  esc_html($linktitle); ?></a>                        
    </div>
    <?php }else{ ?>
     <div class="pricing-footer">
        <a class="btn btn-lg btn-block btn-inverse btn-primary radius-6x" href="<?php echo esc_html($link); ?>"><?php echo  esc_html($linktitle); ?></a>                        
     </div>
     <?php } ?>
</div>