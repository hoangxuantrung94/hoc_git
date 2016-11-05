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

class Pbr_Themer_Posts extends Pbr_Themer_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pbr_posts',
            // Widget name will appear in UI
            __('PBR Posts Widget', 'pbrthemer'),
            // Widget description
            array( 'description' => __( '', 'pbrthemer' ), )
        );
        $this->widgetName = 'posts';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );
        $title = apply_filters( 'widget_title', $title );
         echo ($before_widget);
            wp_reset_query();
            require($this->renderLayout('default'));
            wp_reset_postdata();
        echo ($after_widget);
    }
    // Widget Backend
    public function form( $instance ) {
        $defaults = array(  'title' => 'List Posts',
                            'ids' => array(),
                            'class'=>''
                            );
        $instance = wp_parse_args((array) $instance, $defaults);
        $posts = get_posts( array('orderby'=>'title','posts_per_page'=>-1) );
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php echo __( 'Title:', 'pbrthemer' ); ?></label>
            <br>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'ids' )); ?>"><?php echo __( 'Posts:', 'pbrthemer' ); ?></label>
            <br>
            <select multiple name="<?php echo esc_attr($this->get_field_name( 'ids' )); ?>[]" id="<?php echo esc_attr($this->get_field_id( 'ids' )); ?>" style="width:100%;height:250px;">
               <?php foreach( $posts as $value ){ ?>
                <?php
                    $selected = ( in_array($value->ID, $instance['ids'] ) )?' selected="selected"':'';
                ?>

                <option value="<?php echo esc_attr( $value->ID ); ?>" <?php echo trim($selected); ?>>
                    <?php echo esc_html( $value->post_title ); ?>
                </option>
               <?php } ?>
            </select>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['ids'] = $new_instance['ids'];
        return $instance;

    }
}
register_widget( 'Pbr_Themer_Posts' );