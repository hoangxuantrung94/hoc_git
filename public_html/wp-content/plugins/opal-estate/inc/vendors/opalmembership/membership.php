<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( defined( 'OpalMembership' ) ) {
	return;
}
/**
 * @class OpalEstate_Membership: as vendor class is using for processing logic with update/set permission for user submitting property.
 *
 * @version 1.0
 */
class OpalEstate_Membership{

	/*
	 * Constructor
	 */
	public static function init() {

		/* estate */
		add_action( 'show_admin_bar'							  , array( __CLASS__, 'hide_admin_toolbar' ) ); // hide admin toolbar

		/* cmb2 meta box hook membership information */
		add_filter( 'opalmembership_postype_membership_metaboxes_fields', array( __CLASS__, 'metabox' ), 10 );
		/* add user agent role after insert new user member */
	//	add_filter( 'opalmembership_create_user_data'			  , array( __CLASS__, 'add_user_role_data' ), 10 );
	//	add_action( 'opalmembership_create_new_user_successfully', array( __CLASS__, 'trigger_create_user_agent' ), 10, 3 );
		/**
		 * save user meta when save user agent post type
		 */
		add_action( 'cmb2_save_post_fields', array( __CLASS__, 'trigger_update_user_meta' ), 10, 4 );
		add_action( 'profile_update', array( __CLASS__, 'trigger_update_agent_meta' ), 10, 2 );
		/**
		 *  Call Hook after updated membership information in user data.
		 */
		add_action( 'opalmembership_after_update_user_membership' , array( __CLASS__,'on_set_user_update_membership') , 10, 3 );

		/**
		 * HOOK TO My Properties Page Set action to check when user set property as featured.
		 */
		add_filter( 'opalestate_set_feature_property_checked'      , array( __CLASS__,'feature_property_checked')  );
		add_action( 'opalestate_toggle_featured_property_before'   , array( __CLASS__,'update_featured_remaining_listing'), 10, 2 );

		/**
		 * HOOK to Submssion Page: Check permission before submitting
		 */
		// check validation before
		add_action( 'opalestate_process_submission_before'		 , array( __CLASS__, 'check_membership_validation' ), 1 );

		add_action( 'opalestate_submission_form_before'			 , array('Opalmembership_User','show_membership_warning'), 9 );
		add_action( 'opalestate_submission_form_before'  	     , array( __CLASS__, 'check_membership_validation_message' ) );

		add_action( 'opalestate_process_edit_submission_before'  , array( __CLASS__, 'check_edit_post' )  );
		add_action( 'opalestate_process_add_submission_before'   , array( __CLASS__, 'check_add_post' )  );
		/// check before uploading image
		add_action( 'opalestate_before_process_ajax_upload_file' , array( __CLASS__, 'check_ajax_upload' ) );
		add_action( 'opalestate_process_submission_after'		 , array( __CLASS__, 'update_remainng_listing' ) , 10, 3 );

		/**
		 * HOOK to user management Menu
		 */
		add_filter( 'opalestate_management_user_menu'			  , array( __CLASS__, 'membership_menu' )  );

		/**
		 * Hook to widget to show addition about current package.
		 */
		add_action( 'opalmembership_current_package_summary_after' , array( __CLASS__, 'render_membership_summary' ), 10, 2 );

		/**
		 * Hook to loop of package membership
		 */
		add_action( 'opalmembership_content_single_before' 			, array( __CLASS__, 'render_membership_pricing_box' ) );

		/**
		 * Add 'opalesate_agent' role to get_users member data
		 */
		// add_action( 'opalmembership_member_table_arguments', array( __CLASS__, 'member_table_get_user_arguments' ) );
		// show in membership dashboard
		add_action( 'opalmembership_dashboard_container_before'		, array( __CLASS__, 'check_membership_validation_message' ) );
		// included logic functions
		require_once( 'functions.php' );

		add_action( 'opalmembership_current_package_summary_after' , array( __CLASS__, 'render_membership_summary' ), 10, 2 );

		add_action( 'cmb2_admin_init', array( __CLASS__, 'register_user_package_metabox')   );
	}

	public static function render_membership_pricing_box(){
		echo Opalestate_Template_Loader::get_template_part( 'parts/membership-pricing-info', array() );
	}

	public static function member_table_get_user_arguments( $args ) {
		return array_merge_recursive( $args, array( 'role__in' => array( 'opalestate_agent' ) ) );
	}


