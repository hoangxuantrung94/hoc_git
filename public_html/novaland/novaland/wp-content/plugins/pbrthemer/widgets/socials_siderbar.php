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

class Pbr_Themer_Socials_Siderbar_Widget extends Pbr_Themer_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pbr_socials_siderbar_widget',
            // Widget name will appear in UI
            __('PBR Socials Siderbar', 'pbrthemer'),
            // Widget description
            array( 'description' => __( 'Share Socials Siderbar for website.', 'pbrthemer' ), )
        );
        $this->widgetName = 'socials_siderbar';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );
        echo  trim($before_widget);
        if($instance['list_service']){
            $services = join(",", $instance['list_service']);
            require($this->renderLayout('default'));
        }
        echo  trim($after_widget);
    }
// Widget Backend
    public function form( $instance ) {
        $themes   = array(
            'transparent'       => 'Transparent',
            'light'             => 'Light',
            'gray'              => 'Gray',
            'drark'             => 'Drark'
        );
        //data services share
        $services = array(
            array( 'val' => 'facebook', 'text'      => 'Facebook' ),
            array( 'val' => 'twitter',  'text'      => 'Twitter' ),
            array( 'val' => 'gmail',    'text'      => 'Gmail' ),
            array( 'val' => 'google_plusone_share', 'text'  => 'Google+ Share'),
            array( 'val' => 'email',    'text'      => 'Email'),
            array( 'val' => 'yahoomail', 'text'     => 'Y! Mail'),
            array( 'val' => 'zingme',   'text'      => 'ZingMe'),
            array( 'val' => 'pinterest',    'text'  => 'Pinterest Pin It'),
            array( 'val' => 'more', 'text'          => 'More' ),
            array( 'val' => 'print',    'text'      => 'Print'),
            array( 'val' => 'tumblr',   'text'      => 'Tumblr'),
            array( 'val' => 'linkedin', 'text'      => 'LinkedIn'),
            array( 'val' => 'favorites',    'text'  => 'Favorites'),
            array( 'val' => 'hotmail',  'text'  => 'Hotmail'),
            array( 'val' => 'linkshares',   'text'  =>'LinkShares'),
            array( 'val' => 'myspace',  'text'  => 'Myspace'),
            array( 'val' => 'printfriendly',    'text'  => 'PrintFriendly') ,
            array( 'val' => 'virb', 'text'  => 'Virb'),
            array( 'val' => 'webnews',  'text'  =>'Webnews'),
            array( 'val' => 'windows',  'text'  => 'Windows Gadgets'),
            array( 'val' => 'wordpress',    'text'  => 'WordPress'),
            array( 'val' => 'yigg', 'text'  =>'Yigg'),
            array( 'val' => 'ziczac','text' =>'ZicZac'),
         );

        $positions = array('left' => 'Outsite Left','right' => 'Outsite Right');
        $shows_mobile = array(1 => 'Enable', 0 => 'Disnable');
        $defaults = array(
            'skin' => 'transparent',
            'position'=> 'right', 
            'list_service' => array(), 
            'show_mobile' => false
        );
        $instance = wp_parse_args((array) $instance, $defaults);
    ?>
    <div class="pbr_socials_siderbar">

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('position')); ?>">Position Share:</label>
            </br>
            <select name="<?php echo esc_attr($this->get_field_name( 'position' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'position' )); ?>">
            <?php foreach($positions as $val => $pos){ ?>
                <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $instance['position'], $val ); ?>><?php echo esc_html( $pos );  ?></option>
            <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'list_service' )); ?>"><?php echo __( 'Share services social:', 'pbrthemer' ); ?></label>
            <br>
            <select multiple name="<?php echo esc_attr($this->get_field_name( 'list_service' )); ?>[]" id="<?php echo esc_attr($this->get_field_id( 'list_service' )); ?>" style="width:100%;height:200px;">
               <?php foreach( $services as $value ){ ?>
                <?php
                    $selected = ( in_array($value['val'], $instance['list_service'] ) )?' selected="selected"':'';
                ?>

                <option value="<?php echo esc_attr( $value['val'] ); ?>" <?php echo trim($selected); ?>>
                    <?php echo esc_html( $value['text'] );  ?>
                </option>
               <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('skin')); ?>">Theme:</label>
            </br>
            <select name="<?php echo esc_attr($this->get_field_name( 'skin' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'skin' )); ?>">
            <?php foreach($themes as $skin=>$theme){ ?>
                <option value="<?php echo esc_html( $skin );  ?>" <?php selected( $instance['skin'], $skin ); ?>><?php echo esc_html( $theme );  ?></option>
            <?php } ?>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_mobile')); ?>">Show moblie:</label>
            </br>
            <select name="<?php echo esc_attr($this->get_field_name( 'show_mobile' )); ?>" id="<?php echo esc_attr($this->get_field_id( 'show_mobile' )); ?>">
            <?php foreach($shows_mobile as $k => $vl){ ?>
                <option value="<?php echo esc_attr( $k ); ?>" <?php selected( $instance['show_mobile'], $k );  ?>><?php echo esc_html( $vl );   ?></option>
            <?php } ?>
            </select>
        </p>
    </div>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['skin']           = ( ! empty( $new_instance['skin'] ) ) ? $new_instance['skin'] : 'transparent';
        $instance['position']       = ( ! empty( $new_instance['position'] ) ) ? $new_instance['position'] : 'right';
        $instance['list_service']   = $new_instance['list_service'];
        $instance['show_mobile']    = ( ! empty( $new_instance['show_mobile'] ) ) ? $new_instance['show_mobile'] : 0;

        return $instance;

    }
}

register_widget( 'Pbr_Themer_Socials_Siderbar_Widget' );