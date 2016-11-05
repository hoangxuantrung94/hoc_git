<?php 
/**
 * Remove javascript and css files not use
 */
		function fullhouse_remove_query_strings_1( $src ){	
			$rqs = explode( '?ver', $src );
	        return $rqs[0];
		}
		function fullhouse_remove_query_strings_2( $src ){
			$rqs = explode( '&ver', $src );
		        return $rqs[0];
		}

		if ( !is_admin() ) {
			add_filter( 'script_loader_src', 'fullhouse_remove_query_strings_1', 15, 1 );
			add_filter( 'style_loader_src', 'fullhouse_remove_query_strings_1', 15, 1 );

			add_filter( 'script_loader_src', 'fullhouse_remove_query_strings_2', 15, 1 );
			add_filter( 'style_loader_src', 'fullhouse_remove_query_strings_2', 15, 1 );
		}

/**
 * Hook to top bar layout
 */
function fullhouse_fnc_topbar_layout(){
	$layout = fullhouse_fnc_get_header_layout();
	get_template_part( 'page-templates/parts/topbar', $layout );
	get_template_part( 'page-templates/parts/topbar', 'mobile' );
}

add_action( 'fullhouse_template_header_before', 'fullhouse_fnc_topbar_layout' );

/**
 * Hook to select header layout for archive layout
 */
function fullhouse_fnc_get_header_layout( $layout='' ){
	global $post; 

	$layout = $post && get_post_meta( $post->ID, 'fullhouse_header_layout', 1 ) ? get_post_meta( $post->ID, 'fullhouse_header_layout', 1 ) : fullhouse_fnc_theme_options( 'headerlayout' );
	if ($layout == 'default') {
		$layout = '';
	}
 	if( $layout ){
 		return trim( $layout );
 	}elseif ( $layout = fullhouse_fnc_theme_options('header_skin','') ){
 		return trim( $layout );
 	}

	return $layout;
} 

add_filter( 'fullhouse_fnc_get_header_layout', 'fullhouse_fnc_get_header_layout' );

/**
 * Hook to select header layout for archive layout
 */
function fullhouse_fnc_get_footer_profile( $profile='default' ){

	global $post; 

	$profile =  $post? get_post_meta( $post->ID, 'fullhouse_footer_profile', 1 ):null ;

 	if( $profile ){
 		return trim( $profile );
 	}elseif ( $profile = fullhouse_fnc_theme_options('footer-style', $profile ) ){  
 		return trim( $profile );
 	}

	return $profile;
} 

add_filter( 'fullhouse_fnc_get_footer_profile', 'fullhouse_fnc_get_footer_profile' );


/**
 * Render Custom Css Renderig by Visual composer
 */
if ( !function_exists( 'fullhouse_fnc_print_style_footer' ) ) {
	function fullhouse_fnc_print_style_footer(){
		$footer =  fullhouse_fnc_get_footer_profile( 'default' );
		if($footer!='default'){
			$shortcodes_custom_css = get_post_meta( $footer, '_wpb_shortcodes_custom_css', true );
			if ( ! empty( $shortcodes_custom_css ) ) {
				echo '<style>
					'.$shortcodes_custom_css.'
					</style>';
			}
		}
	}
	add_action('wp_head','fullhouse_fnc_print_style_footer', 18);
}


/**
 * Hook to show breadscrumbs
 */
function fullhouse_fnc_render_breadcrumbs(){
	
	global $post;
	$classes = array();
	$classes[] = 'pbr-breadscrumb';
	if( is_object($post) && is_page() ){
		$disable = get_post_meta( $post->ID, 'fullhouse_disable_breadscrumb', 1 );  
		if(  $disable || is_front_page() ){
			return true; 
		}
		$bgimage = get_post_meta( $post->ID, 'fullhouse_image_breadscrumb', 1 );  
		$color 	 = get_post_meta( $post->ID, 'fullhouse_color_breadscrumb', 1 );  
		$bgcolor = get_post_meta( $post->ID, 'fullhouse_bgcolor_breadscrumb', 1 );  

		$style = array();
		if( $bgcolor  ){
			$style[] = 'background-color:'.$bgcolor;
		}

		if( $bgimage  ){ 
			$img = wp_get_attachment_url($bgimage); 
			$style[] = $img ?  'background-image:url(\''.$img.'\')' : '';
		}

		if( $color  ){ 
			$style[] = 'color:'.$color;
		}
		if ( !empty($style) ) {
			$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
		}  

	} elseif ( is_category() || is_archive( ) ) {
		$bgimage = fullhouse_fnc_theme_options('blog-archive-breadcrumb');
		$classes[] = 'breadcrumb-archive-blog';
	} elseif ( is_singular('post') ) {
		$bgimage = fullhouse_fnc_theme_options('blog-single-breadcrumb');
		$classes[] = 'breadcrumb-single-blog';
	} elseif ( is_singular('opalestate_property') || is_tax('property_category') || is_post_type_archive( 'opalestate_property' ) ) {
		$bgimage = fullhouse_fnc_theme_options('image-property-breadcrumb');
		$classes[] = 'breadcrumb-property';
	} elseif ( is_singular('opalestate_agent') || is_post_type_archive( 'opalestate_agent' ) ) {
		$bgimage = fullhouse_fnc_theme_options('image-agent-breadcrumb');
	} else {
		$classes[] = 'breadcrumb-single-blog';
		$bgimage = fullhouse_fnc_theme_options('blog-single-breadcrumb');
	}

	if( !empty($bgimage)  ){ 
		$url = is_numeric($bgimage)  ? wp_get_attachment_url($bgimage):$bgimage;
		$style[] = $url ? 'background-image:url(\''.$url.'\')':'';
	}
 
	if( isset($url) && strpos($url, get_site_url()) !== false ){  
		$estyle = !empty($style)? 'style="'.implode(";", $style).'"':"";
	}else {
		$estyle = '';
	}
	
	echo '<section id="pbr-breadscrumb" class="'.implode(" ", $classes).'" '.$estyle.'><div class="container">';
			fullhouse_fnc_breadcrumbs();
	echo '</div></section>';

}

