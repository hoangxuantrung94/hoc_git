<?php 
	$package_id 			  = get_the_ID();
	$pack_listings            =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_listings', true );
	$pack_featured_listings   =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_featured_listings', true );
	$pack_unlimited_listings  =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'unlimited_listings', true );

?>
<div class="pricing-more-info">
	<div class="item-info">
		<span>
			<?php if( !empty($pack_listings)): ?>
				<?php echo trim( $pack_listings); ?><?php esc_html_e( ' Listings' , 'opalestate' );?>
			<?php else: ?>
				<?php esc_html_e('Unlimited', 'opalestate');?><?php esc_html_e( ' Listings' , 'opalestate' );?>
			<?php endif; ?>
		</span>
	</div>
	<div class="item-info">
		<span>
			<?php if( !empty($pack_featured_listings)): ?>
				<?php echo trim( $pack_listings); ?><?php esc_html_e( ' Featured' , 'opalestate' );?>
			<?php else: ?>
				<?php esc_html_e('Unlimited', 'opalestate');?><?php esc_html_e( ' Featured' , 'opalestate' );?>
			<?php endif; ?>
		</span>
	</div>
</div>