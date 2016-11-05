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

class Opalmembership_PostType_Packages{

	/**
	 *
	 */
	public static function init(){
		add_action( 'init', array( __CLASS__, 'definition' ) );
		add_filter( 'cmb2_meta_boxes', array( __CLASS__, 'metaboxes' ) );

		if ( ! defined( 'OPALMEMBERSHIP_PACKAGES_PREFIX' ) ) {
			define( 'OPALMEMBERSHIP_PACKAGES_PREFIX', 'opalmembership_pgk_' );
		}
	}

	/**
	 *
	 */
	public static function definition(){

		$labels = array(
			'name'                  => __( 'Opal Packages', 'opalmembership' ),
			'singular_name'         => __( 'Package', 'opalmembership' ),
			'add_new'               => __( 'Add New Package', 'opalmembership' ),
			'add_new_item'          => __( 'Add New Package', 'opalmembership' ),
			'edit_item'             => __( 'Edit Package', 'opalmembership' ),
			'new_item'              => __( 'New Package', 'opalmembership' ),
			'all_items'             => __( 'All Packages', 'opalmembership' ),
			'view_item'             => __( 'View Packages', 'opalmembership' ),
			'search_items'          => __( 'Search Package', 'opalmembership' ),
			'not_found'             => __( 'No Packages found', 'opalmembership' ),
			'not_found_in_trash'    => __( 'No Packages found in Trash', 'opalmembership' ),
			'parent_item_colon'     => '',
			'menu_name'             => __( 'Opal Packages', 'opalmembership' ),
		);

		$labels = apply_filters( 'opalmembership_postype_packages_labels' , $labels );

		register_post_type( 'membership_packages',
			array(
				'labels'            => $labels,
				'supports'          => array( 'title', 'editor', 'thumbnail'  ),
				'public'            => true,
		 		'show_in_menu'	  => 'opalmembership',
				'has_archive'       => true,
				'rewrite'           => array( 'slug' => __( 'membership-packages', 'opalmembership' ) ),
				'menu_position'     => 51,
				'categories'        => array(),
				'menu_icon'         => 'dashicons-admin-home',

			)
		);
	}

	/**
	 *
	 */
	public static function metaboxes_fields(){
		$prefix = OPALMEMBERSHIP_PACKAGES_PREFIX;

		$fields =  array(
			array(
				'name'              => __( 'Highlighted','opalmembership' ),
				'id'                => $prefix . 'hightlighted',
				 'type'    => 'radio_inline',
			    'options' => array(
			        0 => __( 'No', 'opalmembership' ),
			        1   => __( 'Yes', 'opalmembership' ),
			    ),
			),
			array(
				'name' => __( 'Price', 'opalmembership' ),
				'id'   => "{$prefix}price",
				'type' => 'text',
				'description' => sprintf( __( 'Enter Price Package (%s)', 'opalmembership' ), opalmembership_currency_symbol() )
			),

			array(
				'name' => __( 'Saleprice', 'opalmembership' ),
				'id'   => "{$prefix}saleprice",
				'type' => 'text',
				'description' => sprintf( __( 'Enter Sale Price (%s)', 'opalmembership' ), opalmembership_currency_symbol() )
			),

			array(
				'name' => __( 'Recurring', 'opalmembership' ),
				'id'   => "{$prefix}recurring",
				'type' => 'checkbox',
				'description' => __('Do you want enable recurring?','opalmembership')
			),

			array(
				'name' => __( 'Enable Expired Date ', 'opalmembership' ),
				'id'   => "{$prefix}enable_expired",
				'type' => 'checkbox',
				'description' => __('Do you want enable expired date?','opalmembership')
			),

			array(
				'name' => __( 'Expired Date In', 'opalmembership' ),
				'id'   => "{$prefix}duration",
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => __('Enter expired number. Example 1, 2, 3','opalmembership')
			),

			array(
				'name' => __( 'Expired Date Type', 'opalmembership' ),
				'id'   => "{$prefix}duration_unit",
				'type' => 'select',
				'options' => opalmembership_package_expiry_labels(),
				'description' => __( 'Enter expired date type. Example Day(s), Week(s), Month(s), Year(s)', 'opalmembership' )
			),
		);

		return apply_filters( 'opalmembership_postype_membership_metaboxes_fields', $fields, $prefix );
	}

	/**
	 *
	 */
	public static function metaboxes( $metaboxes ){
		   // 1st meta box
	    $metaboxes[] = array(
	        // Meta box id, UNIQUE per meta box. Optional since 4.1.5
	        'id'         => 'opalmembership-standard',
	        // Meta box title - Will appear at the drag and drop handle bar. Required.
	        'title'      => __( 'Package Information', 'opalmembership' ),
	        // Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
	        'object_types' => array( 'membership_packages' ),
	        // Where the meta box appear: normal (default), advanced, side. Optional.
	        'context'    => 'normal',
	        // Order of meta box: high (default), low. Optional.
	        'priority'   => 'low',
	        // Auto save: true, false (default). Optional.
	        'autosave'   => true,
	        // List of meta fields
	        'show_names'                => true,
	        'fields'     =>  self::metaboxes_fields()
	    );
	 	//  echo '<Pre>'.print_r( $metaboxes ,1 ); die ;
	    return $metaboxes;
	}
}

Opalmembership_PostType_Packages::init();