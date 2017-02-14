<?php

	global $nz_ninzio;

	$values           = get_post_custom( get_the_ID() );
	$nz_rh_styles     = "";
	$nz_rh_pstyles    = "";
	$nz_slider_status = "false";
	
	if (isset($values['slider'][0]) && $values['slider'][0] == "true") {
		$nz_slider_status = "true";
	}

	$nz_rh                  = (isset( $values['rh'][0]) && !empty($values['rh'][0])) ? $values["rh"][0] : "false";
	$nz_rh_height           = (isset( $values['rh_height'][0]) && !empty($values['rh_height'][0])) ? $values["rh_height"][0] : "500";
    $nz_back_color          = (isset( $values['rh_back_color'][0]) && !empty($values['rh_back_color'][0])) ? $values["rh_back_color"][0] : "";
    $nz_back_img            = (isset( $values['rh_back_img'][0]) && !empty($values['rh_back_img'][0])) ? $values["rh_back_img"][0] : "";
    $nz_back_img_repeat     = (isset( $values['rh_back_img_repeat'][0]) && !empty($values['rh_back_img_repeat'][0])) ? $values["rh_back_img_repeat"][0] : "no-repeat";
    $nz_back_img_position   = (isset( $values['rh_back_img_position'][0]) && !empty($values['rh_back_img_position'][0])) ? $values["rh_back_img_position"][0] : "left top";
    $nz_back_img_attachment = (isset( $values['rh_back_img_attachment'][0]) && !empty($values['rh_back_img_attachment'][0])) ? $values["rh_back_img_attachment"][0] : "scroll";
    $nz_back_img_size       = (isset( $values['rh_back_img_size'][0]) && !empty($values['rh_back_img_size'][0])) ? $values["rh_back_img_size"][0] : "auto";
    $nz_parallax            = (isset( $values['parallax'][0]) && !empty($values['parallax'][0])) ? $values["parallax"][0] : "true";

    $nz_rh_styles .= 'height:'.$nz_rh_height.'px;';
    
    if (!empty($nz_back_color)) {
    	$nz_rh_styles .= 'background-color:'.$nz_back_color.';';
	}

    if (!empty($nz_back_img)) {

    	if ($nz_parallax == "true") {
    		
	    	$nz_back_img_repeat     = "no-repeat";
			$nz_back_img_position   = "center top";
			$nz_back_img_attachment = "scroll";
			$nz_back_img_size       = "cover";

			$nz_rh_pstyles .= 'background-image:url('.$nz_back_img.');';
	    	$nz_rh_pstyles .= 'background-repeat:'.$nz_back_img_repeat.';';
	    	$nz_rh_pstyles .= 'background-attachment:'.$nz_back_img_attachment.';';
	    	if ($nz_back_img_size == "cover") {
	    		$nz_rh_pstyles .= '-webkit-background-size: cover;-moz-background-size: cover;background-size: cover;';
	    	}
	    	$nz_rh_pstyles .= 'background-position:'.$nz_back_img_position.';';

	    } else {
	    	$nz_rh_styles .= 'background-image:url('.$nz_back_img.');';
	    	$nz_rh_styles .= 'background-repeat:'.$nz_back_img_repeat.';';
	    	$nz_rh_styles .= 'background-attachment:'.$nz_back_img_attachment.';';
	    	if ($nz_back_img_size == "cover") {
	    		$nz_rh_styles .= '-webkit-background-size: cover;-moz-background-size: cover;background-size: cover;';
	    	}
	    	$nz_rh_styles .= 'background-position:'.$nz_back_img_position.';';
	    }

    	
    }

?>
<?php if ($nz_slider_status == "true") : ?>
	<?php get_template_part('includes/ninzio-slider'); ?>
<?php else: ?>
	<?php if ($nz_rh == "true"): ?>
		<header class="rich-header page-header" data-parallax="<?php echo $nz_parallax; ?>" style="<?php echo $nz_rh_styles; ?>">
			<?php if ($nz_parallax == "true"): ?>
				<div class="parallax-container" style="<?php echo $nz_rh_pstyles; ?>">&nbsp;</div>
			<?php endif ?>
			<div class="container nz-clearfix">
				<?php if (isset($values['rh_content'][0]) && !empty($values['rh_content'][0])): ?>
					<div class="page-title-content"><?php echo do_shortcode(wp_kses_post($values['rh_content'][0])); ?></div>
				<?php endif ?>
			</div>
		</header>
	<?php endif ?>
<?php endif ?>
