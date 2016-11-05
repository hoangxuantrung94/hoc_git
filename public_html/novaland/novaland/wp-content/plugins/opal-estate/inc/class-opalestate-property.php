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
 * @class Opalestate_Property
 *
 * @version 1.0
 */
class Opalestate_Property {

	/**
	 * @var Integer $post_id
	 *
	 * @access protected
	 */
	public $post_id;

	/**
	 * @var array $metabox_info
	 *
	 * @access protected
	 */
	protected $metabox_info;

	/**
	 * @var float $price
	 *
	 * @access protected
	 */
	protected $price;

	/**
	 * @var float $saleprice
	 *
	 * @access protected
	 */
	protected $saleprice;

	/**
	 * @var String $map
	 *
	 * @access protected
	 */
	protected $map;

	/**
	 * @var Integer $address
	 *
	 * @access protected
	 */
	public $address;

	/**
	 * @var String $sku
	 *
	 * @access protected
	 */
	public $sku;

	/**
	 * @var String $latitude
	 *
	 * @access protected
	 */
	public $latitude;

	/**
	 * @var String $longitude
	 *
	 * @access protected
	 */
	public $longitude;

	/**
	 * @var Integer $featured 1 or 0
	 *
	 * @access protected
	 */
	public $featured;

	/**
	 * Constructor
	 */
	public function __construct( $post_id ){

		$this->post_id = $post_id;

		$this->map 		  = $this->get_metabox_value( 'map' );
		$this->address    = $this->get_metabox_value( 'address' );
		$this->price 	  = $this->get_metabox_value( 'price' );
		$this->pricelabel = $this->get_metabox_value( 'pricelabel' );
		$this->saleprice  = $this->get_metabox_value( 'saleprice' );
		$this->featured   = $this->get_metabox_value( 'featured' );
		$this->sku  	  = $this->get_metabox_value( 'sku' );
	

	

		$this->latitude   = isset($this->map['latitude'])   ?	$this->map['latitude'] : '';
		$this->longitude  = isset($this->map['longitude']) ? $this->map['longitude'] : ''; 
		
	}

	/**
	 * Get A Instance Of Opalestate_Property
	 */
	public static function getInstance( $post_id ){
		static $_instance; 
		if( !$_instance ){
			$_instance = new Opalestate_Property( $post_id );
		}
		return $_instance;
	}
	
	/**
	 * Gets Amenities
	 *
	 * @access public
	 * @param string $all
	 * @return array
	 */
	public function get_meta_fullinfo(){

		if( empty($this->metabox_info) ){

			$fields = Opalestate_PostType_Property::metaboxes_info_fields();

			foreach( $fields as $field ){
				$id = str_replace( OPALESTATE_PROPERTY_PREFIX, "", $field['id']);
				$this->metabox_info[$id] = array( 'label' => $field['name'] , 'value' => get_post_meta($this->post_id, $field['id'], true)  );
			}

		}
		return $this->metabox_info;
	}

	public function is_featured(){
		return $this->featured;
	}

	public function get_meta_search_objects(){
		$prop = new stdClass();
		$map  = $this->get_metabox_value('map');
		$url = wp_get_attachment_url( get_post_thumbnail_id($this->post_id) );
        $prop->id = $this->post_id;
        $prop->title = get_the_title();
        $prop->url = get_permalink( $this->post_id );

        $prop->lat =  $map['latitude'];
        $prop->lng =  $map['longitude'];
        $prop->address =  $this->address;

        $prop->pricehtml =  opalestate_price_format( $this->get_price() );
        $prop->pricelabel = $this->get_price_label();
        $prop->thumb = $url;

        if( file_exists(get_template_directory().'/images/map/market_icon.png') ){
        	$prop->icon = get_template_directory_uri().'/images/map/market_icon.png';
        }else {
        	 $prop->icon = OPALESTATE_PLUGIN_URL.'/assets/map/market_icon.png';
        }
       

        $prop->featured = $this->featured;

        $metas =  Opalestate_PostType_Property::metaboxes_info_fields();

        foreach( $metas as $key => $field ){
        	$id = str_replace( OPALESTATE_PROPERTY_PREFIX, "", $field['id']);
        	$prop->$id = get_post_meta($this->post_id, $field['id'], true);
        }
        $metas = $this->get_meta_shortinfo();
        if ( !empty($metas) ) {
        	foreach ($metas as $key => $value) {
        		$prop->{$key} = $value;
        	}
        }
        $prop->status = $this->render_statuses();
        return $prop;
	}
	/**
	 * Gets Amenities
	 *
	 * @access public
	 * @param string $all
	 * @return array
	 */
	public function get_meta_shortinfo(){

		$output = array();
		$meta = array ( 'amountrooms', 'bathrooms', 'bedrooms', 'parking' );
		$meta = apply_filters( 'opalestate_property_meta_shortinfo_fields', $meta );

		if( !empty($meta) ){
			$fields = $this->get_meta_fullinfo();


			foreach( $meta as $key => $value  ){
				if( isset($fields[$value]) ){
					$output[$value] = $fields[$value];
				}
			}
		}

		return $output;
	}

