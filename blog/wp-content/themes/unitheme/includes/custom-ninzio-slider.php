<?php

/*====================================================================*/
/*	REGISTER NINZIO-SLIDER
/*====================================================================*/

	function ninzio_slider() {

		$labels = array(
			'name'               => __('Ninzio slider', TEMPNAME),
			'singular_name'      => __('Slider', TEMPNAME),
			'add_new'            => __('Add new', TEMPNAME),
			'add_new_item'       => __('Add new slide', TEMPNAME),
			'edit_item'          => __('Edit slide', TEMPNAME),
			'new_item'           => __('New slide', TEMPNAME),
			'all_items'          => __('All slides', TEMPNAME),
			'view_item'          => __('View slide', TEMPNAME),
			'search_items'       => __('Search slides', TEMPNAME),
			'not_found'          => __('No slides found', TEMPNAME),
			'not_found_in_trash' => __('No slides found in trash', TEMPNAME), 
			'parent_item_colon'  => '',
			'menu_name'          => __('Ninzio slider', TEMPNAME),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true, 
			'show_in_menu'       => true, 
			'query_var'          => true,
			'rewrite'            => array('slug' => 'ninzio-slider'),
			'capability_type'    => 'post',
			'has_archive'        => false, 
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => '',
			'supports'           => array('title')
		); 

		register_post_type( 'ninzio-slider', $args );
	}
	add_action( 'init', 'ninzio_slider' );

/*====================================================================*/
/* NINZIO SLIDER SETTINGS
/*====================================================================*/

	add_action( 'admin_menu', 'ninzio_slider_settings' );
	function ninzio_slider_settings(){
		add_submenu_page(
			'edit.php?post_type=ninzio-slider',
			__( 'Order slides', TEMPNAME),
			__( 'Order slides', TEMPNAME),
			'administrator',
			'ninzio_slider_order',
			'render_ninzio_slider_order'
		);
	}

	function render_ninzio_slider_order(){	
	?>
		<div class="ninzio-slider-order">
			<div>
				<h2><?php echo __("Sort slides", TEMPNAME) ?></h2>
				<p><?php echo __("Simply drag the slides up or down and they will be saved in that order.", TEMPNAME) ?></p>
			</div>
			<div class="ninzio-success">
				<?php echo __("Slide order has been updated successfully!", TEMPNAME) ?>
			</div>
			<div class="ninzio-error">
				<?php echo __("An error occurred. Slide order has not been updated successfully!", TEMPNAME) ?>
			</div>
			<br>
			<?php

				global $post;

				$ninzio_slides_terms = get_terms("slider-group");

				$ninzio_slides_opt = array( 
					'post_type'      => 'ninzio-slider', 
					'posts_per_page' => -1,
					'order'          => 'ASC', 
					'orderby'        => 'menu_order' 
				);

			?>
			<?php $slides = new WP_Query($ninzio_slides_opt); ?>
			<?php if( $slides->have_posts() ) : ?>
				<div class="ninzio-slider-order-wrap">
					<div class="ninzio-slider-order-headers nz-clearfix">
						<div class="column-title"><?php echo __("Title", TEMPNAME); ?></div>
						<div class="column-thumbnail"><?php echo __("Background image", TEMPNAME); ?></div>
					</div>
					<ul class="ninzio-slider-excrepts" data-post-type="ninzio-slider">
					<?php while( $slides->have_posts() ) : $slides->the_post(); ?>
						<li class="nz-clearfix" id="post-<?php the_ID(); ?>">
							<div class="column-title"><strong><?php the_title(); ?></strong></div>
							<div class="column-thumbnail">
								<?php 
									$values = get_post_custom();
									echo '<img src="'.$values["background_image"][0].'">';
								?>
							</div>
						</li>
					<?php endwhile; ?>
					</ul>
				</div>
				<br>
			<?php else: ?>
				<p><?php echo __("No slides found, why not", TEMPNAME)." <a href='post-new.php?post_type=ninzio-slider'>".__("create one?", TEMPNAME)."</a>" ?></p>
			<?php endif; ?>
			<?php wp_reset_postdata();?>
		</div>

	<?php }

	add_action( 'wp_ajax_ninzio_update_post_order', 'ninzio_update_post_order' );

	function ninzio_update_post_order() {
		global $wpdb;
		$post_type = $_POST['ninzio-slider'];
		$order     = $_POST['order'];
		foreach( $order as $menu_order => $post_id )
		{
			$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
			$menu_order = intval($menu_order);
			$_POST['menu_order'] = $menu_order;
			wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
		}

		die( '1' );
	}

