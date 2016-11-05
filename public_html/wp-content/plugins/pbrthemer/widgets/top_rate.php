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

if(class_exists('PostRatings')){

    class Pbr_Themer_Top_Rate_Widget extends Pbr_Themer_Widget {
        public function __construct() {
            parent::__construct(
                // Base ID of your widget
                'pbr_top_rate_widget',
                // Widget name will appear in UI
                __('PBR Top Rate Widget', 'pbrthemer'),
                // Widget description
                array( 'description' => __( 'The highest rated posts on your site', 'pbrthemer' ), )
            );
            $this->widgetName = 'top_rate';
        }

        public function widget( $args, $instance ) {
            global $post;
            extract( $args );
            extract( $instance );

            $title      = apply_filters('widget_title', empty($instance['title']) ? __('Top Rated', 'pbrthemer') : $instance['title'], $instance, $this->id_base);
            $number     = min(max((int)$instance['number'], 1), 20);
            $date_limit = min(max((int)$instance['date_limit'], 0), 999);
            $post_type  = post_type_exists($instance['post_type']) ? $instance['post_type'] : 'post';
            $sort       = isset($instance['sort']) ? esc_attr($instance['sort']) : 'bayesian_rating';

             echo ($before_widget);

            $posts = PostRatings()->getTopRated(array(
                'post_type'  => $post_type,
                'number'     => $number,
                'sortby'     => $sort,
                'order'      => in_array($instance['order'], array('ASC', 'DESC'), true) ? $instance['order'] : 'DESC',
                'date_limit' => $date_limit,
            ));

            if($posts){
                    require($this->renderLayout( 'default'));
                    wp_reset_postdata();
            }
            echo ($after_widget);
        }
        
        // Widget Backend
        public function form( $instance ) {
            $defaults = array(  'title' => 'Top Rated',
                                'number' => '5',
                                'sort' => 'bayesian_rating',
                                'order' => 'DESC',
                                'date_limit' => 0,
                                'post_type' =>  'post');
            $instance = wp_parse_args((array) $instance, $defaults);
            $plugin_options = PostRatings()->getOptions();
            ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:</label>
                <br>
                <input id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php _e('Get most rated:', 'pbrthemer'); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>">
                    <?php foreach(get_post_types(array('public' => true)) as $type): ?>
                    <?php $object = get_post_type_object($type); ?>
                    <option <?php if(!in_array($type, $plugin_options['post_types'])): ?> disabled="disabled" <?php endif; ?> value="<?php echo esc_attr( $type ); ?>" <?php selected($type, $instance['post_type']); ?>><?php echo esc_html( $object->labels->name ); ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('sort')); ?>"><?php _e('Sort by:', 'pbrthemer'); ?></label>
                <select class="widefat" id="<?php echo esc_attr($this->get_field_id('sort')); ?>" name="<?php echo esc_attr($this->get_field_name('sort')); ?>">
                <option <?php selected('bayesian_rating', $instance['sort']); ?> value="bayesian_rating"><?php _e('Overall bayesian rating (score)', 'pbrthemer'); ?></option>
                <option <?php selected('rating', $instance['sort']); ?> value="rating"><?php _e('Average rating', 'pbrthemer'); ?></option>
                <option <?php selected('votes', $instance['sort']); ?> value="votes"><?php _e('Number of votes', 'pbrthemer'); ?></option>
                </select>
            </p>
            
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>_desc">
                <input id="<?php echo esc_attr($this->get_field_id('order')); ?>_desc" name="<?php echo esc_attr($this->get_field_name('order')); ?>" type="radio" value="DESC" <?php checked('DESC', $instance['order']); ?> />
                <?php _e('Descending', 'pbrthemer'); ?>
                </label>

                <label for="<?php echo esc_attr($this->get_field_id('order')); ?>_asc">
                <input id="<?php echo esc_attr($this->get_field_id('order')); ?>_asc" name="<?php echo esc_attr($this->get_field_name('order')); ?>" type="radio" value="ASC" <?php checked('ASC', $instance['order']); ?> />
                <?php _e('Ascending', 'pbrthemer'); ?>
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('date_limit')); ?>"><?php _e('Ignore posts older than:', 'pbrthemer'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('date_limit')); ?>" name="<?php echo esc_attr($this->get_field_name('date_limit')); ?>" type="text" value="<?php echo esc_attr( $instance['date_limit'] ); ?>" size="3" /> <?php _e('days', 'pbrthemer'); ?>
                <br />
                <small><?php _e('(0 to ignore date)', 'pbrthemer'); ?></small>
            </p>

            <p>
                <label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Limit:', 'pbrthemer'); ?></label>
                <input id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3" />
            </p>

    <?php
        }

        public function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = $new_instance['title'];
            $instance['sort'] = $new_instance['sort'];
            $instance['order'] = $new_instance['order'];
            $instance['number'] = $new_instance['number'];
            $instance['date_limit'] = $new_instance['date_limit'];
            $instance['post_type'] = $new_instance['post_type'];
            return $instance;

        }
    }

    register_widget( 'Pbr_Themer_Top_Rate_Widget' );
}