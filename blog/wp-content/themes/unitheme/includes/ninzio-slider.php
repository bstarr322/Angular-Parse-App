<?php

global  $nz_ninzio;

$styles                  = '';
$styles_320              = '';
$styles_480              = '';
$styles_768              = '';
$styles_768_less         = ''; 
$styles_1024             = '';
$styles_1025             = '';
$prefixes                = array('-webkit-', '');
$nz_slider_back_col 	 = (isset($nz_ninzio['slider-background']['background-color']) && $nz_ninzio['slider-background']['background-color']) ? $nz_ninzio['slider-background']['background-color'] : "#121a2f";
$nz_slider_back_img 	 = (isset($nz_ninzio['slider-background']['background-image']) && $nz_ninzio['slider-background']['background-image']) ? esc_url($nz_ninzio['slider-background']['background-image']) : "";
$nz_slider_back_r   	 = (isset($nz_ninzio['slider-background']['background-repeat']) && $nz_ninzio['slider-background']['background-repeat']) ? $nz_ninzio['slider-background']['background-repeat'] : "no-repeat";
$nz_slider_back_s   	 = (isset($nz_ninzio['slider-background']['background-size']) && $nz_ninzio['slider-background']['background-size']) ? $nz_ninzio['slider-background']['background-size'] : "inherit";
$nz_slider_back_a   	 = (isset($nz_ninzio['slider-background']['background-attachment']) && $nz_ninzio['slider-background']['background-attachment']) ? $nz_ninzio['slider-background']['background-attachment'] : "inherit";
$nz_slider_back_p   	 = (isset($nz_ninzio['slider-background']['background-position']) && $nz_ninzio['slider-background']['background-position']) ? $nz_ninzio['slider-background']['background-position'] : "left top";
$nz_slider_layout        = ($nz_ninzio['layout']) ? $nz_ninzio['layout'] : "full";
$nz_slider_height        = ($nz_ninzio['slider-height']) ? esc_attr($nz_ninzio['slider-height']) : "500";
$nz_slider_autoplaydelay = ($nz_ninzio['slider-autoplay-d']) ? esc_attr($nz_ninzio['slider-autoplay-d']) : "5000";
$nz_slider_autoplay      = ($nz_ninzio['slider-autoplay'] && $nz_ninzio['slider-autoplay'] == 1) ? "true" : "false";
$nz_slider_bullets       = ($nz_ninzio['slider-bullets'] && $nz_ninzio['slider-bullets'] == 1) ? "true" : "false";
$nz_slider_parallax      = ($nz_ninzio['slider-parallax'] && $nz_ninzio['slider-parallax'] == 1) ? "true" : "false";
$nz_slider_fixed         = ($nz_ninzio['slider-fixed'] && $nz_ninzio['slider-fixed'] == 1) ? "true" : "false";
$nz_slider_mobile        = ($nz_ninzio['slider-mob'] && $nz_ninzio['slider-mob'] == 1) ? "true" : "false";
$nz_slider_transition    = ($nz_ninzio['slider-transition']) ? $nz_ninzio['slider-transition'] : "fade";
$nz_slider_autoheight    = ($nz_ninzio['slider-autoheight'] && $nz_ninzio['slider-autoheight'] == 1) ? "true" : "false";
$nz_slider_arrow         = ($nz_ninzio['slider-arrow'] && $nz_ninzio['slider-arrow'] == 1) ? "true" : "false";
$transition_delay        = 0;

if ($nz_slider_transition == "side-swing" || $nz_slider_transition == "push-reveal" || $nz_slider_transition == "press-away") {
	$transition_delay = 900;
} elseif ($nz_slider_transition == "soft-scale") {
	$transition_delay = 500;
} else {
	$transition_delay = 300;
}

$styles .="#ninzio-slider {background-color:".$nz_slider_back_col.";"; ?>
<?php if(!empty($nz_slider_back_img)){
	$styles .="background-image:url(".$nz_slider_back_img.");";
	$styles .="background-repeat:".$nz_slider_back_r.";";
	$styles .="background-attachment:".$nz_slider_back_a.";";
	$styles .="-webkit-background-size:".$nz_slider_back_s.";";
	$styles .="-moz-background-size:".$nz_slider_back_s.";";
	$styles .="background-size:".$nz_slider_back_s.";";
	$styles .="background-position:".$nz_slider_back_p.";";
} ?>
<?php $styles .="} "; ?>

