<?php 
function pbrthemer_enable_gallery_setting_fields( ) { 
    add_settings_field(
            'enable_gallery', // ID
            'Enable Gallery', // Title ,
             'pbrthemer_enable_gallery_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_gallery_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_gallery_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_gallery" name="pbr_themer_posttype[enable_gallery]"  %s />',
        isset( $options['enable_gallery'] ) && $options['enable_gallery'] ?  'checked="checked"'  : ''
    );
}

