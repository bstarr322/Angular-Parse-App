<?php

	global $nz_ninzio;				

	$nz_blog_loop_sidebar   = "false";
	$nz_blog_single_sidebar = "false";
	$nz_blog_width          = ($nz_ninzio['blog-width'] && $nz_ninzio['blog-width'] == 1) ? "true" : "false";
	$nz_blog_animation      = ($nz_ninzio['blog-animation'] && $nz_ninzio['blog-animation'] == 1) ? "true" : "false";
	$nz_blog_layout         = ($nz_ninzio['blog-layout']) ? $nz_ninzio['blog-layout'] : "medium";
	$nz_rh                  = ($nz_ninzio['blog-rh'] && $nz_ninzio['blog-rh']  == 1) ? "true" : "false";

	if($nz_ninzio['blog-wa'] && $nz_ninzio['blog-wa'] == 1){$nz_blog_loop_sidebar = "true";}
	if($nz_ninzio['blog-swa'] && $nz_ninzio['blog-swa'] == 1){$nz_blog_single_sidebar = "true";}

	if ($nz_blog_loop_sidebar == "true") {$nz_blog_width = "false";}

?>
<div class="blog-layout-wrap">
	
		<?php if (!is_single()): ?>
			<div class="loop width-<?php echo $nz_blog_width; ?>">
				<div class="container">
					<section class="content lazy blog-layout animation-<?php echo $nz_blog_animation; ?> <?php echo $nz_blog_layout; ?> nz-clearfix">

						<?php if ($nz_rh == "false"): ?>
							<?php if (is_author() || is_archive() || is_day() || is_tag() || is_category() || is_month() || is_day() || is_year()): ?>
								<div class="archive-titles">
									<h1>
									    <?php if (is_category()): ?>
									        <?php echo __("Filtered by category ", TEMPNAME); ?> "<?php single_cat_title("", true); ?>"
									    <?php elseif(is_tag()): ?>
									        <?php echo __("Filtered by tag ", TEMPNAME); ?> "<?php single_tag_title("", true); ?>"
									    <?php elseif(is_day()): ?>
									        <?php echo the_time('F jS, Y'); ?>
									    <?php elseif(is_month()): ?>
									        <?php echo the_time('F, Y'); ?>
									    <?php elseif(is_year()): ?>
									        <?php echo the_time('Y'); ?>
									    <?php elseif(is_author()): ?>
									        <?php global $author; $userdata = get_userdata($author); ?>
									        <?php echo __("Articles posted by", TEMPNAME); ?> "<?php echo $userdata->display_name; ?>"
									    <?php else: ?>
									        <?php echo __("Archive", TEMPNAME); ?>
									    <?php endif ?>
								    </h1>
								</div>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ($nz_blog_loop_sidebar == "true"): ?>

							<section class="main-content left">
								<div class="blog-post"><?php get_template_part( '/includes/blog/content-blog-post' ); ?></div>
							</section>
							<aside class="sidebar">
								<?php if($nz_ninzio['blog-wa'] && $nz_ninzio['blog-wa'] == 1){get_sidebar();} ?>
							</aside>

						<?php else: ?>
							<div class="blog-post"><?php get_template_part( '/includes/blog/content-blog-post' ); ?></div>
						<?php endif ?>
					</section>
				</div>
			</div>
		<?php elseif(is_single()): ?>
			<div class="container">
				<section class='content nz-clearfix'>
					<?php if ($nz_blog_single_sidebar == "true"): ?>

						<section class="main-content left">
							<div class="blog-post"><?php get_template_part( '/includes/blog/content-blog-post' ); ?></div>
						</section>

						<aside class="sidebar">
							<?php if($nz_ninzio['blog-swa'] && $nz_ninzio['blog-swa'] == 1){get_sidebar();} ?>
						</aside>

					<?php else: ?>
						<div class="blog-post"><?php get_template_part( '/includes/blog/content-blog-post' ); ?></div>
					<?php endif ?>	
				</section>
			</div>
		<?php endif; ?>
		<?php ninzio_post_nav_num(); ?>
	
</div>