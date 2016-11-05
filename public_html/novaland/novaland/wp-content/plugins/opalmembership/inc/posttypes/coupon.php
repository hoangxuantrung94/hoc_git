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

class Opalmembership_PostType_Coupon{

	/**
	 *
	 */
	public static function init(){
		
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );

		add_filter( 'enter_title_here', array( __CLASS__, 'change_enter_title_here' ), 1,3  );

		define( 'OPALMEMBERSHIP_COUPON_PREFIX', 'opalmembership_coupon_' );
	}

	/**
	 *
	 */
	public static function definition(){

		$labels = array(
			'name'                  => __( 'Opal Coupons', 'opalmembership' ),
			'singular_name'         => __( 'Membership', 'opalmembership' ),
			'add_new'               => __( 'Add New Coupon', 'opalmembership' ),
			'add_new_item'          => __( 'Add New Coupon', 'opalmembership' ),
			'edit_item'             => __( 'Edit Coupon', 'opalmembership' ),
			'new_item'              => __( 'New Coupon', 'opalmembership' ),
			'all_items'             => __( 'All Coupons', 'opalmembership' ),
			'view_item'             => __( 'View Coupon', 'opalmembership' ),
			'search_items'          => __( 'Search Coupon', 'opalmembership' ),
			'not_found'             => __( 'No Coupons found', 'opalmembership' ),
			'not_found_in_trash'    => __( 'No Coupons found in Trash', 'opalmembership' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Coupons', 'opalmembership' ),
		);

		$labels = apply_filters( 'opalmembership_postype_coupons_labels' , $labels );

		register_post_type( 'membership_coupons',
			array(
				'labels'            => $labels,
				'supports'            => array( 'title'  ),
				'public'              => false,
				'show_ui'             => true,
				'map_meta_cap'        => true,
				'publicly_queryable'  => false,
				'exclude_from_search' => true,

				'show_in_menu'	  => 'opalmembership',
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => 'membership-coupon' ),
				'menu_position'     => 90,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',
				'hierarchical'        => false,
				'show_in_nav_menus'   => false,
				'rewrite'             => false,
				'query_var'           => false,
			)
		);
	}
	public static function change_enter_title_here( $title ){
	     $screen = get_current_screen();

	     if  ( 'membership_coupons' == $screen->post_type ) {
	          $title = __( 'Enter your coupon code' );
	     }

	     return $title;
	}


	/**
	 *
	 */
	public static function metaboxes_fields(){


		$prefix = OPALMEMBERSHIP_COUPON_PREFIX;

		$packages = opalmembership_get_packages_list();


		$fields =  array(
		  // COLOR
			array(
				'name' 			=> __( 'Discount Type', 'opalmembership' ),
				'id'   			=> "{$prefix}type",
				'type' 			=> 'select',
				'options' 		=> array('percenatage' => __('Percenatage','opalmembership'), 'fixed' => __('Fixed Amount','opalmembership') ),
				'description' => __('Select discount type','opalmembership')
			),

			array(
				'name' 			=> __( 'Discount Value', 'opalmembership' ),
				'id'   			=> "{$prefix}value",
				'type' 			=> 'text',
				'description' 	=> __('Enter discount value','opalmembership'),
				'default'		=> 0,
				'attributes'	=> array(
						'type' 		=> 'number',
						'pattern' 	=> '\d*',
						'min'		=> 0
					)
			),

			array(
				'name' 			=> __( 'Start Date', 'opalmembership' ),
				'id'   			=> "{$prefix}start_date",
				'type' 			=> 'text_date',
				'date_format'	=> get_option( 'date_format' ),
				'description' 	=> __('Enter Start Date','opalmembership')
			),

			array(
				'name' 			=> __( 'Expired Date', 'opalmembership' ),
				'id'   			=> "{$prefix}expired_date",
				'type' 			=> 'text_date',
				'date_format'	=> get_option( 'date_format' ),
				'description' 	=> __('Enter End Date','opalmembership')
			),

			array(
				'name' 			=> __( 'Usage Limit', 'opalmembership' ),
				'id'   			=> "{$prefix}usage_limit",
				'type' 			=> 'text',
				'attributes' 	=> array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'description' => __('Enter usage limit time','opalmembership')
			),

			array(
				'name' => __( 'Discount For', 'opalmembership' ),
				'id'   => "{$prefix}applyfor",
				'type' => 'select',
				'options' => $packages,
				'description' => __('Select Package use this coupon.','opalmembership')
			),

		);

		return apply_filters( 'opalmembership_postype_agent_metaboxes_fields' , $fields );
	}
	/**
	 *
	 */
	public static function metaboxes( $metaboxes ){
		   // 1st meta box
	    $metaboxes[] = array(
	        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
	        'id'         => 'standard-coupons',
	        // Meta box title - Will appear at the drag and drop handle bar. Required.
	        'title'      => __( 'Coupon Information', 'opalmembership' ),
	        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
	        'object_types' => array( 'membership_coupons' ),
	        // Where the meta box appear: normal (default), advanced, side. Optional.
	        'context'    => 'normal',
	        // Order of meta box: high (default), low. Optional.
	        'priority'   => 'low',
	        // Auto save: true, false (default). Optional.
	        'autosave'   => true,
	        // List of meta fields
	        'fields'     =>  self::metaboxes_fields()
	    );

	    return $metaboxes;
	}
}

Opalmembership_PostType_Coupon::init();