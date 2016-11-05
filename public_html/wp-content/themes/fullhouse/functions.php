<?php
/**
 * fullhouse functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package WpOpal
 * @subpackage fullhouse
 * @since fullhouse 1.0
 */
define( 'FULLHOUSE_THEME_VERSION', '1.0' );
/**
 * Set up the content width value based on the theme's design.
 *
 * @see fullhouse_fnc_content_width()
 *
 * @since fullhouse 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

if ( ! function_exists( 'fullhouse_fnc_setup' ) ) :
/**
 * mode setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since fullhouse 1.0
 */
function fullhouse_fnc_setup() {

	/*
	 * Make mode available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on mode, use a find and
	 * replace to change 'fullhouse' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'fullhouse', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
// 	add_editor_style( array( 'css/editor-style.css', fullhouse_fnc_font_url(), 'genericons/genericons.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	add_editor_style();
	// Enable support for Post Thumbnails, and declare two sizes.
 

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => esc_html__( 'Top primary menu', 'fullhouse' ),
		'secondary' => esc_html__( 'Secondary menu in left sidebar', 'fullhouse' ),
		'topmenu'	=> esc_html__( 'Topbar Menu in Topbar sidebar', 'fullhouse' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'fullhouse_fnc_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	
	// add support for display browser title
	add_theme_support( 'title-tag' );
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	fullhouse_fnc_get_load_plugins();

}
endif; 
// fullhouse_fnc_setup
add_action( 'after_setup_theme', 'fullhouse_fnc_setup' );

/**
 * batch including all files in a path.
 *
 * @param String $path : PATH_DIR/*.php or PATH_DIR with $ifiles not empty
 */
function fullhouse_pbr_includes( $path, $ifiles=array() ){
 
}

/**
 * Get Theme Option Value.
 * @param String $name : name of prameters 
 */
function fullhouse_fnc_theme_options($name, $default = false) {
  
    // get the meta from the database
    $options = ( get_option( 'pbr_theme_options' ) ) ? get_option( 'pbr_theme_options' ) : null;

    
   
    // return the option if it exists
    if ( isset( $options[$name] ) ) {
        return apply_filters( 'pbr_theme_options_$name', $options[ $name ] );
    }
    if( get_option( $name ) ){
        return get_option( $name );
    }
    // return default if nothing else
    return apply_filters( 'pbr_theme_options_$name', $default );
}
/**
 * Adjust content_width value for image attachment template.
 *
 * @since fullhouse 1.0
 */
function fullhouse_fnc_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'fullhouse_fnc_content_width' );


/**
 * Function for remove srcset (WP4.4)
 *
 */
function fullhouse_fnc_disable_srcset( $sources ) {
    return false;
}
add_filter( 'wp_calculate_image_srcset', 'fullhouse_fnc_disable_srcset' );


/**
 * Require function for including 3rd plugins
 *
 */
require_once(  get_template_directory() . '/inc/plugins/class-tgm-plugin-activation.php' );

