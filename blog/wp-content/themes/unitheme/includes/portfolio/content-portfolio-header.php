<?php  
	
	global $nz_ninzio;
	$nz_rh_styles     = "";
    $nz_rh_pstyles    = "";
	$nz_filter        = ($nz_ninzio['port-filter'] && $nz_ninzio['port-filter']  == 1) ? "true" : "false";

    if (is_single()) {

        $values                 = get_post_custom( get_the_ID() );
        $nz_rh                  = (isset( $values['rh'][0]) && !empty($values['rh'][0])) ? $values["rh"][0] : "false";
        $nz_rh_height           = (isset( $values['rh_height'][0]) && !empty($values['rh_height'][0])) ? $values["rh_height"][0] : "500";
        $nz_back_color          = (isset( $values['rh_back_color'][0]) && !empty($values['rh_back_color'][0])) ? $values["rh_back_color"][0] : "";
        $nz_back_img            = (isset( $values['rh_back_img'][0]) && !empty($values['rh_back_img'][0])) ? $values["rh_back_img"][0] : "";
        $nz_back_img_repeat     = (isset( $values['rh_back_img_repeat'][0]) && !empty($values['rh_back_img_repeat'][0])) ? $values["rh_back_img_repeat"][0] : "no-repeat";
        $nz_back_img_position   = (isset( $values['rh_back_img_position'][0]) && !empty($values['rh_back_img_position'][0])) ? $values["rh_back_img_position"][0] : "left_top";
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

    } else {

        $nz_rh                  = ($nz_ninzio['port-rh'] && $nz_ninzio['port-rh']  == 1) ? "true" : "false";
        $nz_rh_height           = (isset($nz_ninzio['port-rh-height']) && $nz_ninzio['port-rh-height']) ? esc_attr($nz_ninzio["port-rh-height"]) : "500";
        $nz_back_color          = (isset($nz_ninzio['port-back']['background-color']) && $nz_ninzio['port-back']['background-color']) ? $nz_ninzio["port-back"]['background-color'] : "";
        $nz_back_img            = (isset($nz_ninzio['port-back']['background-image']) && $nz_ninzio['port-back']['background-image']) ? esc_url($nz_ninzio['port-back']['background-image']) : "";
        $nz_back_img_repeat     = (isset($nz_ninzio['port-back']['background-repeat']) && $nz_ninzio['port-back']['background-repeat']) ? $nz_ninzio['port-back']['background-repeat'] : "no-repeat";
        $nz_back_img_position   = (isset($nz_ninzio['port-back']['background-position']) && $nz_ninzio['port-back']['background-position']) ? $nz_ninzio['port-back']['background-position'] : "left_top";
        $nz_back_img_attachment = (isset($nz_ninzio['port-back']['background-attachment']) && $nz_ninzio['port-back']['background-attachment']) ? $nz_ninzio['port-back']['background-attachment'] : "scroll";
        $nz_back_img_size       = (isset($nz_ninzio['port-back']['background-size']) && $nz_ninzio['port-back']['background-size']) ? $nz_ninzio['port-back']['background-size'] : "auto";
        $nz_parallax            = ($nz_ninzio['port-parallax'] && $nz_ninzio['port-parallax']  == 1) ? "true" : "false";

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
    }

?>
<?php if ($nz_rh == "true"): ?>
	<header class="rich-header port-header" data-parallax="<?php echo $nz_parallax; ?>" style="<?php echo $nz_rh_styles; ?>">
		<?php if ($nz_parallax == "true"): ?>
            <div class="parallax-container" style="<?php echo $nz_rh_pstyles; ?>">&nbsp;</div>
        <?php endif ?>
        <div class="container nz-clearfix">
            <?php if (is_single()): ?>
                <?php if ('' != get_the_title()): ?>
                    <div class="page-title-content">
                        <h1 class="single-post-title"><?php echo get_the_title(); ?></h1>
                    </div>
                   <?php ninzio_post_nav($post->ID); ?>
                <?php endif ?>
            <?php else: ?>
                <?php if (is_tax('portfolio-category')): ?>
                    <div class="page-title-content">
                        <h1 class="archive-title-heading">
                            <?php echo single_cat_title("", false); ?>
                        </h1>
                    </div>
                <?php else: ?>
                    <?php if (isset($nz_ninzio['port-title']) && !empty($nz_ninzio['port-title'])): ?>
                        <div class="page-title-content"><?php echo do_shortcode(wp_kses_post($nz_ninzio['port-title'])); ?></div>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
		</div>
	</header>
<?php endif ?>
<div class="for-filter filter-<?php echo $nz_filter; ?>">
<?php if (!is_single() && !is_tax('portfolio-category') && $nz_filter == "true"): ?>
	<?php

		$args = array(
		    'orderby'           => 'name', 
		    'order'             => 'ASC',
		    'hide_empty'        => true, 
		    'exclude'           => array(), 
		    'exclude_tree'      => array(), 
		    'include'           => array(),
		    'number'            => '', 
		    'fields'            => 'all', 
		    'slug'              => '', 
		    'parent'            => '',
		    'hierarchical'      => false, 
		    'child_of'          => 0, 
		    'get'               => '', 
		    'name__like'        => '',
		    'description__like' => '',
		    'pad_counts'        => false, 
		    'offset'            => '', 
		    'search'            => '', 
		    'cache_domain'      => 'core'
		);

	?>
	<div class="nz-portfolio-filter portfolio-archive-filter">
		<span class="button animate-false active hover-fill button-ghost medium rounded filter" data-group="all"><?php echo __('Show All', TEMPNAME); ?></span>
		<?php foreach(get_terms('portfolio-category',$args) as $filter_term) { ?>
			<span class="button animate-false hover-fill button-ghost medium rounded filter" data-group="<?php echo $filter_term->slug; ?>"><?php echo $filter_term->name ?></span>
		<?php } ?>
	</div>
<?php endif ?>