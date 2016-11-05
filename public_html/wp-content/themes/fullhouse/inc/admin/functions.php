<?php 
/**
 * Register meta boxes
 *
 * Remember to change "your_prefix" to actual prefix in your project
 *
 * @param array $meta_boxes List of meta boxes
 *
 * @return array
 */
function fullhouse_func_register_meta_boxes( $meta_boxes )
{
	global $wp_registered_sidebars;	 // echo '<pre>'.print_r($wp_registered_sidebars, 1 ); die; 
	/**
	 * prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	$sidebars = array();
	if( $wp_registered_sidebars){
		foreach( $wp_registered_sidebars  as $key => $value ){
			$sidebars[$key] = $value['name'];
		}
	}
	// Better has an underscore as last sign
	$prefix = 'fullhouse_';
	$layouts = array(
	    '' => esc_html__('Auto', 'fullhouse'),
	    'leftmain' => esc_html__('Left - Main Sidebar', 'fullhouse'),
	    'mainright' => esc_html__('Main - Right Sidebar', 'fullhouse'),
	    'leftmainright' => esc_html__('Left - Main - Right Sidebar', 'fullhouse'),

	);

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'standard',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Page Layout Setting', 'fullhouse' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array(  'post', 'page' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
	 	
			// CHECKBOX
			array(
				'name' => esc_html__( 'Enable Fullwidth Layout', 'fullhouse' ),
				'id'   => "{$prefix}enable_fullwidth_layout",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 0,
			),		
			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Header Layout', 'fullhouse' ),
				'id'          => "{$prefix}header_layout",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>  fullhouse_fnc_get_header_layouts(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'fullhouse' ),
			),

			array(
				'name'        => esc_html__( 'Footer Layout', 'fullhouse' ),
				'id'          => "{$prefix}footer_profile",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>   fullhouse_fnc_get_footer_profiles(),
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'fullhouse' ),
			),

			// CHECKBOX
			array(
				'name' => esc_html__( 'Disable Breadscrumb', 'fullhouse' ),
				'id'   => "{$prefix}disable_breadscrumb",
				'type' => 'checkbox',
				// Value can be 0 or 1
				'std'  => 1,
			),	

			// COLOR
			array(
				'name' => esc_html__( 'Breadcrumbs Text Color', 'fullhouse' ),
				'id'   => "{$prefix}color_breadscrumb",
				'type' => 'color',
				'description' => esc_html__('Custom Text Color for breadscrumb','fullhouse')
			), 
			 

			// COLOR
			array(
				'name' => esc_html__( 'Breadcrumbs Background Color', 'fullhouse' ),
				'id'   => "{$prefix}bgcolor_breadscrumb",
				'type' => 'color',
				'description' => esc_html__('Custom Background for breadscrumb','fullhouse')
			), 
			 
			 // THICKBOX IMAGE UPLOAD (WP 3.3+)
			// FILE ADVANCED (WP 3.5+)
			array(
				'name'             => esc_html__( 'Breadscrumb Background', 'fullhouse' ),
				'id'               => "{$prefix}image_breadscrumb",
				'type'             => 'file_advanced',
				'max_file_uploads' => 1,
				'mime_type'        => 'image', // Leave blank for all file types
			),

			array(
				'name'        => esc_html__( 'Layout', 'fullhouse' ),
				'id'          => "{$prefix}page_layout",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     =>   $layouts,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',

			),

			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Left Sidebar', 'fullhouse' ),
				'id'          => "{$prefix}leftsidebar",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => $sidebars,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'fullhouse' ),
			),

			// HEADER SELECT BOX
			array(
				'name'        => esc_html__( 'Right Sidebar', 'fullhouse' ),
				'id'          => "{$prefix}rightsidebar",
				'type'        => 'select',
				// Array of 'value' => 'Label' pairs for select box
				'options'     => $sidebars,
				// Select multiple values, optional. Default is false.
				'multiple'    => false,
				'std'         => '',
				'placeholder' => esc_html__( 'Global', 'fullhouse' ),
			),

		),
		'validation' => array(
			 
		)
	);	
 	 
	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'fullhouse_func_register_meta_boxes' , 102 );


function fullhouse_func_register_postformat_meta_boxes(  $meta_boxes  ){
	 
	// Better has an underscore as last sign
	$prefix = 'fullhouse_';

	$layouts = array(
	    '' => esc_html__('Auto', 'fullhouse'),
	    'leftmain' => esc_html__('Left - Main Sidebar', 'fullhouse'),
	    'mainright' => esc_html__('Main - Right Sidebar', 'fullhouse'),
	    'leftmainright' => esc_html__('Left - Main - Right Sidebar', 'fullhouse'),

	);

	// 1st meta box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id'         => 'post_format_standard_post_meta',
		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title'      => esc_html__( 'Format Setting', 'fullhouse' ),
		// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
		'post_types' => array(  'post' ),
		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context'    => 'normal',
		// Order of meta box: high (default), low. Optional.
		'priority'   => 'low',
		// Auto save: true, false (default). Optional.
		'autosave'   => true,
		// List of meta fields
		'fields'     => array(
	 	
			// CHECKBOX
			
			array(
				'id'   => "{$prefix}gallery_files",
				'name' => esc_html__( 'Images Gallery', 'fullhouse' ),
				'type' => 'file_advanced',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'fullhouse' ),
			),

			array(
				'id'   => "{$prefix}video_link",
				'name' => esc_html__( 'Video Link', 'fullhouse' ),
				'type' => 'oembed',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'fullhouse' ),
			),
			
			array(
				'id'   => "{$prefix}link_text",
				'name' => esc_html__( 'Link Text', 'fullhouse' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'fullhouse' ),
			), 
			array(
				'id'   => "{$prefix}link_link",
				'name' => esc_html__( 'Link To Redirect', 'fullhouse' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'fullhouse' ),
			), 
			 
			array(
				'id'   => "{$prefix}audio_link",
				'name' => esc_html__( 'Audio Link', 'fullhouse' ),
				'type' => 'text',
				'description'  => esc_html__( 'Select one or more images to show as gallery', 'fullhouse' ),
			),  
		),
		'validation' => array(
			 
		)
	);	
 	 
	return $meta_boxes;
}


function fullhouse_func_standard_post_meta( $post_id ){
		
	global $post; 
	$prefix = 'fullhouse_';
	$type = get_post_format();

	$old = array(
		'gallery_files',
		'video_link',
		'link_text',
		'link_link',
		'audio_link',
	);
	
	$data = array( 'gallery' => array('gallery_files'), 
				   'video' =>  array('video_link'), 
				   'audio' =>  array('audio_link'), 
				   'link' => array('link_link','link_text') ); 

	$new = array();

	if( isset($data[$type]) ){
		foreach( $data[$type] as $key => $value ){
			$new[$prefix.$value] = $_POST[$prefix.$value];
		}
	}


	foreach( $old as $key => $value ){
		if( isset($_POST[$prefix.$value]) ){
			unset( $_POST[$prefix.$value] );
		}
	}
	if( $new ){
		$_POST = array_merge( $_POST, $new );
	}
	// echo get_post_format();


}
add_action( "rwmb_post_format_standard_post_meta_before_save_post", 'fullhouse_func_standard_post_meta' , 9  );

add_filter( 'rwmb_meta_boxes', 'fullhouse_func_register_postformat_meta_boxes' , 100 );



function fullhouse_fnc_is_edit_page($new_edit = null){
    global $pagenow;
    //make sure we are on the backend
 


    if($new_edit == "edit")
        return in_array( $pagenow, array( 'post.php',  ) );
    elseif($new_edit == "new") //check for new post page
        return in_array( $pagenow, array( 'post-new.php' ) );
    else //check for either new or edit
        return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
}


/**
 *
 */
function fullhouse_fnc_setup_admin_setting(){

	global $pagenow; 
	if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
		/**
		 *
		 */
		$pts = array( 'brands', 'testimonials', 'portfolio', 'faq', 'footer', 'megamenu','woobrand');

		$options = array();	

		foreach( $pts as $key ){
			$options['enable_'.$key] = 'on'; 
		}
	
		update_option( 'pbr_themer_posttype', $options );

		/// 
		$options = array();
		$options['enable'] = 0; 
		update_option( 'the_champ_sharing', $options, true );
	}

	
	if( fullhouse_fnc_is_edit_page() ){ 	
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		wp_enqueue_script( 'fullhouse-admin-scripts', get_template_directory_uri() . '/js/custom-admin.js', array( 'jquery'  ), '20131022', true );
	}

	wp_enqueue_style( 'custom-admin-css', get_template_directory_uri() . '/css/custom-admin.css', array(), '3.0.3' );	

}
add_action( 'init', 'fullhouse_fnc_setup_admin_setting'  );