	public static function set_properties_expired(){
		
		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		$args = array(
            'post_type'   => 'opalestate_agent',
            'author'      => $user_id,
            'post_status' => 'any'
        );

        $query = new WP_Query( $args );

        while( $query->have_posts()) {
            $query->the_post();

            $prop = array(
                'ID'            => $post->ID,
                'post_type'     => 'opalestate_agent',
                'post_status'   => 'expired'
            );

            wp_update_post($prop );
        }
        wp_reset_query();

	}
	/**
	 * Before upload any file. this is called to check user having package which allows to upload or is not expired.
	 *
	 * @return void if everything is ok, or json data if it is not valid.
	 */
	public static function check_ajax_upload(){
		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		$has = opalesate_check_has_add_listing( $user_id );

		$check = opalesate_is_membership_valid( $user_id );
		
		if( ! $check || ! $has ){
			$std = new stdClass();
			$output->status = false ;
			$output->message = __( 'Could not allow uploading image','opalestate' );
			echo json_encode( $std ); exit();
		}
	}

	/**
	 * hide admin toolbar with user role agent
	 */
	public static function hide_admin_toolbar( $show ) {
		if ( ! is_user_logged_in() ) { return $show; }

		$user = wp_get_current_user();
		if ( opalestate_get_option( 'hide_toolbar' ) && $user->roles && in_array( 'opalestate_agent', $user->roles ) ) {
			return false;
		}
		return $show;
	}

	/**
	 *  Trigger to extend fields to inject into Metabox of property edit/add form.
	 */
	public static function metabox( $fields ) {

		if ( ! defined( 'OPALMEMBERSHIP_PACKAGES_PREFIX' ) ) return $fields;

		$prefix = OPALMEMBERSHIP_PACKAGES_PREFIX;

		$fields[] = array(
				'name' => __( 'Number Of Properties', 'opalestate' ),
				'id'   => $prefix . 'package_listings',
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => __( 'Number of properties with this package. If not set it will be unlimited.', 'opalestate' )
			);

		$fields[] = array(
			'name' => __( 'Number Of Featured Properties', 'opalestate' ),
			'id'   => $prefix . 'package_featured_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => __( 'Number of properties can make featured with this package.', 'opalestate' )
		);

		$fields[] = array(
			'name' => __( ' Unlimited listings ?', 'opalestate' ),
			'id'   => $prefix . 'unlimited_listings',
			'type' => 'checkbox',
			'std' => '1',
			'description' => __( 'Number of properties can make featured with this package. If not set it will be unlimited.', 'opalestate' )
		);

		return $fields;
	}

	/**
	 * Hook Method to add more link for user management
	 */
	public static function membership_menu( $menu ){
		global $opalmembership_options;
		$menu['membership'] = array(
			'icon'			=> 'fa fa-user',
			'link'		 	=> opalmembership_get_dashdoard_page_uri(),
			'title'			=> __( 'My Membership', 'opalestate' ),
			'id'			=> isset( $opalmembership_options['dashboard_page'] ) ? $opalmembership_options['dashboard_page'] : 0
		);

		$menu['packages'] = array(
			'icon'			=> 'fa fa-certificate',
			'link'		 	=> opalmembership_get_membership_page_uri(),
			'title'			=> __( 'Review membership', 'opalestate' ),
			'id'			=> isset( $opalmembership_options['dashboard_page'] ) ? $opalmembership_options['dashboard_page'] : 0
		);

		return $menu;
	}

	/**
	 * This function add new user role in this case is add 'opalestate_agent' role to user created
	 */
	public static function add_user_role_data( $cred ) {
		$cred['role'] = 'opalestate_agent';
		return $cred;
	}

	/**
	 * trigger create new post type user agent
	 */
	public static function trigger_create_user_agent( $user_id, $user_data, $cred ) {
		// create new post(opalestate_agent)
		 $agent_id = opalesate_insert_user_agent( array(
				'first_name'		=> $cred['first_name'],
				'last_name'			=> $cred['last_name'],
				'email'				=> $cred['user_email']
			) );

		update_post_meta( $agent_id, OPALESTATE_AGENT_PREFIX . 'user_id', $user_id ); 
	}

