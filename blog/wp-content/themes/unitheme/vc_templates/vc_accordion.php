<?php

extract(shortcode_atts(array(
    'el_class' => '',
    'collapsible' => 'no',
    'active_tab' => '1'
), $atts));

$output = '';

$output .= '<div class="nz-accordion '.$el_class.'" data-collapsible='.$collapsible.' data-active-tab="'.$active_tab.'">';
	$output .= wpb_js_remove_wpautop($content);
$output .= '</div> ';

echo $output;