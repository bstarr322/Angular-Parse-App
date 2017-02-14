<?php

	extract(shortcode_atts(array(
		'color'      => '',
		'back_color' => '',
		'pl'=> '0',
      'pr'=> '0',
      'pt'=> '0',
      'pb'=> '0'
	), $atts));
   
   $styles = "";
   $output = "";

   if (isset($back_color) && !empty($back_color)) {
   		$styles .= 'background-color:'.$back_color.';';
   }

   if (isset($color) && !empty($color)) {
   		$styles .= 'color:'.$color.';';
   }

   if (isset($pl) && !empty($pl)) {$styles .= 'padding-left:'.$pl.'px;';}
   if (isset($pr) && !empty($pl)) {$styles .= 'padding-right:'.$pr.'px;';}
   if (isset($pt) && !empty($pl)) {$styles .= 'padding-top:'.$pt.'px;';}
   if (isset($pb) && !empty($pl)) {$styles .= 'padding-bottom:'.$pb.'px;';}

   $output = '<div style="'.$styles.'" class="nz-column-text nz-clearfix">'.do_shortcode($content).'</div>';
   echo $output;
	
?>