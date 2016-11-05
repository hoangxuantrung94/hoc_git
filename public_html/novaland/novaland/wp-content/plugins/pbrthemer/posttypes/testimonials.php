<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Team <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015 prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

if(!function_exists('pbr_create_type_testimonial')   ){
    function pbr_create_type_testimonial(){
      $labels = array(
        'name' => __( 'Testimonial', "pbrthemer" ),
        'singular_name' => __( 'Testimonial', "pbrthemer" ),
        'add_new' => __( 'Add New Testimonial', "pbrthemer" ),
        'add_new_item' => __( 'Add New Testimonial', "pbrthemer" ),
        'edit_item' => __( 'Edit Testimonial', "pbrthemer" ),
        'new_item' => __( 'New Testimonial', "pbrthemer" ),
        'view_item' => __( 'View Testimonial', "pbrthemer" ),
        'search_items' => __( 'Search Testimonials', "pbrthemer" ),
        'not_found' => __( 'No Testimonials found', "pbrthemer" ),
        'not_found_in_trash' => __( 'No Testimonials found in Trash', "pbrthemer" ),
        'parent_item_colon' => __( 'Parent Testimonial:', "pbrthemer" ),
        'menu_name' => __( 'Testimonials', "pbrthemer" ),
      );

      $args = array(
          'labels' => $labels,
          'hierarchical' => true,
          'description' => 'List Testimonial',
          'supports' => array( 'title', 'editor', 'thumbnail'),
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 5,
          'show_in_nav_menus' => false,
          'publicly_queryable' => true,
          'exclude_from_search' => false,
          'has_archive' => true,
          'query_var' => true,
          'can_export' => true,
          'rewrite' => true,
          'capability_type' => 'post'
      );
      register_post_type( 'testimonial', $args );
    }

    add_action( 'init','pbr_create_type_testimonial' );
}



function pbr_func_metaboxes_testimonial_fields(){
     /**
       * prefix of meta keys (optional)
       * Use underscore (_) at the beginning to make keys hidden
       * Alt.: You also can make prefix empty to disable it
       */

         // Better has an underscore as last sign
      $prefix = 'testimonials_';
      $fields =  array(
          // COLOR
          array(
            'name' => __( 'Job', "pbrthemer" ),
            'id'   => "{$prefix}job",
            'type' => 'text',
            'description' => __('Enter Job example CEO, CTO', "pbrthemer")
          ), 
           
        
          array(
            'name' => __( 'Link', "pbrthemer" ),
            'id'   => "{$prefix}link",
            'type' => 'text',
            'description' => __('Enter Link to this personal', "pbrthemer")
          ), 

 
          
        ); 
       return apply_filters( 'pbr_team_metaboxes_fields', $fields );
  }

  /**
   *
   */
  function pbrthemer_func_testimonials_register_meta_boxes( $meta_boxes ){

      // 1st meta box
      $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'standard',
        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Testimonials Info', "pbrthemer" ),
        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'testimonial' ),
        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',
        // Order of meta box: high (default), low. Optional.
        'priority'   => 'low',
        // Auto save: true, false (default). Optional.
        'autosave'   => true,
        // List of meta fields
        'fields'     =>  pbr_func_metaboxes_testimonial_fields()
      );

      return $meta_boxes;
  }

  /**
   * Register Metabox 
   */

  add_filter( 'rwmb_meta_boxes', 'pbrthemer_func_testimonials_register_meta_boxes', 12);


if( class_exists("WPBakeryVisualComposerAbstract") ){

    Class Pbr_Themer_Vc_Vendor_Testimonials implements Vc_Vendor_Interface {

        public function load(){ 
            /**********************************************************************************************************************
             * Testimonials
             **********************************************************************************************************************/
            vc_map( array(
                "name" => __("PBR Testimonials", "pbrthemer"),
                "base" => "pbr_testimonials",
                'description'=> __('Play Testimonials In Carousel', "pbrthemer"),
                "class" => "",
                "category" => __('PBR Post Type', "pbrthemer"),
                "params" => array(
                  array(
                  "type" => "textfield",
                  "heading" => __("Title", "pbrthemer"),
                  "param_name" => "title",
                  "admin_label" => true,
                  "value" => '',
                    "admin_label" => true
                ),
                array(
                  "type" => "textfield",
                  "heading" => __("Number", "pbrthemer"),
                  "param_name" => "number",
                  "value" => '10',
                ),
                array(
                  "type" => "dropdown",
                  "heading" => __("Columns", "pbrthemer"),
                  "param_name" => "columns",
                  "value" => array(1,2,3,4,5),
                  "admin_label" => true,
                  "description" => __("Select Columns layout.", "pbrthemer")
                ),
                array(
                  "type" => "dropdown",
                  "heading" => __("Skin", "pbrthemer"),
                  "param_name" => "skin",
                  "value" => array('Version Style left'=>'left','Version Style 2'=>'v2', 'Version Style 4'=>'v4', 'Version Style 5'=>'v5'),
                  "admin_label" => true,
                  "description" => __("Select Skin layout.", "pbrthemer")
                ),
                array(
                  "type" => "textfield",
                  "heading" => __("Extra class name", "pbrthemer"),
                  "param_name" => "el_class",
                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pbrthemer")
                )
                )
            ));
        }
    }

    class WPBakeryShortCode_Pbr_testimonials   extends WPBakeryShortCode {}
    
    function pbrthemer_fnc_init_vc_testimonials_vendors(){
       $vendor = new Pbr_Themer_Vc_Vendor_Testimonials();
       add_action( 'vc_after_set_mode', array(
          $vendor,
         'load'
        ), 99 ); 
    }
    
    pbrthemer_fnc_init_vc_testimonials_vendors();
}      
