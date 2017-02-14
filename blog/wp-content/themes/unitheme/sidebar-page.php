<?php
	$values      = get_post_custom( get_the_ID() );
	$nz_sidebar  = (isset($values["sidebar"][0])) ? $values["sidebar"][0] : "page-sidebar-1";
?>
<?php if ($nz_sidebar != "none"): ?>
	<div class='page-widget-area widget-area'>  
	<?php if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar($nz_sidebar) ) : ?>
	<?php endif; ?>
	</div>	
<?php endif ?>