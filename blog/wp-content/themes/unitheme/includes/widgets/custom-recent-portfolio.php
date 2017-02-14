<?php

	add_action('widgets_init', 'register_recent_portfolio_widget');
	function register_recent_portfolio_widget(){
		register_widget( 'WP_Widget_Recent_Portfolio' );
	}

	class  WP_Widget_Recent_Portfolio extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'recent_portfolio',
				__('* Recent Projects', TEMPNAME),
				array( 'description' => __('Display recent projects with thumbnails', TEMPNAME))
			);
		}

		public function widget( $args, $instance ) {

			extract($args);

			$title        = apply_filters( 'widget_title', $instance['title'] );
			$posts_number = (isset($instance['posts_number']) && is_numeric($instance['posts_number'])) ? esc_attr($instance['posts_number']) : '6';
			$category     = (isset($instance['category'])) ? esc_attr($instance['category']) : '';
			global $post;

			$output = "";

				$recent_portfolio_with_thumbnail = new WP_Query(array( 'orderby' => 'date', 'post_type' => 'portfolio', 'posts_per_page' => $posts_number, 'ignore_sticky_posts' => 1, 'portfolio-category' => $category));
				
				if($recent_portfolio_with_thumbnail->have_posts()){

					echo $before_widget;
			
					if($title) {echo $before_title.$title.$after_title;}

					$output .= '<div class="recent-portfolio nz-clearfix">';

						while($recent_portfolio_with_thumbnail->have_posts()) : $recent_portfolio_with_thumbnail->the_post();
							
							$output .= '<div class="post nz-clearfix">';
								$output .='<a href="' . get_permalink() . '" title="'.get_the_title().'">';
									$output .= '<div class="ninzio-thumbnail">';		
										if ( '' != get_the_post_thumbnail() ) {
											$output .= get_the_post_thumbnail($post->ID, 'thumbnail');
										}
									$output .= '</div>';
									$output .= '<div class="ninzio-overlay"></div>';
								$output .= '</a>';
							$output .= '</div>';

						endwhile;

					$output .= '</div>';

					echo $output;

				} else {
					echo ninzio_not_found('portfolio');
				}

				wp_reset_postdata();


				echo $after_widget;
		}

	 	public function form( $instance ) {

			$defaults = array(
	 			'title'        => __('Recent projects', TEMPNAME),
	 			'posts_number' => '6',
	 			'category'     => ''
	 		);

	 		$instance = wp_parse_args((array) $instance, $defaults);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php echo __( 'Number of projects to show:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" type="text" value="<?php echo $instance['posts_number']; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php echo __( 'Enter comma separated list of categories id to filter:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $instance['category']; ?>" size="3" />
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']        = strip_tags( $new_instance['title'] );
			$instance['posts_number'] = strip_tags( $new_instance['posts_number'] );

			return $instance;
		}
	}

?>