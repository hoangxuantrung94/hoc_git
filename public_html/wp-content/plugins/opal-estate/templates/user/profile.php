<div class="property-submission-form">

	<?php if ( ! empty( $_SESSION['messages'] ) ) : ?>

		<div class="opalesate_messages">
			<?php foreach ( $_SESSION['messages'] as $message ) : ?>

				<?php $status = isset( $message[0] ) ? $message[0] : 'success'; ?>
				<?php $msg = isset( $message[1] ) ? $message[1] : ''; ?>
				<div class="opalesate_message_line <?php echo esc_attr( $status ) ?>">
					<?php printf( '%s', $msg ) ?>
				</div>

			<?php endforeach; unset( $_SESSION['messages'] ); ?>
		</div>

	<?php endif; ?>

 	<div class="panel panel-default">
		
		<div class="panel-body">
			<h3><?php _e( 'Edit User Profile', 'opalestate' ); ?></h3>

			<?php
				do_action( 'opalestate_profile_form_before' );

				echo cmb2_get_metabox_form( $metaboxes[ OPALESTATE_USER_PROFILE_PREFIX . 'front' ], $user_id, array(
					'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb" value="%4$s" class="button-primary btn btn-primary"></form>',
					'save_button' => __( 'Save Change', 'opalestate' ),
				) );

				do_action( 'opalestate_profile_form_after' );
			?>
			</div>
	</div>	

	<div class="panel panel-default">
		<div class="panel-body">
			<h3><?php _e( 'Change Password', 'opalestate' ); ?></h3>
			

			<?php
				do_action( 'opalestate_profile_form_before' );

				echo cmb2_get_metabox_form( $metaboxes[ OPALESTATE_USER_PROFILE_PREFIX . 'frontchangepass' ], $user_id, array(
					'form_format' => '<form action="//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '" class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data"><input type="hidden" name="object_id" value="%2$s">%3$s<input type="submit" name="submit-cmb" value="%4$s" class="button-primary btn btn-primary"></form>',
					'save_button' => __( 'Save Change', 'opalestate' ),
				) );

				do_action( 'opalestate_profile_form_after' );
			?>


		</div>	
	</div>	
</div>