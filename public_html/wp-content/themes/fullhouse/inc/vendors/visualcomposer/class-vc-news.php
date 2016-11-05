<?php 
class Fullhouse_VC_News implements Vc_Vendor_Interface  {
	
	public function load(){
		 
		$newssupported = true; 
 
			/**********************************************************************************
			 * Front Page Posts
			 **********************************************************************************/

			// front page 3
			vc_map( array(
				'name' => esc_html__( '(News) FrontPage 3', 'fullhouse' ),
				'base' => 'pbr_frontpageposts3',
				'icon' => 'icon-wpb-news-3',
				"category" => esc_html__('PBR News', 'fullhouse'),
				'description' => esc_html__( 'Create Post having blog styles', 'fullhouse' ),
				 
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'fullhouse' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'fullhouse' ),
						"admin_label" => true
					),

					 

					array(
						'type' => 'loop',
						'heading' => esc_html__( 'Grids content', 'fullhouse' ),
						'param_name' => 'loop',
						'settings' => array(
							'size' => array( 'hidden' => false, 'value' => 4 ),
							'order_by' => array( 'value' => 'date' ),
						),
						'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'fullhouse' )
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Number Main Posts", 'fullhouse'),
						"param_name" => "num_mainpost",
						"value" => array( 1 , 2 , 3 , 4 , 5 , 6),
						"std" => 1
					),
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Pagination Links', 'fullhouse' ),
						'param_name' => 'show_pagination',
						'description' => esc_html__( 'Enables to show paginations to next new page.', 'fullhouse' ),
						'value' => array( esc_html__( 'Yes, please', 'fullhouse' ) => 'yes' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Thumbnail size', 'fullhouse' ),
						'param_name' => 'thumbsize',
						'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'fullhouse' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
					)
				)
			) );
			// front page 4
			vc_map( array(
				'name' => esc_html__( '(News) FrontPage 4', 'fullhouse' ),
				'base' => 'pbr_frontpageposts4',
				'icon' => 'icon-wpb-news-4',
				"category" => esc_html__('PBR News', 'fullhouse'),
				'description' => esc_html__( 'Create Post having blog styles', 'fullhouse' ),
				 
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'fullhouse' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'fullhouse' ),
						"admin_label" => true
					),

				 
				 

					array(
						'type' => 'loop',
						'heading' => esc_html__( 'Grids content', 'fullhouse' ),
						'param_name' => 'loop',
						'settings' => array(
							'size' => array( 'hidden' => false, 'value' => 4 ),
							'order_by' => array( 'value' => 'date' ),
						),
						'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'fullhouse' )
					),
					 
					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Pagination Links', 'fullhouse' ),
						'param_name' => 'show_pagination',
						'description' => esc_html__( 'Enables to show paginations to next new page.', 'fullhouse' ),
						'value' => array( esc_html__( 'Yes, please', 'fullhouse' ) => 'yes' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Thumbnail size', 'fullhouse' ),
						'param_name' => 'thumbsize',
						'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'fullhouse' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
					)
				)
			) );
			 
			

			$layout_image = array(
				esc_html__('Grid', 'fullhouse')             => 'grid-1',
				esc_html__('List', 'fullhouse')             => 'list-1',
				esc_html__('List not image', 'fullhouse')   => 'list-2',
			);
			
			vc_map( array(
				'name' => esc_html__( '(News) Grid Posts', 'fullhouse' ),
				'base' => 'pbr_gridposts',
				'icon' => 'icon-wpb-news-2',
				"category" => esc_html__('PBR News', 'fullhouse'),
				'description' => esc_html__( 'Post having news,managzine style', 'fullhouse' ),
			 
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Widget title', 'fullhouse' ),
						'param_name' => 'title',
						'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'fullhouse' ),
						"admin_label" => true
					),
 
				 
					array(
						'type' => 'loop',
						'heading' => esc_html__( 'Grids content', 'fullhouse' ),
						'param_name' => 'loop',
						'settings' => array(
							'size' => array( 'hidden' => false, 'value' => 4 ),
							'order_by' => array( 'value' => 'date' ),
						),
						'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'fullhouse' )
					),
					array(
						"type" => "dropdown",
						"heading" => esc_html__("Layout Type", 'fullhouse'),
						"param_name" => "layout",
						"layout_images" => $layout_image,
						"value" => $layout_image,
						"admin_label" => true,
						"description" => esc_html__("Select Skin layout.", 'fullhouse')
					),

					array(
						'type' => 'checkbox',
						'heading' => esc_html__( 'Show Pagination Links', 'fullhouse' ),
						'param_name' => 'show_pagination',
						'description' => esc_html__( 'Enables to show paginations to next new page.', 'fullhouse' ),
						'value' => array( esc_html__( 'Yes, please', 'fullhouse' ) => 'yes' )
					),

					array(
						"type" => "dropdown",
						"heading" => esc_html__("Grid Columns", 'fullhouse'),
						"param_name" => "grid_columns",
						"value" => array( 1 , 2 , 3 , 4 , 6),
						"std" => 3
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Thumbnail size', 'fullhouse' ),
						'param_name' => 'thumbsize',
						'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'fullhouse' )
					),
					array(
						'type' => 'textfield',
						'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
						'param_name' => 'el_class',
						'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
					)
				)
			) );
			
			/**********************************************************************************
			 * Slideshow Post Widget Gets
			 **********************************************************************************/
				vc_map( array(
					'name' => esc_html__( '(News) Slideshow Post', 'fullhouse' ),
					'base' => 'pbr_slideshopbrst',
					'icon' => 'icon-wpb-news-slideshow',
					"category" => esc_html__('PBR News', 'fullhouse'),
					'description' => esc_html__( 'Play Posts In slideshow', 'fullhouse' ),
					 
					'params' => array(
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Widget title', 'fullhouse' ),
							'param_name' => 'title',
							'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'fullhouse' ),
							"admin_label" => true
						),

					 

						array(
							'type' => 'textarea',
							'heading' => esc_html__( 'Heading Description', 'fullhouse' ),
							'param_name' => 'descript',
							"value" => ''
						),

						array(
							'type' => 'loop',
							'heading' => esc_html__( 'Grids content', 'fullhouse' ),
							'param_name' => 'loop',
							'settings' => array(
								'size' => array( 'hidden' => false, 'value' => 10 ),
								'order_by' => array( 'value' => 'date' ),
							),
							'description' => esc_html__( 'Create WordPress loop, to populate content from your site.', 'fullhouse' )
						),

						array(
							"type" => "dropdown",
							"heading" => esc_html__("Grid Columns", 'fullhouse'),
							"param_name" => "grid_columns",
							"value" => array( 1 , 2 , 3 , 4 , 6),
							"std" => 3
						),
						array(
							'type' => 'checkbox',
							'heading' => esc_html__( 'Show Pagination Links', 'fullhouse' ),
							'param_name' => 'show_pagination',
							'description' => esc_html__( 'Enables to show paginations to next new page.', 'fullhouse' ),
							'value' => array( esc_html__( 'Yes, please', 'fullhouse' ) => 'yes' )
						),

						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Thumbnail size', 'fullhouse' ),
							'param_name' => 'thumbsize',
							'description' => esc_html__( 'Enter thumbnail size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height) . ', 'fullhouse' )
						),
						array(
							'type' => 'textfield',
							'heading' => esc_html__( 'Extra class name', 'fullhouse' ),
							'param_name' => 'el_class',
							'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'fullhouse' )
						)
					)
				) );
 
	}
}