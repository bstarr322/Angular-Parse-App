<?php

	function ninzio_portfolio() {
		
		global $nz_ninzio;
		$portfolio_slug          = (isset($nz_ninzio['port-slug']) && !empty($nz_ninzio['port-slug'])) ? $nz_ninzio['port-slug'] : 'portfolio';

		$labels = array(
			'name'               => __('Portfolio', TEMPNAME),
			'singular_name'      => __('Portfolio', TEMPNAME),
			'add_new'            => __('Add new', TEMPNAME),
			'add_new_item'       => __('Add new project', TEMPNAME),
			'edit_item'          => __('Edit project', TEMPNAME),
			'new_item'           => __('New project', TEMPNAME),
			'all_items'          => __('All projects', TEMPNAME),
			'view_item'          => __('View project', TEMPNAME),
			'search_items'       => __('Search projects', TEMPNAME),
			'not_found'          => __('No projects found', TEMPNAME),
			'not_found_in_trash' => __('No projects found in trash', TEMPNAME), 
			'parent_item_colon'  => '',
			'menu_name'          => __('Portfolio', TEMPNAME)
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true, 
			'show_in_menu'       => true, 
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $portfolio_slug,'with_front' => false ),
			'capability_type'    => 'post',
			'has_archive'        => true, 
			'hierarchical'       => false,
			'menu_position'      => null,
			'menu_icon'          => '',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt'),
		);

		register_post_type( 'portfolio', $args );
	}

	add_action( 'init', 'ninzio_portfolio' );

	function portfolio_taxonomies() {

		global $nz_ninzio;
		$portfolio_category_slug = (isset($nz_ninzio['port-cat-slug']) && !empty($nz_ninzio['port-cat-slug'])) ? $nz_ninzio['port-cat-slug'] : 'portfolio-category';
		$portfolio_tag_slug      = (isset($nz_ninzio['port-tag-slug']) && !empty($nz_ninzio['port-tag-slug'])) ? $nz_ninzio['port-tag-slug'] : 'portfolio-tag';

		register_taxonomy('portfolio-category', 'portfolio', array(
			'hierarchical' => true,
			'labels' => array(
				'name' 				=> __( 'Portfolio category', TEMPNAME ),
				'singular_name' 	=> __( 'Portfolio category', TEMPNAME ),
				'search_items' 		=> __( 'Search portfolio category', TEMPNAME ),
				'all_items' 		=> __( 'All portfolio categories', TEMPNAME ),
				'parent_item' 		=> __( 'Parent portfolio category', TEMPNAME ),
				'parent_item_colon' => __( 'Parent portfolio category', TEMPNAME ),
				'edit_item' 		=> __( 'Edit portfolio category', TEMPNAME ),
				'update_item' 		=> __( 'Update portfolio category', TEMPNAME ),
				'add_new_item' 		=> __( 'Add new portfolio category', TEMPNAME ),
				'new_item_name' 	=> __( 'New portfolio category', TEMPNAME ),
				'menu_name' 		=> __( 'Portfolio categories', TEMPNAME ),
			),
			'rewrite' => array(
				'slug' 		   => $portfolio_category_slug,
				'with_front'   => true,
				'hierarchical' => true
			),
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_admin_column' => true
		));

		register_taxonomy('portfolio-tag', 'portfolio', array(
			'hierarchical' => false,
			'labels' => array(
				'name' 				=> __( 'Portfolio tags', TEMPNAME ),
				'singular_name' 	=> __( 'Portfolio tag', TEMPNAME ),
				'search_items' 		=> __( 'Search portfolio tags', TEMPNAME ),
				'all_items' 		=> __( 'All portfolio tags', TEMPNAME ),
				'parent_item' 		=> __( 'Parent portfolio tags', TEMPNAME ),
				'parent_item_colon' => __( 'Parent portfolio tag:', TEMPNAME ),
				'edit_item' 		=> __( 'Edit portfolio tag', TEMPNAME ),
				'update_item' 		=> __( 'Update portfolio tag', TEMPNAME ),
				'add_new_item'	    => __( 'Add new portfolio tag', TEMPNAME ),
				'new_item_name' 	=> __( 'New portfolio tag', TEMPNAME ),
				'menu_name' 		=> __( 'Portfolio tags', TEMPNAME ),
			),
			'rewrite' 		   => array(
				'slug' 		   => $portfolio_tag_slug,
				'with_front'   => true,
				'hierarchical' => false
			),
		));

	}
	add_action( 'init', 'portfolio_taxonomies', 0 );


	add_action("admin_init", "ninzio_add_portfolio_meta_box");
	function ninzio_add_portfolio_meta_box(){

		add_meta_box(
	        "ninzio-portfolio-layout-options", 
	        __("Layout", TEMPNAME),
	        "render_ninzio_portfolio_layout_options", 
	        "portfolio",
	        "normal", 
	        "high"
	    );

		add_meta_box(
	        "ninzio-portfolio-format-options", 
	        __("Format", TEMPNAME),
	        "render_ninzio_portfolio_format_options", 
	        "portfolio",
	        "normal", 
	        "high"
	    );

		add_meta_box(
	        "ninzio-portfolio-details-options", 
	        __("Project details ", TEMPNAME),
	        "render_ninzio_portfolio_details_options", 
	        "portfolio",
	        "normal", 
	        "high"
	    );

	    add_meta_box(
	        "ninzio-portfolio-media-options", 
	        __("Project media", TEMPNAME),
	        "render_ninzio_portfolio_media_options", 
	        "portfolio",
	        "normal", 
	        "high"
	    );

	    add_meta_box(
	        "ninzio-portfolio-title-options", 
	        __("Project page title section options (Rich header)", TEMPNAME),
	        "render_ninzio_portfolio_title_options", 
	        "portfolio",
	        "normal", 
	        "high"
	    );

	}


	function render_ninzio_portfolio_layout_options($post) {

		$values = get_post_custom( $post->ID );
	    $layout = isset( $values['layout'][0] ) ? esc_attr( $values["layout"][0] ) : "false";

?>
        <div>
            <label>
                <input type="checkbox" name="layout" value="true" <?php checked( $layout, "true" ); ?> />
                <?php echo __(' - Solo layout (if active, you can have custom layouts for each project)', TEMPNAME); ?>
            </label>
        </div>

<?php

	}

	function render_ninzio_portfolio_details_options($post) {

		$values        = get_post_custom( $post->ID );
	    $project_link  = isset( $values['project_link'] ) ? esc_url( $values["project_link"][0] ) : "";

?>
        <div>
            <label for="project_link"><?php echo __('Enter project URL here:', TEMPNAME); ?></label>
            <input name="project_link" id="portfolio-project-link" type="text" value="<?php echo $project_link;?>"/>
        </div>

<?php

	}

	function render_ninzio_portfolio_media_options($post) {

		$values         = get_post_custom( $post->ID );
	    $audio_mp3      = isset( $values['audio_mp3'] ) ? esc_url( $values["audio_mp3"][0] ) : "";
	    $audio_ogg      = isset( $values['audio_ogg'] ) ? esc_url( $values["audio_ogg"][0] ) : "";
	    $audio_embed    = isset( $values['audio_embed'] ) ? esc_attr( $values["audio_embed"][0] ) : "";
	    $video_mp4      = isset( $values['video_mp4'] ) ? esc_url( $values["video_mp4"][0] ) : "";
	    $video_ogv  	= isset( $values['video_ogv'] ) ? esc_url( $values["video_ogv"][0] ) : "";
	    $video_webm     = isset( $values['video_webm'] ) ? esc_url( $values["video_webm"][0] ) : "";
	    $video_embed    = isset( $values['video_embed'] ) ? esc_attr( $values["video_embed"][0] ) : "";
	    $video_poster   = isset( $values['video_poster'] ) ? esc_attr( $values["video_poster"][0] ) : "";

	    wp_nonce_field( 'ninzio_portfolio_meta_nonce', 'ninzio_portfolio_meta_nonce' );
?>	

		<div id="ninzio-portfolio-featured-image" class="ninzio-portfolio-option">
			<?php echo __("Set featured image at the right sidebar, like regular posts' featured image", TEMPNAME); ?>
		</div>

		<div id="ninzio-portfolio-featured-audio" class="ninzio-portfolio-option">
	        <h4><?php echo __("Audio options", TEMPNAME); ?></h4>
	        <div>
	            <label for="audio_mp3"><?php echo __('Enter  MP3 audio file link here:', TEMPNAME); ?></label>
	            <input name="audio_mp3" id="portfolio-audio-mp3" type="text" value="<?php echo $audio_mp3;?>"/>
	        </div>
	        <div>
	            <label for="audio_embed"><?php echo __('Enter  OGG audio file link here:', TEMPNAME); ?></label>
	            <input name="audio_ogg" id="portfolio-audio-ogg" type="text" value="<?php echo $audio_ogg;?>"/>
	        </div>
	        <div>
	            <label for="audio_embed"><?php echo __('Embed audio here:', TEMPNAME); ?></label>
	            <textarea name="audio_embed" id="portfolio-audio-embed"><?php echo $audio_embed;?></textarea>
	        </div>
	    </div>

	    <div id="ninzio-portfolio-featured-video" class="ninzio-portfolio-option">
	        <h4><?php echo __("Video options", TEMPNAME); ?></h4>
	        <div>
	            <label for="video_mp4"><?php echo __('Enter  MP4 video file link here:', TEMPNAME); ?></label>
	            <input name="video_mp4" id="portfolio-video-mp3" type="text" value="<?php echo $video_mp4;?>"/>
	        </div>
	        <div>
	            <label for="video_ogv"><?php echo __('Enter  OGV video file link here:', TEMPNAME); ?></label>
	            <input name="video_ogv" id="portfolio-video-ogv" type="text" value="<?php echo $video_ogv;?>"/>
	        </div>
	        <div>
	            <label for="video_webm"><?php echo __('Enter  WEBM video file link here:', TEMPNAME); ?></label>
	            <input name="video_webm" id="portfolio-video-webm" type="text" value="<?php echo $video_webm;?>"/>
	        </div>
	        <br>
	        <div>
	            <div class="ninzio-upload">
	                <input name="video_poster" id="portfolio-video-poster" type="hidden" class="ninzio-upload-path" value="<?php echo $video_poster;?>"/> 
	                <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload video poster image', TEMPNAME) ?>" />
	                <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove video poster image', TEMPNAME) ?>" />
	                <br>
	                <img src='<?php echo $video_poster; ?>' class='ninzio-preview-upload'/>
	            </div>
	        </div>
	        <div>
	            <label for="video_embed"><?php echo __('Embed video here:', TEMPNAME); ?></label>
	            <textarea name="video_embed" id="portfolio-video-embed"><?php echo $video_embed;?></textarea>
	        </div>
	    </div>

	    <div id="ninzio-portfolio-featured-gallery" class="ninzio-portfolio-option">
	        <h4><?php echo __("Gallery options", TEMPNAME); ?></h4>
        	<div><?php echo __('Use 2nd/3rd ... Featured Images (in the right sidebar, right after main featured image) to upload images for the project gallery', TEMPNAME); ?></div>
	    </div>

<?php 

	}

	function render_ninzio_portfolio_format_options($post) {

		$values = get_post_custom( $post->ID );
	    $format = isset( $values['format'] ) ? esc_attr( $values["format"][0] ) : "";

?>
		<div class="select-featured-media-type">
			<fieldset class="nz-clearfix">
				<div id="p-image" class="featured-media-type-option">
	            	<input type="radio" id="portfolio-featured-image" name="format" class="portfolio-featured-media-option" value="image" checked <?php checked( $format, "image" ); ?> />
					<label for="format"><?php echo __("Image", TEMPNAME); ?></label>
				</div>
				<div id="p-gallery" class="featured-media-type-option">
	           		<input type="radio" id="portfolio-featured-gallery" name="format" class="portfolio-featured-media-option" value="gallery" <?php checked( $format, "gallery" ); ?> /> 
					<label for="format"><?php echo __("Gallery", TEMPNAME); ?></label>
				</div>
	            <div id="p-video" class="featured-media-type-option">
	            	<input type="radio" id="portfolio-featured-video" name="format" class="portfolio-featured-media-option" value="video" <?php checked( $format, "video" ); ?> /> 
	            	<label for="format"><?php echo __("Video", TEMPNAME); ?></label>
	            </div>
	            <div id="p-audio" class="featured-media-type-option">
	            	<input type="radio" id="portfolio-featured-audio" name="format" class="portfolio-featured-media-option" value="audio" <?php checked( $format, "audio" ); ?> /> 
	            	<label for="format"><?php echo __("Audio", TEMPNAME); ?></label>
	            </div>  
		    </fieldset>
		</div>

<?php

	}

	function render_ninzio_portfolio_title_options($post) {

	    global $nz_ninzio;

	    $nz_stuck               = ($nz_ninzio['port-hs'] && $nz_ninzio['port-hs'] == 1) ? "true" : "false";
	    $nz_rh                  = ($nz_ninzio['port-rh'] && $nz_ninzio['port-rh']  == 1) ? "true" : "false";
	    $nz_rh_height           = ($nz_ninzio['port-rh-height']) ? $nz_ninzio["port-rh-height"] : "500";
	    $nz_back_color          = ($nz_ninzio['port-back']['background-color']) ? $nz_ninzio["port-back"]['background-color'] : "";
	    $nz_back_img            = ($nz_ninzio['port-back']['background-image']) ? $nz_ninzio['port-back']['background-image'] : "";
	    $nz_back_img_repeat     = ($nz_ninzio['port-back']['background-repeat']) ? $nz_ninzio['port-back']['background-repeat'] : "no-repeat";
	    $nz_back_img_position   = ($nz_ninzio['port-back']['background-position']) ? $nz_ninzio['port-back']['background-position'] : "left_top";
	    $nz_back_img_attachment = ($nz_ninzio['port-back']['background-attachment']) ? $nz_ninzio['port-back']['background-attachment'] : "scroll";
	    $nz_back_img_size       = ($nz_ninzio['port-back']['background-size']) ? $nz_ninzio['port-back']['background-size'] : "auto";
	    $nz_parallax            = ($nz_ninzio['port-parallax'] && $nz_ninzio['port-parallax']  == 1) ? "true" : "false";

	    $values                 = get_post_custom( $post->ID );

	    $header_stuck           = isset( $values["header_stuck"][0] ) ? esc_attr( $values["header_stuck"][0] ) : $nz_stuck;
	    $rh                     = isset( $values['rh'][0] ) ? esc_attr( $values["rh"][0] ) : $nz_rh;
	    $rh_height              = isset( $values['rh_height'] ) ? esc_attr( $values["rh_height"][0] ) : $nz_rh_height;
	    $rh_back_color          = isset( $values['rh_back_color'] ) ? esc_attr( $values["rh_back_color"][0] ) : $nz_back_color;
	    $rh_back_img            = isset( $values['rh_back_img'] ) ? esc_url( $values["rh_back_img"][0] ) : $nz_back_img;
	    $rh_back_img_repeat     = isset( $values['rh_back_img_repeat'] ) ? esc_attr( $values["rh_back_img_repeat"][0] ) : $nz_back_img_repeat;
	    $rh_back_img_position   = isset( $values['rh_back_img_position'] ) ? esc_attr( $values["rh_back_img_position"][0] ) : $nz_back_img_position;
	    $rh_back_img_attachment = isset( $values['rh_back_img_attachment'] ) ? esc_attr( $values["rh_back_img_attachment"][0] ) : $nz_back_img_attachment;
	    $rh_back_img_size       = isset( $values['rh_back_img_size'] ) ? esc_attr( $values["rh_back_img_size"][0] ) : $nz_back_img_size;
	    $parallax               = isset( $values['parallax'][0] ) ? esc_attr( $values["parallax"][0] ) : $nz_parallax;
	?>
	    <br>
	    <div class="ninzio-post-subsection">
	        <div class="ninzio-post-title-option">
	            <label>
	                <input type="checkbox" name="header_stuck" value="true" <?php checked( $header_stuck, "true" ); ?> />
	                <?php echo __(' - Header stuck', TEMPNAME); ?>
	            </label>
	            <p><?php echo __("Toggle Header stuck state on this page", TEMPNAME); ?></p>
	        </div>
	    </div>

	    <div class="ninzio-post-subsection">

	        <div class="ninzio-post-title-option">
	            <label>
	                <input type="checkbox" name="rh" value="true" <?php checked( $rh, "true" ); ?> />
	                <?php echo __(' - Rich header', TEMPNAME); ?>
	            </label>
	            <p><?php echo __("Toggle Rich header (page title section) on this page", TEMPNAME); ?></p>
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __('Page header section height:', TEMPNAME); ?></label>
	            <input name="rh_height" type="text" value="<?php echo $rh_height; ?>" />
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __('Page header section background color:', TEMPNAME); ?></label>
	            <input name="rh_back_color" class="ninzio-color-picker" value="<?php echo $rh_back_color; ?>" />
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __('Page header section background image:', TEMPNAME); ?></label>
	            <div class="ninzio-upload">
	                <input name="rh_back_img" type="hidden" class="ninzio-upload-path" value="<?php echo $rh_back_img;?>"/> 
	                <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload background image', TEMPNAME) ?>" />
	                <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove background image', TEMPNAME) ?>" />
	                <br>
	                <img src='<?php echo $rh_back_img; ?>' class='ninzio-preview-upload'/>
	            </div>
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __("Page header section background image repeat", TEMPNAME); ?></label>
	            <select name="rh_back_img_repeat">  
	                <option value="no-repeat" <?php selected( $rh_back_img_repeat, 'no-repeat' ); ?>><?php echo __('no-repeat',TEMPNAME); ?></option>
	                <option value="repeat-x" <?php selected( $rh_back_img_repeat, 'repeat-x' ); ?>><?php echo __('repeat-x',TEMPNAME); ?></option>
	                <option value="repeat-y" <?php selected( $rh_back_img_repeat, 'repeat-y' ); ?>><?php echo __('repeat-y',TEMPNAME); ?></option>
	                <option value="repeat" <?php selected( $rh_back_img_repeat, 'repeat' ); ?>><?php echo __('repeat',TEMPNAME); ?></option>
	            </select>
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __("Page header section background image position", TEMPNAME); ?></label>
	            <select name="rh_back_img_position">  
	                <option value="left top" <?php selected( $rh_back_img_position, 'left top' ); ?>><?php echo __('left top',TEMPNAME); ?></option>
	                <option value="left center" <?php selected( $rh_back_img_position, 'left center' ); ?>><?php echo __('left center',TEMPNAME); ?></option>
	                <option value="left bottom" <?php selected( $rh_back_img_position, 'left bottom' ); ?>><?php echo __('left bottom',TEMPNAME); ?></option>
	                <option value="center top" <?php selected( $rh_back_img_position, 'center top' ); ?>><?php echo __('center top',TEMPNAME); ?></option>
	                <option value="center center" <?php selected( $rh_back_img_position, 'center center' ); ?>><?php echo __('center center',TEMPNAME); ?></option>
	                <option value="center bottom" <?php selected( $rh_back_img_position, 'center bottom' ); ?>><?php echo __('center bottom',TEMPNAME); ?></option>
	                <option value="right top" <?php selected( $rh_back_img_position, 'right top' ); ?>><?php echo __('right top',TEMPNAME); ?></option>
	                <option value="right center" <?php selected( $rh_back_img_position, 'right center' ); ?>><?php echo __('right center',TEMPNAME); ?></option>
	                <option value="right bottom" <?php selected( $rh_back_img_position, 'right bottom' ); ?>><?php echo __('right bottom',TEMPNAME); ?></option>
	            </select>
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __("Page header section background image attachment", TEMPNAME); ?></label>
	            <select name="rh_back_img_attachment">  
	                <option value="scroll" <?php selected( $rh_back_img_attachment, 'scroll' ); ?>><?php echo __('scroll',TEMPNAME); ?></option>
	                <option value="fixed" <?php selected( $rh_back_img_attachment, 'fixed' ); ?>><?php echo __('fixed',TEMPNAME); ?></option>
	            </select>
	        </div>

	        <div class="ninzio-post-title-option">
	            <label><?php echo __("Page title section background image size", TEMPNAME); ?></label>
	            <select name="rh_back_img_size">  
	                <option value="auto" <?php selected( $rh_back_img_size, 'auto' ); ?>><?php echo __('auto',TEMPNAME); ?></option>
	                <option value="cover" <?php selected( $rh_back_img_size, 'cover' ); ?>><?php echo __('cover',TEMPNAME); ?></option>
	            </select>
	        </div>
	        <div class="ninzio-post-title-option">
	            <label>
	                <input type="checkbox" name="parallax" value="true" <?php checked( $parallax, "true" ); ?> />
	                <?php echo __(' - Parallax', TEMPNAME); ?>
	            </label>
	            <p><?php echo __("Activate parallax effect on post title section (not available on mobile devices). Use images with a height greater than post title section (1:1.5 ratio)", TEMPNAME); ?></p>
	        </div>
	    </div>
	<?php
	}

	add_action( 'save_post', 'save_ninzio_portfolio_options' );  
	function save_ninzio_portfolio_options( $post_id )  
	{  
	    
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
	    if( !isset( $_POST['ninzio_portfolio_meta_nonce'] ) || !wp_verify_nonce( $_POST['ninzio_portfolio_meta_nonce'], 'ninzio_portfolio_meta_nonce' ) ) return;  
	    if( !current_user_can( 'edit_post' ) ) return;

	    if( isset( $_POST['format'] ) ){update_post_meta($post_id, "format",$_POST["format"]);}
	    if( isset( $_POST['audio_mp3'] ) ){update_post_meta($post_id, "audio_mp3",$_POST["audio_mp3"]);}
	    if( isset( $_POST['audio_ogg'] ) ){update_post_meta($post_id, "audio_ogg",$_POST["audio_ogg"]);}
	    if( isset( $_POST['audio_embed'] ) ){update_post_meta($post_id, "audio_embed",$_POST["audio_embed"]);}
	    if( isset( $_POST['video_mp4'] ) ){update_post_meta($post_id, "video_mp4",$_POST["video_mp4"]);}
	    if( isset( $_POST['video_ogv'] ) ){update_post_meta($post_id, "video_ogv",$_POST["video_ogv"]);}
	    if( isset( $_POST['video_webm'] ) ){update_post_meta($post_id, "video_webm",$_POST["video_webm"]);}
	    if( isset( $_POST['video_embed'] ) ){update_post_meta($post_id, "video_embed",$_POST["video_embed"]);}
	    if( isset( $_POST['video_poster'] ) ){update_post_meta($post_id, "video_poster",$_POST["video_poster"]);}
	    if( isset( $_POST['project_link'] ) ){update_post_meta($post_id, "project_link",$_POST["project_link"]);}
	    if( isset( $_POST['rh_height'] ) ){update_post_meta($post_id, "rh_height",$_POST["rh_height"]);}
	    if( isset( $_POST['rh_back_color'] ) ){update_post_meta($post_id, "rh_back_color",$_POST["rh_back_color"]);}
	    if( isset( $_POST['rh_back_img'] ) ){update_post_meta($post_id, "rh_back_img",$_POST["rh_back_img"]);}
	    if( isset( $_POST['rh_back_img_repeat'] ) ){update_post_meta($post_id, "rh_back_img_repeat",$_POST["rh_back_img_repeat"]);}
	    if( isset( $_POST['rh_back_img_position'] ) ){update_post_meta($post_id, "rh_back_img_position",$_POST["rh_back_img_position"]);}
	    if( isset( $_POST['rh_back_img_attachment'] ) ){update_post_meta($post_id, "rh_back_img_attachment",$_POST["rh_back_img_attachment"]);}
	    if( isset( $_POST['rh_back_img_size'] ) ){update_post_meta($post_id, "rh_back_img_size",$_POST["rh_back_img_size"]);}

	    $layout_checked = ( isset( $_POST['layout'] ) ) ? "true" : "false";
	    update_post_meta($post_id, "layout", $layout_checked);

		$rh_checked = ( isset( $_POST['rh'] ) ) ? "true" : "false";
	    update_post_meta($post_id, "rh", $rh_checked);

	    $header_stuck_checked = ( isset( $_POST['header_stuck'] ) ) ? "true" : "false";
	    update_post_meta($post_id, "header_stuck", $header_stuck_checked);

	    $parallax_checked = ( isset( $_POST['parallax'] ) ) ? "true" : "false";
	    update_post_meta($post_id, "parallax", $parallax_checked);

	}

