<?php

function fullhouse_fnc_import_remote_demos() { 
	return array(
		'fullhouse' => array( 'name' => 'fullhouse',  'source'=> 'http://wpsampledemo.com/fullhouse/fullhouse.zip' ),
	);
}

add_filter( 'pbrthemer_import_remote_demos', 'fullhouse_fnc_import_remote_demos' );



function fullhouse_fnc_import_theme() {
	return 'fullhouse';
}
add_filter( 'pbrthemer_import_theme', 'fullhouse_fnc_import_theme' );

function fullhouse_fnc_import_demos() {
	$folderes = glob( get_template_directory().'/inc/import/*', GLOB_ONLYDIR ); 

	$output = array(); 

	foreach( $folderes as $folder ){
		$output[basename( $folder )] = basename( $folder );
	}
 	
 	return $output;
}
add_filter( 'pbrthemer_import_demos', 'fullhouse_fnc_import_demos' );

function fullhouse_fnc_import_types() {
	return array(
			'all' => 'All',
			'content' => 'Content',
			'widgets' => 'Widgets',
			'page_options' => 'Theme + Page Options',
			'menus' => 'Menus',
			'rev_slider' => 'Revolution Slider',
			'vc_templates' => 'VC Templates'
		);
}
add_filter( 'pbrthemer_import_types', 'fullhouse_fnc_import_types' );

/**
 * Matching and resizing images with url.
 *
 *  $ouput = array(
 *        'allowed' => 1, // allow resize images via using GD Lib php to generate image
 *        'height'  => 900,
 *        'width'   => 800,
 *        'file_name' => 'blog_demo.jpg'
 *   ); 
 */
function fullhouse_import_attachment_image_size( $url ){  

   $name = basename( $url );   
 
   $ouput = array(
         'allowed' => 0
   );     
   if( preg_match("#agent#", $name) ) {
      $ouput = array(
         'allowed' => 1,
         'height'  => 270,
         'width'   => 270,
         'file_name' => 'agent_demo.jpg'
      ); 
   }
   elseif( preg_match("#breadcrumb#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 360,
         'width'   => 1920,
         'file_name' => 'breadcrumb_demo.jpg'
      ); 
   }elseif( preg_match("#gal#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 1100,
         'width'   => 1920,
         'file_name' => 'gal_demo.jpg'
      ); 
   }
   elseif( preg_match("#post#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 1200,
         'width'   => 1920,
         'file_name' => 'post_demo.jpg'
      ); 
   }
   elseif( preg_match("#property#", $name) ){
      $ouput = array(
         'allowed' => 1,
         'height'  => 900,
         'width'   => 1920,
         'file_name' => 'property_demo.jpg'
      ); 
   }
   return $ouput;
}

add_filter( 'pbrthemer_import_attachment_image_size', 'fullhouse_import_attachment_image_size' , 1 , 999 );
