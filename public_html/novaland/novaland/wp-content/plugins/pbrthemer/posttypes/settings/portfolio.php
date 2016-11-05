<?php 
function pbrthemer_enable_portfolio_setting_fields( ) { 
    add_settings_field(
            'enable_portfolio', // ID
            'Enable Portfolio', // Title ,
             'pbrthemer_enable_portfolio_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_portfolio_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_portfolio_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_portfolio" name="pbr_themer_posttype[enable_portfolio]"  %s />',
        isset( $options['enable_portfolio'] ) && $options['enable_portfolio'] ?  'checked="checked"'  : ''
    );
}