<?php

	$nz_ninzio_slider_opt = array( 
		'post_type'      => 'ninzio-slider', 
		'posts_per_page' => -1, 
		'orderby'        => 'menu_order', 
		'order'          => 'ASC'
	);

	$nz_ninzio_slider = new WP_Query($nz_ninzio_slider_opt);

?>
<div id="ninzio-slider" data-autoheight="<?php echo $nz_slider_autoheight; ?>" data-arrow="<?php echo $nz_slider_arrow; ?>" data-parallax="<?php echo $nz_slider_parallax; ?>" data-fixed="<?php echo $nz_slider_fixed; ?>" data-transition="<?php echo $nz_slider_transition; ?>" data-layout="<?php echo $nz_slider_layout; ?>" data-height="<?php echo $nz_slider_height; ?>" data-mobile="<?php echo $nz_slider_mobile; ?>" data-autoplaydelay="<?php echo $nz_slider_autoplaydelay; ?>" data-autoplay="<?php echo $nz_slider_autoplay; ?>" data-bullets="<?php echo $nz_slider_bullets; ?>">
<div class="slider-loader">&nbsp;</div>
<div id="slider-arrow" data-target="#nz-content" class="i-separator animate nz-clearfix"><i class="icon-arrow-down2"></i></div>
<?php if($nz_ninzio_slider->have_posts()){ ?>
	<ul class="ninzio-slides">

		<?php while($nz_ninzio_slider->have_posts()) : $nz_ninzio_slider->the_post(); ?>	

			<?php

				$values = get_post_custom( $post->ID ); 
				$background_video_mp4        = (isset( $values['background_video_mp4'][0] ) && !empty( $values['background_video_mp4'][0])) ? $values["background_video_mp4"][0] : "";
			    $background_video_ogv        = (isset( $values['background_video_ogv'][0] ) && !empty( $values['background_video_ogv'][0])) ? $values["background_video_ogv"][0] : "";
			    $background_video_webm       = (isset( $values['background_video_webm'][0] ) && !empty($values['background_video_webm'][0])) ? $values["background_video_webm"][0] : "";
				$background_video            = (!empty($background_video_mp4) || !empty($background_video_ogv) || !empty($background_video_webm)) ? "true" : "false";
			?>

			<li <?php post_class() ?> data-video="<?php echo $background_video; ?>" id="post-<?php the_ID(); ?>">

				<?php if ($background_video == "true"): ?>
					<video class="slide-back-video" preload="auto" loop="loop" muted="muted" poster="<?php echo IMAGES.'/transparent.png'; ?>">
						<?php if ($background_video_mp4): ?>
					    	<source type="video/mp4" src="<?php echo $background_video_mp4; ?>"/>
					    <?php endif ?>
					    <?php if ($background_video_webm): ?>
					    	<source type="video/webm" src="<?php echo $background_video_webm; ?>"/>
					    <?php endif ?>
					    <?php if ($background_video_ogv): ?>
					    	<source type="video/ogg" src="<?php echo $background_video_ogv; ?>"/>
					    <?php endif ?>
					</video>
				<?php endif ?>

				<?php if ($nz_slider_parallax == "true"): ?>
					<div class="parallax-container">&nbsp;</div>
				<?php endif ?>

				<div class="slider-canvas container">

					<?php

						$styles .= '.ninzio-slides li#post-'.get_the_ID().'{';

							if (isset($values["background_color"][0]) && !empty($values["background_color"][0])) {
								$styles .= 'background-color:'.$values["background_color"][0].';';
							}

						$styles .= "}";

						if (isset($values["background_image"][0]) && !empty($values["background_image"][0])) {
							if (!empty($background_video_mp4) || !empty($background_video_webm) || !empty($background_video_ogv)) {
								$styles_768_less .= '.ninzio-slides li#post-'.get_the_ID().'{';
									$styles_768_less .= 'background-image:url('.$values["background_image"][0].');';
								$styles_768_less .= "}";
							} else {

								if ($nz_slider_parallax == "true") {
									$styles .= '.ninzio-slides li#post-'.get_the_ID().' > .parallax-container {';
										$styles .= 'background-image:url('.$values["background_image"][0].');';
									$styles .= "}";
								} else {
									$styles .= '.ninzio-slides li#post-'.get_the_ID().'{';
										$styles .= 'background-image:url('.$values["background_image"][0].');';
									$styles .= "}";
								}
							}
						}

						if (isset($values["background_video_pattern"][0]) && !empty($values["background_video_pattern"][0])) {
							$styles .= '.ninzio-slides li#post-'.get_the_ID().':after{';
								$styles .= 'position: absolute;top: -1px;right: 0px;width: 100%;height: 100%;overflow: hidden;display: block;background-repeat: repeat;background-position: left top;content: "";';
								$styles .= 'background-image: url('.$values["background_video_pattern"][0].');';
							$styles .= "}";
						}

					?>

					<?php for ($i=1; $i <= 5; $i++) { ?>
						<?php if(!empty($values["layer_$i"][0])) { ?>
							<?php

					    		${"layer_delay_$i"}     = isset( $values["layer_delay_$i"] )? $values["layer_delay_$i"][0] : "0";
					    		${"layer_duration_$i"}  = isset( $values["layer_duration_$i"] )? $values["layer_duration_$i"][0] : "0";
					    		${"layer_zindex_$i"}    = isset( $values["layer_zindex_$i"] )? $values["layer_zindex_$i"][0] : "1";
					    		${"layer_direction_$i"} = isset( $values["layer_direction_$i"] ) ? $values["layer_direction_$i"][0] : "none";
					    		${"layer_posx_$i"}      = isset( $values["layer_posx_$i"] )? $values["layer_posx_$i"][0] : "0";
					    		${"layer_posy_$i"}      = isset( $values["layer_posy_$i"] )? $values["layer_posy_$i"][0] : "0";

					    		$styles .= " .active #ninzio-layer-$post->ID-$i{";
									$styles .='z-index:'.${"layer_zindex_$i"}.';';
									foreach ($prefixes as $prefix) {
										$styles .= $prefix.'transition-duration:'.${"layer_duration_$i"}.'ms;';
										$styles .= $prefix.'transition-delay:'.(${"layer_delay_$i"}+$transition_delay).'ms;';
									}
								$styles .= "}";

								$styles .= ".ninzio-slider.first-active #ninzio-layer-$post->ID-$i{";
									foreach ($prefixes as $prefix) {
										$styles .= $prefix.'transition-delay:'.${"layer_delay_$i"}.'ms;';
									}
								$styles .= "}";

					    		// DEFAULT
								/*======================*/

									switch (${"layer_direction_$i"}) {

										case 'left':
										case 'right':

										if ($nz_slider_mobile) {

											$styles_320 .= " #ninzio-layer-$post->ID-$i{";
												$styles_320 .='top:'.round(${"layer_posy_$i"}*0.25, 0).'px !important;';
											$styles_320 .= "}";

											$styles_480 .= " #ninzio-layer-$post->ID-$i{";
												$styles_480 .='top:'.round(${"layer_posy_$i"}*0.38, 0).'px !important;';
											$styles_480 .= "}";

										}

										$styles_768 .= " #ninzio-layer-$post->ID-$i{";
											$styles_768 .='top:'.round(${"layer_posy_$i"}*0.62, 0).'px !important;';
										$styles_768 .= "}";

										$styles_1024 .= " #ninzio-layer-$post->ID-$i{";
											$styles_1024 .='top:'.round(${"layer_posy_$i"}*0.82, 0).'px !important;';
										$styles_1024 .= "}";

										$styles_1025 .= " #ninzio-layer-$post->ID-$i{";
											$styles_1025 .='top:'.${"layer_posy_$i"}.'px !important;';
										$styles_1025 .= "}";

										break;

										case 'top':
										case 'bottom':

										if ($nz_slider_mobile) {

											$styles_320 .= " #ninzio-layer-$post->ID-$i{";
												$styles_320 .='left:'.round(${"layer_posx_$i"}*0.25, 0).'px !important;';
											$styles_320 .= "}";

											$styles_480 .= " #ninzio-layer-$post->ID-$i{";
												$styles_480 .='left:'.round(${"layer_posx_$i"}*0.38, 0).'px !important;';
											$styles_480 .= "}";

										}

										$styles_768 .= " #ninzio-layer-$post->ID-$i{";
											$styles_768 .='left:'.round(${"layer_posx_$i"}*0.62, 0).'px !important;';
										$styles_768 .= "}";

										$styles_1024 .= " #ninzio-layer-$post->ID-$i{";
											$styles_1024 .='left:'.round(${"layer_posx_$i"}*0.82, 0).'px !important;';
										$styles_1024 .= "}";

										$styles_1025 .= " #ninzio-layer-$post->ID-$i{";
											$styles_1025 .='left:'.${"layer_posx_$i"}.'px !important;';
										$styles_1025 .= "}";

										break;

									}

								// ACTIVE
								/*======================*/

									if ($nz_slider_mobile) {

										$styles_320 .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
											$styles_320 .='top:'.round(${"layer_posy_$i"}*0.25, 0).'px !important;';
											$styles_320 .='left:'.round(${"layer_posx_$i"}*0.25, 0).'px !important;';
										$styles_320 .= "}";

										$styles_480 .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
											$styles_480 .='top:'.round(${"layer_posy_$i"}*0.38, 0).'px !important;';
											$styles_480 .='left:'.round(${"layer_posx_$i"}*0.38, 0).'px !important;';
										$styles_480 .= "}";

									}

									$styles_768 .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
										$styles_768 .='top:'.round(${"layer_posy_$i"}*0.62, 0).'px !important;';
										$styles_768 .='left:'.round(${"layer_posx_$i"}*0.62, 0).'px !important;';
									$styles_768 .= "}";

									$styles_1024 .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
										$styles_1024 .='top:'.round(${"layer_posy_$i"}*0.82, 0).'px !important;';
										$styles_1024 .='left:'.round(${"layer_posx_$i"}*0.82, 0).'px !important;';
									$styles_1024 .= "}";

									$styles_1025 .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
										$styles_1025 .='top:'.${"layer_posy_$i"}.'px !important;';
										$styles_1025 .='left:'.${"layer_posx_$i"}.'px !important;';
									$styles_1025 .= "}";
									
							?> 
							<div id="ninzio-layer-<?php echo $post->ID."-".$i; ?>" class="ninzio-layer <?php echo ${"layer_direction_$i"}; ?>" data-direction="<?php echo ${"layer_direction_$i"}; ?>" data-posx="<?php echo ${"layer_posx_$i"}; ?>" data-posy="<?php echo ${"layer_posy_$i"}; ?>">
								<?php echo apply_filters('the_content', $values["layer_$i"][0] ); ?>
							</div>
						<?php } ?>
					<?php } ?>

				</div>

			</li>

		<?php endwhile; ?>

	</ul>
	<style>
		<?php echo $styles; ?>
		<?php if($nz_slider_mobile): ?>
		@media only screen and (min-width: 320px){
			#ninzio-slider {height: <?php echo round($nz_slider_height*0.25, 0); ?>px;}
			<?php echo $styles_320; ?>
			#ninzio-slider .ninzio-layer {
				-webkit-transform: scale(0.25,0.25);
				-ms-transform: scale(0.25,0.25);
				transform: scale(0.25,0.25);
			}
		}
		@media only screen and (min-width: 480px){
			#ninzio-slider {height: <?php echo round($nz_slider_height*0.38, 0); ?>px;}
			<?php echo $styles_480; ?>
			#ninzio-slider .ninzio-layer {
				-webkit-transform: scale(0.38,0.38);
				-ms-transform: scale(0.38,0.38);
				transform: scale(0.38,0.38);
			}
		}
		@media only screen and (max-width: 767px){
			<?php echo $styles_768_less; ?>
		}
		<?php endif; ?>
		@media only screen and (min-width: 768px){
			#ninzio-slider {height: <?php echo round($nz_slider_height*0.62, 0); ?>px;}
			<?php echo $styles_768; ?>
			#ninzio-slider .ninzio-layer {
				-webkit-transform: scale(0.62,0.62);
				-ms-transform: scale(0.62,0.62);
				transform: scale(0.62,0.62);
			}
		}
		@media only screen and (min-width: 1024px){
			#ninzio-slider {height: <?php echo round($nz_slider_height*0.82, 0); ?>px;}
			<?php echo $styles_1024; ?>
			#ninzio-slider .ninzio-layer {
				-webkit-transform: scale(0.82,0.82);
				-ms-transform: scale(0.82,0.82);
				transform: scale(0.82,0.82);
			}
		}
		@media only screen and (min-width: 1025px){
			#ninzio-slider {height: <?php echo $nz_slider_height; ?>px;}
			<?php echo $styles_1025; ?>
			#ninzio-slider .ninzio-layer {
				-webkit-transform: scale(1,1);
				-ms-transform: scale(1,1);
				transform: scale(1,1);
			}
		}
	</style>
<?php } ?>
</div>

<?php wp_reset_query(); ?>