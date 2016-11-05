<?php

/**
 *
 */
function opalestate_property_render_field_template( $field, $label ){

	$qvalue = isset($_GET['info'][$field])?$_GET['info'][$field]:"";

 	$template = '';

 	$template = apply_filters( 'opalestate_property_render_search_field_template', $field, $label  );
 	$template = apply_filters( 'opalestate_property_'.$field.'_field_template', $template );
 	if( $template == $field ){
 		$template = '';
 	}
 	if( empty($template) ){
		$template = '<select class="form-control" name="info[%s]"><option value="">%s</option>';

		for( $i=1; $i <= 10; $i++ ){
			$selected = $i == $qvalue ? 'selected="selected"':'';

			$template .= '<option '.$selected.' value="'.$i.'">'.$i.'</option>';
		}

		$template .= '</select>';

		$template = sprintf($template, $field, $label );

	}

	echo $template;
}

/**
 * RENDER FIELD FOR SEARCHING
 */

function opalestate_property_areasize_field_template( $template='' ){
	$search_min = isset($_GET['min_area']) ? $_GET['min_area'] :  opalestate_options( 'search_min_area', 0 );
	$search_max = isset($_GET['max_area']) ? $_GET['max_area'] : opalestate_options( 'search_max_area', 1000 );

	$data = array(
		'id' 	 => 'area',
		'unit'   => 'sqft ',
		'ranger_min' => opalestate_options( 'search_min_area', 0 ),
		'ranger_max' => opalestate_options( 'search_max_area', 1000 ),
		'input_min'  =>  $search_min,
		'input_max'	 => $search_max
	);
	opalesate_property_slide_ranger_template( __("Area:",'opalestate'), $data );

	return ;
}

add_filter("opalestate_property_areasize_field_template",'opalestate_property_areasize_field_template');


function opalesate_property_slide_ranger_template( $label , $data ){
		$default = array(
			'id'	=> 'price',
			'unit' => '',
			'decimals' => 0,
			'ranger_min' => 0,
			'ranger_max' => 1000,
			'input_min'	 => 0,
			'input_max'  => 1000
		);

		$data = array_merge( $default, $data );


		extract( $data );
	?>
	<div class="opal-slide-ranger" data-unit="<?php echo $unit; ?>" data-decimals="<?php echo $decimals; ?>" >

 	<label><?php //echo $label; ?>
		<span  class="slide-ranger-min-label"></span> <i>-</i>
		<span  class="slide-ranger-max-label"></span></label>
	<div class="slide-ranger-bar" data-min="<?php echo $ranger_min; ?>" data-max="<?php echo $ranger_max; ?>"></div>

  	<input type="hidden" class="slide-ranger-min-input" autocomplete="off" name="min_<?php echo $id; ?>" value="<?php echo (int)$input_min ; ?>" />
  	<input type="hidden" name="max_<?php echo $id; ?>" autocomplete="off" class="slide-ranger-max-input" value="<?php echo (int)$input_max ; ?>" />
  </div>
	<?php
}