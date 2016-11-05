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

if(!function_exists('pbr_create_type_footer')   ){
function pbr_create_type_footer(){
  $labels = array(
    'name' => __( 'Footers', "pbrthemer" ),
    'singular_name' => __( 'Footer', "pbrthemer" ),
    'add_new' => __( 'Add Profile Footer', "pbrthemer" ),
    'add_new_item' => __( 'Add Profile Footer', "pbrthemer" ),
    'edit_item' => __( 'Edit Footer', "pbrthemer" ),
    'new_item' => __( 'New Profile', "pbrthemer" ),
    'view_item' => __( 'View Footer Profile', "pbrthemer" ),
    'search_items' => __( 'Search Footer Profiles', "pbrthemer" ),
    'not_found' => __( 'No Footer Profiles found', "pbrthemer" ),
    'not_found_in_trash' => __( 'No Footer Profiles found in Trash', "pbrthemer" ),
    'parent_item_colon' => __( 'Parent Footer:', "pbrthemer" ),
    'menu_name' => __( 'Footers', "pbrthemer" ),
  );

  $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'description' => 'List Footer',
      'supports' => array( 'title', 'editor' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'show_in_nav_menus' => false,
      'publicly_queryable' => false,
      'exclude_from_search' => false,
      'has_archive' => false,
      'query_var' => true,
      'can_export' => true,
      'rewrite' => false
  );
  register_post_type( 'footer', $args );

  if($options = get_option('wpb_js_content_types')){
    $check = true;
    foreach ($options as $key => $value) {
      if($value=='footer') $check=false;
    }
    if($check)
      $options[] = 'footer';
    update_option( 'wpb_js_content_types',$options );
  }else{
    $options = array('page','footer');
  }

}

add_action('init','pbr_create_type_footer');

}