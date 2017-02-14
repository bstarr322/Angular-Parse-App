<?php get_header(); ?>
<?php  global $nz_ninzio; ?>
<div class='container'>
	<div class='nz-content nz-clearfix'>
		<div class="error404-wrap">
			<div class="error404-status">404</div>
			<h3 class="error404-title"><?php echo __("Page not found", TEMPNAME); ?></h3>
			<div class="search-form">
				<?php 
					$args = array(
						'before_widget'=>'',
						'after_widget' =>'',
						'before_title' =>'',
						'after_title'  =>''
					);
					the_widget( 'WP_Widget_Search', $args ); 
				?>
			</div>
		</div>
	</div>
</div>
<!-- container end -->
<?php get_footer(); ?>
