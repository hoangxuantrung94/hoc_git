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


if( class_exists("WPBakeryVisualComposerAbstract") ){
    function opalestate_vc_get_term_object( $term ) {
		$vc_taxonomies_types = vc_taxonomies_types();

		return array(
			'label' => $term->name,
			'value' => $term->slug,
			'group_id' => $term->taxonomy,
			'group' => isset( $vc_taxonomies_types[ $term->taxonomy ], $vc_taxonomies_types[ $term->taxonomy ]->labels, $vc_taxonomies_types[ $term->taxonomy ]->labels->name ) ? $vc_taxonomies_types[ $term->taxonomy ]->labels->name : esc_html__( 'Taxonomies', 'mode' ),
		);
	}

	function opalestate_category_field_search( $search_string ) {
		$data = array();
		$vc_taxonomies_types = array('property_category');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opalestate_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}

	function opalestate_category_render($query) {
		$category = get_term_by('slug', $query['value'], 'property_category');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	function opalestate_location_field_search( $search_string ) {

		$data = array();
		$vc_taxonomies_types = array('opalestate_location');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );

		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opalestate_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}

	function opalestate_location_render($query) {
		$category = get_term_by('slug', $query['value'], 'opalestate_location');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	function opalestate_types_field_search( $search_string ) {
		$data = array();
		$vc_taxonomies_types = array('opalestate_types');
		$vc_taxonomies = get_terms( $vc_taxonomies_types, array(
			'hide_empty' => false,
			'search' => $search_string
		) );
		if ( is_array( $vc_taxonomies ) && ! empty( $vc_taxonomies ) ) {
			foreach ( $vc_taxonomies as $t ) {
				if ( is_object( $t ) ) {
					$data[] = opalestate_vc_get_term_object( $t );
				}
			}
		}

		return $data;
	}

	function opalestate_types_render($query) {
		$category = get_term_by('slug', $query['value'], 'opalestate_types');
		if ( ! empty( $query ) && !empty($category)) {
			$data = array();
			$data['value'] = $category->slug;
			$data['label'] = $category->name;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	$shortcodes = array( 'pbr_estate_filter_property' );

	foreach( $shortcodes as $shortcode ){

		add_filter( 'vc_autocomplete_'.$shortcode .'_property_category_callback', 'opalestate_category_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_property_category_render', 'opalestate_category_render', 10, 1 );

	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opalestate_location_callback', 'opalestate_location_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opalestate_location_render', 'opalestate_location_render', 10, 1 );

	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opalestate_types_callback', 'opalestate_types_field_search', 10, 1 );
	 	add_filter( 'vc_autocomplete_'.$shortcode .'_opalestate_types_render', 'opalestate_types_render', 10, 1 );
	}



	function opalestate_property_slugs_field_search( $search_string ){
		$data = array();

		$args = array(
            'post_type' 	 => 'opalestate_property',
            'post_status' 	 => 'publish',
            's'		=> $search_string
        );

		$posts = get_posts( $args );
		if ( is_array( $posts ) && ! empty( $posts ) ) {
			foreach ( $posts as $_post ) {
				$t = array(
					'label' => $_post->post_title,
					'value' => $_post->post_name
				);
				$data[] = $t;
			}
		}
		wp_reset_query();
		return $data;
	}

	function opalestate_property_slugs_render( $query ){

		$_post = get_page_by_path( $query['value'],OBJECT,'opalestate_property' );
 
		if ( ! empty( $query ) && !empty($_post)) {
			$data = array();
			$data['value'] = $_post->post_name;
			$data['label'] = $_post->post_title;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}

	add_filter( 'vc_autocomplete_pbr_estate_manual_carousel_properties_property_slugs_callback', 'opalestate_property_slugs_field_search', 10, 1 );
	add_filter( 'vc_autocomplete_pbr_estate_manual_carousel_properties_property_slugs_render', 'opalestate_property_slugs_render', 10, 1 );


	// search agents
    vc_map( array(
           
           "name" => __("Search Property Box ", "opalestate"),
           "base" => "pbr_estate_searchbox",
           "class" => "",
           "description" => 'Display form to search properties',
           "category" => __('OpalEstate', "opalestate"),
           "params" => array(
        	array(
	            
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	            "admin_label" => true
	       	),
        )
    ));
    // search agents
    vc_map( array(
           
           "name" => __("Search Agents Box ", "opalestate"),
           "base" => "pbr_estate_search_agents",
           "class" => "",
           "description" => 'Display form to search agents',
           "category" => __('OpalEstate', "opalestate"),
           "params" => array(
        	array(
	            
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	            "admin_label" => true
	       	),

	       	array(
	            
	            "type" => "textarea_html",
	            "heading" => __("Description", "opalestate"),
	            "param_name" => "description",

	            "admin_label" => false
	       	),
        )
    ));

    vc_map( array(
          "name" 		=> __("Featured Property", "opalestate"),
          "base" 		=> "pbr_featured_property",
          "class" 		=> "",
          "description" => 'Get data from post type Team',
          "category" 	=> __('OpalEstate', "opalestate"),
          "params" => array(
        	array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	        ),
	        array(
			    'type' => 'colorpicker',
			    'heading' => esc_html__( 'Title Color', 'opalestate' ),
			    'param_name' => 'title_color',
			    'description' => esc_html__( 'Select font color', 'opalestate' )
			),
	         array(
	            "type" => "textfield",
	            "heading" => __("Description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	        ),


	        array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),
          )
      ));

	 vc_map( array(
          "name" => __("Carousel Property", "opalestate"),
          "base" => "pbr_estate_carousel_property",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),

	        array(
				"type" => "dropdown",
				"heading" => esc_html__("Enable Thumbnail", 'opalestate'),
				"param_name" => "enable_thumbnail",
				'value' 	=> array(
					esc_html__('Disable', 'opalestate') => 0,
					esc_html__('Enable', 'opalestate') => 1,
				),
				'std' => 0
			),
          )
      ));
	 vc_map( array(
          "name" => __("Manual Carousel Properties", "opalestate"),
          "base" => "pbr_estate_manual_carousel_properties",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
		        array(
		            "type" => "textfield",
		            "heading" => __("Title", "opalestate"),
		            "param_name" => "title",
		            "value" => '',
		              "admin_label" => true
		        ),
	          	
	          	array(
		            'type' => 'autocomplete',
		            "heading" => __("Properties", "opalestate"),
		            'param_name' => 'property_slugs',
		            "value" => '',
		              'settings' => array(
				     	'multiple' => true,
				     	'unique_values' => true,
					     // In UI show results except selected. NB! You should manually check values in backend
					    ),

		        ),
		          array(
		            "type" => "textfield",
		            "heading" => __("Column", "opalestate"),
		            "param_name" => "column",
		            "value" => 1,
		            'description' =>  ''
		          ),
		         array(
		            "type" => "textfield",
		            "heading" => __("Limit", "opalestate"),
		            "param_name" => "limit",
		            "value" => 6,
		            'description' =>  __('Limit featured properties showing', 'opalestate')
		        ),
          )
      ));

      vc_map( array(
          "name" => __("Grid Property", "opalestate"),
          "base" => "pbr_estate_grid_property",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opalestate"),
	            "param_name" => "showsortby"
	        ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opalestate"),
	            "param_name" => "description"
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opalestate"),
	            "param_name" => "pagination"
	        ),
          )
      ));


      vc_map( array(
          "name" => __("Filter Property", "opalestate"),
          "base" => "pbr_estate_filter_property",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	        array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Categories', 'opalestate' ),
			    'value' => '',
			    'param_name' => 'property_category',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Categories', 'opalestate' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
		   	array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Locations', 'opalestate' ),
			    'value' => '',
			    'param_name' => 'opalestate_location',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Locations', 'opalestate' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
		   	array(
			    'type' => 'autocomplete',
			    'heading' => esc_html__( 'Types', 'opalestate' ),
			    'value' => '',
			    'param_name' => 'opalestate_types',
			    "admin_label" => true,
			    'description' => esc_html__( 'Select Types', 'opalestate' ),
			    'settings' => array(
			     	'multiple' => true,
			     	'unique_values' => true,
			     // In UI show results except selected. NB! You should manually check values in backend
			    ),
		   	),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opalestate"),
	            "param_name" => "showsortby"
	        ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),

	         array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opalestate"),
	            "param_name" => "description"
	        ),
	         array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opalestate"),
	            "param_name" => "pagination"
	        ),
          )
      ));

      vc_map( array(
          "name" => __("List Property", "opalestate"),
          "base" => "pbr_estate_list_property",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Sort By", "opalestate"),
	            "param_name" => "showsortby"
	        ),
	           array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit per page", "opalestate"),
	            "param_name" => "limit",
	            "value" => 10,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Don't show Description", "opalestate"),
	            "param_name" => "description"
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opalestate"),
	            "param_name" => "pagination"
	        ),
          )
      ));


      vc_map( array(
          "name" => __("Grid Agent", "opalestate"),
          "base" => "pbr_estate_grid_agent",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured agents showing', 'opalestate')
	          ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Featured Only", "opalestate"),
	            "param_name" => "onlyfeatured"
	          ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opalestate"),
	            "param_name" => "pagination"
	          ),
          )
      ));

      vc_map( array(
          "name" => __("List Agent", "opalestate"),
          "base" => "pbr_estate_list_agent",
          "class" => "",
          "description" => 'Get data from post type Team',
          "category" => __('OpalEstate', "opalestate"),
          "params" => array(
	            array(
	            "type" => "textfield",
	            "heading" => __("Title", "opalestate"),
	            "param_name" => "title",
	            "value" => '',
	              "admin_label" => true
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("description", "opalestate"),
	            "param_name" => "description",
	            "value" => '',
	            'description' =>  ''
	         ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Column", "opalestate"),
	            "param_name" => "column",
	            "value" => '4',
	            'description' =>  ''
	          ),
	          array(
	            "type" => "textfield",
	            "heading" => __("Limit", "opalestate"),
	            "param_name" => "limit",
	            "value" => 6,
	            'description' =>  __('Limit featured properties showing', 'opalestate')
	        ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Show Featured Only", "opalestate"),
	            "param_name" => "onlyfeatured"
	          ),
	          array(
	            "type" => "checkbox",
	            "heading" => __("Pagination", "opalestate"),
	            "param_name" => "pagination"
	        ),
          )
      ));
		

	class OpalEstate_Shortcode_Base extends WPBakeryShortCode {
		public function __construct(  $settings ){
			parent::__construct($settings);
			if( !file_exists(get_template_directory().'/vc_templates/'.$this->settings['base']) ){
				$this->html_template = OPALESTATE_PLUGIN_DIR.'templates/vc_templates/'.$this->settings['base'].'.php';
			}
		}
	}
	class WPBakeryShortCode_Pbr_featured_property  extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_Pbr_estate_searchbox   extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_Pbr_estate_search_agents  extends OpalEstate_Shortcode_Base {}


	class WPBakeryShortCode_pbr_estate_grid_property  extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_pbr_estate_list_property  extends OpalEstate_Shortcode_Base {
	}
	class WPBakeryShortCode_pbr_estate_filter_property  extends OpalEstate_Shortcode_Base {}

	class WPBakeryShortCode_pbr_estate_grid_agent  extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_pbr_estate_list_agent  extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_pbr_estate_carousel_property  extends OpalEstate_Shortcode_Base {}
	class WPBakeryShortCode_pbr_estate_manual_carousel_properties  extends OpalEstate_Shortcode_Base {}
  }