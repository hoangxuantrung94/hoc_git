<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
 $productConfig = array(     
  'product_enablezoom'         => 1,
  'product_zoommode'           => 'basic',
  'product_zoomeasing'         => 1,
  'product_zoomlensshape'      => "round",
  'product_zoomlenssize'       => "150",
  'product_zoomgallery'        => 0,
  'enable_product_customtab'   => 0,
  'product_customtab_name'     => '',
  'product_customtab_content'  => '',
  'product_related_column'     => 0,        
);

global $post, $woocommerce, $product;

?>
<div class="images row">
	<div class="col-lg-9 col-md-9">
	<?php
		if ( has_post_thumbnail() ) {

			$image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );

			list( $popupsrc, $popup_width, $popup_height ) = wp_get_attachment_image_src( get_post_thumbnail_id(), "shop_magnifier" );

			$image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title'	=> $image_title,
				'alt'	=> $image_title,
				'data-zoom-image'	=> $image_link,
				'id'	=> 'image'
				) );

			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="woocommerce-main-image ">%s</div>',  $image ), $post->ID );

		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );
		}
	?>
	</div>
	<div class="col-lg-3 col-md-3">
		<?php do_action( 'woocommerce_product_thumbnails' ); ?>
	</div>

</div>
<script type="text/javascript">
(function ($, window, document) { 
	if( $("body").width() > 700 ){ 
	    var zoomCollection = '<?php echo $productConfig["product_zoomgallery"]=="basic"?"#image":"#image";?>';
	    $( zoomCollection ).elevateZoom({
		    <?php if( $productConfig['product_zoommode'] != 'basic' ) { ?>
		    zoomType        : "<?php echo $productConfig['product_zoommode'];?>",
		    <?php } ?>
		    lensShape : "<?php echo $productConfig['product_zoomlensshape'];?>",
		    lensSize    : <?php echo (int)$productConfig['product_zoomlenssize'];?>,
		    easing:true,
		    gallery:'image-additional-carousel',
		    cursor: 'pointer',
		    galleryActiveClass: "active"
		  });
	}    
})(jQuery);


	 
</script>