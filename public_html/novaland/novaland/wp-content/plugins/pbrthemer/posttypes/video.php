<?php
 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author      Team <opalwordpress@gmail.com >
  * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

if(!function_exists('pbr_create_type_video')   ){
  function pbr_create_type_video(){
    $labels = array(
      'name' => __( 'Video', "pbrthemer" ),
      'singular_name' => __( 'Video', "pbrthemer" ),
      'add_new' => __( 'Add New Video', "pbrthemer" ),
      'add_new_item' => __( 'Add New Video', "pbrthemer" ),
      'edit_item' => __( 'Edit Video', "pbrthemer" ),
      'new_item' => __( 'New Video', "pbrthemer" ),
      'view_item' => __( 'View Video', "pbrthemer" ),
      'search_items' => __( 'Search Videos', "pbrthemer" ),
      'not_found' => __( 'No Videos found', "pbrthemer" ),
      'not_found_in_trash' => __( 'No Videos found in Trash', "pbrthemer" ),
      'parent_item_colon' => __( 'Parent Video:', "pbrthemer" ),
      'menu_name' => __( 'Videos', "pbrthemer" ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'List Video',
        'supports' => array( 'title', 'editor', 'thumbnail','comments', 'excerpt' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
    register_post_type( 'video', $args );

    $labels = array(
        'name'              => __( 'Categories Video', "pbrthemer" ),
        'singular_name'     => __( 'Category', "pbrthemer" ),
        'search_items'      => __( 'Search Category', "pbrthemer" ),
        'all_items'         => __( 'All Categories', "pbrthemer" ),
        'parent_item'       => __( 'Parent Category', "pbrthemer" ),
        'parent_item_colon' => __( 'Parent Category:', "pbrthemer" ),
        'edit_item'         => __( 'Edit Category', "pbrthemer" ),
        'update_item'       => __( 'Update Category', "pbrthemer" ),
        'add_new_item'      => __( 'Add New Category', "pbrthemer" ),
        'new_item_name'     => __( 'New Category Name', "pbrthemer" ),
        'menu_name'         => __( 'Categories Video', "pbrthemer" ),
      );
      // Now register the taxonomy
      register_taxonomy('category_video',array('video'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'rewrite'           => array( 'slug' => 'video'
          ),
      ));
  }
  add_action( 'init', 'pbr_create_type_video' );
}


