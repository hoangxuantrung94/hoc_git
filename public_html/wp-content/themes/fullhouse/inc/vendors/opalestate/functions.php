<?php


function fullhouse_fnc_get_template_link_by_file( $file ){
    $pages = get_pages(array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $file
    ));

    if( $pages ){
        $pageLink = get_permalink( $pages[0]->ID);
    }else{
        $pageLink = home_url();
    }
    return $pageLink;
}

/**
 * Hook to account menu which displaying in Top Right.
 */

add_action('opal_account_dropdown_content', 'opalestate_management_user_menu');
/**
 * Hook Layout
 */
function fullhouse_fnc_get_single_property_sidebar_configs( $configs='' ){

	$left  =  fullhouse_fnc_theme_options( 'opalestate-single-left-sidebar' ); 

	$right =  fullhouse_fnc_theme_options( 'opalestate-single-right-sidebar' );

	return fullhouse_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fullhouse_fnc_get_single_property_sidebar_configs', 'fullhouse_fnc_get_single_property_sidebar_configs', 1, 1 );

function fullhouse_fnc_get_archive_property_sidebar_configs( $configs='' ){

	$left  =  fullhouse_fnc_theme_options( 'opalestate-archive-left-sidebar' ); 

	$right =  fullhouse_fnc_theme_options( 'opalestate-archive-right-sidebar' );

	return fullhouse_fnc_get_layout_configs( $left, $right );
}

add_filter( 'fullhouse_fnc_get_archive_property_sidebar_configs', 'fullhouse_fnc_get_archive_property_sidebar_configs', 1, 1 );

function fullhouse_fnc_add_social_share(){
    get_template_part( 'page-templates/parts/sharebox' );
}
add_action( 'opalestate_single_content_bottom',  'fullhouse_fnc_add_social_share', 9999  );