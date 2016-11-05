<?php 
/*
  Plugin Name: Wpopal Framework For Themes
  Plugin URI: http://www.wpopal.com/
  Description: Implement rich functions for themes base on prestabrain wordpress framework and load widgets for theme used, this is required.
  Version: 1.2.4.3
  Author: WPOPAL
  Author URI: http://www.wpopal.com
  License: GPLv2 or later
  Update: Aug, 15,2016
 */

 /**
  * $Desc
  *
  * @version    $Id$
  * @package    wpbase
  * @author     Wordpress Opal  Team <opalwordpress@gmail.com>
  * @copyright  Copyright (C) 2015 www.wpopal.com. All Rights Reserved.
  * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
  *
  * @website  http://www.wpopal.com
  * @support  http://www.wpopal.com/questions/
  */

  define( 'PBR_THEMER_PLUGIN_THEMER_URL', plugin_dir_url( __FILE__ ) );
  define( 'PBR_THEMER_PLUGIN_THEMER_DIR', plugin_dir_path( __FILE__ )  );
  define( 'PBR_THEMER_PLUGIN_THEMER_TEMPLATE_DIR', PBR_THEMER_PLUGIN_THEMER_DIR.'metabox_templates/' );

  include_once( dirname( __FILE__ ) . '/import/import.php' );
  include_once( dirname( __FILE__ ) . '/export/export.php' );

  require 'plugin-updates/plugin-update-checker.php';
  $ExampleUpdateChecker = PucFactory::buildUpdateChecker(
    'http://wpopal.com/themeframework/pbrthemer.json',
    __FILE__,
    'pbrthemer'
  ); 
  /**
   * Loading Widgets
   */
  function pbrthemer_load_custom_wp_admin_style() {
          wp_enqueue_style( 'pbrthemer-admin-css', PBR_THEMER_PLUGIN_THEMER_URL.'assets/css/admin.css');
          wp_enqueue_style( 'pbrthemer-admin-css' );
  }
  add_action( 'admin_enqueue_scripts', 'pbrthemer_load_custom_wp_admin_style' );
  function pbr_themer_widgets_init(){ 

    if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
        require( PBR_THEMER_PLUGIN_THEMER_DIR.'woocommerce.php' );
    }

      require( PBR_THEMER_PLUGIN_THEMER_DIR.'function.templates.php' );
      require( PBR_THEMER_PLUGIN_THEMER_DIR.'setting.class.php' );
      require( PBR_THEMER_PLUGIN_THEMER_DIR.'widget.class.php' );
      
      define( "PBR_THEMER_PLUGIN_THEMER", true );
      define( 'PBR_THEMER_PLUGIN_THEMER_WIDGET_TEMPLATES', get_template_directory().'/'  );

      $widgets = apply_filters( 'pbr_themer_load_widgets', array( 'contact-info', 'twitter','posts','featured_post','top_rate','sliders','recent_comment','recent_post','tabs','flickr', 'video', 'socials', 'menu_vertical', 'socials_siderbar','popupnewsletter') );


      if( !empty($widgets) ){
          foreach( $widgets as $opt => $key ){

              $file = str_replace( 'enable_', '', $key );
              $filepath = PBR_THEMER_PLUGIN_THEMER_DIR.'widgets/'.$file.'.php'; 
              if( file_exists($filepath) ){ 
                  require_once( $filepath );
              }
          }  
      }
  }
  add_action( 'widgets_init', 'pbr_themer_widgets_init' );

    
  /**
   * Loading Post Types
   */
  function pbr_themer_load_posttypes_setup(){
       

      $opts = apply_filters( 'pbr_themer_load_posttypes', get_option( 'pbr_themer_posttype' ) );
      if( !empty($opts) ){

          foreach( $opts as $opt => $key ){

              $file = str_replace( 'enable_', '', $opt );
              $filepath = PBR_THEMER_PLUGIN_THEMER_DIR.'posttypes/'.$file.'.php'; 
              if( file_exists($filepath) ){
                  require_once( $filepath );
              }
          }  
      }
  }   
  add_action( 'init', 'pbr_themer_load_posttypes_setup', 1 );   
  

if(!function_exists('pbr_string_limit_words')){
  function pbr_string_limit_words($string, $word_limit)
  {
    $words = explode(' ', $string, ($word_limit + 1));

    if(count($words) > $word_limit) {
      array_pop($words);
    }

    return implode(' ', $words);
  }
}