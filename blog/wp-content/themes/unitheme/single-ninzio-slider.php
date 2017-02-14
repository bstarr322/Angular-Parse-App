<?php if ( current_user_can('manage_options') ): ?>

	<?php get_header(); ?>

	<?php 
		global  $nz_ninzio;
		$styles = '';
		$prefixes = array('-webkit-', '');
		$data_height = ($nz_ninzio['slider-height']) ? $nz_ninzio['slider-height'] : "500";
		$nz_slider_back_col 	 = ($nz_ninzio['slider-background']['background-color']) ? $nz_ninzio['slider-background']['background-color'] : "#121a2f";
		$nz_slider_back_img 	 = ($nz_ninzio['slider-background']['background-image']) ?  esc_url($nz_ninzio['slider-background']['background-image']) : "";
		$nz_slider_back_r   	 = ($nz_ninzio['slider-background']['background-repeat']) ? $nz_ninzio['slider-background']['background-repeat'] : "no-repeat";
		$nz_slider_back_s   	 = ($nz_ninzio['slider-background']['background-size']) ? $nz_ninzio['slider-background']['background-size'] : "inherit";
		$nz_slider_back_a   	 = ($nz_ninzio['slider-background']['background-attachment']) ? $nz_ninzio['slider-background']['background-attachment'] : "inherit";
		$nz_slider_back_p   	 = ($nz_ninzio['slider-background']['background-position']) ? $nz_ninzio['slider-background']['background-position'] : "left top";
		
		$styles .="#ninzio-slider {background-color:".$nz_slider_back_col.";";

	?>

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

		<?php if (have_posts()) : ?>

			<section id="ninzio-slider" class="preview" data-height="<?php echo $data_height; ?>">
				<div class="slider-loader">&nbsp;</div>
				<div class="grid">
					<span class="grid-line grid_1_v">&nbsp;</span>
					<span class="grid-line grid_2_v">&nbsp;</span>
					<span class="grid-line grid_3_v">&nbsp;</span>
					<span class="grid-line grid_4_v">&nbsp;</span>
					<span class="grid-line grid_5_v">&nbsp;</span>
					<span class="grid-line grid_6_v">&nbsp;</span>
					<span class="grid-line grid_7_v">&nbsp;</span>
					<span class="grid-line grid_8_v">&nbsp;</span>
					<span class="grid-line grid_9_v">&nbsp;</span>
					<span class="grid-line grid_1_h">&nbsp;</span>
					<span class="grid-line grid_2_h">&nbsp;</span>
					<span class="grid-line grid_3_h">&nbsp;</span>
					<span class="grid-line grid_4_h">&nbsp;</span>
					<span class="grid-line grid_5_h">&nbsp;</span>
				</div>

				<ul class="ninzio-slides">

					<?php while (have_posts()) : the_post(); ?>	

						<?php

							$values = get_post_custom( $post->ID ); 
							$background_video_mp4        = (isset( $values['background_video_mp4'][0] ) && !empty( $values['background_video_mp4'][0])) ? $values["background_video_mp4"][0] : "";
						    $background_video_ogv        = (isset( $values['background_video_ogv'][0] ) && !empty( $values['background_video_ogv'][0])) ? $values["background_video_ogv"][0] : "";
						    $background_video_webm       = (isset( $values['background_video_webm'][0] ) && !empty($values['background_video_webm'][0])) ? $values["background_video_webm"][0] : "";
						    $background_image            = (isset($values["background_image"][0]) && !empty($values["background_image"][0])) ? $values["background_image"][0] : "";
							$background_video            = (!empty($background_video_mp4) || !empty($background_video_ogv) || !empty($background_video_webm)) ? "true" : "false";
						?>

						<li <?php post_class() ?> data-video="<?php echo $background_video; ?>" id="post-<?php the_ID(); ?>">

							<?php if ($background_video == "true"): ?>
								<video class="slide-back-video" preload="auto" loop="loop" muted="muted" poster="<?php echo IMAGES.'/transparent.png'; ?>">
									<?php if ($background_video_mp4): ?>
								    	<source type="video/mp4; codecs=avc1.42E01E,mp4a.40.2" src="<?php echo $background_video_mp4; ?>"></source>
								    <?php endif ?>
								    <?php if ($background_video_webm): ?>
								    	<source type="video/webm; codecs=vp8,vorbis" src="<?php echo $background_video_webm; ?>"></source>
								    <?php endif ?>
								    <?php if ($background_video_ogv): ?>
								    	<source type="video/ogg; codecs=theora,vorbis" src="<?php echo $background_video_ogv; ?>"></source>
								    <?php endif ?>
								</video>
							<?php endif ?>

							<div class="slider-canvas container">

								<?php

									$styles .= '.ninzio-slides li#post-'.get_the_ID().'{';

										if (isset($values["background_color"][0]) && !empty($values["background_color"][0])) {
											$styles .= 'background-color:'.$values["background_color"][0].';';
										}

										if (!empty($background_image)) {
											$styles .= 'background-image:url('.$background_image.');';
										}

									$styles .= "}";

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

								    		$styles .= " #ninzio-layer-$post->ID-$i{";
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

													$styles .= " #ninzio-layer-$post->ID-$i{";
														$styles .='top:'.${"layer_posy_$i"}.'px !important;';
														$styles .='left:'.(${"layer_posx_$i"}-100).'px !important;';
													$styles .= "}";

													break;

													case 'right':

													$styles .= " #ninzio-layer-$post->ID-$i{";
														$styles .='top:'.${"layer_posy_$i"}.'px !important;';
														$styles .='left:'.(${"layer_posx_$i"}+100).'px !important;';
													$styles .= "}";

													break;

													case 'top':

													$styles .= " #ninzio-layer-$post->ID-$i{";
														$styles .='top:'.(${"layer_posy_$i"}-100).'px !important;';
														$styles .='left:'.${"layer_posx_$i"}.'px !important;';
													$styles .= "}";

													break;

													case 'bottom':

													$styles .= " #ninzio-layer-$post->ID-$i{";
														$styles .='top:'.(${"layer_posy_$i"}+100).'px !important;';
														$styles .='left:'.${"layer_posx_$i"}.'px !important;';
													$styles .= "}";

													break;
												}

											// ACTIVE
											/*======================*/
												
												$styles .= " .active #ninzio-layer-$post->ID-$i, #ninzio-layer-$post->ID-$i.none {";
													$styles .='top:'.${"layer_posy_$i"}.'px !important;';
													$styles .='left:'.${"layer_posx_$i"}.'px !important;';
												$styles .= "}";
												
										?> 
										<div id="ninzio-layer-<?php echo $post->ID."-".$i; ?>" class="ninzio-layer <?php echo ${"layer_direction_$i"}; ?>" data-posx="<?php echo ${"layer_posx_$i"}; ?>" data-posy="<?php echo ${"layer_posy_$i"}; ?>">
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
					#ninzio-slider {height: <?php echo $data_height; ?>px;}
				</style>

			</section>

			<aside class="container nz-clearfix" id="ninzio-slider-preview-panel">
				<div id="ninzio-slider-coords">
					<div><span class="posx-label"><?php echo __("X coordinate:", TEMPNAME); ?></span>&nbsp;<span class="posx"></span></div>
					<div><span class="posy-label"><?php echo __("Y coordinate:", TEMPNAME); ?></span>&nbsp;<span class="posy"></span></div>
				</div>
				<div id="ninzio-slider-controls">
					<button class="button small" id="animate-in"><?php echo __("Animate-in", TEMPNAME) ?></button>
					<button class="button small" id="animate-out"><?php echo __("Animate-out", TEMPNAME) ?></button>
				</div>
			</aside>

			<div class="error-message device-message">
				<?php echo __("In order to preview Ninzio Slider you need a device with a screen at least 768 pixels wide.", TEMPNAME); ?>
			</div>

		<?php endif; ?>

	<?php get_footer(); ?>

<?php else: ?>

	<p class="error-message"><?php echo __("You do not have permission to view this page.", TEMPNAME); ?></p>

<?php endif; ?>