<?php 
function pbrthemer_enable_brands_setting_fields( ) { 
    add_settings_field(
            'enable_brands', // ID
            'Enable Brand', // Title ,
             'pbrthemer_enable_brands_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_brands_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_brands_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_brands" name="pbr_themer_posttype[enable_brands]"  %s />',
        isset( $options['enable_brands'] ) && $options['enable_brands'] ?  'checked="checked"'  : ''
    );
}