	/**
	 * save user meta data
	 */
	public static function trigger_update_user_meta( $agent_id, $cmb_id, $updated, $cmb2 ) {
		if ( $cmb_id !== 'opalestate_agt_info' || empty( $cmb2->data_to_save ) ) return;
		$user_id = get_post_meta( $agent_id, OPALESTATE_AGENT_PREFIX . 'user_id', true );

		if ( ! $user_id ) return;
		foreach ( $cmb2->data_to_save as $name => $value ) {
			if ( strpos( $name, OPALESTATE_AGENT_PREFIX ) === 0 ) {
				update_user_meta( $user_id, OPALESTATE_USER_PROFILE_PREFIX . substr( $name, strlen( OPALESTATE_AGENT_PREFIX ) ), $value );
			}
		}
	}

	/**
	 * trigger save agent post meta
	 */
	public static function trigger_update_agent_meta( $user_id, $old_user_meta ) {
		if ( empty( $_POST ) ) return;
		global $wpdb;
		$sql = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %d AND meta_key = %s", $user_id, OPALESTATE_AGENT_PREFIX . 'user_id' );
		$agent_id = $wpdb->get_var( $sql );

		if ( ! $agent_id ) return;
		foreach ( $_POST as $name => $value ) {
			if ( strpos( $name, OPALESTATE_USER_PROFILE_PREFIX ) === 0 ) {
				update_post_meta( $agent_id, OPALESTATE_AGENT_PREFIX . substr( $name, strlen( OPALESTATE_USER_PROFILE_PREFIX ) ), $value );
			}
		}
	}

	/**
	 * This function is called when payment status is completed. It will update new number of featured, listing for user.
	 *
	 * @return void
	 */
	public static function on_set_user_update_membership(  $package_id, $user_id=0, $payment_id=0 ){
		/**
		 * Get some information from selected package.
		 */
	    $pack_listings            = get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_listings', true );
	    $pack_featured_listings   = get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_featured_listings', true );
	    $pack_unlimited_listings  = get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'unlimited_listings', true );

	  	/**
	  	 * Get package information with user logined
	  	 */
	    $current_listings           =  get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings',true);
	    $curent_featured_listings   =  get_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings',true);
	    $current_pack 				=  get_user_meta( $user_id,OPALMEMBERSHIP_USER_PREFIX_.'package_id', true );

	    $user_current_listings           = opalesate_get_user_current_listings ( $user_id ); // get user current listings ( no expired )
	    $user_current_featured_listings  = opalesate_get_user_current_featured_listings( $user_id ); // get user current featured listings ( no expired )

	    if( opalesate_check_package_downgrade_status( $user_id, $package_id ) ) {
	        $new_listings           =  $pack_listings;
	        $new_featured_listings  =  $pack_featured_listings;
	    }else{
	        $new_listings           =  $pack_listings - $user_current_listings ;
	        $new_featured_listings  =  $pack_featured_listings -  $user_current_featured_listings ;
	    }

	    // in case of downgrade
	    if( $new_listings < 0 ) {
	        $new_listings = 0;
	    }

	    if( $new_featured_listings < 0 ) {
	        $new_featured_listings = 0;
	    }


	    if ( $pack_unlimited_listings == 1 ) {
	        $new_listings = -1;
	    }

	    /**
	     * Update new number of packages listings and featured listing.
	     */
	    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings', $new_listings) ;
	    update_user_meta( $user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings', $new_featured_listings);
	}

	/**
	 * This function is called when user set property as featured.
	 *
	 *  @return boolean. true is user having permission.
	 */
	public static function feature_property_checked(){
		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		if( isset($_POST['property_id']) ){
			return opalesate_get_user_featured_remaining_listing( $user_id );
		}
		return false;
	}

	/**
	 * Reduce -1 when set featured status is done.
	 */
	public static function update_featured_remaining_listing( $user_id, $property_id ){
		opalesate_update_package_number_featured_listings(  $user_id );
	}

	/**
	 *
	 */
	public static function update_remainng_listing( $user_id, $property_id , $isedit=true ){
		if( $isedit != true ){
			opalesate_update_package_number_listings( $user_id );
		}
	}

	/**
	 * Check user having any actived package and the package is not expired.
	 * Auto redirect to membership packages package.
	 */
	public static function check_membership_validation(){
		$check = opalesate_is_membership_valid();
		if( !$check ){
			wp_redirect( opalmembership_get_membership_page_uri(array('warning=1')) ); exit;
		}
	}

	/**
	 * Check any action while editing page
	 */
	public static function check_edit_post(){
		return true;
	}

