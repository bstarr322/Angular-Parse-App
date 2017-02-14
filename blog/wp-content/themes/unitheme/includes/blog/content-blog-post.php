<?php global $nz_ninzio;?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

			<article data-grid="ninzio_01" <?php post_class() ?> id="post-<?php the_ID(); ?>">

				<div class="post-wrap nz-clearfix">
					<?php get_template_part('/includes/blog/content'); ?>
				</div>

			</article>

			<?php if (is_single()): ?>

				<?php if ($nz_ninzio['blog-author'] && $nz_ninzio['blog-author'] == 1): ?>

					<aside class="post-author-info">
						<?php if ('' != get_avatar(get_the_author_meta('email'), '60')): ?>
							<div class="author-gavatar ninzio-gavatar"><?php echo get_avatar(get_the_author_meta('email'), '60'); ?></div>
						<?php endif ?>
						<div class="author-info-box">
							<h3 class="post-author-info-title"><?php echo __("About the author:", TEMPNAME); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta("ID") ); ?>"><?php echo get_the_author_meta("display_name"); ?></a></h3>
							<?php if ('' != get_the_author_meta("description")): ?>
								<div class="author-description"><?php echo get_the_author_meta("description"); ?></div>
							<?php endif ?>
						</div>
					</aside>

				<?php endif; ?>

				<?php if ($nz_ninzio['blog-comments'] && $nz_ninzio['blog-comments'] == 1) {
					comments_template();
				} ?>

			<?php endif; ?>
			
		<?php endwhile; ?>

	<?php else : ?>

		<?php ninzio_not_found('post'); ?>

	<?php endif; ?>