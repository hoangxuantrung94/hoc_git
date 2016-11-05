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

if(!function_exists('pbr_create_type_brand')  ){ 
  function pbr_create_type_brand(){
    $labels = array(
      'name' => __( 'Brand Logos', "pbrthemer" ),
      'singular_name' => __( 'Brand', "pbrthemer" ),
      'add_new' => __( 'Add New Brand', "pbrthemer" ),
      'add_new_item' => __( 'Add New Brand', "pbrthemer" ),
      'edit_item' => __( 'Edit Brand', "pbrthemer" ),
      'new_item' => __( 'New Brand', "pbrthemer" ),
      'view_item' => __( 'View Brand', "pbrthemer" ),
      'search_items' => __( 'Search Brands', "pbrthemer" ),
      'not_found' => __( 'No Brands found', "pbrthemer" ),
      'not_found_in_trash' => __( 'No Brands found in Trash', "pbrthemer" ),
      'parent_item_colon' => __( 'Parent Brand:', "pbrthemer" ),
      'menu_name' => __( 'Brands', "pbrthemer" ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'List Brand',
        'supports' => array( 'title', 'thumbnail'),
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
    register_post_type( 'brands', $args );
    
  }

  add_action('init','pbr_create_type_brand');


///////
function pbr_func_metaboxes_brands_fields(){
     
     /**
       * prefix of meta keys (optional)
       * Use underscore (_) at the beginning to make keys hidden
       * Alt.: You also can make prefix empty to disable it
       */

         // Better has an underscore as last sign
      $prefix = 'brands_';
      $fields =  array(
     
           // COLOR
          array(
            'name' => __( 'Brand Link', "pbrthemer" ),
            'id'   => "{$prefix}brank_link",
            'type' => 'text',
            'default' => '#',
            'description' => __('Enter Link To', "pbrthemer")
          ), 

          
          
        ); 
       return apply_filters( 'pbr_brand_metaboxes_fields', $fields );
  }

  /**
   *
   */
  function pbrthemer_func_brand_register_meta_boxes( $meta_boxes ){

      // 1st meta box
      $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'standard',
        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Brand Setting', "pbrthemer" ),
        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'brands' ),
        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',
        // Order of meta box: high (default), low. Optional.
        'priority'   => 'low',
        // Auto save: true, false (default). Optional.
        'autosave'   => true,
        // List of meta fields
        'fields'     =>  pbr_func_metaboxes_brands_fields()
      );


      return $meta_boxes;
  }

  /**
   * Register Metabox 
   */

  add_filter( 'rwmb_meta_boxes', 'pbrthemer_func_brand_register_meta_boxes', 11);


}



/*********************************************************************************************************************
 *  Brands Carousel
 *********************************************************************************************************************/

if( class_exists("WPBakeryVisualComposerAbstract") ){

    Class Pbr_Themer_Vc_Vendor_Brands implements Vc_Vendor_Interface {

         public function load(){ 

                  vc_map( array(
                      "name" => __("PBR Brands Carousel", "pbrthemer"),
                      "base" => "pbr_brands",
                      'description'=>'Show Brand Logos, Manufacture Logos From Source: Brands',
                      "class" => "",
                      "category" => __('PBR Post Type', "pbrthemer"),
                      "params" => array(
                        array(
                        "type" => "textfield",
                        "heading" => __("Title", "pbrthemer"),
                        "param_name" => "title",
                        "value" => '',
                      ),

                      array(
                        "type" => "textarea",
                        "heading" => __('Descriptions', "pbrthemer"),
                        "param_name" => "descript",
                        "value" => ''
                      ),
                array(
                  'type' => 'textfield',
                  'heading' => __( 'Number post', "pbrthemer" ),
                  'param_name' => 'number',
                  'std' => 12
                ),
                array(
                  'type' => 'dropdown',
                  'heading' => __( 'Columns count', "pbrthemer" ),
                  'param_name' => 'columns_count',
                  'value' => array(
                    __( '2 Items', "pbrthemer" ) => 2,
                    __( '3 Items', "pbrthemer" ) => 3,
                    __( '4 Items', "pbrthemer" ) => 4,
                    __( '5 Items', "pbrthemer" ) => 5,
                    __( '6 Items', "pbrthemer" ) => 6,
                  ),
                  'std' => 6
                ),
                array(
                  'type' => 'dropdown',
                  'heading' => __( 'Styles', "pbrthemer" ),
                  'param_name' => 'style',
                  'value' => array(
                    __( 'Grid', "pbrthemer" ) => 'grid',
                    __( 'Carousel', "pbrthemer" ) => 'carousel',
                  ),
                  'std' => 'carousel'
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
    class WPBakeryShortCode_Pbr_brands extends WPBakeryShortCode {}
    
      function pbrthemer_fnc_init_vc_brands_vendors(){
         $vendor = new Pbr_Themer_Vc_Vendor_Brands();
         add_action( 'vc_after_set_mode', array(
            $vendor,
           'load'
          ), 99 ); 
      }
    
    pbrthemer_fnc_init_vc_brands_vendors();
    

}    