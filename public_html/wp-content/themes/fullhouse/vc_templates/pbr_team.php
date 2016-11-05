<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$layout = $style;
?>

<?php if( $layout === 'horizontal' ){ ?>
<div class="team-list">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="team-header">
                <?php $img = wp_get_attachment_image_src($photo,'full'); ?>
				<?php if( isset($img[0]) )  { ?>
					<img class="img-responsive" src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $title ); ?>"  />
				<?php } ?>  
            </div> 
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="team-body">
                <div class="team-body-content">
                    <h3 class="team-name"><?php echo trim( $title ); ?></h3>
            		<p class="team-position"><?php echo esc_html($job); ?></p>
                </div>  
                 <p class="team-info text-medium-1">
			        <?php echo esc_html($information); ?>
			    </p>      
                <div class="bo-social-icons">

		        	<?php if( $facebook ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
						<?php } ?>
					<?php if( $twitter ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
					<?php } ?>
					<?php if( $pinterest ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
					<?php } ?>
					<?php if( $google ){  ?>
					<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
					<?php } ?>
		                              
		        </div>                           
            </div>                            
        </div>
    </div>
</div>
<?php } else if( $layout == "v2" ){ ?>


<?php } else { ?>
<div class="team-v1">
    <div class="team-header">
       <?php $img = wp_get_attachment_image_src($photo,'full'); ?>
		<?php if( isset($img[0]) )  { ?>
			<img class="img-responsive" src="<?php echo esc_url( $img[0] );?>" alt="<?php echo esc_attr( $title ); ?>"  />
		<?php } ?>   
    </div>     
    <div class="team-body">
        <div class="team-body-content">
            <h3 class="team-name"><?php echo trim( $title ); ?></h3>
            <p><?php echo esc_html($job); ?></p>
        </div>      
        <div class="bo-social-icons">

        	<?php if( $facebook ){  ?>
			<a class="bo-social-white radius-x" href="<?php echo esc_url( $facebook ); ?>"> <i  class="fa fa-facebook"></i> </a>
				<?php } ?>
			<?php if( $twitter ){  ?>
			<a class="bo-social-white radius-x" href="<?php echo esc_url( $twitter ); ?>"><i  class="fa fa-twitter"></i> </a>
			<?php } ?>
			<?php if( $pinterest ){  ?>
			<a class="bo-social-white radius-x" href="<?php echo esc_url( $pinterest ); ?>"><i  class="fa fa-pinterest"></i> </a>
			<?php } ?>
			<?php if( $google ){  ?>
			<a class="bo-social-white radius-x" href="<?php echo esc_url( $google ); ?>"> <i  class="fa fa-google"></i></a>
			<?php } ?>


                              
        </div>                        
    </div>  
    <p class="team-info">
        <?php echo esc_html($information); ?>
    </p>                                      
</div>
<?php } ?>
