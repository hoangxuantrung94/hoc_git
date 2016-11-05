<?php if( $title){ ?>
<h3 class="widget-title"><span><?php echo trim($title); ?></span></h3>
<?php } ?>
<div class="contact-info">
<?php
foreach ($this->params as $key => $value) :
    if ($instance[$key]) : 
        switch ($key) { 
            case 'working-days':
            case 'working-hours':
                if(isset($instance[$key.'_class']) && !empty($instance[$key.'_class'])): ?>
                    <p class="<?php echo esc_attr( $key ) ?>"><div class="contact-icon"><i class="<?php echo esc_attr( $instance[$key.'_class'] ); ?>" ></i></div><?php echo esc_html( $value ); ?>: <?php echo esc_html( $instance[$key] ); ?></p>
            <?php else: ?>
                <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ) ?>: <?php echo esc_html( $instance[$key] ); ?></p>
                <?php endif;
            break;
                if(isset($instance[$key.'_class']) && !empty($instance[$key.'_class'])): ?>
                        <p class="<?php echo esc_attr( $key ) ?>"><div class="contact-icon"><i class="<?php echo esc_attr( $instance[$key.'_class'] ); ?>" ></i></div><?php echo esc_html( $value ) ?>: <?php echo esc_html( $instance[$key] ); ?></p>
                <?php else: ?>
                <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ); ?>: <?php echo esc_html( $instance[$key] ); ?></p>
                <?php endif;
                break;
            case 'skype':
                if(isset($instance[$key.'_class']) && !empty($instance[$key.'_class'])): ?>
                        <p class="<?php echo esc_attr( $key ) ?>"><div class="contact-icon"><i class="<?php echo esc_attr( $instance[$key.'_class'] ); ?>" ></i></div><?php echo esc_html( $value ) ?>: <?php echo esc_html( $instance[$key] ); ?></p>
                <?php else: ?>
                <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ) ?>: <?php echo esc_html( $instance[$key] ); ?></p>
                <?php endif;
                break;
            case 'title':
            case 'website-url':
                break;
            case 'email':
                if(isset($instance[$key.'_class']) && !empty($instance[$key.'_class'])): ?>
                    <p class="<?php echo esc_attr( $key ) ?>"><div class="contact-icon"><i class="<?php echo esc_attr( $instance[$key.'_class'] ); ?>" ></i></div><?php echo esc_html( $value )?>: <a href="mailto:<?php echo sanitize_email( $instance['email-address'] ); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } ?></a></p>
                <?php else: ?>
                    <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ) ?>: <a href="mailto:<?php echo sanitize_email( $instance['email-address'] ); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></a></p>
                <?php endif;
                break;
            case 'website':
                if(isset($instance[$key.'_class']) && !empty($instance[$key.'_class'])): ?>
                    <p class="<?php echo esc_attr( $key ) ?>"><div class="contact-icon"><i class="<?php echo esc_attr( $instance[$key.'_class'] ); ?>" ></i></div><?php echo esc_html( $value ) ?>: <a href="<?php echo esc_url($instance['website-url']); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></a></p>
                <?php else: ?>
                    <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $value ) ?> <a href="<?php echo esc_url($instance['website-url']); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></a></p>
                <?php endif;
            break;

            case 'email-address':
                ?>
                    <div class="<?php echo esc_attr( $key ) ?>">
                        <p class="desc"><?php echo esc_html( $value ) ?> </p>
                        <a href="<?php echo esc_url($instance['email-address']); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></a>
                    </div>
                <?php 
                break;

            case 'company':
                ?>
                    <div class="<?php echo esc_attr( $key ) ?>">
                        <p class="desc"><?php echo __('head Office', "pbrthemer") ?> </p>
                        <a href="<?php echo esc_url($instance['company']); ?>"><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></a>
                    </div>
                <?php 
                break;

            case 'phone':
                ?>  <div class="phone-number">
                    <p class="desc"><?php echo __('Phone Number', "pbrthemer"); ?></p>
                    <p><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></p>
                <?php 
                break;

            case 'mobile':
                ?>
                    <p><?php if($instance[$key]) { echo esc_html( $instance[$key] ); } else { echo esc_html( $instance[$key] ); } ?></p>
                    </div>
                <?php 
                break;

            default: ?>
                <p class="<?php echo esc_attr( $key ) ?>"><?php echo esc_html( $instance[$key] ); ?></p>
    <?php }
    endif;
endforeach; ?>
</div>