<?php 
function pbrthemer_enable_faq_setting_fields( ) { 
    add_settings_field(
            'enable_faq', // ID
            'Enable Faq', // Title ,
             'pbrthemer_enable_faq_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_faq_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_faq_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_faq" name="pbr_themer_posttype[enable_faq]"  %s />',
        isset( $options['enable_faq'] ) && $options['enable_faq'] ?  'checked="checked"'  : ''
    );
}