function fullhouse_fnc_get_load_plugins(){

	$plugins[] =(array(
		'name'                     => esc_html__('MetaBox','fullhouse'), // The plugin name
	    'slug'                     => 'meta-box', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));


	$plugins[] =(array(
		'name'                     => esc_html__('Contact Form 7','fullhouse'), // The plugin name
	    'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));

	$plugins[] =(array(
		'name'                     => esc_html__('MailChimp', 'fullhouse'),// The plugin name
	    'slug'                     => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
	    'required'                 =>  true
	));

	$plugins[] =(array(
		'name'                     => esc_html__('WPBakery Visual Composer','fullhouse'), // The plugin name
	    'slug'                     => 'js_composer', // The plugin slug (typically the folder name)
	    'required'                 => true,
	    'source'				   => esc_url('http://www.wpopal.com/thememods/js_composer.zip') 
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Revolution Slider','fullhouse'), // The plugin name
        'slug'                     => 'revslider', // The plugin slug (typically the folder name)
        'required'                 => true ,
        'source'				   => esc_url('http://www.wpopal.com/thememods/revslider.zip')
	));

	$plugins[] =(array(
		'name'                     => esc_html__('PBR Themer For Themes','fullhouse'), // The plugin name
        'slug'                     => 'pbrthemer', // The plugin slug (typically the folder name)
        'required'                 => true ,
        'source'				   => 'http://www.wpopal.com/themeframework/pbrthemer.zip'
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Opal Estate','fullhouse'), // The plugin name
        'slug'                     => "opal-estate", // The plugin slug (typically the folder name)
        'required'                 => true 
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Opal Membership','fullhouse'), // The plugin name
	    'slug'                     => 'opalmembership', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	    'source'				   => esc_url('http://www.wpopal.com/_download_cm_/opalmembership.zip')
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Snazzy Maps - Map Custom Styles','fullhouse'), // The plugin name
	    'slug'                     => 'snazzy-maps', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));

	$plugins[] =(array(
		'name'                     => esc_html__('Super Socializer - Intergrate Social Login','fullhouse'), // The plugin name
	    'slug'                     => 'super-socializer', // The plugin slug (typically the folder name)
	    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
	));


	tgmpa( $plugins );
}

/**
 * Register three mode widget areas.
 *
 * @since fullhouse 1.0
 */
function fullhouse_fnc_registart_widgets_sidebars() {
	 
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Sidebar Default', 'fullhouse' ),
		'id'            => 'sidebar-default',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget  clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span</span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Newsletter' , 'fullhouse'),
		'id'            => 'newsletter',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget  clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span</span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Social' , 'fullhouse'),
		'id'            => 'social',
		'description'   => esc_html__( 'Appears on content in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget  clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span></span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Left Sidebar' , 'fullhouse'),
		'id'            => 'sidebar-left',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget widget-style  clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span></span></h3>',
	));
	register_sidebar(
	array(
		'name'          => esc_html__( 'Right Sidebar' , 'fullhouse'),
		'id'            => 'sidebar-right',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span></span></h3>',
	));

	register_sidebar( 
	array(
		'name'          => esc_html__( 'Blog Left Sidebar' , 'fullhouse'),
		'id'            => 'blog-sidebar-left',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span></span></h3>',
	));

	register_sidebar( 
	array(
		'name'          => esc_html__( 'Blog Right Sidebar', 'fullhouse'),
		'id'            => 'blog-sidebar-right',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget widget-style clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span><span>',
		'after_title'   => '</span></span></h3>',
	));


	register_sidebar( 
	array(
		'name'          => esc_html__( 'Footer 1' , 'fullhouse'),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Footer 2' , 'fullhouse'),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Footer 3' , 'fullhouse'),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));
	register_sidebar( 
	array(
		'name'          => esc_html__( 'Footer 4' , 'fullhouse'),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Appears in the footer section of the site.', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));

	register_sidebar( 
	array(
		'name'          => esc_html__( 'User Sidebar' , 'fullhouse'),
		'id'            => 'user-sidebar',
		'description'   => esc_html__( 'Appears on posts and pages in the sidebar', 'fullhouse'),
		'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	));
	
}
add_action( 'widgets_init', 'fullhouse_fnc_registart_widgets_sidebars' );

/**
 * Register Lato Google font for mode.
 *
 * @since fullhouse 1.0
 *
 * @return string
 */
function fullhouse_fnc_font_url() {
	 
	$fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lora = _x( 'on', 'Hind font: on or off', 'fullhouse' );
 
    /* Translators: If there are characters in your language that are not
    * supported by Lato, translate this to 'off'. Do not translate
    * into your own language.
    */
    $lato = _x( 'on', 'Lato font: on or off', 'fullhouse' );
 
    if ( 'off' !== $lora || 'off' !== $lato ) {
        $font_families = array();
 
        if ( 'off' !== $lora ) {
            $font_families[] = 'Montserrat:400,700';
        }
 
        if ( 'off' !== $lato ) {
            $font_families[] = 'Lato:400,800,700italic,700,400italic,300,300italic,900';
        }
 
        $query_args = array(
            'family' => ( implode( '%7C', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 		
 		 
 		$protocol = is_ssl() ? 'https:' : 'http:';
        $fonts_url = add_query_arg( $query_args, $protocol .'//fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since fullhouse 1.0
 */
function fullhouse_fnc_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'fullhouse-lato', fullhouse_fnc_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '3.0.3' );

	if(isset($_GET['pbr-skin']) && $_GET['pbr-skin']) {
		$currentSkin = $_GET['pbr-skin'];
	}else{
		$currentSkin = str_replace( '.css','', fullhouse_fnc_theme_options('skin','default') );
	}
	if( is_rtl() ){
		if( !empty($currentSkin) && $currentSkin != 'default' ){ 
			wp_enqueue_style( 'fullhouse-'.$currentSkin.'-style', get_template_directory_uri() . '/css/skins/rtl-'.$currentSkin.'/style.css' );
		}else {
			// Load our main stylesheet.
			wp_enqueue_style( 'fullhouse-style', get_template_directory_uri() . '/css/rtl-style.css' );
		}
	}
	else {
		if( !empty($currentSkin) && $currentSkin != 'default' ){ 
			wp_enqueue_style( 'fullhouse-'.$currentSkin.'-style', get_template_directory_uri() . '/css/skins/'.$currentSkin.'/style.css' );
		}else {
			// Load our main stylesheet.
			wp_enqueue_style( 'fullhouse-style', get_template_directory_uri() . '/css/style.css' );
		}	
	}	
	
	
	wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '20130402' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


	wp_enqueue_script( 'fullhouse-script'  , get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150315', true );
	wp_enqueue_script( 'owl-carousel'	   , get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array( 'jquery' ), '20150315', true );
	wp_enqueue_script( 'prettyphoto-js'    ,	get_template_directory_uri().'/js/jquery.prettyPhoto.js',array(),false,true);

	wp_enqueue_style( 'prettyPhoto'		   , get_template_directory_uri() . '/css/prettyPhoto.css');
	wp_enqueue_style( 'opalestate'		   , get_template_directory_uri() . '/css/opalestate.css');

	wp_localize_script( 'fullhouse-script' , 'fullhouseAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));	
}
add_action( 'wp_enqueue_scripts', 'fullhouse_fnc_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since fullhouse 1.0
 */
function fullhouse_fnc_admin_fonts() {
	wp_enqueue_style( 'fullhouse-lato', fullhouse_fnc_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'fullhouse_fnc_admin_fonts' );


/**
 * Implement rick meta box for post and page, custom post types. These 're used with metabox plugins
 */
if( is_admin() ){
	require_once(  get_template_directory() . '/inc/admin/functions.php' );
}
require_once(  get_template_directory() . '/inc/classes/account.php' );
require_once(  get_template_directory() . '/inc/classes/nav.php' );
require_once(  get_template_directory() . '/inc/classes/offcanvas-menu.php' );

require_once(  get_template_directory() . '/inc/custom-header.php' );
require_once(  get_template_directory() . '/inc/customizer.php' );
require_once(  get_template_directory() . '/inc/function-post.php' );
require_once(  get_template_directory() . '/inc/function-unilty.php' );
require_once(  get_template_directory() . '/inc/functions-import.php' );
require_once(  get_template_directory() . '/inc/template-hook.php' );
require_once(  get_template_directory() . '/inc/template-tags.php' );
require_once(  get_template_directory() . '/inc/template.php' );
 

/**
 * Check and load to support visual composer
 */
if(  in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) && class_exists('WPBakeryVisualComposerAbstract') ){
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-elements.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-extends.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-news.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/class-vc-theme.php' );
	require_once(  get_template_directory() . '/inc/vendors/visualcomposer/function-vc.php' );

}

/**
 * Check and load to support visual composer
 */
if(  in_array( 'opal-estate/opal-estate.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  ){
	require_once(  get_template_directory() . '/inc/vendors/opalestate/customizer.php' );
	require_once(  get_template_directory() . '/inc/vendors/opalestate/functions.php' );
}
