<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

class Pbr_Themer_Tweets_Widget extends Pbr_Themer_Widget{

    public function __construct() {
         parent::__construct(
            // Base ID of your widget
            'pbr_twitter_widget',
            // Widget name will appear in UI
            __('PBR Latest Twitter', 'pbrthemer'),
            // Widget description
            array( 'description' => __( 'Latest Twitter widget.', 'pbrthemer' ), )
        );
        $this->widgetName = 'twitter';
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
    }

    
    public function admin_enqueue_scripts ( $hook_suffix )
    {
        if ( $hook_suffix != 'widgets.php' ) return;

        wp_enqueue_style( 'wp-color-picker' );          
        wp_enqueue_script( 'wp-color-picker' ); 
    }

    public function widget( $args, $instance ) {
        extract( $args );
        //Our variables from the widget settings.
        $title  = apply_filters('widget_title', esc_attr($instance['title']));
        $user   = $instance['user'];
        $twitter_id     = $instance['twitter_id'];
        $limit          = $instance['limit'];
        $width          = $instance['width'];
        $height         = $instance['height'];
        $border_color   = $instance['border_color'];
        $link_color     = $instance['link_color'];
        $text_color     = $instance['text_color'];
        $name_color     = $instance['name_color'];
        $mail_color     = $instance['mail_color'];
        $show_scrollbar = $instance['show_scrollbar'];
        $show_replies   = $instance['show_replies'];
        $chrome = '';

        if ($instance['show_header'] == 0) {
            $chrome .= 'noheader ';
        }
        if ($instance['show_footer'] == 0) {
           $chrome .= 'nofooter ';
        }
        if ($instance['show_border'] == 0) {
           $chrome .= 'noborders ';
        }

        if ($instance['transparent'] == 0) {
            $chrome .= 'transparent';
        }
        $js = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
        //Test


            require($this->renderLayout('default'));
            
        echo ($after_widget);
    }

    //Update the widget

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        //Strip tags from title and name to remove HTML
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['user']       = strip_tags( $new_instance['user'] );
        $instance['twitter_id'] = strip_tags( $new_instance['twitter_id'] );
        $instance['limit']      = $new_instance['limit'];
        $instance['width']      = $new_instance['width'];
        $instance['height']     = $new_instance['height'];
        $instance['border_color']       = strip_tags( $new_instance['border_color'] );
        $instance['link_color']         = strip_tags( $new_instance['link_color'] );
        $instance['text_color']         = strip_tags( $new_instance['text_color'] );
        $instance['name_color']         = strip_tags( $new_instance['name_color'] );
        $instance['mail_color']         = strip_tags( $new_instance['mail_color'] );
        $instance['show_header']    = $new_instance['show_header'];
        $instance['show_footer']    = $new_instance['show_footer'];
        $instance['show_border']    = $new_instance['show_border'];
        $instance['show_scrollbar'] = $new_instance['show_scrollbar'];
        $instance['transparent']    = $new_instance['transparent'];
        $instance['show_replies']   = $new_instance['show_replies'];
        return $instance;
    }


    public function form( $instance ) {
        //Set up some default widget settings.
        $defaults = array( 'title' => __('Latest tweets.', 'pbrthemer'),
                            'user' => __('Leotheme', 'pbrthemer'),
                            'twitter_id' => '477627952327188480',
                            'limit' => 2,
                            'width' => 180,
                            'height' => 200,
                            'border_color' => ('#000'),
                            'link_color' => ('#000'),
                            'text_color' => ('#000'),
                            'name_color' => ('#000'),
                            'mail_color' => ('#000'),
                            'show_header' => 0,
                            'show_footer' => 0,
                            'show_border' => 0,
                            'show_scrollbar' => 0,
                            'transparent' => 0,
                            'show_replies' => 0,
                        );
                        
                $values = array(
                    1 => __('Yes', 'pbrthemer'),
                    0 => __('No', 'pbrthemer'),
                );              
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e('Title:', 'pbrthemer'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'user' )); ?>"><?php _e('Twitter Username:', 'pbrthemer'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'user' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'user' )); ?>" value="<?php echo esc_attr( $instance['user'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>"><?php _e('Limit:', 'pbrthemer'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'limit' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'limit' )); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" style="width:100%;" />
        </p>        
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'twitter_id' )); ?>"><?php _e('Twitter Id:', 'pbrthemer'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'twitter_id' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'twitter_id' )); ?>" value="<?php echo esc_attr( $instance['twitter_id'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'border_color' )); ?>"><?php _e('Border Color:', 'pbrthemer'); ?></label>
             <br>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'border_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'border_color' )); ?>" value="<?php echo esc_attr( $instance['border_color'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'link_color' )); ?>"><?php _e('Link Color:', 'pbrthemer'); ?></label>
             <br>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'link_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'link_color' )); ?>" value="<?php echo esc_attr( $instance['link_color'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'text_color' )); ?>"><?php _e('Text Color:', 'pbrthemer'); ?></label>
             <br>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'text_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'text_color' )); ?>" value="<?php echo esc_attr( $instance['text_color'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'name_color' )); ?>"><?php _e('Name Color:', 'pbrthemer'); ?></label>
             <br>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'name_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'name_color' )); ?>" value="<?php echo esc_attr( $instance['name_color'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'mail_color' )); ?>"><?php _e('Mail Color:', 'pbrthemer'); ?></label>
             <br>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'mail_color' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'mail_color' )); ?>" value="<?php echo esc_attr( $instance['mail_color'] ); ?>" style="width:100%;" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'transparent' )); ?>"><?php _e('Show background', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'transparent' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'transparent' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['transparent'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_replies' )); ?>"><?php _e('Show Replies', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_replies' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_replies' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['show_replies'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_header' )); ?>"><?php _e('Show Header', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_header' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_header' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['show_header'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_footer' )); ?>"><?php _e('Show Footer', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_footer' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_footer' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['show_footer'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_border' )); ?>"><?php _e('Show Border', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_border' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_border' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['show_border'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>    
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'show_scrollbar' )); ?>"><?php _e('Show Scrollbar', 'pbrthemer'); ?></label>
            <br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_scrollbar' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_scrollbar' )); ?>">
                <?php foreach ($values as $key => $value): ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $instance['show_scrollbar'], $key ); ?>><?php echo esc_html( $value ); ?></option>
                <?php endforeach; ?>
            </select>
        </p>            
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#<?php echo esc_js( $this->get_field_id( 'border_color' ) ); ?>').wpColorPicker();
                $('#<?php echo esc_js( $this->get_field_id( 'link_color' ) ); ?>').wpColorPicker();
                $('#<?php echo esc_js( $this->get_field_id( 'text_color' ) ); ?>').wpColorPicker();
                $('#<?php echo esc_js( $this->get_field_id( 'name_color' ) ); ?>').wpColorPicker();
                $('#<?php echo esc_js( $this->get_field_id( 'mail_color' ) ); ?>').wpColorPicker();
            });
        </script>   
    <?php
    }
}

register_widget( 'Pbr_Themer_Tweets_Widget' );

?>