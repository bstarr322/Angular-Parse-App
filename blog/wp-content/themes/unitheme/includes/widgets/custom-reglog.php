<?php

	add_action('widgets_init', 'register_reglog_widget');
	function register_reglog_widget(){
		register_widget( 'WP_Widget_RegLog' );
	}

	class  WP_Widget_RegLog extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'reglog',
				__('* Registration/Login form', TEMPNAME),
				array( 'description' => __('Front-end registration/login form', TEMPNAME))
			);
		}

		public function widget( $args, $instance ) {

			extract($args);

			$title  = apply_filters( 'widget_title', $instance['title'] );

			$output = "";
			echo $before_widget;
			if ( ! empty( $title ) ){echo $before_title . $title . $after_title;}

			$args = array(
		        'echo'           => true,
		        'form_id'        => 'loginform',
		        'label_username' => __('Username', TEMPNAME),
		        'label_password' => __('Password', TEMPNAME),
		        'label_remember' => __( 'Remember Me', TEMPNAME),
		        'label_log_in'   => __( 'Log In', TEMPNAME),
		        'id_username'    => 'user_login',
		        'id_password'    => 'user_pass',
		        'id_remember'    => 'rememberme',
		        'id_submit'      => 'wp-submit',
		        'remember'       => false,
		        'value_username' => '',
		        'value_remember' => false
			);

			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				$user = ($current_user->user_firstname) ? $current_user->user_firstname : $current_user->display_name;
			?>
			<span><?php echo __('Hello, ', TEMPNAME).$user; ?></span> |  
			<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php echo __('Logout', TEMPNAME); ?>"><?php echo __('Logout', TEMPNAME); ?></a>
			<?php } else {wp_login_form( $args );}
			echo $after_widget;
		}

	 	public function form( $instance ) {

			$defaults = array(
	 			'title'  => __('Login', TEMPNAME),
	 		);

	 		$instance = wp_parse_args((array) $instance, $defaults);
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			</p>
			<p><?php echo __('This widget does not have any options',TEMPNAME); ?></p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']  = strip_tags( $new_instance['title'] );
			return $instance;
		}
	}

?>