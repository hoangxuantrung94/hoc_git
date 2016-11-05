<?php 
function pbrthemer_enable_testimonials_setting_fields( ) { 
    add_settings_field(
            'enable_testimonials', // ID
            'Enable Testimonials', // Title ,
             'pbrthemer_enable_testimonials_callback', // Callback
            'pbrframework-setting-admin', // Page
            'setting_section_id' // Section           
        );  
}
add_action( 'pbrthemer_add_setting_field', 'pbrthemer_enable_testimonials_setting_fields' ); 

/** 
 * Get the settings option array and print one of its values
 */
function pbrthemer_enable_testimonials_callback()
{
	$options = get_option( 'pbr_themer_posttype' );
    printf(
        '<input type="checkbox" id="enable_testimonials" name="pbr_themer_posttype[enable_testimonials]"  %s />',
        isset( $options['enable_testimonials'] ) && $options['enable_testimonials'] ?  'checked="checked"'  : ''
    );
}

