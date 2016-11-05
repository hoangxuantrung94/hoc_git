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
class Opalestate_Taxonomy_Status{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opalestate_taxomony_status_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Status', 'opalestate' ),
			'singular_name'     => __( 'Properties By Status', 'opalestate' ),
			'search_items'      => __( 'Search Status', 'opalestate' ),
			'all_items'         => __( 'All Status', 'opalestate' ),
			'parent_item'       => __( 'Parent Status', 'opalestate' ),
			'parent_item_colon' => __( 'Parent Status:', 'opalestate' ),
			'edit_item'         => __( 'Edit Status', 'opalestate' ),
			'update_item'       => __( 'Update Status', 'opalestate' ),
			'add_new_item'      => __( 'Add New Status', 'opalestate' ),
			'new_item_name'     => __( 'New Status', 'opalestate' ),
			'menu_name'         => __( 'Status', 'opalestate' ),
		);

		register_taxonomy( 'opalestate_status', 'opalestate_property'  , array(
			'labels'            => apply_filters( 'opalestate_status_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'property-status',
			'rewrite'           => array( 'slug' => __( 'property-status', 'opalestate' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}

	public static function metaboxes(){

	}

	public static function getList(){
		 return get_terms('opalestate_status', array('hide_empty'=> false));
	}

	public static function dropdownList( $selected=0){

		$id = "opalestate_status".rand();
		
		$args = array( 
				'show_option_none' => __( 'Select Status', 'opalestate' ),
				'id' => $id,
				'class' => 'form-control',
				'show_count' => 0,
				'hierarchical'	=> '',
				'name'	=> 'status',
				'value_field'	=> 'slug',
				'selected'	=> $selected,
				'taxonomy'	=> 'opalestate_status'
		);		

		return wp_dropdown_categories( $args );
	}
}

Opalestate_Taxonomy_Status::init();