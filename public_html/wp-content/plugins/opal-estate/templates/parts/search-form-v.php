<?php
	$fields = OpalEstate_Search::get_setting_search_fields( '_v' );
	$slocation  = isset($_GET['location'])?$_GET['location']:opalestate_get_session_location_val();
	$stypes 	= isset($_GET['types'])?$_GET['types']:0;
	$sstatus 	= isset($_GET['status'])?$_GET['status']:0;

	$search_min_price = isset($_GET['min_price']) ? $_GET['min_price'] : opalestate_options( 'search_min_price',0 );
	$search_max_price = isset($_GET['max_price']) ? $_GET['max_price'] : opalestate_options( 'search_max_price',10000000 );

	$showareasize = opalestate_options(OPALESTATE_PROPERTY_PREFIX.'areasize_opt_v', 1 );
	$showprice 	  = opalestate_options(OPALESTATE_PROPERTY_PREFIX.'price_opt_v' , 1 );  
?>

<form id="opalestate-search-form-v" class="opalestate-search-form opalestate-rows" action="<?php echo opalestate_get_search_link(); ?>" method="get">
			<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
				<div class="col-md-12"> 

				


					<ul class="list-inline pull-left">
						<li><i class="fa fa-search"></i></li>
					</ul>
					<?php 
						$statuses = Opalestate_Taxonomy_Status::getList();
		 				if( $statuses ): 
					?>
					<ul class="list-inline clearfix list-property-status pull-left">
						<li class="status-item active" data-id="-1">	
							<span><?php _e( 'Search Properties', 'opalestate' ); ?></span>
						</li>	
					</ul>	
					<?php endif; ?>
				</div>
			</div>	
			<div class="<?php echo apply_filters('opalestate_row_container_class', 'row opal-row');?>">
				<div class="col-lg-12">
					<div class="form-group">   
						<label><?php _e("Keyword", 'opalestate'); ?></label>
						<input class="form-control" name="search_text">			 
					</div>

					<div class="form-group">
						<label><?php _e("Status", 'opalestate'); ?></label>
						<?php Opalestate_Taxonomy_Status::dropdownList( $sstatus );?>
					</div>


					<div class="form-group">
						<label><?php _e("Location", 'opalestate'); ?></label>
						<?php Opalestate_Taxonomy_Location::dropdownList( $slocation );?>
					</div>

					<div class="form-group">
						<label><?php _e("Type", 'opalestate'); ?></label>
						<?php  Opalestate_Taxonomy_Type::dropdownList( $stypes ); ?>
					</div>

					<?php if( $fields ): ?>
						<?php foreach( $fields as $key => $label ):  ?>
						<div class="form-group">
							<label><?php echo $label; ?></label>
							<?php opalestate_property_render_field_template( $key, __("No . ", 'opalestate' ) . $label ); ?>
						</div>
						<?php endforeach; ?>
					<?php endif; ?>

					<?php if( $showprice ): ?>
					<div class="form-group">
						 <div class="cost-price-content">
							<?php 

						 	 	$data = array(
									'id' 	 => 'price',
									'unit'   => opalestate_currency_symbol().' ',
									'ranger_min' => opalestate_options( 'search_min_price',0 ),
									'ranger_max' =>  opalestate_options( 'search_max_price',10000000 ),
									'input_min'  =>  $search_min_price,
									'decimals' => opalestate_get_price_decimals(),
									'input_max'	 => $search_max_price
								);
								opalesate_property_slide_ranger_template( __("Price:",'opalestate'), $data );	
							?>
						</div>
					</div>
					<?php endif; ?>
					<?php if( $showareasize  ): ?>
					<div class="form-group">
						 <div class="area-range-content">
							<?php echo opalestate_property_areasize_field_template(); ?>
						</div>
					</div>
					<?php endif; ?>
					<div class="form-group">
						<button type="submit" class="btn btn-danger btn-lg btn-search btn-block">
							<?php _e('Search', 'opalestate'); ?>
						</button>
					</div>

				</div>
				
			</div>	
		</form>

