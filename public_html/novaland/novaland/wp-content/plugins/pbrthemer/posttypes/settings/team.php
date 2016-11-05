<?php 
function pbrthemer_enable_team_setting_fields( ) { 
    add_settings_field(
            'enable_team', // ID
            'Enable Team', // Title ,
             'pbrthemer_enable_team_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_team_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_team_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_team" name="pbr_themer_posttype[enable_team]"  %s />',
        isset( $options['enable_team'] ) && $options['enable_team'] ?  'checked="checked"'  : ''
    );
}

