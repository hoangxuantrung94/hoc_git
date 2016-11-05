<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $post;

$contact_id = (int)Opalestate_Query::get_agent_by_property($post->ID);

?>
<?php if( $contact_id ): ?> 
 <?php 
 	$email = get_post_meta( $contact_id, OPALESTATE_AGENT_PREFIX . 'email', true );
 	$args = array( 'post_id' => 0, 'email' => $email );
?>
<div class="opalestate-box property-agent-section">
	<h3><?php _e( 'Contact Agent', 'opalestate' ); ?></h3>
	<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
		<div class="col-lg-7 property-agent-info">
			<?php OpalEstate_Agent::render_box_info( $contact_id  ); ?>
		</div>
		<div class="col-lg-5 property-agent-contact">
			<?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/form', $args ); ?> 
		</div>	
	</div>	
</div>
<?php else : ?>
<?php $email = get_user_meta( $post->post_author, OPALESTATE_USER_PROFILE_PREFIX . 'email', true ); ?>	
<?php 
 
	$args = array( 'post_id' => 0, 'email' => $email );
	$data =  get_userdata( $post->post_author ); 
?>

<div class="opalestate-box property-agent-section">
	<h3><?php _e( 'Contact Agent', 'opalestate' ); ?></h3>
	<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
		<div class="col-lg-7 property-agent-info">
			<?php echo Opalestate_Template_Loader::get_template_part( 'parts/author-box', array('author'=>$data , 'hide_description' => true ) ); ?>
		</div>
		<div class="col-lg-5 property-agent-contact">
			<?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/form', $args ); ?> 
		</div>	
	</div>	
</div>

<?php endif; ?>

