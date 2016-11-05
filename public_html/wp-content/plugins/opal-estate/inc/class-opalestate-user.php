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
 
class OpalEstate_User{

	public $id;

	/**
	 *
	 */
	public function __construct( ){

		define( "OPALESTATE_USER_PROFILE_PREFIX", 'opalestate_user_');
		 
		 
		add_filter( 'cmb2_meta_boxes', array( $this, 'front_edit_fields' ) );
	 

		$shortcodes = array(
	 		'user_profile'		   =>  array( 'code' => 'user_profile', 'label' => __( 'User Profile', 'opalestate' ) ),
	 	);
		
	 	foreach( $shortcodes as $shortcode ){
	 		add_shortcode( 'opalestate_'.$shortcode['code'] , array( __CLASS__, $shortcode['code'] ) );
	 	}

	 	if( is_admin() ){
	 		add_action( 'media_buttons', array( __CLASS__, 'shortcode_button' ) );
	 		add_action( 'cmb2_admin_init', array( $this, 'register_user_profile_metabox')   );
	 	}

 		add_action( 'cmb2_render_text_password', array( __CLASS__,'cmb2_render_text_password' ), 10, 5 );
	 	/**
	 	 * Ajax action
	 	 */
		add_action( 'wp_ajax_opalestate_save_changepass', array($this,'save_change_password') );
		add_action( 'wp_ajax_nopriv_opalestate_save_changepass', array($this,'save_change_password') );
		
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts') );  

		add_action( 'init', array( __CLASS__, 'process_submission' ), 100000 );


		/**
	 	 * Check User  Block Submission
	 	 */
		add_action( 'opalestate_submission_form_before'	, array( __CLASS__,'show_message'), 9 ); 	
		add_action( 'opalestate_before_process_ajax_upload_file' , array( __CLASS__, 'check_blocked' ) );
		add_action( 'opalestate_before_process_ajax_upload_user_avatar' , array( __CLASS__, 'check_blocked' ) );
		add_action( 'opalestate_profile_form_process_before' , array( __CLASS__, 'check_blocked' ) );
		add_action( 'opalestate_toggle_featured_property_before' , array( __CLASS__, 'check_blocked' ) );
		

		add_action( 'wp_before_admin_bar_render', array( __CLASS__, 'disable_profile_page' )  );
		add_action( 'admin_init', array( __CLASS__, 'disable_profile_page' )  );

	}

	public static function disable_profile_page(){

		// Remove AdminBar Link
	    if ( 
	        'wp_before_admin_bar_render' === current_filter()
	        && ! current_user_can( 'manage_options' )
	    )
	        return $GLOBALS['wp_admin_bar']->remove_menu( 'edit-profile', 'user-actions' );

	    // Remove (sub)menu items
	  //  remove_menu_page( 'profile.php' );
		  remove_submenu_page( 'users.php', 'profile.php' );

	    // Deny access to the profile page and redirect upon try
	    if ( 
	        defined( 'IS_PROFILE_PAGE' )
	        && IS_PROFILE_PAGE
	        && ! current_user_can( 'manage_options' )
	        )
	    {
	       // wp_redirect( admin_url() );
	        exit;
	    }

	}

	public static function show_message(){
		if( self::is_blocked() ){

			echo apply_filters( 'opalestate_user_block_submission_message', '<div class="alert alert-danger">'.__('Your account is blocked form submission, you could not submit any more.', 'opalestate').'</div>' );
		}
	}

	public static function check_blocked(){  
		$check =  self::is_blocked();
		if( $check ){
			$std = new stdClass();
			$output->status = false ;
			$output->message = __( 'Your account is blocked, you could not complete this action','opalestate' );
			$output->msg = $output->message;
			echo  json_encode( $output );  wp_die();
		}
	}

