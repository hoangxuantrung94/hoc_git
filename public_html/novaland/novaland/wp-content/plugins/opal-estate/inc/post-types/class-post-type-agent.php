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
class Opalestate_PostType_Agent{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes_target' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );
		

		define( 'OPALESTATE_AGENT_PREFIX', 'opalestate_agt_' );
	}

	

	/**
	 *
	 */
	public static function definition(){

		$labels = array(
			'name'                  => __( 'Agents', 'opalestate' ),
			'singular_name'         => __( 'Property', 'opalestate' ),
			'add_new'               => __( 'Add New Agent', 'opalestate' ),
			'add_new_item'          => __( 'Add New Agent', 'opalestate' ),
			'edit_item'             => __( 'Edit Agent', 'opalestate' ),
			'new_item'              => __( 'New Agent', 'opalestate' ),
			'all_items'             => __( 'All Agents', 'opalestate' ),
			'view_item'             => __( 'View Agent', 'opalestate' ),
			'search_items'          => __( 'Search Agent', 'opalestate' ),
			'not_found'             => __( 'No Agents found', 'opalestate' ),
			'not_found_in_trash'    => __( 'No Agents found in Trash', 'opalestate' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Agents', 'opalestate' ),
		);

		$labels = apply_filters( 'opalestate_postype_agent_labels' , $labels );

		register_post_type( 'opalestate_agent',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author', 'excerpt' ),
				'public'            => true,
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => _x( 'property-agent', 'URL Slug', 'opalestate' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-groups',

			)
		);


		///
		$labels = array(
	        'name'              => __( 'Agent Levels', 'opalestate' ),
	        'singular_name'     => __( 'Level', 'opalestate' ),
	        'search_items'      => __( 'Search Level', 'opalestate' ),
	        'all_items'         => __( 'All Levels', 'opalestate' ),
	        'parent_item'       => __( 'Parent Level', 'opalestate' ),
	        'parent_item_colon' => __( 'Parent Level:', 'opalestate' ),
	        'edit_item'         => __( 'Edit Level', 'opalestate' ),
	        'update_item'       => __( 'Update Level', 'opalestate' ),
	        'add_new_item'      => __( 'Add New Level', 'opalestate' ),
	        'new_item_name'     => __( 'New Level Name', 'opalestate' ),
	        'menu_name'         => __( 'Agent Levels', 'opalestate' ),
	      );
		///
		register_taxonomy('opalestate_agent_level',array('opalestate_agent'),
          array(
              'hierarchical'      => true,
              'labels'            => $labels,
              'show_ui'           => true,
              'show_admin_column' => true,
              'query_var'         => true,
              'show_in_nav_menus' =>true,
              'rewrite'           => array( 'slug' => 'agent-level'
          ),
      ));
	}

	public static function metaboxes_target(){
		$prefix = OPALESTATE_AGENT_PREFIX;
		$fields = array(
			array(
				'id'   => "{$prefix}target_min_price",
				'name' => __( 'Target Min Price', 'opalestate' ),
				'type' => 'text',
				'description'  => __( 'Enter min price of property which is for sale/rent...', 'opalestate' ),
			),

			array(
				'id'   => "{$prefix}target_max_price",
				'name' => __( 'Target Max Price', 'opalestate' ),
				'type' => 'text',
				'description'  => __( 'Enter max price of property which is for sale/rent...', 'opalestate' ),
			),

			array(
			    'name'     => __('Location' ,'opalestate'),
			    'desc'     => __('Select one, to add new you create in location of estate panel','opalestate'),
			    'id'       => $prefix."location",
			    'taxonomy' => 'opalestate_location', //Enter Taxonomy Slug
			    'type'     => 'taxonomy_select',
			) ,

			array(
			    'name'     => __('Types' ,'opalestate'),
			    'desc'     => __('Select one, to add new you create in location of estate panel','opalestate'),
			    'id'       => $prefix."type",
			    'taxonomy' => 'opalestate_types', //Enter Taxonomy Slug
			    'type'     => 'taxonomy_select',
			) ,

		); 
	    $metaboxes[ $prefix . 'target' ] = array(
			'id'                        => $prefix . 'target',
			'title'                     => __( 'Agent For Seachable', 'opalestate' ),
			'object_types'              => array( 'opalestate_agent' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    =>  $fields
		);

	    return $metaboxes;
	}
	/**
	 *
	 */
	public static function metaboxes_fields( $prefix = '' ){
		if ( ! $prefix ) {
			$prefix = OPALESTATE_AGENT_PREFIX;
		}

		$fields =  array(
			array(
				'id'   => "{$prefix}featured",
				'name' => __( 'Is Featured', 'opalestate' ),
				'type' => 'select',
				'description'  => __( 'Set this agent as featured', 'opalestate' ),
				 'options'          => array(
			        0 => __( 'No', 'opalestate' ),
			        1  => __( 'Yes', 'opalestate' )
			    ),

			),

			array(
				'id'   => "{$prefix}avatar",
				'name' => __( 'Avatar', 'opalestate' ),
				'type' => 'file',
				'description'  => __( 'Select one or more images to show as gallery', 'opalestate' ),
			),

			array(
				'name' => __( 'job', 'opalestate' ),
				'id'   => "{$prefix}job",
				'type' => 'text'
			),

			array(
				'name' => __( 'email', 'opalestate' ),
				'id'   => "{$prefix}email",
				'type' => 'text'
			),

			array(
				'name' => __( 'Phone', 'opalestate' ),
				'id'   => "{$prefix}phone",
				'type' => 'text'
			),

			array(
				'name' => __( 'Mobile', 'opalestate' ),
				'id'   => "{$prefix}mobile",
				'type' => 'text'
			),

			array(
				'name' => __( 'Fax', 'opalestate' ),
				'id'   => "{$prefix}fax",
				'type' => 'text'
			),
			array(
				'name' => __( 'Website', 'opalestate' ),
				'id'   => "{$prefix}web",
				'type' => 'text_url'
			),

			

			array(
				'name' => __( 'Twitter', 'opalestate' ),
				'id'   => "{$prefix}twitter",
				'type' => 'text_url'
			),

			array(
				'name' => __( 'Facebook', 'opalestate' ),
				'id'   => "{$prefix}facebook",
				'type' => 'text_url'
			),

			array(
				'name' => __( 'Google', 'opalestate' ),
				'id'   => "{$prefix}google",
				'type' => 'text_url'
			),

			array(
				'name' => __( 'LinkedIn', 'opalestate' ),
				'id'   => "{$prefix}linkedin",
				'type' => 'text_url'
			),

			array(
				'name' => __( 'Pinterest', 'opalestate' ),
				'id'   => "{$prefix}pinterest",
				'type' => 'text_url'
			),
			array(
				'name' => __( 'Instagram', 'opalestate' ),
				'id'   => "{$prefix}instagram",
				'type' => 'text_url'
			),


			array(
				'name' => __( 'Address', 'opalestate' ),
				'id'   => "{$prefix}address",
				'type' => 'text'
			),
			
			array(
				'id'            => "{$prefix}map",
				'name'          => __( 'Map Location', 'opalestate' ),
				'type'              => 'opal_map',
				'sanitization_cb'   => 'opal_map_sanitise',
                'split_values'      => true,
			),
		);
	
		return apply_filters( 'opalestate_postype_agent_metaboxes_fields' , $fields );
	}

	/**
	 *
	 */
	public static function metaboxes(array $metaboxes){
		$prefix = OPALESTATE_AGENT_PREFIX;

	    $metaboxes[ $prefix . 'info' ] = array(
			'id'                        => $prefix . 'info',
			'title'                     => __( 'Agent Information', 'opalestate' ),
			'object_types'              => array( 'opalestate_agent' ),
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => self::metaboxes_fields( $prefix )
		);

	    return $metaboxes;
	}
}

Opalestate_PostType_Agent::init();