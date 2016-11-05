<?php 

	if( isset($_POST['opalsortable']) ){
		if( !empty($_POST['opalsortable']) ){
			$_SESSION['opalsortable'] = $_POST['opalsortable'];
		}else if( isset( $_SESSION['opalsortable'] ) ) {
			unset( $_SESSION['opalsortable'] );
		}	
	}

	$selected = '';

	if( isset($_SESSION['opalsortable']) ){
		$args['sortable'] = $_SESSION['opalsortable']; 	
		$selected = $args['sortable'];  
	}

	$mode  = isset($mode)?$mode:'';
?>
<div class="opalesate-archive-top">
	<div class="row">
		

		<div >
			<div style="text-align:center; font-family: Times New Roman; font-size:24px; font-weight: bold;text-transform: uppercase; color:black;">
				<?php //echo opalestate_render_sortable_dropdown( $selected ); ?>
				<?php echo "DANH SÁCH DỰ ÁN"; ?> 
			</div>
			<div class="pull-right">
				 <?php //opalestate_show_display_modes( $mode ); ?>
			</div>
		</div>
	</div>
</div>