	/**
	 * Check permission to allow creating any property. The package is not valid, it is automatic redirect to membership page.
	 */
	public static function check_add_post(){

		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		$has = opalesate_check_has_add_listing( $user_id );
		if( $has  == false ){
			wp_redirect( opalmembership_get_membership_page_uri( array('warning=2') ) ); exit;
		}
	}

	/**
	 * Display membership warning at top of submission form.
	 */
	public static function check_membership_validation_message(){

		global $current_user;
	    wp_get_current_user();
	    $user_id =   $current_user->ID;

		echo Opalestate_Template_Loader::get_template_part( 'parts/membership-warning', array('user_id' => $user_id) );

	}

	/**
	 * Hooked method to display more information about actived package.
	 */
	public static function render_membership_summary($package_id=0, $payment_id=0){

		global $current_user;

		wp_get_current_user();
	 	$user_id = $current_user->ID;

		$current_listings           =  get_user_meta($user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_listings',true);
	    $curent_featured_listings   =  get_user_meta($user_id, OPALMEMBERSHIP_USER_PREFIX_.'package_featured_listings',true);

	    ///
	    $pack_listings            =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_listings', true );
	    $pack_featured_listings   =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'package_featured_listings', true );
	    $pack_unlimited_listings  =   get_post_meta( $package_id, OPALMEMBERSHIP_PACKAGES_PREFIX.'unlimited_listings', true );
	    ///

	    $output = '';
	    	$output .= '<li><span>'.__('(Package) Listings Included:','opalestate').'</span> '.$pack_listings.'</span></li>';
	    	$output .= '<li><span>'.__('(Package) Featured Included:','opalestate').'</span> '.$pack_featured_listings.'</li>';

	    	$output .= '<li><span>'.__('Listings Remaining:','opalestate').'</span> <span class="text-primary">'.$current_listings.'</span></li>';
	    	$output .= '<li><span>'.__('Featured Remaining:','opalestate').'</span>  <span class="text-primary">'.$curent_featured_listings.'</span></li>';

	    echo $output;
	}

	public static function membership_username_actions( $actions, $items ) {
		$actions['edit']	= sprintf( '<a href="%s">%s</a>', get_edit_post_link( 0 ), __( 'Edit', 'estate' ) );
		return $actions;
	}

	/**
	 * Hook in and add a metabox to add fields to the user profile pages
	 */
	public static function register_user_package_metabox( ) {

		
		$prefix = OPALMEMBERSHIP_USER_PREFIX_;
		$fields = array();
		/**
		 * Metabox for the user profile screen
		 */
		$cmb_user = new_cmb2_box( array(
			'id'               => $prefix . 'package',
			'title'            => __( 'Membership Package', 'cmb2' ), // Doesn't output for user boxes
			'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta
			'show_names'       => true,
			'new_user_section' => 'add-new-user', // where form will show on new user page. 'add-existing-user' is only other valid option.
		) );
 	
 		$fields[] = array(
				'name' => __( 'Package', 'opalestate' ),
				'id'   => $prefix . 'package_id',
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => __( 'Number of properties with this package. If not set it will be unlimited.', 'opalestate' ),
				'before_row' => '<h3> '.__( 'Membership Information', 'opalestate' ).' </h3>'
			);


		$fields[] = array(
				'name' => __( 'Number Of Properties', 'opalestate' ),
				'id'   => $prefix . 'package_listings',
				'type' => 'text',
				'attributes' => array(
					'type' 		=> 'number',
					'pattern' 	=> '\d*',
					'min'		=> 0
				),
				'std' => '1',
				'description' => __( 'Number of properties with this package. If not set it will be unlimited.', 'opalestate' )
			);

		$fields[] = array(
			'name' => __( 'Number Of Featured Properties', 'opalestate' ),
			'id'   => $prefix . 'package_featured_listings',
			'type' => 'text',
			'attributes' => array(
				'type' 		=> 'number',
				'pattern' 	=> '\d*',
				'min'		=> 0
			),
			'std' => '1',
			'description' => __( 'Number of properties can make featured with this package.', 'opalestate' )
		);

		$fields[] = array(
			'name' => __( 'Number Of Featured Properties', 'opalestate' ),
			'id'   => $prefix . 'package_expired',
			'type' => 'text_date',
			'date_format' => 'Y-m-d H:i:s',
			'std' => '1',
			'description' => __( 'Number of properties can make featured with this package.', 'opalestate' )
		);
 
 
		foreach( $fields as $field ){
			$cmb_user->add_field( $field  );
		}
		
	}
}

OpalEstate_Membership::init();