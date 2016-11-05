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
class Opalestate_Taxonomy_Location{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'opalestate_taxomony_location_metaboxes', array( __CLASS__, 'metaboxes' ) );
	}

	/**
	 *
	 */
	public static function definition(){
		
		$labels = array(
			'name'              => __( 'Locations', 'opalestate' ),
			'singular_name'     => __( 'Properties By Location', 'opalestate' ),
			'search_items'      => __( 'Search Locations', 'opalestate' ),
			'all_items'         => __( 'All Locations', 'opalestate' ),
			'parent_item'       => __( 'Parent Location', 'opalestate' ),
			'parent_item_colon' => __( 'Parent Location:', 'opalestate' ),
			'edit_item'         => __( 'Edit Location', 'opalestate' ),
			'update_item'       => __( 'Update Location', 'opalestate' ),
			'add_new_item'      => __( 'Add New Location', 'opalestate' ),
			'new_item_name'     => __( 'New Location', 'opalestate' ),
			'menu_name'         => __( 'Locations', 'opalestate' ),
		);

		register_taxonomy( 'opalestate_location', 'opalestate_property', array(
			'labels'            => apply_filters( 'opalestate_taxomony_location_labels', $labels ),
			'hierarchical'      => true,
			'query_var'         => 'property-location',
			'rewrite'           => array( 'slug' => __( 'property-location', 'opalestate' ) ),
			'public'            => true,
			'show_ui'           => true,
		) );
	}


	public static function metaboxes(){

	}


	public static function getList(){
		 return get_terms('opalestate_location', array('hide_empty'=> false));
	}
	
	public static function dropdownAgentsList( $selected=0  ){
		$id = "opalestate_location".rand();
		$args = array( 
				'show_option_none' => __( 'Select Location', 'opalestate' ),
				'id' => $id,
				'class' => 'form-control',
				'name'	=> 'location',
				'show_count' => 0,
				'hierarchical'	=> '',
				'selected'	=> $selected,
				'value_field'	=> 'slug',
				'taxonomy'	=> 'opalestate_agent_location'
		);		

		return wp_dropdown_categories( $args );
	}

	public static function dropdownList( $selected=0 ){
		$id = "opalestate_location".rand();
		$args = array( 
				'show_option_none' => __( 'Select Location', 'opalestate' ),
				'id' => $id,
				'class' => 'form-control',
				'name'	=> 'location',
				'show_count' => 0,
				'hierarchical'	=> '',
				'selected'	=> $selected,
				'value_field'	=> 'slug',
				'taxonomy'	=> 'opalestate_location'
		);		

		return wp_dropdown_categories( $args );
	}
}

Opalestate_Taxonomy_Location::init();