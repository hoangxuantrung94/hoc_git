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

class Pbr_Themer_Socials_Widget extends Pbr_Themer_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pbr_socials_widget',
            // Widget name will appear in UI
            __('PBR Socials', 'pbrthemer'),
            // Widget description
            array( 'description' => __( 'Socials for website.', 'pbrthemer' ), )
        );
        $this->widgetName = 'socials';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $title = apply_filters('widget_title', $instance['title']);
        $socials = $instance['socials'];
        
        echo    $before_widget;
            require($this->renderLayout( 'default' ));
        echo    $after_widget;
    }
// Widget Backend
    public function form( $instance ) {
        $list_socials = array(
            'facebook'      => 'Facebook',
            'twitter'       => 'Twitter',
            'youtube'       => 'Youtube',
            'pinterest'     => 'Pinterest',
            'google-plus'   => 'Google plus',
            'linkedin'      => 'LinkedIn',
            'instagram'     => 'Instagram'
        );
        $defaults = array('title' => 'Find us on social networks', 'layout' => 'default', 'socials' => array());
        $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <div class="pbr_socials">

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'socials' )); ?>">Select socials:</label>
            <br>
        <?php
            foreach ($list_socials as $key => $value):
                $checked = (isset($instance['socials'][$key]['status']) && ($instance['socials'][$key]['status'])) ? 1: 0;
                $link = (isset($instance['socials'][$key]['page_url'])) ? $instance['socials'][$key]['page_url']: '';
        ?>
                <p>
                <input class="checkbox" type="checkbox" <?php checked( $checked, 1 ); ?> id="<?php echo esc_attr( $key ); ?>"
                    name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr( $key ); ?>][status]" />
                    <label for="<?php echo esc_attr($this->get_field_name('socials') ); ?>[<?php echo esc_attr( $key ); ?>][status]">
                        <?php echo 'Show '.esc_html( $value ); ?>
                    </label>
                <input type="hidden" name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr( $key ); ?>][name]" value=<?php echo esc_attr( $value ); ?> />
                </p>
                <p style="display: <?php echo ($checked)? 'block': 'none'; ?>" id="<?php echo esc_attr($this->get_field_id($key)); ?>" class="text_url <?php echo esc_attr( $key ); ?>">
                    <label for="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr( $key ); ?>][page_url]">
                        <?php echo esc_html( $value ).' Page URL: '; ?>
                    </label>
                    <input class="widefat" type="text"
                        id="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr( $key ); ?>][page_url]"
                        name="<?php echo esc_attr($this->get_field_name('socials')); ?>[<?php echo esc_attr( $key ); ?>][page_url]"
                        value="<?php echo esc_url($link); ?>"
                    />
                </p>
            <?php endforeach; ?>
        </p>
    </div>
    <script type="application/javascript">
        jQuery('.checkbox').on('click',function(){
            jQuery('.'+this.id).toggle();
        });
    </script>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['socials'] = $new_instance['socials'];

        return $instance;

    }
}

register_widget( 'Pbr_Themer_Socials_Widget' );