/*====================================================================*/
/*	NINZIO SLIDE OPTIONS
/*====================================================================*/

	add_action("admin_init", "ninzio_slider_add_meta_box");
	function ninzio_slider_add_meta_box(){

		add_meta_box(
			"ninzio-slide-options", 
			__("Ninzio Slide Options", TEMPNAME),
			"render_ninzio_slide_options", 
			"ninzio-slider",
			"normal", 
			"high"
		);

	}

	function render_ninzio_slide_options($post) {

    	$values = get_post_custom( $post->ID );
    	$background_image            = isset( $values['background_image'] ) ? esc_url( $values["background_image"][0] ) : "";
    	$background_color            = isset( $values['background_color'] ) ? esc_attr( $values["background_color"][0] ) : "";
    	$background_video_pattern    = isset( $values['background_video_pattern'] ) ? esc_url( $values["background_video_pattern"][0] ) : "";
    	$background_video_mp4        = isset( $values['background_video_mp4'] ) ? esc_url( $values["background_video_mp4"][0] ) : "";
	    $background_video_ogv        = isset( $values['background_video_ogv'] ) ? esc_url( $values["background_video_ogv"][0] ) : "";
	    $background_video_webm       = isset( $values['background_video_webm'] ) ? esc_url( $values["background_video_webm"][0] ) : "";

    	for ($i=1; $i <= 5; $i++) {
    		${"layer_$i"}           = isset( $values["layer_$i"] ) ? wp_kses_post($values["layer_$i"][0]) : "";
    		${"layer_index_$i"}     = isset( $values["layer_index_$i"] ) ? esc_attr( $values["layer_index_$i"][0] ) : "";
    		${"layer_delay_$i"}     = isset( $values["layer_delay_$i"] )? esc_attr( $values["layer_delay_$i"][0] ) : "0";
    		${"layer_duration_$i"}  = isset( $values["layer_duration_$i"] )? esc_attr( $values["layer_duration_$i"][0] ) : "0";
    		${"layer_zindex_$i"}    = isset( $values["layer_zindex_$i"] )? esc_attr( $values["layer_zindex_$i"][0] ) : "1";
    		${"layer_direction_$i"} = isset( $values["layer_direction_$i"] ) ? esc_attr( $values["layer_direction_$i"][0] ) : "none";
    		${"layer_posx_$i"}      = isset( $values["layer_posx_$i"] )? esc_attr( $values["layer_posx_$i"][0] ) : "0";
    		${"layer_posy_$i"}      = isset( $values["layer_posy_$i"] )? esc_attr( $values["layer_posy_$i"][0] ) : "0";
    	}
    
    	wp_nonce_field( 'ninzio_slide_options_nonce', 'ninzio_slide_options_nonce' );

    ?>
    	<!-- Hidden inputs for active tabs indexes -->
    	<div id="ninzio-slide-background-image" class="ninzio-section">
    		<div class="ninzio-section-title"><span><?php echo __("Slide background options", TEMPNAME) ?></span></div>
    		<div class="ninzio-section-content">
    			<div class="ninzio-slide-background-color">
    				<label><?php echo __('Slide background color:', TEMPNAME); ?></label>
       				<input name="background_color" id="background_color" class="ninzio-color-picker" value="<?php echo $background_color; ?>" />
    			</div>
    			<div class="ninzio-section-description"><?php echo __("The image should be between 1600px - 2000px in width and have a minimum height of slider height for best results", TEMPNAME); ?></div>
    			<div class="ninzio-upload">
					<input name="background_image" id="background-image" type="hidden" class="ninzio-upload-path" value="<?php echo $background_image;?>"/> 
				    <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload background image', TEMPNAME) ?>" />
				    <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove background image', TEMPNAME) ?>" />
					<img src='<?php echo $background_image; ?>' class='ninzio-preview-upload'/>
				</div>
			    <br>
				<div class="ninzio-section-description"><?php echo __("Enter video files links for background video (use background image for video poster) ", TEMPNAME); ?></div>
				<div class="video_background">
		            <label for="background_video_webm"><?php echo __('Enter  WEBM video file link here:', TEMPNAME); ?></label>
		            <input name="background_video_webm" type="text" value="<?php echo $background_video_webm;?>"/>
		        </div>
				<div class="video_background">
		            <label for="background_video_mp4"><?php echo __('Enter  MP4 video file link here:', TEMPNAME); ?></label>
		            <input name="background_video_mp4" type="text" value="<?php echo $background_video_mp4;?>"/>
		        </div>
		        <div class="video_background">
		            <label for="background_video_ogv"><?php echo __('Enter  OGV video file link here:', TEMPNAME); ?></label>
		            <input name="background_video_ogv" type="text" value="<?php echo $background_video_ogv;?>"/>
		        </div>
		        <div class="ninzio-upload">
					<input name="background_video_pattern" id="background-video-pattern" type="hidden" class="ninzio-upload-path" value="<?php echo $background_video_pattern;?>"/> 
				    <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload video background pattern', TEMPNAME) ?>" />
				    <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove video background pattern', TEMPNAME) ?>" />
					<div style='background-image:url(<?php echo $background_video_pattern; ?>);' class="ninzio-pattern-preview"></div>
				</div>
    		</div>
    	</div>

    	<script>
			jQuery(document).ready(function(){
			    jQuery('.ninzio-layer').each(function(){
			    	var self = jQuery(this),
			    		title = self.find('.ninzio-ui'),
			    		layerAnimation = self.find('.layer-animation'),
			    		dashboard = new Array();
			    		dashboard[0] = '<span title="<?php echo __("Delay", TEMPNAME) ?>" class="title-item title-delay">' + layerAnimation.find('.delay').val() + 'ms</span>';
			    		dashboard[2] = '<span title="<?php echo __("Pos-x", TEMPNAME) ?>" class="title-item title-posx">' + layerAnimation.find('.posx').val() + 'px</span>';
			    		dashboard[3] = '<span title="<?php echo __("Pos-y", TEMPNAME) ?>" class="title-item title-posy">' + layerAnimation.find('.posy').val() + 'px</span>';
			    		title.append(dashboard.join(''));
			    });

			     // Animation form validation
			    var label = jQuery(".layer-animation label.ninzio-validation");
			     	input = label.find('input');

			    input.each(function(){
			    	var self = jQuery(this),
			    		index = input.index(this);
			    	self.on('focusout', function(){
				        if(isNaN(self.val())){
				           label.eq(index).append("<span class='validation-warning'><?php echo __('Input should be numeric', TEMPNAME) ?></span>")
				           self.addClass('ninzio-validate');
				        } else {
				        	label.eq(index).find('.validation-warning').remove();
				    		self.removeClass('ninzio-validate');
				        }
				    })
			    })

			});
		</script>
    	<div id="ninzio-slide-layers" class="ninzio-section">
    		<div class="ninzio-section-title"><span><?php echo __("Slide layers", TEMPNAME) ?></span></div>
    		<div class="ninzio-section-content">
				<?php for ($i=1; $i <= 5 ; $i++) { ?>
	    			<div class="ninzio-accordion-container ninzio-layer">
	    				<input type="hidden" class="ninzio-hidden" id="layer-index-<?php echo $i; ?>" name="layer_index_<?php echo $i; ?>" value="<?php echo ${"layer_index_$i"} ?>" />
	    				<div class="ninzio-accordion-title ninzio-ui <?php echo ${"layer_index_$i"} ?>"><span class="title-item title-index"><?php echo __("Layer ", TEMPNAME).$i ?></span></div>
	    				<div class="ninzio-accordion-content layer-animation">
	    					<div class="ninzio-accordion-container">
	    						<div class="ninzio-accordion-title nz-clearfix">
	    							<span class="layer-animation-title"><?php echo __("Animation", TEMPNAME); ?></span>
	    						</div>
	    						<div class="ninzio-accordion-content">
	    							<label class="ninzio-validation">
										<?php echo __('Duration (ms):', TEMPNAME); ?>
										<input type="text" class="ninzio-spinner  ninzio-slider-animation duration" id="layer-delay-<?php echo($i); ?>" name="layer_duration_<?php echo($i); ?>" value="<?php echo ${"layer_duration_$i"}; ?>" />
									</label>
	    							<label class="ninzio-validation">
										<?php echo __('Delay (ms):', TEMPNAME); ?>
										<input type="text" class="ninzio-spinner  ninzio-slider-animation delay" id="layer-delay-<?php echo($i); ?>" name="layer_delay_<?php echo($i); ?>" value="<?php echo ${"layer_delay_$i"}; ?>" />
									</label>
									<label class="ninzio-validation">
										<?php echo __('Z-index:', TEMPNAME); ?>
										<input type="text" class="ninzio-spinner ninzio-slider-animation zindex" id="layer-zindex-<?php echo($i); ?>" name="layer_zindex_<?php echo($i); ?>" value="<?php echo ${"layer_zindex_$i"}; ?>" />
									</label>
									<label>
										<?php echo __('Direction:', TEMPNAME); ?>
										<select id="layer-direction-<?php echo($i); ?>" class="ninzio-slider-animation direction" name="layer_direction_<?php echo($i); ?>">
											<option value="none" <?php selected( ${"layer_direction_$i"}, 'none' ); ?>><?php echo __("None", TEMPNAME); ?></option>
											<option value="left" <?php selected( ${"layer_direction_$i"}, 'left' ); ?>><?php echo __("Left", TEMPNAME); ?></option>
											<option value="right" <?php selected( ${"layer_direction_$i"}, 'right' ); ?>><?php echo __("Right", TEMPNAME); ?></option>
											<option value="top" <?php selected( ${"layer_direction_$i"}, 'top' ); ?>><?php echo __("Top", TEMPNAME); ?></option>
											<option value="bottom" <?php selected( ${"layer_direction_$i"}, 'bottom' ); ?>><?php echo __("Bottom", TEMPNAME); ?></option>
										</select>
									</label>
									<label class="ninzio-validation">
										<?php echo __('Pos-x (px):', TEMPNAME); ?>
										<input type="text" class="ninzio-slider-animation posx" id="layer-posx-<?php echo($i); ?>" name="layer_posx_<?php echo($i); ?>" value="<?php echo ${"layer_posx_$i"}; ?>" />
									</label>
									<label class="ninzio-validation">
										<?php echo __('Pos-y (px):', TEMPNAME); ?>
										<input type="text" class="ninzio-slider-animation posy" id="layer-posy-<?php echo($i); ?>" name="layer_posy_<?php echo($i); ?>" value="<?php echo ${"layer_posy_$i"}; ?>" />
									</label>
	    						</div>
	    					</div>
			    			<div class="ninzio-custom-editor">
			    				
			    				<?php

			    					$tinymce_opt = array(
			    						'height'  => "250",
			    						'plugins' => "textcolor,paste, nz_gap, nz_sep, nz_btn, nz_you, nz_vim, nz_colorbox, nz_fw",
			    						'toolbar1' => "italic,alignleft,aligncenter,alignright,alignjustify,link,unlink,formatselect,fontselect,fontsizeselect,styleselect,nz_fw,undo,redo",
									  	'toolbar2' => "nz_gap, nz_sep, nz_btn, nz_you, nz_vim, nz_colorbox,forecolor,removeformat,charmap",
									  	'toolbar3' => "",
			    					);

									$settings = array ('tinymce' => $tinymce_opt);
			    					wp_editor( ${"layer_$i"}, "layer_$i", $settings); 
			    				?>
			    			</div>
		    			</div>
	    			</div>

    			<?php } ?>
			</div>
    	</div>

    <?php
	}

	add_action( 'save_post', 'save_ninzio_slide_options' );  
	function save_ninzio_slide_options( $post_id )  
	{  
	    
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	    if( !isset( $_POST['ninzio_slide_options_nonce'] ) || !wp_verify_nonce( $_POST['ninzio_slide_options_nonce'], 'ninzio_slide_options_nonce' ) ) return;  
	    if( !current_user_can( 'edit_post' ) ) return;

	    if( isset( $_POST['background_image'] ) ){update_post_meta($post_id, "background_image",$_POST["background_image"]);}
	    if( isset( $_POST['background_color'] ) ){update_post_meta($post_id, "background_color",$_POST["background_color"]);}

	    if( isset( $_POST['background_video_mp4'] ) ){update_post_meta($post_id, "background_video_mp4",$_POST["background_video_mp4"]);}
	    if( isset( $_POST['background_video_ogv'] ) ){update_post_meta($post_id, "background_video_ogv",$_POST["background_video_ogv"]);}
	    if( isset( $_POST['background_video_webm'] ) ){update_post_meta($post_id, "background_video_webm",$_POST["background_video_webm"]);}
	    if( isset( $_POST['background_video_pattern'] ) ){update_post_meta($post_id, "background_video_pattern",$_POST["background_video_pattern"]);}

	    for ($i=1; $i <= 5 ; $i++) { 
	    	if( isset( $_POST["layer_$i"] ) ) { update_post_meta( $post_id, "layer_$i", $_POST["layer_$i"]);}
	    	if( isset( $_POST["layer_index_$i"] ) ) { update_post_meta( $post_id, "layer_index_$i", $_POST["layer_index_$i"]);}
	    	if( isset( $_POST["layer_delay_$i"] ) ) { update_post_meta( $post_id, "layer_delay_$i", $_POST["layer_delay_$i"]);}
	    	if( isset( $_POST["layer_duration_$i"] ) ) { update_post_meta( $post_id, "layer_duration_$i", $_POST["layer_duration_$i"]);}
	    	if( isset( $_POST["layer_zindex_$i"] ) ) { update_post_meta( $post_id, "layer_zindex_$i", $_POST["layer_zindex_$i"]);}
	    	if( isset( $_POST["layer_direction_$i"] ) ) { update_post_meta( $post_id, "layer_direction_$i", $_POST["layer_direction_$i"]);}
	    	if( isset( $_POST["layer_posx_$i"] ) ) { update_post_meta( $post_id, "layer_posx_$i", $_POST["layer_posx_$i"]);}
	    	if( isset( $_POST["layer_posy_$i"] ) ) { update_post_meta( $post_id, "layer_posy_$i", $_POST["layer_posy_$i"]);}
		}
	}

/*====================================================================*/
/*	NINZIO SLIDER ADMIN COLUMNS
/*====================================================================*/
	
	add_filter("manage_edit-ninzio-slider_columns", "ninzio_slider_edit_columns");

	function ninzio_slider_edit_columns($columns){

		$columns = array(
			"cb" 		          => "<input type=\"checkbox\" />",
			"title" 	          => "Slide Title",
			"background_image"    => __("Background Image", TEMPNAME)
		);

		return $columns;
	}

	add_action("manage_ninzio-slider_posts_custom_column", "ninzio_slider_custom_columns");

	function ninzio_slider_custom_columns($column){

		global $post;
		$values = get_post_custom();

		switch ($column){

			case "background_image":
				if (!empty($values["background_image"][0])) {
					echo '<img class="ninzio-slider-background-image-column" src="'.$values["background_image"][0].'" alt="'.__("Slide background image").'">';
				}
			break;

		}
	}


?>