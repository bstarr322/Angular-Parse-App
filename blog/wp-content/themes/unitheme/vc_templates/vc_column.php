<?php

	extract(shortcode_atts(array(
		'width'   => '1/1',
		'animate' => 'false',
		'effect'  => 'fade-left',
		'margin_b' => 'true',
		'text_align' => 'left',
		'el_class'=> '',
		'pl'=> '0',
		'pr'=> '0',
		'pt'=> '0',
		'pb'=> '0'
	), $atts));

	$output = "";
	$styles = "";
	$width  = ninzio_column_convert($width);

	if ($margin_b == "false") {
		$margin_b = 'data-margin="false"';
	} else {
		$margin_b = "";
	}

	if (isset($pl) && !empty($pl)) {$styles .= 'padding-left:'.$pl.'px;';}
	if (isset($pr) && !empty($pl)) {$styles .= 'padding-right:'.$pr.'px;';}
	if (isset($pt) && !empty($pl)) {$styles .= 'padding-top:'.$pt.'px;';}
	if (isset($pb) && !empty($pl)) {$styles .= 'padding-bottom:'.$pb.'px;';}

	$output .= '<div class="col '.$width.' '.$el_class.' col-animate-'.$animate.'" data-align="'.$text_align.'" data-effect="'.$effect.'" '.$margin_b.'>';
		$output .='<div class="col-inner" style="'.$styles.'">'.do_shortcode($content).'</div>';
	$output .= '</div>';
	echo $output;
	
?>