	/**
	 * Gets Amenities
	 *
	 * @access public
	 * @param string $all
	 * @return array
	 */
	public function get_amenities( $all=true ){

		if( $all ){
			$terms = Opalestate_Query::get_amenities();
		}else {
			$terms = wp_get_post_terms( $this->post_id, 'opalestate_amenities' );
		}
		return $terms;
	}

	public function get_locations(){
		
		$terms = wp_get_post_terms( $this->post_id, 'opalestate_location' );

		if( $terms ){
			return $terms; 
		}
		return array();
	}
 	/**
	 * Gets locations
	 *
	 * @access public
	 * @return array
	 */
 	public function render_locations(){
		$terms = wp_get_post_terms( $this->post_id, 'opalestate_location' );
		if( $terms ){
			$output = '<span class="property-locations">';
			foreach( $terms as $term  ){
				$output .= '<a href="'.get_term_link( $term->term_id ).'" class="location-name">'.$term->name.'</a>';
			}
			$output .= '</span>';
			echo $output;
		}
		
	}
	/**
	 * Gets types
	 *
	 * @access public
	 * @return array
	 */
	public function get_status(){
		$terms = wp_get_post_terms( $this->post_id, 'opalestate_status' );
		return $terms;
	}

	public function render_statuses(){
		$types = $this->get_status();

		if( empty($types) ){
			return ;
		}

		$output = '<ul class="property-status">';
		foreach( $types as $key => $value ){
			$output .= '<li class="property-type-item"><span>'.$value->name.'</span></li>';
		}
		$output .= '</ul>';

		return $output;
	}
	public function getAuthor(){

	}

	public function render_author_link(){

		$userId = $this->get_metabox_value( 'agent' ); 
		
		if( $userId ){
			$agent =  get_post( $userId );  
			$url = OpalEstate_Agent::get_avatar_url( $userId );
			$avatar = $url ? '<img class="avatar" src="'.$url.'" alt="" />':"";
			return !$agent ? __('Unknow Agent', 'opalestate'): '<a href="'.get_permalink($agent->ID).'" class="author-link">'.$avatar.'<span>'. $agent->post_title.'</span>'.'</a>';
		}else {
			
			$author = get_the_author();
    		$authorlink = get_author_posts_url( get_the_author_meta( 'ID' ) );
    		$url = get_avatar_url( get_the_author_meta( 'email' ) );
    		$avatar = $url ? '<img class="avatar" src="'.$url.'" alt="" />':"";
			return !$authorlink ? __('Unknow Agent', 'opalestate'): '<a href="'.$authorlink.'" class="author-link">'.$avatar.'<span>'. $author.'</span>'.'</a>';

		}
	}
	/**
	 * Gets status
	 *
	 * @access public
	 * @return array
	 */
	public function get_category_tax(){
		$terms = wp_get_post_terms( $this->post_id, 'property_category' );
		return $terms;
	}

	public function get_types_tax(){
		$terms = wp_get_post_terms( $this->post_id, 'opalestate_types' );
		return $terms;
	}

	/**
	 * Gets meta box value
	 *
	 * @access public
	 * @param $key
	 * @param $single
	 * @return string
	 */
	public function get_metabox_value( $key, $single = true ) {
		return get_post_meta( $this->post_id, OPALESTATE_PROPERTY_PREFIX.$key, $single );
	}
	/**
	 * Gets map value
	 *
	 * @access public
	 * @return string
	 */
	public function getMap(){
		return $this->map;
	}
	/**
	 * Gets address value
	 *
	 * @access public
	 * @return string
	 */
	public function get_address(){
		return $this->address;
	}
	/**
	 * Gets video url value
	 *
	 * @access public
	 * @return string
	 */
	public function getVideoURL(){
		return $this->get_metabox_value( 'video' );
	}

	/**
	 * Gets gallery ids value
	 *
	 * @access public
	 * @return array
	 */
	public function getGallery() {
		return $this->get_metabox_value( 'gallery', false );
	}

	/**
	 * Gets price value
	 *
	 * @access public
	 * @return string
	 */
	public function get_price() {
		return $this->price;
	}

	/**
	 * Gets price value
	 *
	 * @access public
	 * @return string
	 */
	public function get_price_label(){
		return $this->pricelabel;
	}

	/**
	 * Gets sale price value
	 *
	 * @access public
	 * @return string
	 */
	public function get_sale_price() {
		return $this->saleprice;
	}
	/**
	 * Gets price format value
	 *
	 * @access public
	 * @return string
	 */
	public function get_format_price() {
		return $this->get_metabox_value( 'formatprice' );
	}

	public function enable_google_mapview(){
		return $this->get_metabox_value( 'enablemapview' );
	}

	public function get_google_map_link(){
		$url = 'https://maps.google.com/maps?q='.$this->address.'&ll='.$this->latitude.','.$this->longitude.'&z=17';
		return $url;
	}
	public static function is_allowed_remove( $user_id, $item_id ) {
		$item = get_post( $item_id );

		if ( ! empty( $item->post_author ) ) {
			if ( $item->post_author == $user_id ) {
				return true;
			}
		}

		return false;
	}

	public function get_facilities(){
		return $this->get_metabox_value( 'public_facilities_group' );
	}

	public function get_attachments(){
		return $this->get_metabox_value( 'attachments' );
	}

}