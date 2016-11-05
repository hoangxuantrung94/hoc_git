
<div class="payment-detail">

	<?php if( $payment ): ?>
	<?php
		$fields = OpalMembership()->address()->get_fields( );
		$packages = $payment->get_cartitems();
	 	$coupons = $payment->get_coupons();

	 // 	echo '<pre>'.print_r($packages, 1 );die;
	 	
	?>
	
			<h2><?php _e( 'Payment ID' ); ?>: <?php echo $payment->get_payment_number(); ?></h2>
			<div class="row">
				<div class="membership-payment-info col-sm-6">
						<div class="panel panel-default">
							<h4 class="panel-heading"><?php _e( 'Payment Information', 'opalmembership' ); ?></h4>

						
							 <ul class="list-group">
							 	 <li class="list-group-item">
									<span class="text-label"><?php _e( 'Date Purchase', 'opalmembership' ); ?>:</span><span> <?php echo $payment->created(); ?> </span>
								</li>

								 <li class="list-group-item">
									<span class="text-label"><?php _e( 'Gateway', 'opalmembership' ); ?>:</span><span> <?php echo opalmembership_get_gateways_by_key( $payment->get_gateway() ); ?> </span>
								</li>
								 <li class="list-group-item">
									<span><?php _e( 'Key', 'opalmembership' ); ?>:</span><span><?php echo $payment->get_meta( 'purchase_key' ); ?></span>
								</li>
								<?php if( $payment->get_meta( 'transaction_id' ) ) {  ?>
								 <li class="list-group-item">
									<span><?php _e( 'Transaction ID', 'opalmembership' ); ?>:</span><span><?php echo $payment->get_meta( 'transaction_id' ); ?></span>
								</li>
								<?php } ?>
								 <li class="list-group-item">
									<span><?php _e( 'IP Client', 'opalmembership' ); ?></span><span><?php echo $payment->get_meta( 'user_ip' ); ?></span>
								</li>
							</ul>
						</div> 		
					</div>

					<div class="membership-payment-address col-sm-6">
						<div class="panel panel-default">
							<h4 class="panel-heading"><?php _e( 'Billing Address', 'opalmembership' ); ?></h4>
							 <ul class="list-group">
								 <?php foreach ( $fields as $key => $field ) : ?>
								 	<?php if( isset($payment->billing[$key]) && isset($field['label']) && $payment->billing[$key] ): ?> 
									 <li class="list-group-item"><span class="text-label"><?php echo $field['label']; ?> : </span> <?php echo $payment->billing[$key]; ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div> 	
					</div>
		 			
			</div>	
		
		
		<div class="panel panel-default">
			<div class="panel-body">
				<h2><?php _e( 'Package Info' ); ?></h2>
				<div class="table-responsive">
				  <table  class="table table-bordered">
				   		<thead> 
				   			<tr> 
				   				<th><?php _e( 'Package Name' ,'opalmembership'); ?></th> 
				   				<th><?php _e( 'Total' ,'opalmembership'); ?></th> 
				   			</tr> 
				   		
				   		</thead>
				   		<tbody>
				   			<?php foreach( $packages as $package ): ?>
				   			<tr> 
				  				<td><?php echo opalmembership_get_package_name($package['package_id']); ?></td> 

				  				<td><?php echo opalmembership_price_format( $package['price'] ); ?></td> 
				  			 
				  			</tr> 
				  			<?php endforeach; ?>
				 

							<?php if( !empty($coupons) ) { ?>
							<?php foreach(  $coupons as $coupon ) { ?>
								<tr>
									<td class="text-right"><strong><?php _e( 'Coupon' ); ?> <span>( <?php echo $coupon['code']; ?> )</span></strong></td>
									<td><?php if( $coupon['type'] == 'percenatage' ){ ?>
										-<?php  echo opalmembership_price_format(  ($package['price']/$coupon['value']) * 10 );  ?>
									<?php }else {  ?>
									<?php  echo opalmembership_price_format(  $coupon['value'] );  ?>
									<?php } ?>
									</td>
								</tr>
								<?php } ?>
							<?php } ?>


							<tr>
								<td class="text-right"><strong><?php _e( 'Total', 'opalmembership' ); ?></strong></td>
								<td><?php echo opalmembership_price_format( $payment->get_payment_total() );?></td>
							</tr>
				 		</tbody>
					</table>

				</div>   		
			</div>	
		</div>	

	<?php else : ?>
	<?php _e( 'Could not find any payment', 'opalmembership' ); ?>	
	<?php endif; ?>
	<div>
		<a href="<?php echo esc_url( opalmembership_get_payment_history_page_uri() ) ; ?>" class="btn btn-primary"><?php _e( 'Back To List', 'opalmembership' ); ?></a>
	</div>	
</div>	