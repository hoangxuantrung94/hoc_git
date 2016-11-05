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
if(!function_exists('pbr_create_type_gallery')   ){
    function pbr_create_type_gallery(){
      $labels = array(
          'name'               => __( 'Gallerys', "pbrthemer" ),
          'singular_name'      => __( 'Gallery', "pbrthemer" ),
          'add_new'            => __( 'Add New Gallery', "pbrthemer" ),
          'add_new_item'       => __( 'Add New Gallery', "pbrthemer" ),
          'edit_item'          => __( 'Edit Gallery', "pbrthemer" ),
          'new_item'           => __( 'New Gallery', "pbrthemer" ),
          'view_item'          => __( 'View Gallery', "pbrthemer" ),
          'search_items'       => __( 'Search Gallerys', "pbrthemer" ),
          'not_found'          => __( 'No Gallerys found', "pbrthemer" ),
          'not_found_in_trash' => __( 'No Gallerys found in Trash', "pbrthemer" ),
          'parent_item_colon'  => __( 'Parent Gallery:', "pbrthemer" ),
          'menu_name'          => __( 'Gallerys', "pbrthemer" ),
      );

      $args = array(
          'labels'              => $labels,
          'hierarchical'        => false,
          'description'         => 'List Gallery',
          'supports'            => array( 'title', 'editor', 'author', 'thumbnail','excerpt','custom-fields' ), //page-attributes, post-formats
          'taxonomies'          => array( 'gallery_category','skills','post_tag' ),
          'public'              => true,
          'show_ui'             => true,
          'show_in_menu'        => true,
          'menu_position'       => 5,
          'menu_icon'           => '',
          'show_in_nav_menus'   => false,
          'publicly_queryable'  => true,
          'exclude_from_search' => false,
          'has_archive'         => true,
          'query_var'           => true,
          'can_export'          => true,
          'rewrite'             => array('slug'=>'gallery'),
          'capability_type'     => 'post',
      );
      register_post_type( 'gallery', $args );

      //Add Port folio Skill
      // Add new taxonomy, make it hierarchical like categories
      //first do the translations part for GUI
      $labels = array(
        'name'              => __( 'Categories', "pbrthemer" ),
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
      register_taxonomy('gallery_category',array('gallery'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' => false,
              'rewrite'           => array( 'slug' => 'gallery-category'
          ),
      ));



      

  }
  add_action( 'init','pbr_create_type_gallery' );
}