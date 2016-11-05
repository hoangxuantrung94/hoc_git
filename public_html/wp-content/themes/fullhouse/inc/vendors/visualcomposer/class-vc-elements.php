<?php 

class Fullhouse_VC_Elements implements Vc_Vendor_Interface {

	public function load(){ 
		
		/*********************************************************************************************************************
		 *  Our Service
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Featured Box",'fullhouse'),
		    "base" => "pbr_featuredbox",
		
		    "description"=> esc_html__('Decreale Service Info', 'fullhouse'),
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => '',    "admin_label" => true,
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Title Color', 'fullhouse' ),
				    'param_name' => 'title_color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' )
				),

		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Sub Title", 'fullhouse'),
					"param_name" => "subtitle",
					"value" => '',
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Style", 'fullhouse'),
					"param_name" => "style",
					'value' 	=> array(
						esc_html__('Default', 'fullhouse') => '', 
						esc_html__('Version 1', 'fullhouse') => 'v1', 
						esc_html__('Version 2', 'fullhouse') => 'v2', 
						esc_html__('Version 3', 'fullhouse' )=> 'v3',
						esc_html__('Version 4', 'fullhouse') => 'v4'
					),
					'std' => ''
				),

				array(
					'type'                           => 'dropdown',
					'heading'                        => esc_html__( 'Title Alignment', 'fullhouse' ),
					'param_name'                     => 'title_align',
					'value'                          => array(
					esc_html__( 'Align left', 'fullhouse' )   => 'separator_align_left',
					esc_html__( 'Align center', 'fullhouse' ) => 'separator_align_center',
					esc_html__( 'Align right', 'fullhouse' )  => 'separator_align_right'
					),
					'std' => 'separator_align_left'
				),

			 	array(
					"type" => "textfield",
					"heading" => esc_html__("FontAwsome Icon", 'fullhouse'),
					"param_name" => "icon",
					"value" => 'fa fa-gear',
					'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'fullhouse' )
									. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
									. esc_html__( 'here to see the list', 'fullhouse' ) . '</a>'
				),
				array(
				    'type' => 'colorpicker',
				    'heading' => esc_html__( 'Icon Color', 'fullhouse' ),
				    'param_name' => 'color',
				    'description' => esc_html__( 'Select font color', 'fullhouse' )
				),	
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Background Icon', 'fullhouse' ),
					'param_name' => 'background',
					'value' => array(
						esc_html__( 'None', 'fullhouse' ) => 'nostyle',
						esc_html__( 'Success', 'fullhouse' ) => 'bg-success',
						esc_html__( 'Info', 'fullhouse' ) => 'bg-info',
						esc_html__( 'Danger', 'fullhouse' ) => 'bg-danger',
						esc_html__( 'Warning', 'fullhouse' ) => 'bg-warning',
						esc_html__( 'Light', 'fullhouse' ) => 'bg-default',
					),
					'std' => 'nostyle',
				),

				array(
					"type" => "attach_image",
					"heading" => esc_html__("Photo", 'fullhouse'),
					"param_name" => "photo",
					"value" => '',
					'description'	=> ''
				),

				array(
					"type" => "textarea",
					"heading" => esc_html__("information", 'fullhouse'),
					"param_name" => "information",
					"value" => 'Your Description Here',
					'description'	=> esc_html__('Allow  put html tags', 'fullhouse' )
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
		 * Pricing Table
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Pricing",'fullhouse'),
		    "base" => "pbr_pricing",
		    "description" => esc_html__('Make Plan for membership', 'fullhouse' ),
		    "class" => "",
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
					"type" => "textfield",
					"heading" => esc_html__("Price", 'fullhouse'),
					"param_name" => "price",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Currency", 'fullhouse'),
					"param_name" => "currency",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Period", 'fullhouse'),
					"param_name" => "period",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Subtitle", 'fullhouse'),
					"param_name" => "subtitle",
					"value" => '',
					'description'	=> ''
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Is Featured", 'fullhouse'),
					"param_name" => "featured",
					'value' 	=> array(  esc_html__('No', 'fullhouse') => 0,  esc_html__('Yes', 'fullhouse') => 1 ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Skin", 'fullhouse'),
					"param_name" => "skin",
					'value' 	=> array(  esc_html__('Skin 1', 'fullhouse') => 'v1',  esc_html__('Skin 2', 'fullhouse') => 'v2', esc_html__('Skin 3', 'fullhouse') => 'v3' ),
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__("Box Style", 'fullhouse'),
					"param_name" => "style",
					'value' 	=> array( 'boxed' => esc_html__('Boxed', 'fullhouse')),
				),

				array(
					"type" => "textarea_html",
					"heading" => esc_html__("Content", 'fullhouse'),
					"param_name" => "content",
					"value" => '',
					'description'	=> esc_html__('Allow  put html tags', 'fullhouse')
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Link Title", 'fullhouse'),
					"param_name" => "linktitle",
					"value" => 'SignUp',
					'description'	=> ''
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Link", 'fullhouse'),
					"param_name" => "link",
					"value" => 'http://yourdomain.com',
					'description'	=> ''
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
		 *  PBR Counter
		 *********************************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Counter",'fullhouse'),
		    "base" => "pbr_counter",
		    "class" => "",
		    "description"=> esc_html__('Counting number with your term', 'fullhouse'),
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => '',
					"admin_label"	=> true
				),
				array(
					"type" => "textarea",
					"heading" => esc_html__("Description", 'fullhouse'),
					"param_name" => "description",
					"value" => '',
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Number", 'fullhouse'),
					"param_name" => "number",
					"value" => ''
				),

			 	array(
					"type" => "textfield",
					"heading" => esc_html__("FontAwsome Icon", 'fullhouse'),
					"param_name" => "icon",
					"value" => '',
					'description'	=> esc_html__( 'This support display icon from FontAwsome, Please click', 'fullhouse' )
									. '<a href="' . ( is_ssl()  ? 'https' : 'http') . '://fortawesome.github.io/Font-Awesome/" target="_blank">'
									. esc_html__( 'here to see the list', 'fullhouse' ) . '</a>'
				),


				array(
					"type" => "attach_image",
					"description" => esc_html__("If you upload an image, icon will not show.", 'fullhouse'),
					"param_name" => "image",
					"value" => '',
					'heading'	=> esc_html__('Image', 'fullhouse' )
				),

		 

				array(
					"type" => "colorpicker",
					"heading" => esc_html__("Text Color", 'fullhouse'),
					"param_name" => "text_color",
					'value' 	=> '',
				),

				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)
		   	)
		));


		/**************************************************
		*   Element time line 
		**************************************************/
		vc_map( array(
				'name'        => esc_html__('PBR Timeline','fullhouse'),
				'base'        => 'pbr_timeline',
				"class"       => "",
				"category" => esc_html__('PBR Widgets', 'fullhouse'),
				'description' => esc_html__('Create Item timeline with content + icon', 'fullhouse' ),
				'params'		=> array(
					array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"value" => '',
						"admin_label" => true
					),

			    	array(
						"type" => "textfield",
						"heading" => esc_html__("Sub Title", 'fullhouse'),
						"param_name" => "subtitle",
						"value" => '',
							"admin_label" => true
					),
					array(
						'type' => 'dropdown',
						'heading' => esc_html__('Title Alignment', 'fullhouse' ),
						'param_name' => 'alignment',
						'value' => array(
							esc_html__('Align left', 'fullhouse' ) => 'separator_align_left',
							esc_html__('Align center', 'fullhouse' ) => 'separator_align_center',
							esc_html__('Align right', 'fullhouse' ) => 'separator_align_right'
						)
					),
					
					array(
						'type' => 'param_group',
						'heading' => esc_html__('Items', 'fullhouse' ),
						'param_name' => 'items',
						'description' => '',
						'value' => urlencode( json_encode( array(
							
						) ) ),

						'params' => array(
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Title', 'fullhouse' ),
								'param_name' => 'title',
								'admin_label' => true,
							),
							array(
								'type' => 'textfield',
								'heading' => esc_html__('Sub Title', 'fullhouse' ),
								'param_name' => 'sub_title',
								'admin_label' => true,
							),
							array(
								'type' => 'attach_image',
								'heading' => esc_html__('Icon', 'fullhouse' ),
								'param_name' => 'icon',
								'admin_label' => false,
							),
							array(
								'type' => 'textarea',
								'heading' => esc_html__('Content', 'fullhouse' ),
								'param_name' => 'content',
								'admin_label' => false,
							),
						),
					),
				)
			)
		);


		/* Gallery
		***************************************************************************************************/
		vc_map( array(
		    "name" => esc_html__("PBR Gallery",'fullhouse'),
		    "base" => "pbr_gallery",
		    'description'=> esc_html__('Diplay Gallery Grid', 'fullhouse'),
		    "class" => "",
		    "category" => esc_html__('PBR Widgets', 'fullhouse'),
		    "params" => array(
		    	array(
					"type" => "textfield",
					"heading" => esc_html__("Title", 'fullhouse'),
					"param_name" => "title",
					"admin_label" => true,
					"value" => '',
						"admin_label" => true
				),
            array(
                'type' => 'textfield',
                'heading' => esc_html__( 'Number', 'fullhouse' ),
                'param_name' => 'number',
                'value' => '',
            ),
            array(
					"type" => "dropdown",
					"heading" => esc_html__("Columns", 'fullhouse'),
					"param_name" => "columns",
					"value" => array(6, 4, 3, 1),
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__("Extra class name", 'fullhouse'),
					"param_name" => "el_class",
					"description" => esc_html__("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'fullhouse')
				)
		   )
		));
		 
	}
}