	/**
	 *
	 */
	public static function process_submission(){
		
		global $current_user;
		 // Verify Nonce
		$user_id = get_current_user_id();
		$check 	=  self::is_blocked();

		$key = 'nonce_CMB2phpopalestate_user_front';

		if( !isset($_POST[$key]) || empty($_POST[$key]) || !is_user_logged_in()	|| $check ){
			return ;
		}
				
		if( isset($_POST['profile-picture-id']) && !empty($_POST['profile-picture-id']) && (int)$_POST['profile-picture-id'] > 0 ){

			$_POST[OPALESTATE_USER_PROFILE_PREFIX.'avatar']   = wp_get_attachment_url($_POST['profile-picture-id']);
			$_POST[OPALESTATE_USER_PROFILE_PREFIX.'avatar_id'] = intval($_POST['profile-picture-id']);
			update_user_meta( $user_id, OPALESTATE_USER_PROFILE_PREFIX . 'avatar_id', $_POST['profile-picture-id'] );
			update_user_meta( $user_id, OPALESTATE_USER_PROFILE_PREFIX . 'avatar', $_POST[OPALESTATE_USER_PROFILE_PREFIX.'avatar']  );

			delete_post_meta( $_POST['profile-picture-id'], '_pending_to_use', 1 );
		}
	}

	public static function is_blocked(){
		global $current_user;
		 // Verify Nonce
		$user_id = get_current_user_id(); 	
		
		if( $user_id <= 0 ){
			return true;
		}

		$blocked 	= get_user_meta( $user_id, OPALESTATE_USER_PROFILE_PREFIX . 'block_submission', true ); 

		return $blocked; 
	}
	/**
	 *
	 */
	public static function get_avatar_url( $user_id ){
		
		return  get_avatar_url( $user_id );
	}

	/**
	 *
	 */
	public static function get_author_picture( $user_id ){
		
		$avatar 	= get_user_meta( $user_id, OPALESTATE_USER_PROFILE_PREFIX . 'avatar', true );

		if( !$avatar  ){
			$avatar = opalestate_get_image_placeholder( 'author-picture', true );
		}
		return  $avatar;

	}

	/**
	 *
	 */
	public static function shortcode_button(){

	}

	/**
	 *
	 */
 	public function save_change_password(){

 		global $current_user;

 		$nonce = 'nonce_CMB2phpopalestate_user_frontchangepass';
 		if( !isset($_POST[$nonce], $_POST['oldpassword'], $_POST['new_password'], $_POST['confirm_password'] ) || !wp_verify_nonce( $_POST[$nonce], $nonce ) ){
 			return false;
 		}
 		
 		do_action( 'opalestate_profile_form_process_before' );
 		$output = new stdClass();
 		$output->status = false;
 		$output->message = __( 'Found a problem while updating', 'opalestate' );

        wp_get_current_user();

        $userID         = $current_user->ID;

 		$oldpassword	  = $_POST['oldpassword'];
 		$new_password 	  = $_POST['new_password'];
 		$confirm_password = $_POST['confirm_password'];

 		if( empty($oldpassword) ||  empty($new_password) || empty($confirm_password ) ){
 			$output->message = __( 'passwords fields are not empty', 'opalestate' );  
 			echo json_encode( $output );exit;
 		}
 		
 		if( $new_password != $confirm_password ){
 			$output->message = __( 'New password is not same confirm password', 'opalestate' );  
 			echo json_encode( $output );exit;
 		}

 		
		$user = get_user_by( 'id', $userID );
        if( $user && wp_check_password( $oldpassword, $user->data->user_pass, $userID ) ) {
            wp_set_password( $new_password, $userID );
            $output->status = true;
            $output->message = __( 'Password Updated', 'opalestate' );
        } else {
            $output->message = __( 'Old password is not correct', 'opalestate' );
        }
  
        echo json_encode( $output );
        die();
 	}

	/**
	 * Hook in and add a metabox to add fields to the user profile pages
	 */
	public function register_user_profile_metabox() {

		
		$prefix = OPALESTATE_USER_PROFILE_PREFIX;
	
		/**
		 * Metabox for the user profile screen
		 */
		$cmb_user = new_cmb2_box( array(
			'id'               => $prefix . 'edit',
			'title'            => __( 'User Profile Metabox', 'cmb2' ), // Doesn't output for user boxes
			'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
			'show_names'       => true,
			'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
		) );

		$fields = self::extra_info_fields();
		foreach( $fields as $field ){
			$cmb_user->add_field( $field  );
		}
		
	}

	

