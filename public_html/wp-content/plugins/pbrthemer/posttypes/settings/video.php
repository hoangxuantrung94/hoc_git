<?php 
function pbrthemer_enable_video_setting_fields( ) { 
    add_settings_field(
            'enable_video', // ID
            'Enable Video', // Title ,
             'pbrthemer_enable_video_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_video_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_video_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_video" name="pbr_themer_posttype[enable_video]"  %s />',
        isset( $options['enable_video'] ) && $options['enable_video'] ?  'checked="checked"'  : ''
    );
}