/*====================================================================*/
/*	PORTFOLIO ADMIN COLUMNS
/*====================================================================*/
	
	add_filter("manage_edit-portfolio_columns", "portfolio_edit_columns");

	function portfolio_edit_columns($columns){


		$columns['cb']             = "<input type=\"checkbox\" />";
		$columns['title']          = __("Project title", TEMPNAME);
		$columns['format']         = __("Format", TEMPNAME);
		$columns['category']       = __("Category", TEMPNAME);
		$columns['portfolio-tags'] = __("Tags", TEMPNAME);

		return $columns;
	}

	add_action("manage_portfolio_posts_custom_column", "portfolio_custom_columns");

	function portfolio_custom_columns($column){

		global $post;
		$values = get_post_custom();

		$ninzio_portfolio_format = isset($values["ninzio_portfolio_format"][0]) ? $values["ninzio_portfolio_format"][0] : "image";

		switch ($column){

			case "format":
				
				echo '<span title="'.$ninzio_portfolio_format.' format" class="'.$ninzio_portfolio_format.'">'.$ninzio_portfolio_format.'</span>';
				
			break;

			case "category":

				$terms = get_the_terms( $post->ID, 'portfolio-category' );

				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'portfolio-category' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio-category', 'display' ) )
						);
					}

					echo join( ', ', $out );

				} else {
					echo __("No categories", TEMPNAME);
				}
				
			break;

			case "portfolio-tags":

				$terms = get_the_terms( $post->ID, 'portfolio-tag' );

				if ( !empty( $terms ) ) {
					$out = array();
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'portfolio-tag' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'portfolio-tag', 'display' ) )
						);
					}

					echo join( ', ', $out );

				} else {
					echo __("No tags", TEMPNAME);
				}
				
			break;

		}
	}

?>