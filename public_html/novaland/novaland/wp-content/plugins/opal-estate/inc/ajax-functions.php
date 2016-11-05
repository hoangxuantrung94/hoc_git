<?php 
/**
 * $Desc$
 *
 * @version    $Id$
 * @package    opalestate
 * @author     Opal  Team <info@wpopal.com >
 * @copyright  Copyright (C) 2016 wpopal.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/support/forum.html
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if (!function_exists('opalestate_process_send_email')) {
	function opalestate_process_send_email() {

		$name     = sanitize_text_field( $_POST['name'] );
		$email    = sanitize_email( $_POST['email'] );
		$message  = sanitize_text_field( $_POST['message'] );
		$post_id  = intval( $_POST['post_id'] );
		$agent_id = intval( $_POST['agent_id'] );
		$cc_me 	  = isset( $_POST['cc_me'] ) ?  absint( $_POST['cc_me'] ) : 0;
		$author_id 	  = isset( $_POST['author_id'] ) ?  absint( $_POST['author_id'] ) : "";

		$subject = opalestate_get_option('contact_email_subject', __('You got a message', 'opalestate') );
		
		$default = trim(preg_replace('/\t+/', '', "Hi {receive_name},<br>
							You have got message from {name} with email {email}. Here is detail:
						 <br>
						<br>
						{message}
						<br>
						&nbsp;<br>
						<br>
						<em>This message was sent by {site_link} on {current_time}.</em>")); 

		$from_name 	= opalestate_get_option('from_name');
		$from_email = opalestate_get_option('from_email');
		$headers 	= sprintf( "From: %s <%s>\r\n Content-type: text/html", $from_name, $from_email );
		$agent_email = $receive_name = '';
		
		if( $agent_id ){
			$agent 		  = get_post( $agent_id );
			$agent_email  = get_post_meta( $agent_id, OPALESTATE_AGENT_PREFIX . 'email', true );
			$receive_name = $agent->post_title;
		}

		if( $author_id > 0 && $agent_id  == 0 &&  $post_id == 0 ){
			$user = get_user_by('id', $author_id );
			$agent_email = $user->data->user_email; 
			$receive_name = $user->data->display_name; 
		}

		if ( !empty($post_id) && get_post_type( $post_id ) == 'opalestate_property' ) {
			$property_link = get_permalink( $post_id );
			$property_name = get_the_title( $post_id );
		} else {
			$property_link = '';
			$property_name  = '';
		}
		$site_link 	  = get_home_url();
		$current_time = date("F j, Y, g:i a");
							
		$tags = array("{receive_name}", "{name}", "{email}", "{property_link}", "{message}", "{property_name}", "{site_link}","{current_time}");

		$values = array($receive_name, $name, $email, $property_link, $message, $property_name, $site_link, $current_time );

		$body   = opalestate_get_option('contact_email_body', $default );

 		

		$subject = html_entity_decode($subject);
		$subject = str_replace($tags, $values, $subject);

		$body 	 = html_entity_decode($body);
		$message = str_replace($tags, $values, $body);

		if( $receive_name &&  $agent_email ) {
			if( $cc_me ){
				$status = wp_mail( $email, sprintf( __('You sent a message for %s', 'opalestate') , $receive_name),  $subject, $message, $headers );
		 	}
	 	

			$status = wp_mail( $agent_email, $subject, $message, $headers );


			if ( ! empty( $status ) && 1 == $status  ) {
				$return = array( 'status' => 'success', 'msg' => __( 'Message has been successfully sent.', 'opalestate' ) );
				echo json_encode($return); die();
			}  
		}
		$return = array( 'status' => 'danger', 'msg' => __( 'Unable to send a message.', 'opalestate' ) );
		echo json_encode($return); die();
	}
}

add_action( 'wp_ajax_send_email_contact', 'opalestate_process_send_email' );
add_action( 'wp_ajax_nopriv_send_email_contact', 'opalestate_process_send_email' );

/* set feature property */
add_action( 'wp_ajax_opalestate_set_feature_property', 'opalestate_set_feature_property' );
add_action( 'wp_ajax_nopriv_opalestate_set_feature_property', 'opalestate_set_feature_property' );
if ( ! function_exists( 'opalestate_set_feature_property' ) ) {
	function opalestate_set_feature_property() {

		if ( ! isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( $_REQUEST['nonce'], 'nonce' ) ) return;
		if ( ! isset( $_REQUEST['property_id'] ) ) return;
		update_post_meta( absint( $_REQUEST['property_id'] ), OPALESTATE_PROPERTY_PREFIX . 'featured', 1 );

		wp_redirect( admin_url( 'edit.php?post_type=opalestate_property' ) ); exit();
	}
}
/* remove feature property */
add_action( 'wp_ajax_opalestate_remove_feature_property', 'opalestate_remove_feature_property' );
add_action( 'wp_ajax_nopriv_opalestate_remove_feature_property', 'opalestate_remove_feature_property' );
if ( ! function_exists( 'opalestate_remove_feature_property' ) ) {
	function opalestate_remove_feature_property() {
		if ( ! isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( $_REQUEST['nonce'], 'nonce' ) ) return;

		if ( ! isset( $_REQUEST['property_id'] ) ) return;

		update_post_meta( absint( $_REQUEST['property_id'] ), OPALESTATE_PROPERTY_PREFIX . 'featured', '' );
		wp_redirect( admin_url( 'edit.php?post_type=opalestate_property' ) ); exit();
	}
}

/**
 * Set Featured Item Following user
 */
add_action( 'wp_ajax_opalestate_toggle_featured_property', 'opalestate_toggle_featured_property' );
add_action( 'wp_ajax_nopriv_opalestate_toggle_featured_property', 'opalestate_toggle_featured_property' );

function opalestate_toggle_featured_property(){
	 	
 	global $current_user;
    wp_get_current_user();
    $user_id =   $current_user->ID;

    $property_id = intval( $_POST['property_id'] );
    $post = get_post( $property_id );

    if( $post->post_author == $user_id ) {
   
      	$check = apply_filters( 'opalestate_set_feature_property_checked', false );
        if( $check ) {
            do_action( 'opalestate_toggle_featured_property_before', $user_id, $property_id );
            update_post_meta( $property_id, OPALESTATE_PROPERTY_PREFIX . 'featured', 1 );
            echo json_encode( array( 'status' => true, 'msg' => __('Could not set this as featured','opalestate') ) );
            wp_die();
        } 
    }  

    echo json_encode( array( 'status' => false, 'msg' => __('Could not set this as featured','opalestate') ) );
    wp_reset_query();
    wp_die();
 
}
