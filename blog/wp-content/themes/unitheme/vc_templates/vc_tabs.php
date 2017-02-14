<?php

extract( shortcode_atts( array(
	'title'    => '',
	'type'     => 'horizontal',
	'el_class' => ''
), $atts ) );

$output = '';

// Extract tab titles
preg_match_all( '/vc_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}
$tabs_nav = '';
$tabs_nav .= '<div class="tabset nz-clearfix">';
foreach ( $tab_titles as $tab ) {
	$tab_atts = shortcode_parse_atts($tab[0]);
	if(isset($tab_atts['title'])) {
		$tabs_nav .= '<span class="tab">'. $tab_atts['title'] . '</span>';
	}
}
$tabs_nav .= '</div>';
$output .= '<div class="nz-tabs ' . $el_class . ' '.$type.'">';
$output .= $tabs_nav;
$output .= '<div class="tabs-container">'.wpb_js_remove_wpautop( $content ).'</div>';
$output .= '</div> ';

echo $output;