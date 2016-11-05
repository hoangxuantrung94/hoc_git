<?php 
	
	global $wp_query;
	$current_author = $wp_query->get_queried_object();
	$email = get_user_meta( $current_author->ID , OPALESTATE_USER_PROFILE_PREFIX . 'email', true ); 
	$args = array( 'post_id' => 0, 'email' =>  $email );
?>
	<div class="agent-box">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6">  
				<?php echo Opalestate_Template_Loader::get_template_part( 'parts/author-box', array('author'=>$current_author->data) ); ?>
			</div>
 
			<div class="col-lg-6 col-md-6 col-sm-6"> <?php echo Opalestate_Template_Loader::get_template_part( 'single-agent/form', $args ); ?> </div>
	 
		</div>
	</div>

	<div class="entry-content">
		<?php echo Opalestate_Template_Loader::get_template_part( 'parts/author-box-content', array('author'=>$current_author->data) ); ?>
	</div>

<?php
$properties = Opalestate_Query::get_properties_by_user( null, $current_author->ID , 3 );
if( $properties->have_posts() ) :
?>
<div class="clearfix clear"></div>
<div class="opalestate-box property-same-agent-section">
	<h3><?php _e('My Properties','fullhouse');?></h3>
	<div class="box-content opalestate-rows">
		<div class="row">
			<?php while( $properties->have_posts() ) : $properties->the_post(); ?>
			  	<div class="col-lg-4 col-md-4 col-sm-4">
			  	 <?php echo Opalestate_Template_Loader::get_template_part( 'content-property-grid' ); ?>
			  	</div> 
			<?php endwhile; ?>	
		</div>
	</div>	
</div>	
<?php endif; ?>
<?php wp_reset_postdata(); ?>