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

/**
 * @class OpalEstate_Shortcodes
 *
 * @version 1.0
 */
class OpalEstate_Shortcodes{

	/**
	 * Static $shortcodes
	 */
	static $shortcodes;

	/**
	 * defined list of shortcode and functions of this for each.
	 */
	public static function init(){

	 	self::$shortcodes = array(
	 		'change_agent_profile' 		=> array( 'code' => 'change_agent_profile', 'label' => __( 'Agent Profile', 'opalestate' ) ),
	 		'search_properties_result'	=> array( 'code' => 'search_properties_result', 'label' => __( 'Search Properties Result', 'opalestate' ) ),
	 		'search_properties'    		=> array( 'code' => 'search_properties', 'label'    => __( 'Search Properties', 'opalestate' ) ),
	 		'search_properties_v'  		=> array( 'code' => 'search_properties_v', 'label'  => __( 'Search Properties Vertical', 'opalestate' ) ),
	 		'search_agents'		   		=> array( 'code' => 'search_agents', 'label' 	   => __( 'Search Agents', 'opalestate' ) ),
	 	);

	 	foreach( self::$shortcodes as $shortcode ){
	 		add_shortcode( 'opalestate_'.$shortcode['code'] , array( __CLASS__, $shortcode['code'] ) );
	 	}

	 	if( is_admin() ){
	 		add_action( 'media_buttons', array( __CLASS__, 'shortcode_button' ) );
	 	}

	}
	public static function shortcode_button(){
		
	}

	public static function search_properties_result(){
		echo Opalestate_Template_Loader::get_template_part( 'shortcodes/search-properties-result' );
	}

	public static function search_agents(){
		echo Opalestate_Template_Loader::get_template_part( 'shortcodes/search-agents' );
	}
	/**
	 * Display all properties follow user when logined
	 */
	public static function agent_property(){

		echo Opalestate_Template_Loader::get_template_part( 'shortcodes/agent-property-listing' );
	}

	/**
	 * Render search property page with horizontal form and map
	 */
	public static function search_properties(){
		echo Opalestate_Template_Loader::get_template_part( 'shortcodes/search-properties', array( 'loop' => '') );
	}

	/**
	 * Render search property page with vertical form and map
	 */
	public static function search_properties_v(){
		echo Opalestate_Template_Loader::get_template_part( 'shortcodes/search-properties-v', array( 'loop' => '') );
	}
}

OpalEstate_Shortcodes::init();
