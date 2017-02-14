<?php
extract(shortcode_atts($this->predefined_atts, $atts));
$output = "";
$output .= '<div id="tab-'. (empty($tab_id) ? sanitize_title( $title ) : $tab_id) .'" class="tab-content">';
$output .= ($content=='' || $content==' ') ? __("Empty tab. Edit page to add content here.", TEMPNAME) : wpb_js_remove_wpautop($content);
$output .= "\n\t\t\t" . '</div> ';

echo $output;