add_action( 'fullhouse_template_main_before', 'fullhouse_fnc_render_breadcrumbs' ); 

 
/**
 * Main Container
 */

function fullhouse_template_main_container_class( $class ){
	global $post; 
	global $fullhouse_wpopconfig;
	if( !is_object($post) ){
		return;
	}
	$layoutcls = get_post_meta( $post->ID, 'fullhouse_enable_fullwidth_layout', 1 );
	
	if( $layoutcls ) {
		$fullhouse_wpopconfig['layout'] = 'fullwidth';
		return 'container-fluid';
	}
	return $class;
}
add_filter( 'fullhouse_template_main_container_class', 'fullhouse_template_main_container_class', 1 , 1  );
add_filter( 'fullhouse_template_main_content_class', 'fullhouse_template_main_container_class', 1 , 1  );



function fullhouse_template_footer_before(){
	return get_sidebar( 'newsletter' );
}

add_action( 'fullhouse_template_footer_before', 'fullhouse_template_footer_before' );


/**
 * Get Configuration for Page Layout
 *
 */
function fullhouse_fnc_get_page_sidebar_configs( $configs='' ){

	global $post; 

	if( $post ){
		$left  =  get_post_meta( $post->ID, 'fullhouse_leftsidebar', 1 );
		$right =  get_post_meta( $post->ID, 'fullhouse_rightsidebar', 1 );
		return fullhouse_fnc_get_layout_configs( $left, $right );
	}
	
	return fullhouse_fnc_get_layout_configs( '', '' );
	
}

add_filter( 'fullhouse_fnc_get_page_sidebar_configs', 'fullhouse_fnc_get_page_sidebar_configs', 1, 1 );


function fullhouse_fnc_get_single_sidebar_configs( $configs='' ){

	global $post; 

	$left  =  get_post_meta( $post->ID, 'fullhouse_leftsidebar', 1 );
	$right =  get_post_meta( $post->ID, 'fullhouse_rightsidebar', 1 );

	if ( empty( $left ) ) {
		$left  =  fullhouse_fnc_theme_options( 'blog-single-left-sidebar' ); 
	}

	if ( empty( $right ) ) {
		$right =  fullhouse_fnc_theme_options( 'blog-single-right-sidebar' ); 
	}

	return fullhouse_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fullhouse_fnc_get_single_sidebar_configs', 'fullhouse_fnc_get_single_sidebar_configs', 1, 1 );

function fullhouse_fnc_get_archive_sidebar_configs( $configs='' ){

	global $post; 


	$left  =  fullhouse_fnc_theme_options( 'blog-archive-left-sidebar' ); 
	$right =  fullhouse_fnc_theme_options( 'blog-archive-right-sidebar' ); 
 	
	return fullhouse_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fullhouse_fnc_get_archive_sidebar_configs', 'fullhouse_fnc_get_archive_sidebar_configs', 1, 1 );
add_filter( 'fullhouse_fnc_get_category_sidebar_configs', 'fullhouse_fnc_get_archive_sidebar_configs', 1, 1 );

/**
 *
 */
function fullhouse_fnc_get_layout_configs( $left, $right ){
	$configs = array();
	$configs['main'] = array( 'class' => 'col-lg-9 col-md-9 col-sm-9' );

	$configs['sidebars'] = array( 
		'left'  => array( 'sidebar' => $left, 'active' => is_active_sidebar( $left ), 'class' => 'col-lg-3 col-md-3 col-sm-3'  ),
		'right' => array( 'sidebar' => $right, 'active' => is_active_sidebar( $right ), 'class' => 'col-lg-3 col-md-3 col-sm-3' ) 
	); 

	if( $left && $right ){
		$configs['main'] = array( 'class' => 'col-lg-9 col-md-9 col-sm-9' );
	} elseif( empty($left) && empty($right) ){
		$configs['main'] = array( 'class' => 'col-lg-12 col-md-12' );
	}
	return $configs; 
}