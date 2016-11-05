<?php 
function pbrthemer_enable_footer_setting_fields( ) { 
    add_settings_field(
            'enable_footer', // ID
            'Enable Footer', // Title ,
             'pbrthemer_enable_footer_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_footer_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_footer_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_footer" name="pbr_themer_posttype[enable_footer]"  %s />',
        isset( $options['enable_footer'] ) && $options['enable_footer'] ?  'checked="checked"'  : ''
    );
}

