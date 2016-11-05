<?php 
/**
 *
 */
function pbrthemer_woocommerce_scripts(){
	wp_enqueue_script( 'pbrthemer-elevatezoom', plugins_url('assets/js/elevatezoom/elevatezoom-min.js', __FILE__) );
}

function pbr_themer_load_zoom_images(){
	if ( function_exists('yith_wcmg_is_enabled') && yith_wcmg_is_enabled () && ! apply_filters ( 'yith_wczm_featured_video_enabled', false ) ) {
	}else {
		add_action( 'wp_enqueue_scripts', 'pbrthemer_woocommerce_scripts', 999 );


		remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
		remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);


		add_action('woocommerce_before_single_product_summary', 'pbrthemer_woocommerce_show_product_images', 20);
		add_action('woocommerce_product_thumbnails', 'pbrthemer_woocommerce_show_product_thumbnails', 20);
	}	
}
add_action('init','pbr_themer_load_zoom_images', 99);

/**
 *
 */
function pbrthemer_woocommerce_show_product_images(){
	$layout = apply_filters( 'pbrthemer_woocommerce_show_product_images', 'product-image' );
	require(PBR_THEMER_PLUGIN_THEMER_DIR .'templates/woocommerce/'.$layout.'.php');
}

/**
 *
 */
function pbrthemer_woocommerce_show_product_thumbnails(){
	$layout = apply_filters( 'pbrthemer_woocommerce_show_product_thumbnails', 'product-thumbnails' );
	require(PBR_THEMER_PLUGIN_THEMER_DIR .'templates/woocommerce/'.$layout.'.php');

}
