<?php 

class Fullhouse_VC_Theme implements Vc_Vendor_Interface {

	public function load(){
		/*********************************************************************************************************************
		 *  Vertical menu
		 *********************************************************************************************************************/
		$option_menu  = array(); 
		if( is_admin() ){
			$menus = wp_get_nav_menus( array( 'orderby' => 'name' ) );
		    $option_menu = array('---Select Menu---'=>'');
		    foreach ($menus as $menu) {
		    	$option_menu[$menu->name]=$menu->term_id;
		    }
		}    
		vc_map( array(
		    "name" => esc_html__("PBR Quick Links Menu",'fullhouse'),
		    "base" => "pbr_quicklinksmenu",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    'description'	=> esc_html__( 'Show Quick Links To Access', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => 'Quick To Go'
				),
		    	array(
					"type" => "dropdown",
					"heading" => esc_html__("Menu", 'fullhouse'),
					"param_name" => "menu",
					"value" => $option_menu,
					"description" => esc_html__("Select menu.", 'fullhouse')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)
		   	)
		));
		 
		

		/*********************************************************************************************************************
		 *  Vertical menu
		 *********************************************************************************************************************/
	 
		vc_map( array(
		    "name" => esc_html__("PBR Vertical MegaMenu",'fullhouse'),
		    "base" => "pbr_verticalmenu",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(

		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => 'Vertical Menu',
					"admin_label"	=> true
				),

		    	array(
					"type" => "dropdown",
					"heading" => esc_html__("Menu", 'fullhouse'),
					"param_name" => "menu",
					"value" => $option_menu,
					"description" => esc_html__("Select menu.", 'fullhouse')
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Position", 'fullhouse'),
					"param_name" => "postion",
					"value" => array(
							'left'=>'left',
							'right'=>'right'
						),
					'std' => 'left',
					"description" => esc_html__("Postion Menu Vertical.", 'fullhouse')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)
		   	)
		));
		 
		vc_map( array(
		    "name" => esc_html__("Fixed Show Vertical Menu ",'fullhouse'),
		    "base" => "pbr_verticalmenu_show",
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "description" => esc_html__( 'Always showing vertical menu on top', 'fullhouse' ),
		    "params" => array(
		  
				array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"description" => esc_html__("When enabled vertical megamenu widget on main navition and its menu content will be showed by this module. This module will work with header:Martket, Market-V2, Market-V3" , 'fullhouse')
				)
		   	)
		));
	 

		/******************************
		 * Our Team
		 ******************************/
		vc_map( array(
		    "name" => esc_html__("PBR Our Team Grid Style",'fullhouse'),
		    "base" => "pbr_team",
		    "class" => "",
		    "description" => 'Show Personal Profile Info',
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => '',
						"admin_label" => true
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Photo", 'fullhouse'),
					"param_name" => "photo",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Job", 'fullhouse'),
					"param_name" => "job",
					"value" => 'CEO',
					'description'	=>  ''
				),

				array(
					"type" => "textarea",
					"heading" => esc_html__("information", 'fullhouse'),
					"param_name" => "information",
					"value" => '',
					'description'	=> esc_html__('Allow  put html tags', 'fullhouse')
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Phone", 'fullhouse'),
					"param_name" => "phone",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Google Plus", 'fullhouse'),
					"param_name" => "google",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Facebook", 'fullhouse'),
					"param_name" => "facebook",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Twitter", 'fullhouse'),
					"param_name" => "twitter",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Pinterest", 'fullhouse'),
					"param_name" => "pinterest",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Linked In", 'fullhouse'),
					"param_name" => "linkedin",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'fullhouse'),
					"param_name" => "style",
					'value' 	=> array( 'circle' => esc_html__('circle', 'fullhouse'), 'vertical' => esc_html__('vertical', 'fullhouse') , 'horizontal' => esc_html__('horizontal', 'fullhouse') ),
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)
		   	)
		));
	 
		/******************************
		 * Our Team
		 ******************************/
		vc_map( array(
			"name" => esc_html__("PBR Our Team List Style",'fullhouse'),
			"base" => "pbr_team_list",
			"class" => "",
			"description" => esc_html__('Show Info In List Style', 'fullhouse'),
			"category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => '',
						"admin_label" => true
				),
				array(
					"type" => "attach_image",
					"heading" => esc_html__("Photo", 'fullhouse'),
					"param_name" => "photo",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Phone", 'fullhouse'),
					"param_name" => "phone",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Job", 'fullhouse'),
					"param_name" => "job",
					"value" => 'CEO',
					'description'	=>  ''
				),
				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Information", 'fullhouse'),
					"param_name" => "content",
					"value" => '',
					'description'	=> esc_html__('Allow  put html tags', 'fullhouse')
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Blockquote", 'fullhouse'),
					"param_name" => "blockquote",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Email", 'fullhouse'),
					"param_name" => "email",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Facebook", 'fullhouse'),
					"param_name" => "facebook",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Twitter", 'fullhouse'),
					"param_name" => "twitter",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Linked In", 'fullhouse'),
					"param_name" => "linkedin",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'fullhouse'),
					"param_name" => "style",
					'value' 	=> array( 'circle' => esc_html__('circle', 'fullhouse'), 'vertical' => esc_html__('vertical', 'fullhouse') , 'horizontal' => esc_html__('horizontal', 'fullhouse') ),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)

		   	)
		));
	 
		
	 

		/* Heading Text Block
		---------------------------------------------------------- */
		vc_map( array(
			'name'        => esc_html__( 'PBR Widget Heading','fullhouse'),
			'base'        => 'pbr_title_heading',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'fullhouse'),
			'description' => esc_html__( 'Create title for one Widget', 'fullhouse' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'fullhouse' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Title', 'fullhouse' ),
					'description' => esc_html__( 'Enter heading title.', 'fullhouse' ),
					"admin_label" => true
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'fullhouse' ),
				    'param_name' => 'font_color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' )
				),
				 
				array(
					"type" => "textarea",
					'heading' => esc_html__( 'Description', 'fullhouse' ),
					"param_name" => "descript",
					"value" => '',
					'description' => esc_html__( 'Enter description for title.', 'fullhouse' )
			    ),
			    array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'fullhouse'),
					"param_name" => "style",
					'value' 	=> array( 'default' => esc_html__('default', 'fullhouse'), 'style-2' => esc_html__('style-2', 'fullhouse'), 'style-3' => esc_html__('style-3', 'fullhouse'), 'style-4' => esc_html__('style-4', 'fullhouse') ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
				)
			),
		));
		
		/* Banner CountDown
		---------------------------------------------------------- */
		vc_map( array(
			'name'        => esc_html__( 'PBR Banner CountDown','fullhouse'),
			'base'        => 'pbr_banner_countdown',
			"class"       => "",
			"category" => esc_html__('PBR Widgets', 'fullhouse'),
			'description' => esc_html__( 'Show CountDown with banner', 'fullhouse' ),
			"params"      => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Widget title', 'fullhouse' ),
					'param_name' => 'title',
					'value'       => esc_html__( 'Title', 'fullhouse' ),
					'description' => esc_html__( 'Enter heading title.', 'fullhouse' ),
					"admin_label" => true
				),


				array(
					"type" => "attach_image",
					"description" => esc_html__("If you upload an image, icon will not show.", 'fullhouse'),
					"param_name" => "image",
					"value" => '',
					'heading'	=> esc_html__('Image', 'fullhouse' )
				),


				array(
				    'type' => 'textfield',
				    'heading' => esc_html__( 'Date Expired', 'fullhouse' ),
				    'param_name' => 'input_datetime',
				    'description' => esc_html__( 'Select font color', 'fullhouse' ),
				),
				 

				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'fullhouse' ),
				    'param_name' => 'font_color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' ),
				    'class'	=> 'hacongtien'
				),
				 
				array(
					"type" => "textarea",
					'heading' => esc_html__( 'Description', 'fullhouse' ),
					"param_name" => "descript",
					"value" => '',
					'description' => esc_html__( 'Enter description for title.', 'fullhouse' )
			    ),

			    array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Description Color', 'fullhouse' ),
				    'param_name' => 'description_font_color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' ),
				    'class'	=> 'hacongtien'
				),

				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
					'param_name' => 'el_class',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
				),


				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Text Link', 'fullhouse' ),
					'param_name' => 'text_link',
					'value'		 => 'Find Out More',
					'description' => esc_html__( 'Enter your link text', 'fullhouse' )
				),

				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Link Color', 'fullhouse' ),
				    'param_name' => 'link_font_color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' ),
				    'class'	=> 'hacongtien'
				),
				
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Link', 'fullhouse' ),
					'param_name' => 'link',
					'value'		 => 'http://',
					'description' => esc_html__( 'Enter your link to redirect', 'fullhouse' )
				)
			),
		));


	}
}