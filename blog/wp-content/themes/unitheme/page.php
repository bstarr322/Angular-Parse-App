<?php get_header(); ?>
<?php get_template_part( '/includes/page/content-page-header' ); ?>
<?php

	$values          = get_post_custom( get_the_ID() );
	$nz_sidebar      = (isset($values["sidebar"][0])) ? $values["sidebar"][0] : "none";
	$nz_sidebar_pos  = (isset($values["sidebar_pos"][0])) ? $values["sidebar_pos"][0] : "left";
	$nz_padding      = (isset($values["padding"][0])) ? $values["padding"][0] : "true";
	$nz_layout_class = (isset($values["layout"][0]) && $values["layout"][0] == "true") ? "page-full-width" : "page-standard-width";

	if ($nz_sidebar == "none") {$nz_sidebar_pos = "none";}
	if ($nz_sidebar_pos != "none"){$nz_layout_class = "page-standard-width";$nz_padding = "true";}
?>
<div class='container <?php echo $nz_layout_class; ?>'>
	<!-- content start -->
	<div id="nz-content" class='content nz-clearfix padding-<?php echo $nz_padding; ?>'>
		<?php

			if($nz_sidebar_pos == "left") {

				echo '<div class="sidebar">';
					get_sidebar('page');
				echo '</div>';

				echo '<div class="main-content right">';
					get_template_part( '/includes/page/content-page-body' );
				echo '</div>';
				
			} elseif ($nz_sidebar_pos == "right") {

				echo '<div class="main-content left">';
					get_template_part( '/includes/page/content-page-body' );
				echo '</div>';

				echo '<div class="sidebar">';
					get_sidebar('page');
				echo '</div>';

			} else {
				echo get_template_part( '/includes/page/content-page-body' );
			}

		?>
	</div>
	<!-- content end -->
</div>
<!-- container end -->
<?php get_footer(); ?>