<?php

	add_action('widgets_init', 'register_mailchimp_widget');
	function register_mailchimp_widget(){
		register_widget( 'WP_Widget_Mailchimp' );
	}

	class  WP_Widget_Mailchimp extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'mailchimp',
				__('* Mailchimp', TEMPNAME),
				array( 'description' => __('MailChimp Signup Form', TEMPNAME))
			);
		}

		public function widget( $args, $instance ) {

			extract($args);

			$output = "";

			$title         = apply_filters( 'widget_title', $instance['title'] );
			$action        = (isset($instance['action'])) ? esc_attr($instance['action']) : '';
			$name          = (isset($instance['name'])) ? esc_attr($instance['name']) : '';
			$description   = (isset($instance['description'])) ? esc_attr($instance['description']) : '';

			$output .= $before_widget;
			if ( ! empty( $title ) ){$output .= $before_title . $title . $after_title;}
			$output .='<div id="mc_embed_signup">';
				$output .='<form action="'.$action.'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';
					$output .='<span class="icon-envelope"></span><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" data-placeholder="'.__("Enter email address",TEMPNAME).'" required>';
				    $output .='<input type="text" name="b_d4b8ae9364cc26cecfd46d335_23c55ddae5" tabindex="-1" value="" class="hidden">';
				    $output .='<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"><span class="icon-plus"></span>';
				$output .='</form>';
			$output .='</div>';
			$output .= '<div class="mailchimp-description">'.$description.'</div>';
			$output .= $after_widget;
			echo $output;
		}

	 	public function form( $instance ) {

			$defaults = array(
	 			'title'  => __('Subscribe', TEMPNAME),
	 			'action' => '',
	 			'name'   => ''
	 		);

	 		$instance = wp_parse_args((array) $instance, $defaults);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'action' ); ?>"><?php echo __( 'Action:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'action' ); ?>" name="<?php echo $this->get_field_name( 'action' ); ?>" type="text" value="<?php echo $instance['action']; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'name' ); ?>"><?php echo __( 'Name:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'name' ); ?>" name="<?php echo $this->get_field_name( 'name' ); ?>" type="text" value="<?php echo $instance['name']; ?>" size="3" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php echo __( 'Description:', TEMPNAME ); ?></label> 
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text"><?php echo $instance['description']; ?></textarea>
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['action']      = strip_tags( $new_instance['action'] );
			$instance['name']        = strip_tags( $new_instance['name'] );
			$instance['description'] = strip_tags( $new_instance['description'] );
			return $instance;
		}
	}

?>