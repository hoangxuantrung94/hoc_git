<?php
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalestate
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
class Opalestate_Taxonomy_Type{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opalestate_taxomony_types_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Types', 'opalestate' ),
			'singular_name'     => __( 'Properties By Type', 'opalestate' ),
			'search_items'      => __( 'Search Types', 'opalestate' ),
			'all_items'         => __( 'All Types', 'opalestate' ),
			'parent_item'       => __( 'Parent Type', 'opalestate' ),
			'parent_item_colon' => __( 'Parent Type:', 'opalestate' ),
			'edit_item'         => __( 'Edit Type', 'opalestate' ),
			'update_item'       => __( 'Update Type', 'opalestate' ),
			'add_new_item'      => __( 'Add New Type', 'opalestate' ),
			'new_item_name'     => __( 'New Type', 'opalestate' ),
			'menu_name'         => __( 'Types', 'opalestate' ),
		);

		register_taxonomy( 'opalestate_types',  array( 'opalestate_property' ) , array(
			'labels'            => apply_filters( 'opalestate_taxomony_types_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'property-type',
			'rewrite'           => array( 'slug' => __( 'property-type', 'opalestate' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes(){

	}

	public static function dropdownList( $selected=0 ){

		$id = "opalestate_types".rand();
		
		$args = array( 
				'show_option_none' => __( 'Select Types', 'opalestate' ),
				'id' => $id,
				'class' => 'form-control',
				'show_count' => 0,
				'hierarchical'	=> '',
				'name'	=> 'types',
				'selected'	=> $selected,
				'value_field'	=> 'slug',
				'taxonomy'	=> 'opalestate_types'
		);		

		 
		return wp_dropdown_categories( $args );
	}

}

Opalestate_Taxonomy_Type::init();