	/**
	 *
	 */
	public static function extra_info_fields(){
		$prefix = OPALESTATE_USER_PROFILE_PREFIX;
		$a = null;
		
		$management = array(
				array(
					'name'    => __( 'Avatar Pictures', 'cmb2' ),
					'desc'    => __( 'This image will display in user detail and profile box information', 'cmb2' ),
					'id'      => $prefix . 'avatar',
					'type'    => is_admin() ? 'file' : 'opal_upload',
					'avatar'  => true,
					'before_row' => '<div class="'.apply_filters('opalestate_row_container_class', 'row opal-row').'"> <div class="col-lg-4">',
					'after_row' => '</div>'
				),

				array(
					'id'   => "first_name",
					'name' => __( 'First Name', 'opalestate' ),
					'type' => 'text',
					'attributes' => array(
				        'required' => 'required',
				    ),
					'before_row' => '<div class="col-lg-8">',
				 
				),
				array(
					'id'   => "last_name",
					'name' => __( 'Last Name', 'opalestate' ),
					'type' => 'text',
					'attributes' => array(
				        'required' => 'required',
				    ),
				),

				array(
					'id'   => "description",
					'name' => __( 'Biographical Info', 'opalestate' ),
					'type' => 'textarea',
					'description'  => __( 'Input for videos, audios from Youtube, Vimeo and all supported sites by WordPress. It has preview feature.', 'opalestate' ),
					
					'after_row' => '</div></div>'
				),
				array(
					'id'   => "{$prefix}job",
					'name' => __( 'Title/Job', 'opalestate' ),
					'type' => 'text',
					'description'  => __( 'Please enter position or job in your company.', 'opalestate' ),
					'before_row'   => '<div class="row-group-features group-has-two clearfix"><h3>'.__('Information','opalestate').'</h3>', // callback
				),

				array(
					'id'   => "{$prefix}company",
					'name' => __( 'company', 'opalestate' ),
					'type' => 'text',
					'description'  => __( 'Please enter company name.', 'opalestate' ),
				),
				array(
					'id'   => "{$prefix}email",
					'name' => __( 'Contact email', 'opalestate' ),
					'type' => 'text_email',
					'description'  => __( 'Enter contact name that allow user contact you via the contact form of website.', 'opalestate' ),
				),


				array(
					'id'   => "{$prefix}phone",
					'name' => __( 'Phone', 'opalestate' ),
					'type' => 'text',
					'description'  => __( 'Enter your home phone.', 'opalestate' ),
				),

				array(
					'id'   => "{$prefix}skype",
					'name' => __( 'Skype', 'opalestate' ),
					'type' => 'text',
					'description'  => __( 'Input for skype account.', 'opalestate' ),
				),

				array(
					'id'   => "url",
					'name' => __( 'Website URL', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Link to your website', 'opalestate' ),
					'after_row'   => '</div>'
				),

				array(
					'id'   => "{$prefix}facebook",
					'name' => __( 'Facebook', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Enter your facebook profile or facebook newfeed', 'opalestate' ),
					'before_row'   => '<div class="row-group-features group-has-two group-price clearfix"><h3>'.__('Social','opalestate').'</h3>', // callback
				),

				array(
					'id'   => "{$prefix}linkedin",
					'name' => __( 'Linkedin URL', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Input for linked in profile.', 'opalestate' ),
				),
				array(
					'id'   => "{$prefix}instagram",
					'name' => __( 'Instagram URL', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Input for instagram profile.', 'opalestate' ),
				),
				array(
					'id'   => "{$prefix}pinterest",
					'name' => __( 'Pinterest Url', 'opalestate' ),
					'type' => 'text',
					'description'  => __( 'Input for pinterest feed', 'opalestate' ),
				),

				array(
					'id'   => "{$prefix}googleplus",
					'name' => __( 'Google Plus Url', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Input for goolge plus profile or your newfeed.', 'opalestate' ),
				),

				array(
					'id'   => "{$prefix}youtube",
					'name' => __( 'Youtube Url', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Input for your channel youtube.', 'opalestate' ),
				),

				array(
					'id'   => "{$prefix}vimeo",
					'name' => __( 'Vimeo Url', 'opalestate' ),
					'type' => 'text_url',
					'description'  => __( 'Input for your channel Vimeo', 'opalestate' ),
					'after_row'   =>  '</div>'
				),
			);
		
		if( is_admin() ){
			$admin_fields = array();
			$admin_fields[] = array(
				'id'   => "{$prefix}block_submission",
				'name' => __( 'Block Submssion', 'opalestate' ),
				'type' => 'checkbox',
			 
				'before_row' => '',
			 
			);
			$management = array_merge_recursive( $admin_fields, $management );  
		}	

		return $management;		
	}

	/**
	 * Defines custom front end fields
	 *
	 * @access public
	 * @param array $metaboxes
	 * @return array
	 */
	public function front_edit_fields( array $metaboxes ) {

		$post_id  = 0;
		$prefix = OPALESTATE_USER_PROFILE_PREFIX;
		if ( ! is_admin() ) {
			
			$default  = array(
				
			);
		
			$fields = array_merge_recursive( $default, self::extra_info_fields() );

			$metaboxes[ $prefix . 'front' ] = array(
				'id'                        => $prefix . 'front',
				'title'                     => __( 'Name and Description', 'opalestate' ),
				'object_types'              => array( 'opalestate_property' ),
				'context'                   => 'normal',
				'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
				'priority'                  => 'high',
				'show_names'                => true,
				'fields'                    => $fields
			);


			$metaboxes[ $prefix . 'frontchangepass' ] = array(
				'id'                        => $prefix . 'frontchangepass',
				'title'                     => __( 'Name and Description', 'opalestate' ),
				'object_types'              => array( 'opalestate_property' ),
				'context'                   => 'normal',
				'object_types'    		    => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
				'priority'                  => 'high',
				'show_names'                => true,
				'fields'                    => array(
						array(
							'id'   => "oldpassword",
							'name' => __( 'Old Password', 'opalestate' ),
							'type' => 'text_password',
							'attributes' => array(
						        'required' => 'required',
						    ),
							'description'  => __( 'Please enter your old password', 'opalestate' ),
						),
						array(
							'id'   => "new_password",
							'name' => __( 'New Password', 'opalestate' ),
							'type' => 'text_password',
							'attributes' => array(
						        'required' => 'required',
						    ),
							'description'  => __( 'Please enter your new password.', 'opalestate' ),
						),
						array(
							'id'   => "confirm_password",
							'name' => __( 'Confirm Password', 'opalestate' ),
							'type' => 'text_password',
							'attributes' => array(
						        'required' => 'required',
						    ),
							'description'  => __( 'Please enter your confirm password.', 'opalestate' ),
						)
				)		
			);	

		}
		return $metaboxes;
	}	

	public static function cmb2_render_text_password(  $field_args, $escaped_value, $object_id, $object_type, $field_type_object ){
		 echo $field_type_object->input( array( 'type' => 'password', 'class' => 'form-control' ) );
	}
	
	/**
	 * FrontEnd Submission
	 */
	public static function user_profile(){
		global $current_user;
	
		

		if ( ! is_user_logged_in() ) {
		    echo Opalestate_Template_Loader::get_template_part( 'parts/not-allowed' );
		    return;
	    }

		$metaboxes = apply_filters( 'cmb2_meta_boxes', array() );

		if ( ! isset( $metaboxes[ OPALESTATE_USER_PROFILE_PREFIX . 'front' ] ) ) {
			return __( 'A metabox with the specified \'metabox_id\' doesn\'t exist.', 'opalestate' );
		}
		$user_id = get_current_user_id();

	    echo Opalestate_Template_Loader::get_template_part( 'user/profile', array(  'metaboxes' => $metaboxes, 'user_id' => $user_id) );
	}

	/**
	 *
	 */
	public static function load_scripts(){
		if( is_user_logged_in() ){
			wp_enqueue_style( 'opalesate-submission', OPALESTATE_PLUGIN_URL . 'assets/submission.css', null, OPALESTATE_VERSION, false );
		}
	}
}

new OpalEstate_User();