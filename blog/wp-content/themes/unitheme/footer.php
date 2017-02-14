	<?php global $nz_ninzio;?>

		<!-- footer start -->
		<footer class='footer'>
			<?php get_sidebar('footer'); ?>
			<div class="footer-content">
				<div class="container nz-clearfix">
					<?php if ($nz_ninzio['footer-social-links'] && $nz_ninzio['footer-social-links'] == 1): ?>
						<div class="social-links">
							<?php include(locate_template("/includes/social-links.php")); ?>
						</div>
					<?php endif ?>
					<?php if (has_nav_menu("footer-menu")): ?>
						<nav class="footer-menu nz-clearfix">
							<?php

								$arg = array( 
									'theme_location' => 'footer-menu', 
									'depth'          => 1, 
									'container'      => false, 
									'menu_id'        => 'footer-menu', 
								);
								wp_nav_menu($arg); 
							?>
						</nav>
					<?php endif ?>
					<div class="footer-info">
						<?php if ($nz_ninzio['footer-copyright']) { ?>
							<?php echo wp_kses_post($nz_ninzio['footer-copyright']); ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</footer>
		<!-- footer end -->

	</div>
	<!-- wrap end -->

</div>
<!-- general wrap end -->
<?php if ($nz_ninzio['sidebar'] && $nz_ninzio['sidebar'] == 1){get_sidebar('sidebar');}; ?>
<a class="icon-arrow-up7" id="top" href="#wrap"></a>
<?php if (isset($nz_ninzio['google-analytics']) && !empty($nz_ninzio['google-analytics'])) {
	echo '<script>'.$nz_ninzio['google-analytics'].'</script>';
} ?>
<?php include(locate_template("includes/dynamic-scripts.php")); ?>
<?php wp_footer(); ?>
</body>
</html>