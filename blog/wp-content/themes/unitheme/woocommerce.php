<?php get_header(); ?>
<?php
	
	global $nz_ninzio;
	$nz_rh_styles     = "";
    $nz_rh_pstyles    = "";

	$nz_rh                  = ($nz_ninzio['shop-rh'] && $nz_ninzio['shop-rh']  == 1) ? "true" : "false";
    $nz_rh_height           = (isset($nz_ninzio['shop-rh-height']) && $nz_ninzio['shop-rh-height']) ? esc_attr($nz_ninzio["shop-rh-height"]) : "500";
    $nz_back_color          = (isset($nz_ninzio['shop-back']['background-color']) && $nz_ninzio['shop-back']['background-color']) ? $nz_ninzio["shop-back"]['background-color'] : "";
    $nz_back_img            = (isset($nz_ninzio['shop-back']['background-image']) && $nz_ninzio['shop-back']['background-image']) ? esc_url($nz_ninzio['shop-back']['background-image']) : "";
    $nz_back_img_repeat     = (isset($nz_ninzio['shop-back']['background-repeat']) && $nz_ninzio['shop-back']['background-repeat']) ? $nz_ninzio['shop-back']['background-repeat'] : "no-repeat";
    $nz_back_img_position   = (isset($nz_ninzio['shop-back']['background-position']) && $nz_ninzio['shop-back']['background-position']) ? $nz_ninzio['shop-back']['background-position'] : "left_top";
    $nz_back_img_attachment = (isset($nz_ninzio['shop-back']['background-attachment']) && $nz_ninzio['shop-back']['background-attachment']) ? $nz_ninzio['shop-back']['background-attachment'] : "scroll";
    $nz_back_img_size       = (isset($nz_ninzio['shop-back']['background-size']) && $nz_ninzio['shop-back']['background-size']) ? $nz_ninzio['shop-back']['background-size'] : "auto";
    $nz_parallax            = ($nz_ninzio['shop-parallax'] && $nz_ninzio['shop-parallax']  == 1) ? "true" : "false";

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

    $nz_shop_sidebar   = ($nz_ninzio['shop-sidebar']) ? $nz_ninzio['shop-sidebar'] : "none";
	$nz_shop_width     = ($nz_ninzio['shop-width'] && $nz_ninzio['shop-width'] == 1) ? "true" : "false";
	$nz_shop_animation = ($nz_ninzio['shop-animation'] && $nz_ninzio['shop-animation'] == 1) ? "true" : "false";
	$nz_shop_layout    = ($nz_ninzio['shop-layout']) ? $nz_ninzio['shop-layout'] : "medium";
	$nz_shop_rp        = ($nz_ninzio['shop-rp'] && $nz_ninzio['shop-rp'] == 1) ? "true" : "false";
	$nz_shop_rpn       = ($nz_ninzio['shop-rpn']) ? $nz_ninzio['shop-rpn'] : 3;

	if ($nz_shop_sidebar == "left" || $nz_shop_sidebar == "right") {
		$nz_shop_width = "false";
	}

?>
<?php if ($nz_rh == "true"): ?>
	<header class="rich-header shop-header" data-parallax="<?php echo $nz_parallax; ?>" style="<?php echo $nz_rh_styles; ?>">
		<?php if ($nz_parallax == "true"): ?>
            <div class="parallax-container" style="<?php echo $nz_rh_pstyles; ?>">&nbsp;</div>
        <?php endif ?>
		<div class="container nz-clearfix">
       
            <?php if (is_product_category() || is_product_tag()): ?>
                <div class="page-title-content">
                    <h1 class="archive-title-heading">
                        <?php echo single_term_title('',false); ?>
                    </h1>
                </div>
            <?php else: ?>
                <?php if (isset($nz_ninzio['shop-title']) && !empty($nz_ninzio['shop-title'])): ?>
                    <div class="page-title-content"><?php echo do_shortcode(wp_kses_post($nz_ninzio['shop-title'])); ?></div>
                <?php endif ?>
                <?php if (is_product()){ninzio_post_nav($post->ID);} ?>
            <?php endif ?>

		</div>
	</header>
<?php endif ?>
<div class="shop-layout-wrap rh-<?php echo $nz_rh; ?> <?php echo $nz_shop_layout; ?>">
	<?php if(is_shop() || is_product_category() || is_product_tag()): ?>
		<div class="loop width-<?php echo $nz_shop_width; ?>">
			<div class="container">
				<section class="content lazy shop-layout animation-<?php echo $nz_shop_animation; ?> <?php echo $nz_shop_layout; ?> nz-clearfix">

					<?php
						if($nz_shop_sidebar == "left") {

							echo '<aside class="sidebar">';
								get_sidebar('shop');
							echo '</aside>';

							echo '<section class="main-content right">';
								woocommerce_content();
							echo '</section>';
							
						} elseif ($nz_shop_sidebar == "right") {

							echo '<section class="main-content left">';
								woocommerce_content();
							echo '</section>';

							echo '<aside class="sidebar">';
								get_sidebar('shop');
							echo '</aside>';

						} else {
							woocommerce_content();
						}
					?>

				</section>
			</div>
		</div>
	<?php endif; ?>
	<?php if (is_product()): ?>
		<div class="container">
			<section class='content nz-clearfix' data-rp="<?php echo $nz_shop_rp; ?>" data-rpn="<?php echo $nz_shop_rpn; ?>">
				<div class="nz-shop-posts"><?php woocommerce_content(); ?></div>
			</section>
		</div>
	<?php endif ?>
</div>
<?php get_footer(); ?>