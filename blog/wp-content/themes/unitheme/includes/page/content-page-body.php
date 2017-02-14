<?php global $nz_ninzio; ?>
<?php while ( have_posts() ) : the_post(); ?>
	<!-- post start -->
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<section class="page-content nz-clearfix">
			<?php the_content(); ?>
		</section>
	</div>
	<!-- post end -->
<?php endwhile; ?>
<?php if ($nz_ninzio['page-comments'] && $nz_ninzio['page-comments'] == 1) {comments_template();} ?>
