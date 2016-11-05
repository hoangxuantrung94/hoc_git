<?php 
/**
 *
 */
function opalestate_admin_enqueue_assets(){ 
	
	$suffix = "";

	wp_enqueue_script(
		'opalestate-admin',
		OPALESTATE_PLUGIN_URL . 'assets/js/admin' . $suffix . '.js',
		array( 'jquery' ),
		null,
		true
	);		
}
add_action( 'admin_enqueue_scripts', "opalestate_admin_enqueue_assets");
/**
 * Searches for users via ajax and returns a list of results
 *
 * @since  1.0
 *
 * @return void
 */
function opalestate_ajax_search_users() {

	if ( current_user_can( 'manage_opalestate_settings' ) ) {

		$search_query = trim( $_POST['user_name'] );
		$exclude      = trim( $_POST['exclude'] );

		$get_users_args = array(
			'number' => 9999,
			'search' => $search_query . '*'
		);

		if ( ! empty( $exclude ) ) {
			$exclude_array             = explode( ',', $exclude );
			$get_users_args['exclude'] = $exclude_array;
		}

		$get_users_args = apply_filters( 'opalestate_search_users_args', $get_users_args );

		$found_users = apply_filters( 'opalestate_ajax_found_users', get_users( $get_users_args ), $search_query );

		$user_list = '<ul>';
		if ( $found_users ) {
			foreach ( $found_users as $user ) {
				$user_list .= '<li><a href="#" data-userid="' . esc_attr( $user->ID ) . '" data-login="' . esc_attr( $user->user_login ) . '">' . esc_html( $user->user_login ) . '</a></li>';
			}
		} else {
			$user_list .= '<li>' . esc_html__( 'No users found', 'opalestate' ) . '</li>';
		}
		$user_list .= '</ul>';

		echo json_encode( array( 'results' => $user_list ) );

	}
	die();
}

add_action( 'wp_ajax_opalestate_search_users', 'opalestate_ajax_search_users' );
