<?php
/**
 * Count Number of listing following user
 */
function opalesate_get_user_current_listings( $user_id ){
	$args = array(
        'post_type'   => 'opalestate_property',
        'post_status' => array( 'pending', 'publish' ),
        'author'      => $user_id,

    );
    $posts = new WP_Query( $args );
    return $posts->found_posts;
    wp_reset_postdata();
}

/**
 * Count Number of featured listing following user
 */
function opalesate_get_user_current_featured_listings( $user_id ){

	$args = array(
        'post_type'     =>  'opalestate_property',
        'post_status'   =>  array( 'pending', 'publish' ),
        'author'        =>  $user_id,
        'meta_query'    =>  array(
            array(
                'key'   => OPALESTATE_PROPERTY_PREFIX.'featured',
                'value' => 1,
                'meta_compare '=>'='
            )
        )
    );
    $posts = new WP_Query( $args );
    return $posts->found_posts;
    wp_reset_postdata();
}

/**
 * Check current package is downgrade package or not via current number of featured, listing lesser
 */
function opalesate_check_package_downgrade_status( $user_id, $package_id ){

	$pack_listings            =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_listings', true );
	$pack_featured_listings   =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_featured_listings', true );
	$pack_unlimited_listings  =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'unlimited_listings', true );

    $user_current_listings          = opalesate_get_user_current_listings( $user_id );
    $user_current_featured_listings = opalesate_get_user_current_featured_listings( $user_id );

    $current_listings               =  get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings',true);

    if( $pack_unlimited_listings == 1 ) {
        return false;
    }

    // if is unlimited and go to non unlimited pack
    if ( $current_listings == -1 && $pack_unlimited_listings != 1 ) {
        return true;
    }

    return ( $user_current_listings > $pack_listings ) || ( $user_current_featured_listings > $pack_featured_listings ) ;
}

/**
 * Check Current User having permission to add new property or not?
 */
function opalesate_check_has_add_listing( $user_id, $package_id=null ){

    if( !$package_id ){
        $package_id = (int)get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_id', true );
    }
    $pack_listings            =  (int) get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', true );
    $pack_unlimited_listings  =  (int) get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'unlimited_listings', true );
 
    if( $pack_unlimited_listings ){
        return true; 
    }
    if( $pack_listings  > 0 ){
        return true; 
    }
    return false;
}

/**
 * Check current package is downgrade package or not via current number of featured, listing lesser
 */
function opalesate_get_user_featured_remaining_listing( $user_id ){

    $count = get_the_author_meta( OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings' , $user_id );

    return $count;
}

/**
 * Update remaining featured listings
 */
function opalesate_update_package_number_featured_listings( $user_id ) {

    $current = get_the_author_meta( OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings' , $user_id );

    if( $current-1 >= 0 ) {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', $current-1 ) ;
    } else {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', 0 );
    }
}

/**
 * Update remaining featured listings
 */
function opalesate_update_package_number_listings( $user_id ) {

    $current = get_the_author_meta( OPALMEMBERSHIP_USER_PREFIX_.'package_listings' , $user_id );

    if( $current-1 >= 0 ) {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', $current-1 ) ;
    } else {
        update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', 0 );
    }
}


/**
 * Check
 */
function opalesate_is_membership_valid( $user_id = null ){
   return Opalmembership_User::is_membership_valid( $user_id );
}
 
    
/**
 *
 */
function opalesate_listing_set_to_expire($post_id){

    $prop = array(

        'ID'            => $post_id,
        'post_type'     => 'opalestate_property',
        'post_status'   => 'expired'
    
    );

    wp_update_post($prop );

    $post = get_post( $post_id );
    $user_id = $post->post_author;

    $user       =   get_user_by('id', $user_id);
    $user_email =   $user->user_email;

    $args = array(
        'expired_listing_url'  => get_permalink($post_id),
        'expired_listing_name' => get_the_title($post_id)
    );
    
    opalesate_email_type( $user_email, 'listing_expired', $args );
}