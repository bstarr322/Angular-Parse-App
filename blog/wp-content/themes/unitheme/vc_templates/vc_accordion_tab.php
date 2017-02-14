<?php

extract(shortcode_atts(array(
	'title' => '',
	'open'  => 'false'
), $atts));

$output = '';

if($open == 'true'){
	$open = "active";
}

$output .= '<div class="'.$open.' toggle-title nz-clearfix">';
	$output .= '<span class="arrow icon-plus4"></span><span class="toggle-title-header">'.$title.'</span>';
$output .= '</div> ';
$output .= '<div id="'.sanitize_title($title).'" class="toggle-content nz-clearfix">';
    $output .= wpb_js_remove_wpautop($content);
$output .= '</div>';

echo $output;