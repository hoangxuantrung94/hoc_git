<?php if( function_exists("opalestate_get_location_active") ): 
		$alocation =  opalestate_get_location_active();
		$description = fullhouse_fnc_theme_options('location_header_desc');
	?>
	
		<a class="btn-modal-locations" data-target="#modal-locations" data-toggle="modal" href="#">
			<i class="fa fa-map-marker text-primary"></i><?php echo $alocation; ?>
		</a>
				
	</div>

	<div class="modal fade" id="modal-locations" tabindex="-1" role="dialog" aria-labelledby="modal-locations">
     	<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div aria-label="Close" data-dismiss="modal" class="close pull-right"><a aria-hidden="true" href="#"><i class="fa fa-times"></i></a></div>
				<div class="modal-body row">
					<?php if( $description ): ?>
					<div class="col-sm-6"><?php echo  $description ; ?></div> 
					<div class="col-sm-6">	
					<?php else : ?>
					<div class="col-sm-12">	
					<?php endif; ?>		
						<h3><?php _e('Chọn vị trí','fullhouse');?></h3>
						<p><em><?php _e('Chọn vị trí mà bạn muốn tìm dự án','fullhouse'); ?></em></p>
						<div class="locations row">
							<?php $locations = Opalestate_Taxonomy_Location::getList(); ?>
							<?php foreach( $locations as $location ): ?>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"><a <?php if( $location->name == $alocation ): ?> class="text-primary active" <?php endif; ?> href="<?php echo  home_url( '/' )?>?set_location=<?php echo $location->slug; ?>"> <?php echo $location->name; ?></a> </div>
							<?php endforeach; ?>
						</div>	
						<p class="location-bottom text-center">
							<a class="btn btn-warning btn-3d" href="<?php echo  home_url( '/' )?>?clear_location=1">
								<i class="fa fa-remove"></i>	<?php _e('Xóa vị trí','fullhouse'); ?>
							</a>
						</p>
					</div>
		
				</div>
			</div>
		</div>
	
<?php endif; ?>