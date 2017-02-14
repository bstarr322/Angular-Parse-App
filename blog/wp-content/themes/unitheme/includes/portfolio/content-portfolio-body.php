<?php

	global $nz_ninzio;				
	$nz_solo_layout    = "false";
	$nz_port_sidebar   = "false";

	$nz_port_width          = ($nz_ninzio['port-width'] && $nz_ninzio['port-width'] == 1) ? "true" : "false";
	$nz_port_animation      = ($nz_ninzio['port-animation'] && $nz_ninzio['port-animation'] == 1) ? "true" : "false";
	$nz_port_layout         = ($nz_ninzio['port-layout']) ? $nz_ninzio['port-layout'] : "medium";
	$nz_rh                  = ($nz_ninzio['port-rh'] && $nz_ninzio['port-rh']  == 1) ? "true" : "false";

	if($nz_ninzio['port-wa'] && $nz_ninzio['port-wa'] == 1){$nz_port_sidebar = "true";}
	if ($nz_port_layout == "no-gap-grid-3" || $nz_port_layout == "no-gap-grid-4" || $nz_port_layout == "masonry-3" || $nz_port_layout == "masonry-4") {
		$nz_port_sidebar   = "false";
	}
	if ($nz_port_sidebar == "true") {$nz_port_width = "false";}

	if (is_single()) {
		$values = get_post_custom( $post->ID );
		$nz_solo_layout    = (isset( $values['layout'][0]) && !empty($values['layout'][0]) ) ? $values["layout"][0] : "false";
	}

	if ($nz_ninzio['port-pagination'] == 0) {
		global $query_string;
		query_posts( $query_string . '&posts_per_page=-1' );
	}

?>
<div class="port-layout-wrap solo-<?php echo $nz_solo_layout; ?> <?php echo $nz_port_layout; ?>">
	
	<?php if (!is_single()): ?>
		<div class="loop width-<?php echo $nz_port_width; ?>">
			<div class="container">
				<section class="content lazy port-layout animation-<?php echo $nz_port_animation; ?> <?php echo $nz_port_layout; ?> nz-clearfix">

					<?php if ($nz_port_sidebar == "true"): ?>

						<section class="main-content left">
							<div class="nz-portfolio-posts"><?php get_template_part( '/includes/portfolio/content-portfolio-post' ); ?></div>
						</section>
						<aside class="sidebar">
							<?php if($nz_ninzio['port-wa'] && $nz_ninzio['port-wa'] == 1){get_sidebar('portfolio');;} ?>
						</aside>

					<?php else: ?>
						<div class="nz-portfolio-posts"><?php get_template_part( '/includes/portfolio/content-portfolio-post' ); ?></div>
					<?php endif ?>
				</section>
			</div>
		</div>
	<?php elseif(is_single()): ?>
		<div class="container">
			<section class='content nz-clearfix'>
				<div class="nz-portfolio-posts"><?php get_template_part( '/includes/portfolio/content-portfolio-post' ); ?></div>
			</section>
		</div>
	<?php endif; ?>
	<?php 
		if ($nz_ninzio['port-pagination'] == 1) {
			ninzio_post_nav_num();
		}
	?>
		
</div>
</div>