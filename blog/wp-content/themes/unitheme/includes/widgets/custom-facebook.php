<?php 
	
	add_action('widgets_init', 'register_facebook_like_widget');
	function register_facebook_like_widget(){
		register_widget( 'WP_Widget_Facebook_Like_Box' );
	} 

	class WP_Widget_Facebook_Like_Box extends WP_Widget {

		public function __construct() {
			parent::__construct(
				'facebook',
				__('* Facebook Like Box', TEMPNAME),
				array( 'description' => __('Facebook Like Box widget', TEMPNAME))
			);
		}

		public function widget( $args, $instance ) {

			extract($args);

			global $nz_ninzio;

			$title 	      = apply_filters( 'widget_title', $instance['title'] );
			$href    	  = isset($instance['href']) ? esc_attr($instance['href']) : "";
			$app_id       = isset($instance['app_id']) ? esc_attr($instance['app_id']) : "";
			$show_faces   = isset($instance['show_faces']) ? 'yes' : 'no';
			$stream 	  = isset($instance['stream']) ? 'yes' : 'no';
			$header 	  = isset($instance['header']) ? 'yes' : 'no';
			$show_border  = isset($instance['show_border']) ? 'yes' : 'no';
			$color_scheme = ($nz_ninzio['ninzio-skin'] && $nz_ninzio['ninzio-skin'] == "light") ? "light" : "dark";

			echo $before_widget;

				if ( ! empty( $title ) ){echo $before_title . $title . $after_title;}
			
				if($href): ?>
					<div id="fb-root"></div>
					<script>
					  window.fbAsyncInit = function() {
					    FB.init({
					      appId      : '<?php echo $app_id; ?>',
					      channelUrl : '<?php echo home_url(); ?>/channel.php',
					      status     : true,
					      xfbml      : true
					    });
					  };

					  (function(d, s, id){
					     var js, fjs = d.getElementsByTagName(s)[0];
					     if (d.getElementById(id)) {return;}
					     js = d.createElement(s); js.id = id;
					     js.src = "//connect.facebook.net/en_US/all.js";
					     fjs.parentNode.insertBefore(js, fjs);
					   }(document, 'script', 'facebook-jssdk'));

					</script>
					<div class="fb-like-box" data-href="<?php echo $href; ?>" data-width="282" data-colorscheme="<?php echo $color_scheme; ?>" data-show-faces="<?php echo $show_faces; ?>" data-header="<?php echo $header; ?>" data-stream="<?php echo $stream; ?>" data-show-border="<?php echo $show_border; ?>"></div>
				<?php endif;

			echo $after_widget;
		}

	 	public function form( $instance ) {

	 		$defaults = array(
	 			'title'       => __('Find us on Facebook', TEMPNAME),
	 			'href'        => '',
	 			'app_id'      => '',
	 			'show_faces'  => 'yes',
	 			'show_border' => 'yes',
	 			'stream'      => 'no',
	 			'header'      => 'no'
	 		);

	 		$instance = wp_parse_args((array) $instance, $defaults);

			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __( 'Title:', TEMPNAME ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('href'); ?>"><?php echo __( 'Facebook Page URL:', TEMPNAME ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('href'); ?>" name="<?php echo $this->get_field_name('href'); ?>" type="text" value="<?php echo $instance['href']; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('app_id'); ?>"><?php echo __( 'App ID from the app dashboard:', TEMPNAME ); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('app_id'); ?>" name="<?php echo $this->get_field_name('app_id'); ?>" type="text" value="<?php echo $instance['app_id']; ?>" />
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['show_faces'], 'yes'); ?> id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" /> 
				<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php echo __( 'Show faces', TEMPNAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['show_border'], 'yes'); ?> id="<?php echo $this->get_field_id('show_border'); ?>" name="<?php echo $this->get_field_name('show_border'); ?>" /> 
				<label for="<?php echo $this->get_field_id('show_border'); ?>"><?php echo __( 'Show border', TEMPNAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['stream'], 'yes'); ?> id="<?php echo $this->get_field_id('stream'); ?>" name="<?php echo $this->get_field_name('stream'); ?>" /> 
				<label for="<?php echo $this->get_field_id('stream'); ?>"><?php echo __( 'Show stream', TEMPNAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked($instance['header'], 'yes'); ?> id="<?php echo $this->get_field_id('header'); ?>" name="<?php echo $this->get_field_name('header'); ?>" /> 
				<label for="<?php echo $this->get_field_id('header'); ?>"><?php echo __( 'Show facebook header', TEMPNAME ); ?></label>
			</p>
			<?php
		}

		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title']       = strip_tags( $new_instance['title'] );
			$instance['href']        = strip_tags( $new_instance['href']);
			$instance['app_id']      = strip_tags($new_instance['app_id']);
			$instance['show_faces']  = $new_instance['show_faces'];
			$instance['show_border'] = $new_instance['show_border'];
			$instance['stream']      = $new_instance['stream'];
			$instance['header']      = $new_instance['header'];
			return $instance;
		}
	}
?>