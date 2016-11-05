<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalmembership
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class OpalMembership_Taxonomy_Package_Category{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
	//	add_filter( 'opalmembership_taxomony_types_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){

		$labels = array(
			'name'              => __( 'Categories', 'opalmembership' ),
			'singular_name'     => __( 'Category', 'opalmembership' ),
			'search_items'      => __( 'Search Categories', 'opalmembership' ),
			'all_items'         => __( 'All Categories', 'opalmembership' ),
			'parent_item'       => __( 'Parent Category', 'opalmembership' ),
			'parent_item_colon' => __( 'Parent Category:', 'opalmembership' ),
			'edit_item'         => __( 'Edit Category', 'opalmembership' ),
			'update_item'       => __( 'Update Category', 'opalmembership' ),
			'add_new_item'      => __( 'Add New Category', 'opalmembership' ),
			'new_item_name'     => __( 'New Category', 'opalmembership' ),
			'menu_name'         => __( 'Categories', 'opalmembership' ),
		);

		register_taxonomy( 'membership_category', 'membership_packages', array(
			'labels'            => apply_filters( 'membership_category_label', $labels ),
			'hierarchical'      => true,
			  'show_in_menu'  => true,
			'query_var'         => 'membership-category',
			'rewrite'           => array( 'slug' => 'membership-category' ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes( $metaboxes ){

		return $metaboxes;
	}

}

OpalMembership_Taxonomy_Package_Category::init();