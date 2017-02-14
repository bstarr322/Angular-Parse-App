<?php get_header(); ?>
<div class="search-results-title">
	<div class='container nz-clearfix'>
	<?php
		global $wp_query;
		$total_results = $wp_query->found_posts;
	?>
	<?php echo $total_results.__(' search results for', TEMPNAME).' <strong><i>"'.get_search_query().'</i></strong>"'; ?>
	</div>
</div>
<div class='container search-r'>
	<div class='content nz-clearfix'>

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

		<?php if (have_posts()) : ?>


			<?php while (have_posts()) : the_post(); ?>

				<?php $post_type = get_post_type( get_the_ID() ); ?>

				<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
					<div class="post-body">

						<?php if ($post_type == "post"): ?>
							<span title="<?php echo $post_type; ?>" class="post-indication icon-pencil2"></span>
						<?php elseif($post_type == "portfolio"): ?>
							<span title="<?php echo $post_type; ?>" class="post-indication icon-portfolio"></span>
						<?php else: ?>
							<span title="<?php echo $post_type; ?>" class="post-indication icon-newspaper2"></span>
						<?php endif ?>

						<?php if ( '' != get_the_title() ): ?>
							<h3 class="post-title">
								<a href="<?php the_permalink(); ?>" title="<?php echo __("Go to", TEMPNAME).' '.get_the_title(); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h3>
						<?php endif; ?>

						<div class="post-meta nz-clearfix">
							<div class="post-author"><span class="icon-user2"></span><?php echo __("Posted by", TEMPNAME); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" title="<?php echo __('View all posts by', TEMPNAME); ?> <?php the_author(); ?>"><?php the_author(); ?></a></div>
							
							<?php if ($post_type == "post"): ?>
								<div class="post-category nz-clearfix"><span class="icon-list3"></span><?php the_category("<span class='comma'>, </span>"); ?></div>
							<?php elseif($post_type == "portfolio"): ?>
								<div class="post-category nz-clearfix"><span class="icon-list3"></span><?php echo get_the_term_list( $post->ID, 'portfolio-category', '', ', ', '' ); ?></div>
							<?php endif ?>

						</div>
						<?php if ( '' != get_the_content() ): ?>
						<div class="post-content nz-clearfix">
							<?php the_excerpt(); ?>
						</div>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>" class="button search-button small"><?php echo __("Read more", TEMPNAME); ?></a>
					</div>
				</article>
				
			<?php endwhile; ?>

			<?php ninzio_post_nav_num(); ?>

		<?php else : ?>

			<p><strong><?php echo __('Suggestions:', TEMPNAME); ?></strong></p>

			<ol>
				<li><?php echo __('Make sure that all words are spelled correctly', TEMPNAME); ?></li>
				<li><?php echo __('Try different keywords', TEMPNAME); ?></li>
				<li><?php echo __('Try more general keywords', TEMPNAME); ?></li>
				<li><?php echo __('Try fewer keywords', TEMPNAME); ?></li>
			</ol>

		<?php endif; ?>

	</div>
	
</div>
<?php get_footer(); ?>