<?php if (is_page()){ 

	global $nz_ninzio;

	$nz_one_page_speed  = ($nz_ninzio['one-page-speed']) ? esc_js($nz_ninzio['one-page-speed']) : 750;
	$nz_one_page_hash   = ($nz_ninzio['one-page-hash'] && $nz_ninzio['one-page-hash'] == 1) ? 'true' : 'false';
	$nz_fixed_height    = ($nz_ninzio['fixed-height']) ? $nz_ninzio['fixed-height'] : '90';
	$nz_one_page_nav    = ($nz_ninzio['one-page-navigation']) ? $nz_ninzio['one-page-navigation'] : 'side';
	$nz_one_page_filter = (isset($nz_ninzio['one-page-filter']) && $nz_ninzio['one-page-filter']) ? esc_js(explode(',',$nz_ninzio['one-page-filter'])) : '';
	$nz_filter_array    = array();
	$nz_one_page_status = "false";

	if (is_array($nz_one_page_filter)) {
		foreach ($nz_one_page_filter as $filter) {
			array_push($nz_filter_array, '.menu-item-'.$filter.'> a');
		}
	}

	$values = get_post_custom( get_the_ID() );
	if (isset($values['one_page'][0]) && $values['one_page'][0] == "true") {
		$nz_one_page_status = "true";
	}
?>

	<?php if ($nz_one_page_status == "true"): ?>

		<script>
			//<![CDATA[
				(function($){
					$(document).ready(function(){

						if (Modernizr.mq("only screen and (min-width: 1280px)")) {

							<?php if($nz_one_page_nav == "top"): ?>

								$('ul#header-menu').singlePageNav({
								    currentClass: 'one-page-active',
								    speed: <?php echo $nz_one_page_speed; ?>,
									<?php if($nz_ninzio['fixed'] && $nz_ninzio['fixed'] == 1): ?>offset: "<?php echo $nz_fixed_height; ?>",<?php endif; ?>
								    easing: "swing",
								    updateHash: <?php echo $nz_one_page_hash; ?>,
								    <?php if(!empty($nz_filter_array)): ?>
								    filter:':not(<?php echo implode(',', $nz_filter_array); ?>)'
								    <?php endif; ?>
								});

							<?php else: ?>

								$('ul#one-page-bullets').singlePageNav({
							    	currentClass: 'one-page-active',
								    speed: <?php echo $nz_one_page_speed; ?>,
									<?php if($nz_ninzio['fixed'] && $nz_ninzio['fixed'] == 1): ?>offset: "<?php echo $nz_fixed_height; ?>",<?php endif; ?>
								    easing: "swing",
								    updateHash: <?php echo $nz_one_page_hash; ?>,
								    <?php if(!empty($nz_filter_array)): ?>
								    filter:':not(<?php echo implode(',', $nz_filter_array); ?>)'
								    <?php endif; ?>
								});

							<?php endif; ?>

						};
						
					});
				})(jQuery);
			//]]>
		</script>

		<?php if($nz_one_page_nav == "side"): ?>
			<?php
				$arg = array( 
					'theme_location' => 'one-page-bullets', 
					'depth'          => 1, 
					'container'      => false, 
					'menu_id'        => 'one-page-bullets',
					'link_before'    => '',
					'link_after'     => ''
				);
			?>
			<div class="one-page-bullets"><?php wp_nav_menu($arg); ?></div>
		<?php endif; ?>

	<?php endif; ?>

<?php } ?>
