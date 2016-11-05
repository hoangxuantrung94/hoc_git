<?php
	
	global $mc4wp;
	$image_link = '';
	$style = 'background: url(\''.($image_link).'\') no-repeat 0 0 transparent';
?>
<div class="popupnewsletter">	
	 <button type="button" class="btn btn-primary btn-lg btn-flying-right" data-toggle="modal" data-target="#popupNewsletterModal">
	 	<i class="fa fa-envelope-o"></i>
	</button>

	<!-- Modal -->
	<div class="modal fade" id="popupNewsletterModal" tabindex="-1" role="dialog" aria-labelledby="popupNewsletterModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="<?php echo ($style);?>">
	   	 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      <div class="modal-body">
	      		 <div class="popupnewsletter-widget <?php echo esc_attr( $el_class ); ?> <?php echo esc_attr( $class ); ?>"><div>
					<?php if(!empty($title)){ ?>
						<h3>
							<span><?php echo esc_html( $title ); ?></span>
						</h3>
					<?php } ?>
					
					<?php if(!empty($description)){ ?>
						<p class="description">
							<?php echo trim( $description ); ?>
						</p>
					<?php } ?>		
					
					<?php
						mc4wp_show_form('');
					?>
				</div></div>
	      </div>
	    </div>
	  </div>
	</div>
</div>	