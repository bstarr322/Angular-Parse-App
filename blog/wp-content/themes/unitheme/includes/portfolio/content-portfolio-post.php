<?php global $nz_ninzio; ?>

<?php if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<?php

			$classes= array('"all"');
			if (get_the_terms( $post->ID, 'portfolio-category', '', ' ', '' )) {
				foreach(get_the_terms( $post->ID, 'portfolio-category', '', '', '' ) as $term) {
					array_push($classes, '"'.$term->slug.'"');
				}
			}

		?>

		<article data-grid="ninzio_01" <?php post_class() ?> data-groups='[<?php echo implode(', ',$classes); ?>]' id="post-<?php the_ID(); ?>">
			<?php get_template_part('/includes/portfolio/content'); ?>
		</article>

		<?php if (is_single()): ?>

			<?php if ($nz_ninzio['port-rp'] && $nz_ninzio['port-rp'] == 1): ?>

				<?php 

					global $post;
					$posts_number = ($nz_ninzio['port-rpn']) ? $nz_ninzio['port-rpn'] : 4;
					$terms        = get_the_terms( $post->ID , 'portfolio-tag');

					$nz_ninzio_grid = "grid_3";

					switch ($posts_number) {
						case '3':
							$nz_ninzio_grid   = "grid_3";
							break;
						case '4':
							$nz_ninzio_grid   = "grid_4";
							break;
						default:
							$nz_ninzio_grid   = "grid_3";
							break;
					}

				?>

				<?php if ($terms): ?>

					<?php

						$tagids = array();
						foreach($terms as $tag) {$tagids[] = $tag->term_id;}

						$args = array(
							'post_type' => 'portfolio',
							'tax_query' => array(
					            array(
					                'taxonomy' => 'portfolio-tag',
					                'field'    => 'id',
					                'terms'    => $tagids,
					                'operator' => 'IN'
					             )
					        ),
							'posts_per_page'      => $posts_number,
							'ignore_sticky_posts' => 1,
							'orderby'             => 'date',
							'post__not_in'        => array($post->ID)
						);

					    $related_projects = new WP_Query($args);

					?>

					<?php if ($related_projects->have_posts()): ?>

						<div class="nz-recent-portfolio nz-related-products grid nz-clearfix nogap-false <?php echo $nz_ninzio_grid; ?>" data-animate="false">
							
							<h3 class="nz-reletated-projects-sep"><?php echo __("Related projects", TEMPNAME); ?></h3>

							<div class="nz-portfolio-posts">

								<?php while($related_projects->have_posts()) : $related_projects->the_post(); ?>

									<div class="mix post nz-clearfix" data-grid="ninzio_01">
										<div class="post-body">

											<div class="nz-thumbnail">
												<?php if (has_post_thumbnail()) {echo get_the_post_thumbnail( $post->ID, 'Ninzio-Uni' );} ?>
												<a href="<?php echo get_permalink() ?>">
													<div class="ninzio-overlay"></div>
												</a>
											</div>
											<div class="project-details">
												<?php if ( '' != get_the_title() ){ ?>
													<a href="<?php echo get_permalink(); ?>">
														<h4 class="project-title"><?php echo get_the_title() ?></h4>
													</a>
												<?php } ?>
											</div>

										</div>
									</div>

								<?php endwhile; ?>

								<?php wp_reset_postdata(); ?>

							</div>

						</div>

					<?php else: ?>
						<?php echo '<p>'.__('No related projects found', TEMPNAME).'</p>'; ?>
					<?php endif ?>

				<?php else: ?>

					<?php echo '<p>'.__("No related projects found", TEMPNAME).'</p>'; ?>
					
				<?php endif ?>

			<?php endif; ?>

		<?php endif; ?>

	<?php endwhile; ?>

<?php else : ?>

	<?php ninzio_not_found('portfolio'); ?>

<?php endif; ?>