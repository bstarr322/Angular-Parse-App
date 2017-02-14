<?php

	get_header();

	global $post;

	$post_type = get_post_type($post->ID);

	if ($post_type) {
		
		if ('portfolio' == $post_type) {

			get_template_part('/includes/portfolio/content-portfolio-header');
			get_template_part('/includes/portfolio/content-portfolio-body');

		} elseif ('faq' == $post_type) {

			get_template_part('/includes/faq/content-faq-header');
			get_template_part('/includes/faq/content-faq-body');
			
		} else {

			get_template_part('/includes/blog/content-blog-header');
			get_template_part('/includes/blog/content-blog-body');

		}

	} else {

		get_template_part('/includes/blog/content-blog-header');
		get_template_part('/includes/blog/content-blog-body');

	}

	get_footer(); 

?>