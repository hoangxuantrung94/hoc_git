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
if ( class_exists( 'RWMB_Field' ) ) {

  class RWMB_skills_Field extends RWMB_Field
  {
      /**
       * Get field HTML
       *
       * @param mixed $meta
       * @param array $field
       *
       * @return string
       */
      static public function html( $meta, $field )
      {
          return sprintf(
            '<input type="tel" name="%s" id="%s" value="%s" pattern="\d{3}-\d{4}">',
            $field['field_name'],
            $field['id'],
            $meta
          );
      }
  }
}

if(!function_exists('pbr_create_type_team')   ){
    function pbr_create_type_team(){
      $labels = array(
        'name' => __( 'Team', "pbrthemer" ),
        'singular_name' => __( 'Team', "pbrthemer" ),
        'add_new' => __( 'Add New Team', "pbrthemer" ),
        'add_new_item' => __( 'Add New Team', "pbrthemer" ),
        'edit_item' => __( 'Edit Team', "pbrthemer" ),
        'new_item' => __( 'New Team', "pbrthemer" ),
        'view_item' => __( 'View Team', "pbrthemer" ),
        'search_items' => __( 'Search Teams', "pbrthemer" ),
        'not_found' => __( 'No Teams found', "pbrthemer" ),
        'not_found_in_trash' => __( 'No Teams found in Trash', "pbrthemer" ),
        'parent_item_colon' => __( 'Parent Team:', "pbrthemer" ),
        'menu_name' => __( 'Teams', "pbrthemer" ),
      );

      $args = array(
          'labels' => $labels,
          'hierarchical' => false,
          'description' => 'List Team',
          'supports' => array( 'title', 'editor', 'thumbnail','excerpt'),
          'public' => true,
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 5,
          'show_in_nav_menus' => false,
          'publicly_queryable' => true,
          'exclude_from_search' => true,
          'has_archive' => true,
          'query_var' => true,
          'can_export' => true,
          'rewrite' => false,
          'capability_type' => 'post'
      );
      register_post_type( 'team', $args );

      $labels = array(
        'name'              => __( 'Teacher Categories', "pbrthemer" ),
        'singular_name'     => __( 'Category', "pbrthemer" ),
        'search_items'      => __( 'Search Category', "pbrthemer" ),
        'all_items'         => __( 'All Categories', "pbrthemer" ),
        'parent_item'       => __( 'Parent Category', "pbrthemer" ),
        'parent_item_colon' => __( 'Parent Category:', "pbrthemer" ),
        'edit_item'         => __( 'Edit Category', "pbrthemer" ),
        'update_item'       => __( 'Update Category', "pbrthemer" ),
        'add_new_item'      => __( 'Add New Category', "pbrthemer" ),
        'new_item_name'     => __( 'New Category Name', "pbrthemer" ),
        'menu_name'         => __( 'Categories', "pbrthemer" ),
      );
      // Now register the taxonomy
      register_taxonomy('category_teachers',array('team'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' =>true,
              'rewrite'           => array( 'slug' => 'team-category'
          ),
      ));



}

add_action( 'init','pbr_create_type_team' );




function pbr_func_metaboxes_team_fields(){
     /**
       * prefix of meta keys (optional)
       * Use underscore (_) at the beginning to make keys hidden
       * Alt.: You also can make prefix empty to disable it
       */

         // Better has an underscore as last sign
      $prefix = 'team_';
      $fields =  array(
          // COLOR
          array(
            'name' => __( 'Job', "pbrthemer" ),
            'id'   => "{$prefix}job",
            'type' => 'text',
            'description' => __('Enter Job example CEO, CTO', "pbrthemer")
          ), 
           
           // THICKBOX IMAGE UPLOAD (WP 3.3+)
          // FILE ADVANCED (WP 3.5+)
          array(
            'name'             => __( 'Phone Number', "pbrthemer" ),
            'id'               => "{$prefix}phone_number",
            'type'             => 'text',
            'max_file_uploads' => 10,
            'mime_type'        => 'image', // Leave blank for all file types
          ),

           // COLOR
          array(
            'name' => __( 'Google Plus Link', "pbrthemer" ),
            'id'   => "{$prefix}google",
            'type' => 'text',
            'description' => __('Enter google', "pbrthemer")
          ), 

          array(
            'name' => __( 'Facebook Link', "pbrthemer" ),
            'id'   => "{$prefix}facebook",
            'type' => 'text',
            'description' => __('Enter facebook', "pbrthemer")
          ), 

          array(
            'name' => __( 'Twitter', "pbrthemer" ),
            'id'   => "{$prefix}twitter",
            'type' => 'text',
            'description' => __('Enter Twitter', "pbrthemer")
          ), 

          array(
            'name' => __( 'Printest', "pbrthemer" ),
            'id'   => "{$prefix}pinterest",
            'type' => 'text',
            'description' => __('Enter pinterest', "pbrthemer")
          ), 
          
        ); 
       return apply_filters( 'pbr_team_metaboxes_fields', $fields );
  }

  /**
   *
   */
  function pbrthemer_func_team_register_meta_boxes( $meta_boxes ){

      // 1st meta box
      $meta_boxes[] = array(
        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
        'id'         => 'standard',
        // Meta box title - Will appear at the drag and drop handle bar. Required.
        'title'      => __( 'Team Setting', "pbrthemer" ),
        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
        'post_types' => array( 'team' ),
        // Where the meta box appear: normal (default), advanced, side. Optional.
        'context'    => 'normal',
        // Order of meta box: high (default), low. Optional.
        'priority'   => 'low',
        // Auto save: true, false (default). Optional.
        'autosave'   => true,
        // List of meta fields
        'fields'     =>  pbr_func_metaboxes_team_fields()
      );

      return $meta_boxes;
  }

  /**
   * Register Metabox 
   */

  add_filter( 'rwmb_meta_boxes', 'pbrthemer_func_team_register_meta_boxes', 9);

  if( class_exists("WPBakeryVisualComposerAbstract") ){
      /******************************
       * Our Team
       ******************************/
      vc_map( array(
          "name" => __("Team Grid (Team Source)", "pbrthemer"),
          "base" => "pbr_posttype_team",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('PBR Post Type', "pbrthemer"),
          "params" => array(
            array(
            "type" => "textfield",
            "heading" => __("Title", "pbrthemer"),
            "param_name" => "title",
            "value" => '',
              "admin_label" => true
          ),
            array(
            "type" => "textfield",
            "heading" => __("Number items", "pbrthemer"),
            "param_name" => "number",
            "value" => '8',
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
                  'std' => 4
          ),
          array(
                  "type" => "textfield",
                  "heading" => __("Extra class name", "pbrthemer"),
                  "param_name" => "el_class",
                  "description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "pbrthemer")
          )
        )
      ));
      class WPBakeryShortCode_Pbr_posttype_team extends WPBakeryShortCode {}
  }

  function pbr_fnc_team_query(){

      $args = array(
            'post_type' => 'team'           
        );
       
      return new WP_Query( $args );  
  }    
}


