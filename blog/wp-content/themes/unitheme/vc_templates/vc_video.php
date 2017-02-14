<?php

	extract(shortcode_atts(array(
		'video_poster' => '',
		'webm_video'   => '',
		'mp4_video'    => '',
		'ogv_video'    => '',
		'el_class'     => '',
		'height'       => '',
		'width'        => '',
		'autoplay'     => 'off',
		'loop'         => 'off'
	), $atts));

	$output = '<div class="'.$el_class.'">'.do_shortcode('[video mp4="'.$mp4_video.'" ogv="'.$ogv_video.'" webm="'.$webm_video.'" poster="'.$video_poster.'" loop="'.$loop.'" autoplay="'.$autoplay.'" width="'.$width.'" height="'.$height.'"]').'</div>';
	echo $output;
	
?>