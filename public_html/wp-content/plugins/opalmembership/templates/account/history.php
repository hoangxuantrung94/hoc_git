<div class="panel panel-default">
	<div class="panel-body">
		<div class="membership-history">
			<h2><?php _e( 'List Of Payments' ); ?></h2>
			<?php if( $loop->have_posts() ): ?>
			<div class="table-responsive">
			  <table  class="table table-bordered">
			   		<thead> 
			   			<tr> 
			   				<th>#</th> 
			   				<th><?php _e( 'Title' ,'opalmembership'); ?></th> 
			   				<th><?php _e( 'Date' ,'opalmembership'); ?></th> 

			   				<th><?php _e( 'Package' ,'opalmembership'); ?></th> 
			   				<th><?php _e( 'Status' ,'opalmembership'); ?></th> 
			   				<th><?php _e( 'Price' ,'opalmembership'); ?></th> 
			   				<th><?php _e( 'Action' ,'opalmembership'); ?></th> 
			   			</tr> 
			   		</thead>
			  		<tbody> 
			  		
			  			<?php 
			  				$cnt=0; while( $loop->have_posts() ): $loop->the_post(); 
			  				$payment = opalmembership_payment( get_the_ID() ); 

			  			?>
			  			<tr> 
			  				<th scope="row"><?php echo ++$cnt; ?></th> 
			  				<td><?php echo $payment->get_payment_number(); ?></td> 
			  				<td><?php echo $payment->payment_date; ?></td> 
			  				<td><?php echo opalmembership_get_package_name($payment->package_id); ?></td> 
			  				<td><?php echo opalmembership_get_payment_status_name($payment->get_status() ); ?></td> 
			  				<td><?php echo $payment->get_formatted_payment_total(); ?></td> 
			  				<th>
			  					<a href="<?php echo esc_url( opalmembership_get_payment_history_detail_page_uri( $payment->id )); ?>"><?php _e( 'View' ,'opalmembership'); ?></a>
			  				</th> 
			  			</tr> 
			  			<?php endwhile; ?>
			  		</tbody>
			  </table>
			  <?php else : ?>
			  <div>
			  		<?php _e( 'You have not purchase any package yet!', 'opalmembership' ); ?>
			  </div>	
			  <?php endif; ?>

			</div>
		</div>
	</div>
</div>
