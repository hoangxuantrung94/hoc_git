<?php 
function pbrthemer_enable_megamenu_setting_fields( ) { 
    add_settings_field(
            'enable_megamenu', // ID
            'Enable Megamenu', // Title ,
             'pbrthemer_enable_megamenu_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_megamenu_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_megamenu_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_megamenu" name="pbr_themer_posttype[enable_megamenu]"  %s />',
        isset( $options['enable_megamenu'] ) && $options['enable_megamenu'] ?  'checked="checked"'  : ''
    );
}

