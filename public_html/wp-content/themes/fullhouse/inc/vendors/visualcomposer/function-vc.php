<?php

 /**
  * Register Woocommerce Vendor which will register list of shortcodes
  */
function fullhouse_fnc_init_vc_vendors(){
	
	$vendor = new Fullhouse_VC_News();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );


	$vendor = new Fullhouse_VC_Theme();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );

	$vendor = new Fullhouse_VC_Elements();
	add_action( 'vc_after_set_mode', array(
		$vendor,
		'load'
	), 99 );

	
}
add_action( 'after_setup_theme', 'fullhouse_fnc_init_vc_vendors' , 99 );   

/**
 * Add parameters for row
 */
function fullhouse_fnc_add_params(){

 	/**
	 * add new params for row
	 */
	vc_add_param( 'vc_row', array(
	    "type" => "checkbox",
	    "heading" => esc_html__("Parallax", 'fullhouse'),
	    "param_name" => "parallax",
	    "value" => array(
	        'Yes, please' => true
	    )
	));

	$row_class =  array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Background Styles', 'fullhouse' ),
        'param_name' => 'bgstyle',
        'description'	=> esc_html__('Use Styles Supported In Theme, Select No Use For Customizing on Tab Design Options','fullhouse'),
        'value' => array(
			esc_html__( 'No Use', 'fullhouse' ) => '',
			esc_html__( 'Background Color Primary', 'fullhouse' ) => 'bg-primary',
			esc_html__( 'Background Color Info', 'fullhouse' ) 	 => 'bg-info',
			esc_html__( 'Background Color Danger', 'fullhouse' )  => 'bg-danger',
			esc_html__( 'Background Color Warning', 'fullhouse' ) => 'bg-warning',
			esc_html__( 'Background Color Success', 'fullhouse' ) => 'bg-success',
			esc_html__( 'Background Color Theme', 'fullhouse' ) 	 => 'bg-theme',
			esc_html__( 'Background Color Navy', 'fullhouse' ) 	 => 'bg-navy',
		    esc_html__( 'Background Image 1 Dark', 'fullhouse' ) => 'bg-style-v1',
			esc_html__( 'Background Image 2 Dark', 'fullhouse' ) => 'bg-style-v2',
			esc_html__( 'Background Image 3 Blue', 'fullhouse' ) => 'bg-style-v3',
			esc_html__( 'Background Image 4 Red', 'fullhouse' ) => 'bg-style-v4',
        )
    ) ;

	vc_add_param( 'vc_row', $row_class );
	vc_add_param( 'vc_row_inner', $row_class );
 

	 vc_add_param( 'vc_row', array(
	     "type" => "dropdown",
	     "heading" => esc_html__("Is Boxed", 'fullhouse'),
	     "param_name" => "isfullwidth",
	     "value" => array(
	     				esc_html__('Yes, Boxed', 'fullhouse') => '1',
	     				esc_html__('No, Wide', 'fullhouse') => '0'
	     			)
	));

	vc_add_param( 'vc_row', array(
	    "type" => "textfield",
	    "heading" => esc_html__("Icon", 'fullhouse'),
	    "param_name" => "icon",
	    "value" => '',
		'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'fullhouse' )
						. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
						. esc_html__( 'here to see the list, and use class icons-lg, icons-md, icons-sm to change its size', 'fullhouse' ) . '</a>'
	));

	/**
	 * add new params for icon
	 */

	$icon_class =  array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Color Styles', 'fullhouse' ),
        'param_name' => 'colorstyle',
        'description'	=> esc_html__('Use Styles Supported In Theme, Select No Use For Customizing on Tab Design Options','fullhouse'),
        'value' => array(
			esc_html__( 'No Use', 'fullhouse' ) => '',
			esc_html__( 'Text Color Primary', 'fullhouse' ) => 'text-primary',
			esc_html__( 'Text Color Info', 'fullhouse' ) 	 => 'text-info',
			esc_html__( 'Text Color Danger', 'fullhouse' )  => 'text-danger',
			esc_html__( 'Text Color Warning', 'fullhouse' ) => 'text-warning',
			esc_html__( 'Text Color Success', 'fullhouse' ) => 'text-success',
			esc_html__( 'Text Color White', 'fullhouse' ) => 'text-white',
        )
    ) ;

    $bgicon_class =  array(
        'type' => 'dropdown',
        'heading' => esc_html__( 'Background Styles', 'fullhouse' ),
        'param_name' => 'bgicon_style',
        'description'	=> esc_html__('Use Styles Supported In Theme, Select No Use For Customizing on Tab Design Options','fullhouse'),
        'value' => array(
			esc_html__( 'No Use', 'fullhouse' ) => '',
			esc_html__( 'Background Color Primary', 'fullhouse' ) => 'bg-primary',
			esc_html__( 'Background Color Info', 'fullhouse' ) 	 => 'bg-info',
			esc_html__( 'Background Color Danger', 'fullhouse' )  => 'bg-danger',
			esc_html__( 'Background Color Warning', 'fullhouse' ) => 'bg-warning',
			esc_html__( 'Background Color Success', 'fullhouse' ) => 'bg-success',
        )
    ) ;

	vc_add_param( 'vc_icon', $icon_class );
	vc_add_param( 'vc_icon', $bgicon_class );
	vc_remove_param('vc_icon','color');
	vc_remove_param('vc_icon','custom_color');
	vc_remove_param('vc_icon','background_color');
	vc_remove_param('vc_icon','custom_background_color');

	// add param for image elements

	 vc_add_param( 'vc_single_image', array(
	     "type" => "textarea",
	     "heading" => esc_html__("Image Description", 'fullhouse'),
	     "param_name" => "description",
	     "value" => "",
	     'priority'	
	));
}
add_action( 'after_setup_theme', 'fullhouse_fnc_add_params', 99 );
 
 /** 
  * Replace pagebuilder columns and rows class by bootstrap classes
  */
function fullhouse_wpo_change_bootstrap_class( $class_string,$tag ){
 
	if ($tag=='vc_column' || $tag=='vc_column_inner') {
		$class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);
		$class_string = preg_replace('/vc_hidden-(\w)/', 'hidden-$1', $class_string);
		$class_string = preg_replace('/vc_col-(\w)/', 'col-$1', $class_string);
		$class_string = str_replace('wpb_column', '', $class_string);
		$class_string = str_replace('column_container', '', $class_string);
	}
	return $class_string;
}

add_filter( 'vc_shortcodes_css_class', 'fullhouse_wpo_change_bootstrap_class',10,2);