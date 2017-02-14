<?php

/*  CLEAR EXTRA TAGS FROM SHORTCODES
/*====================================================================*/

	add_filter("the_content", "ninzio_the_content_filter");
	add_filter('widget_text', 'ninzio_the_content_filter');
	 
	function ninzio_the_content_filter($content) {
	 
		$block = join("|",array("nz_table","nz_dropcap","nz_highlight","nz_il","nz_btn","nz_fw","nz_sep","nz_icons","nz_gap","nz_youtube","nz_vimeo","nz_you","nz_vim","nz_colorbox"));
	 
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
			
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
	 
		return $rep;
	 
	}

global $nz_ninzio;
$nz_color = (isset($nz_ninzio['main-color']) && $nz_ninzio['main-color']) ? $nz_ninzio['main-color'] : "#08ade4";

/*  TINYMCE CONFIG
/*====================================================================*/

	function ninzio_tinyMCE_more_buttons($buttons) {

		$buttons[] = 'fontselect';
		$buttons[] = 'fontsizeselect';
		$buttons[] = 'styleselect';
		return $buttons;

	}
	add_filter("mce_buttons_2", "ninzio_tinyMCE_more_buttons");

	if ( ! function_exists( 'ninzio_font_size' ) ) {
	    function ninzio_font_size( $initArray ){
	        $initArray['fontsize_formats'] = "12px 13px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px 50px 52px 54px 56px 58px 60px 62px 64px 66px 68px 70px 72px";
	        return $initArray;
	    }
	}
	add_filter( 'tiny_mce_before_init', 'ninzio_font_size' );

	function ninzio_styles_dropdown( $settings ) {

		$items = array();

		for ($i=16; $i < 101; $i = $i + 2) { 
			array_push($items, array('title'  => $i.'px','inline' => 'span','styles' => array('lineHeight' => $i.'px')));
		};

		$new_styles = array(
			array(
				'title'	=> __( 'Line height', TEMPNAME ),
				'items'	=> $items
			),
		);

		$settings['style_formats_merge'] = true;
		$settings['style_formats'] = json_encode( $new_styles );
		return $settings;

	}
	add_filter( 'tiny_mce_before_init', 'ninzio_styles_dropdown' );

	add_filter("the_content", "nz_the_content_filter");
	add_filter('widget_text', 'nz_the_content_filter');
	 
	function nz_the_content_filter($content) {
	 
		$block = join("|",array("nz_box"));
		$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
		$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
		return $rep;
	 
	}

/* COLORBOX
/*====================================================================*/

	function nz_colorbox( $atts, $content = null ) {

		extract(shortcode_atts(array(
	        'border_radius'    => '',
	        'border_width'     => '',
	        'background_color' => '',
	        'border_color'     => '',
	        'color'            => '',
	        'padding'          => '20px 20px 20px 20px',
	        'width'            => '',
	    ), $atts));


	    $style = "";
	    $output = "";

	    static $id_counter = 1;

	    if(empty($width)){
	    	$style .= 'width:100%;';
	    } else {
	    	$style .= 'width:'.$width.'px;';
	    }

	    if(!is_numeric($border_radius) || $border_radius < 0 ){$border_radius = "0";}
	    if(!is_numeric($border_width) || $border_width < 0 ){$border_width = "";}

	    if (isset($padding) && !empty($padding)) {
	    	$style .= "padding:".$padding.";";
	    }

	    if (isset($border_radius) && !empty($border_radius)) {
	    	$style .= "border-radius:".$border_radius."px;";
	    }

	    if (isset($border_width) && !empty($border_width)){
	    	$style .= "border-width:".$border_width."px; border-style:solid;";
	    }

	    if (isset($border_color) && !empty($border_color)){
	    	$style .= "border-color:".$border_color.";";
	    }

	    if (isset($background_color) && !empty($background_color)){
	    	$style .= "background-color:".$background_color.";";
	    }

	    if (isset($color) && !empty($color)){
	    	$style .= "color:".$color.";";
	    }

	   $output = '<div data-id="nz-colorbox-'.$id_counter.'" class="nz-colorbox nz-clearfix" style="'.$style.'">'.do_shortcode($content).'</div>';

	   $id_counter++;

	   return $output;

	}
	add_shortcode('nz_colorbox', 'nz_colorbox');

/*  HIGHLIGHT
/*====================================================================*/

	function nz_highlight( $atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'color' => ''
			), $atts)
		);

		if (isset($color) && !empty($color)) {
			$color='style="background-color:'.$color.';"';
		}

		$output = '<span class="nz-highlight" '.$color.'>'.do_shortcode($content).'</span>';

		return $output;  		
	}

	add_shortcode('nz_highlight', 'nz_highlight');

/*  DROPCAP
/*====================================================================*/

	function nz_dropcap( $atts, $content = null ) {

		extract(shortcode_atts(
			array(
				'type' => 'empty',
				'color' => ''
			), $atts)
		);

		if (isset($color) && !empty($color)) {
			switch ($type) {
				case 'empty':
					$color = 'style="color:'.$color.';"';
					break;
				case 'full':
					$color = 'style="background-color:'.$color.';"';
					break;
			}
		}
			
		$output = '<span class="nz-dropcap '.$type.'" '.$color.'>'.do_shortcode($content).'</span>';

		return $output;  		
	}

	add_shortcode('nz_dropcap', 'nz_dropcap');

/*  ICON LIST
/*====================================================================*/
	
	function nz_icon_list_fun($atts, $content = null, $tag) {

		extract(shortcode_atts(
			array(
				'icon' 		       => 'icon-checkmark',
				'icon_color'       => '',
				'background_color' => '',
				'type'             => ''
			), $atts)
		);

		$styles = '';
		$output = '';

		if(isset($icon_color) && !empty($icon_color)){
			$styles .='color:'.$icon_color.';';
		}

		if(isset($background_color) && !empty($background_color) && empty($type)){
			$type = 'square';
		}

		if(isset($background_color) && !empty($background_color) && isset($type) && !empty($type)){
			$styles .='background-color:'.$background_color.';';
		}

		switch( $tag ) {
	        case "nz_icon_list":
	            $output .= '<ul class="nz-i-list '.$type.'">';
					$split = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $content);
					foreach($split as $haystack) {
			            $output .= '<li><div><span class="icon '.$icon.'" style="'.$styles.'"></span></div><div>' . $haystack . '</div></li>';
			        }
			    $output .= '</ul>';
	            break;
	        case "nz_il":
	            $content = str_replace('<ul>', '<ul class="nz-i-list '.$type.' '.$class.'">', do_shortcode($content));
				$content = str_replace('<li>', '<li><div><span class="icon '.$icon.'" style="'.$styles.'"></span></div><div>', do_shortcode($content));
				$content = str_replace('</li>', '</div></li>', do_shortcode($content));
				$output = $content;
	            break;
	    }
	
		return $output;

	}

	add_shortcode( 'nz_icon_list', 'nz_icon_list_fun' );
	add_shortcode( 'nz_il', 'nz_icon_list_fun' );

/*  GALLERY SHORTCODE
/*====================================================================*/
	
	remove_shortcode('gallery', 'gallery_shortcode');
	add_shortcode('gallery', 'nz_gallery');

	function nz_gallery($attr) {

		$post = get_post();

		static $instance = 0;
		$instance++;

		if ( ! empty( $attr['ids'] ) ) {
			// 'ids' is explicitly ordered, unless you specify otherwise.
			if ( empty( $attr['orderby'] ) )
				$attr['orderby'] = 'post__in';
			$attr['include'] = $attr['ids'];
		}

		// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
		if ( isset( $attr['orderby'] ) ) {
			$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
			if ( !$attr['orderby'] )
				unset( $attr['orderby'] );
		}

		extract(shortcode_atts(array(
			'order'      => 'ASC',
			'orderby'    => 'menu_order ID',
			'id'         => $post ? $post->ID : 0,
			'itemtag'    => 'div',
			'icontag'    => 'div',
			'captiontag' => 'div',
			'columns'    => 3,
			'size'       => 'thumbnail',
			'include'    => '',
			'exclude'    => '',
			'link'       => ''
		), $attr, 'gallery'));
		
		$columns = intval($columns);

		if ($size == "medium" || $size == "thumbnail") {
			$size = 'Ninzio-Half';
		} elseif ($size == "large") {
			$size = 'Ninzio-Whole';
		}

		if ($columns == '3' || $columns == '2' || $columns == '4') {
			$size = 'Ninzio-Half';
		} elseif ($columns == '1') {
			$size = 'Ninzio-Whole';
		}

		$id = intval($id);
		if ( 'RAND' == $order )
			$orderby = 'none';

		if ( !empty($include) ) {
			$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}
		} elseif ( !empty($exclude) ) {
			$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		} else {
			$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		}

		if ( empty($attachments) )
			return '';

		if ( is_feed() ) {
			$output = "\n";
			foreach ( $attachments as $att_id => $attachment )
				$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
			return $output;
		}

		$selector = "nz-gallery-{$instance}";
		
		$size_class = sanitize_html_class( $size );

		$output = "<div id='$selector' class='nz-gallery galleryid-{$id}  gallery-size-{$size_class}' data-columns='".$columns."''>";

			foreach ( $attachments as $id => $attachment ) {

				$image_output    = wp_get_attachment_image_src( $id, $size, false);
				$img_full        = wp_get_attachment_image_src( $id, 'full', false);

				$before_img = '';
				$after_img  = '';

				if (!empty($attachment->post_excerpt)) {
					$before_img = '<figure class="wp-caption aligncenter">';
					$after_img = '<figcaption class="wp-caption-text">'.$attachment->post_excerpt.'</figcaption></figure>';
				}

				if ( ! empty( $link ) && 'file' === $link ){
					$image_output = $before_img.'<a data-lightbox-gallery="gallery2" href="'.$img_full[0].'"><div class="ninzio-overlay"></div><img alt="'.$attachment->post_excerpt.'" src="'.$image_output[0].'" width="'.$image_output[1].'" height="'.$image_output[2].'"></a>'.$after_img;
				}
				elseif ( ! empty( $link ) && 'none' === $link ){
					$image_output = $before_img.'<img src="'.$image_output[0].'" width="'.$image_output[1].'" height="'.$image_output[2].'" alt="'.$attachment->post_excerpt.'">'.$after_img;
				}
				else {
					$image_output = wp_get_attachment_link( $id, $size, true, false );
				}

				$output .= "<div class='gallery-item'>";
					$output .= $image_output;
				$output .= "</div>";
			}

		$output .= "</div>";

		return $output;
	}

/*  BUTTONS SHORTCODE
/*====================================================================*/

	function nz_btn($atts, $content = null) {

		extract(shortcode_atts(array(
			'text'                  => '',
			'link'                  => '',
			'target'                => '',
			'icon'                  => '',
			'animate'               => '',
			'animation_type'        => '',
			'color'                 => '',
			'size'                  => '',
			'shape'                 => '',
			'type'                  => '',
			'hover_normal'          => '',
			'hover_ghost'           => '',
			'el_class'                   => ''

		), $atts));

		$output = "";
		$class  = "button-".$type;
		$class  .= " ".$color;
		$class  .= " ".$size;
		$class  .= " ".$shape;
		if (isset($icon) && !empty($icon)) {
			$class  .= " icon-true";
		}
		$class  .= " animate-".$animate;
		$class  .= " anim-type-".$animation_type;

		switch ($type) {
			case 'normal':
				$class  .= " hover-".$hover_normal;
				break;
			case 'ghost':
				$class  .= " hover-".$hover_ghost;
				break;
		}

		if (isset($el_class) && !empty($el_class)) {$class  .= " ".$el_class;}

		$output .= '<a class="button '.$class.'" href="'.$link.'" target="'.$target.'">';
			$output .= '<span class="txt">'.$text.'</span>';
			if (isset($icon) && !empty($icon)) {$output .= '<span class="btn-icon '.$icon.'"></span>';}
		$output .= '</a>';
		return $output;
	}

	add_shortcode('nz_btn', 'nz_btn');

/*  GAP SHORTCODE
/*====================================================================*/

	function nz_gap( $atts, $content = null ) {
	   extract(shortcode_atts(array('height' => ''), $atts));
	   return "<div class='gap nz-clearfix' style='height:".$height."px'>&nbsp;</div>";
	}
	add_shortcode('nz_gap', 'nz_gap');

/*  SEPARATOR SHORTCODE
/*====================================================================*/
	
	function nz_sep($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'top'    => '20',
				'bottom' => '20',
				'type'   => 'solid',
				'color'  => '',
				'align'  => 'left',
				'width'  => '',
				'height' => ''
			), $atts)
		);

		$styles = "";

		if (isset($color) && !empty($color)) {
			$styles .= 'border-bottom-color:'.$color.';';
		}

		if (isset($width) && !empty($width)) {
			$styles .= 'width:'.$width.'px;';
		} else {
			$styles .= 'width:100%;';
		}

		if (isset($height) && !empty($height)) {
			$styles .= 'border-bottom-width:'.$height.'px;';
		}

		$output = '<div class="sep-wrap '.$align.' nz-clearfix"><div class="nz-separator '.$type.'" style="margin-top:'.$top.'px; margin-bottom:'.$bottom.'px;'.$styles.'">&nbsp;</div></div>';
		return $output;
	}
	add_shortcode('nz_sep', 'nz_sep');

/*  SOCIAL LINKS SHORTCODE
/*====================================================================*/
	
	function nz_sl($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'target'         => '_self',
				'align'          => 'left',
				'link_color'     => '',
				'link_back_color'=> ''
			), $atts)
		);

		$output     = "";
		$styles     = "";
		$datacolors = "";

		if (isset($link_color) && !empty($link_color)) {
			$styles .= 'color:'.$link_color.';';
		}

		if (isset($link_back_color) && !empty($link_back_color)) {
			$styles .= 'background-color:'.$link_back_color.';';
			$datacolors = 'data-color="'.$link_back_color.'" data-colorhover="'.ninzio_hex_to_rgb_shade($link_back_color,20).'"';
		}

		$output .= '<div class="nz-sl social-links nz-clearfix '.$align.'">';
		
		foreach($atts as $social => $href) {
			if($href && $social != 'target' && $social != 'align' && $social != 'link_color' && $social != 'link_back_color') {
				if ($social == "email") {
					$output .='<a style="'.$styles.'" '.$datacolors.' class="icon-envelope" href="'.$href.'" target="'.$target.'" ><span>'.$social.'</span></a>';
				} else {
					$output .='<a style="'.$styles.'" '.$datacolors.' class="icon-'.$social.'" href="'.$href.'" target="'.$target.'" ><span>'.$social.'</span></a>';
				}
			}
		}

		$output .= '</div>';

		return $output;
	}
	add_shortcode('nz_sl', 'nz_sl');

/*  ICONS SHORTCODE
/*====================================================================*/
	
	function nz_icons($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type'             => '',
				'size'             => 'small',
				'icon'             => 'icon-happy',
				'icon_color'       => '',
				'border_color'     => '',
				'background_color' => '',
				'animate'          => 'false'
			), $atts)
		);

		$output = '';
		$styles = '';

		if (!empty($icon_color)) {$styles .= 'color:'.$icon_color.';';}
		if (!empty($background_color)) {$styles .= 'background-color:'.$background_color.';';}
		if(empty($type)) {$type="square";}
		if(empty($border_color)){$border_color = $background_color;}
		if(!empty($border_color) && !empty($type)) {$styles .= 'border-color:'.$border_color.';';}
		$output .= '<span class="nz-icon '.$type.' '.$size .' '.$icon.' animate-'.$animate.'" style="'.$styles.'"></span>';
		return $output;
	}
	add_shortcode('nz_icons', 'nz_icons');

/*  VIDEO EMBEDS
/*====================================================================*/
	
	function nz_emb( $atts, $content = null, $tag ) {

	    extract( 
	    	shortcode_atts(
    		array(
    			'id' 	=> '',
    			'width' => ''
    		), $atts)
	    );

	    switch( $tag ) {
	        case "nz_youtube":
	            $src = 'http://www.youtube-nocookie.com/embed/';
	            break;
	        case "nz_vimeo":
	            $src = 'http://player.vimeo.com/video/';
	            break;
	    }

	    $style="";

	    if (!empty($width)) {$style = 'max-width:'.$width.'px;';}

	    $output ="";

	    if(isset($id) && !empty($id)){
	    	$output .='<div class="video-embed" style="'.$style.'">';
		    	$output .='<div class="flex-mod">';
		    		$output .= '<iframe src="'.$src.$id.'" class="iframevideo"></iframe>';
		    	$output .='</div>';
		    $output .='</div>';
	    }

	    return $output;
	}
	add_shortcode( 'nz_youtube', 'nz_emb' );
	add_shortcode( 'nz_vimeo', 'nz_emb' );


	function nz_emb_slider( $atts, $content = null, $tag ) {

	    extract( 
	    	shortcode_atts(
    		array(
    			'id' 	=> '',
    			'width' => ''
    		), $atts)
	    );

	    switch( $tag ) {
	        case "nz_you":
	            $src = 'http://www.youtube-nocookie.com/embed/';
	            break;
	        case "nz_vim":
	            $src = 'http://player.vimeo.com/video/';
	            break;
	    }

	    $height="";

	    if (!empty($width)) {$height = round($width*0.5625,0);}

	    $output ="";

	    if(isset($id) && !empty($id)){
	    	$output .='<div class="video-embed">';
		    	$output .= '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.$id.'" class="iframevideo"></iframe>';
		    $output .='</div>';
	    }

	    return $output;
	}
	add_shortcode( 'nz_you', 'nz_emb_slider' );
	add_shortcode( 'nz_vim', 'nz_emb_slider' );

/*  SOUNDCLOUD
/*====================================================================*/
	
	function nz_soundcloud($atts) {

		extract( 
		 	shortcode_atts(
			array(
				'url'    => '',
				'width'  => '100%',
				'height' => '166'
			), $atts)
		);

		global $nz_color;
		$output = "";

		$params = 'color='.substr($nz_color, -6).'&auto_play=false&show_artwork=true';

		if(empty($width)) {$width = "100%";}

		if(empty($height) || !is_numeric($height)) {$height = "166";}

		if(isset($url) && !empty($url)){
			$output .= '<div class="soundcloud"><iframe width="'.$width.'" height="'.$height.'" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url='.$url.'&amp;'.$params.'"></iframe></div>';
		}
	    
		return $output;
	}

	add_shortcode('nz_soundcloud', 'nz_soundcloud');

/*  TWEETS
/*====================================================================*/
	
	function nz_tweets($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'user_id'  => '',
				'number'   => '',
				'color'    => '',
				'autoplay' => ''
			), $atts)
		);

		$output = '';
		static $id_counter = 1;

		global $nz_ninzio;

		$consumer_key        = ($nz_ninzio['tweets-consumer-key']) ? esc_attr($nz_ninzio['tweets-consumer-key']) : "";
		$consumer_secret     = ($nz_ninzio['tweets-consumer-secret']) ? esc_attr($nz_ninzio['tweets-consumer-secret']) : "";
		$access_token        = ($nz_ninzio['tweets-access-token']) ? esc_attr($nz_ninzio['tweets-access-token']) : "";
		$access_token_secret = ($nz_ninzio['tweets-access-token-secret']) ? esc_attr($nz_ninzio['tweets-access-token-secret']) : "";

		if (isset($color) && !empty($color)) {
			$color = '#nz-tweets-'.$id_counter.' {color:'.$color.';}#nz-tweets-'.$id_counter.' .owl-controls .owl-page {background-color:'.$color.';}#nz-tweets-'.$id_counter.' .owl-controls .owl-page.active {border-color:'.$color.';}';
		}

		if (!empty($consumer_key) && !empty($consumer_secret) && !empty($access_token) && !empty($access_token_secret)) {

			$args = array(
				'before_widget' => '<div id="nz-tweets-'.$id_counter.'" class="nz-tweets lazy" data-autoplay="'.$autoplay.'"><style scoped>'.$color.'</style>',
				'after_widget'  => '</div>'
			);

			$instance = array(
				'title'               => '',
				'consumer_key'        => $consumer_key,
				'consumer_secret'     => $consumer_secret,
				'access_token'        => $access_token,
				'access_token_secret' => $access_token_secret,
				'twitter_id'          => $user_id,
				'count'               => $number
			);

			$output .= get_the_widget( 'WP_Widget_Twitter', $instance,$args);

		}

		$id_counter++;

		return $output;
	}

	add_shortcode('nz_tweets', 'nz_tweets');

/*  MAILCHIMP SIGNUP
/*====================================================================*/
	
	function nz_mailchimp($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'action'    => '',
				'name'      => '',
				'color'     => '',
				'btn_color' => '',
				'width'     => '',
				'align'     => 'center'
			), $atts)
		);

		static $id_counter = 1;
		$output = '';
		$output = "";

		if (isset($action) && !empty($action) && isset($name) && !empty($name)) {

			$output .='<div class="nz-mailchimp-wrap nz-clearfix" data-align="'.$align.'">';

				$output .='<div id="nz-mailchimp-'.$id_counter.'" class="nz-mailchimp">';

					$output .= '<style scoped>';

						if (isset($color) && !empty($color)) {
							$output .= '#nz-mailchimp-'.$id_counter.' input[type="email"] {color:'.$color.';border-color:'.$color.';}';
							$output .= '#nz-mailchimp-'.$id_counter.' input[type="email"]:focus {background-color:'.ninzio_hex_to_rgba($color,0.2).' !important;}';
							$output .= '#nz-mailchimp-'.$id_counter.' .icon-envelope {color:'.$color.';}';
						}

						if (isset($btn_color) && !empty($btn_color)) {
							$output .= '#nz-mailchimp-'.$id_counter.' input[type="submit"] {background-color:'.$btn_color.';}';
							$output .= '#nz-mailchimp-'.$id_counter.' input[type="submit"]:hover {background-color:'.ninzio_hex_to_rgb_shade($btn_color,20).';}';
						}

						if (isset($width) && !empty($width)) {
							$output .= '#nz-mailchimp-'.$id_counter.' {width:'.$width.'px;}';
						}

					$output .= '</style>';

					$output .='<div id="mc_embed_signup">';
						$output .='<form action="'.$action.'" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>';
							$output .='<span class="icon-envelope"></span><input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" data-placeholder="Enter email address" required>';
						    $output .='<input type="text" name="'.$name.'" tabindex="-1" value="" class="hidden">';
						    $output .='<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"><span class="icon-plus"></span>';
						$output .='</form>';
					$output .='</div>';

				$output .='</div>';

			$output .='</div>';

		}

		return $output;
		$id_counter++;
	}

	add_shortcode('nz_mailchimp', 'nz_mailchimp');

/*  TAGLINE
/*====================================================================*/
	
	function nz_tagline($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'title'           => '',
				'color'           => '',
				'back_color'      => '',
				'back_color_hov'  => '',
				'link'            => ''
			), $atts)
		);

		$output       = "";
		$styles       = "";
		$styles_hover = "";

		static $id_counter = 1;

		if (isset($color) && !empty($color)) {
			$styles .= 'color:'.$color.';';
		}

		if (isset($back_color) && !empty($back_color)) {
			$styles .= 'background-color:'.$back_color.';';
		}

		if (isset($back_color_hov) && !empty($back_color_hov)) {
			$styles_hover .= 'background-color:'.$back_color_hov.';';
		}

		if (!isset($link) && empty($link)) {
			$link = "#";
		}

		$output .= '<div id="nz-tagline-'.$id_counter.'">';
		$output .= '<style scoped>'; 
			$output .= '#nz-tagline-'.$id_counter.' a {'.$styles.';}';
			$output .= '#nz-tagline-'.$id_counter.' a:hover {'.$styles_hover.';}';
		$output .= '</style>';
		$output .= '<a href="'.$link.'" class="nz-tagline nz-clearfix">';
			$output .='<div class="container">';
					if(isset($title) && !empty($title)){$output .= '<div class="tagline-title">'.$title.'</div>';}
			$output .= '</div>';
		$output .= '</a></div>';

		$id_counter++;
		return $output;
	}

	add_shortcode('nz_tagline', 'nz_tagline');

/*  SLIDER
/*====================================================================*/
	
		function nz_media_slider($atts, $content = null) {

			extract(shortcode_atts(
				array(
					'effect' => 'fade',
					'bul' => 'true',
					'nav' => 'true',
					'autoplay' => 'true'
				), $atts)
			);

			$output = '<div data-effect="'.$effect.'" data-bullets="'.$bul.'" data-autoplay="'.$autoplay.'" data-navigation="'.$nav.'" class="lazy nz-media-slider">';
				$output .= '<ul class="slides">';
					$output .= do_shortcode($content);
				$output .= '</ul>';
			$output .= '</div>';

			return $output;
		}
		add_shortcode('nz_media_slider', 'nz_media_slider');

		function nz_media_slide($atts, $content = null) {

			extract(shortcode_atts(
				array(
					'type'        => '',
					'id'          => '',
					'src'         => '',
					'description' => ''
				), $atts)
			);

			if(isset($src) && !empty($src) && empty($id)){
				$type = "img";
			}

			$output = '';

			$output .= '<li>';
				switch ($type) {
					case 'youtube':

						if (isset($id) && !empty($id)) {
							$output .='<div class="video-embed">';
						    	$output .='<div class="flex-mod">';
						    		$output .= '<iframe src="http://www.youtube-nocookie.com/embed/'.$id.'" class="iframevideo" title="'.$description.'"></iframe>';
						    	$output .='</div>';
						    $output .='</div>';
						}
						
						break;
					case 'vimeo':

						if (isset($id) && !empty($id)) {
							$output .='<div class="video-embed">';
						    	$output .='<div class="flex-mod">';
						    		$output .= '<iframe src="http://player.vimeo.com/video/'.$id.'" class="iframevideo" title="'.$description.'"></iframe>';
						    	$output .='</div>';
						    $output .='</div>';
						}

						break;
					case 'img':
						if (isset($src) && !empty($src)) {
							$image_attributes = wp_get_attachment_image_src($src, 'full');
							$src = $image_attributes[0];
							$output .='<img src="'.$src.'" alt="'.$description.'">';
						}
						break;
				}
			$output .= '</li>';
			return $output;
		}
		add_shortcode('nz_media_slide', 'nz_media_slide');

/*  TIMER
/*====================================================================*/
	
	function nz_timer($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'enddate'      => '',
				'color'        => '',
				'border_color' => '',
				'days'         => '',
				'hours'        => '',
				'minutes'      => '',
				'seconds'      => ''
			), $atts)
		);

		static $id_counter = 1;

		if (isset($enddate) && !empty($enddate)) {
			$enddate = 'data-enddate="'.$enddate.'"';
		}

		if (isset($days) && !empty($days)) {
			$days = 'data-days="'.$days.'"';
		}

		if (isset($hours) && !empty($hours)) {
			$hours = 'data-hours="'.$hours.'"';
		}

		if (isset($minutes) && !empty($minutes)) {
			$minutes = 'data-minutes="'.$minutes.'"';
		}

		if (isset($seconds) && !empty($seconds)) {
			$seconds = 'data-seconds="'.$seconds.'"';
		}

		if (isset($color) && !empty($color)) {
			$color = 'style="color:'.$color.';"';
		}

		if (isset($border_color) && !empty($border_color)) {
			$border_color = '<style scoped>#nz-timer-'.$id_counter.' .timer-item:before {box-shadow:inset 0 0 0 2px '.$border_color.';}</style>';
		}

		$output ='<div id="nz-timer-'.$id_counter.'" class="nz-timer-wrap">'.$border_color.'<div class="nz-timer nz-clearfix" '.$enddate.' '.$days.' '.$hours.' '.$minutes.' '.$seconds.' '.$color.'></div></div>';

		$id_counter++;

		return $output;
	}

	add_shortcode('nz_timer', 'nz_timer');

/*  ALERT MESSAGE
/*====================================================================*/
	
	function nz_alert($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type' => 'note'
			), $atts)
		);

		$output = '';

		$output .= '<div class="alert '.$type.'">';
			$output .= '<div class="alert-message">'.$content.'</div>';
			$output .= '<span class="close-alert">X</span>';
		$output .= '</div>';

		return $output;
	}

	add_shortcode('nz_alert', 'nz_alert');

/*  GOOGLE MAP
/*====================================================================*/
	
	function nz_gmap($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'zoom'    => '18',
				'x_coords'=> '53.339381',
				'y_coords'=> '-6.260405',
				'type'    => 'roadmap',
				'width'   => '100%',
				'height'  => '480px',
				'marker'  => ''
			), $atts)
		);

		global $nz_ninzio;
		static $id = 1;
		$output ='';

		if(empty($width)) {$width = "100%";}
		if(empty($height)) {$height = "480px";}
		if(empty($zoom) || !is_numeric($zoom) || $zoom < 0){$zoom = "18";}

		if (!isset($marker) || empty($marker)) {
			$marker = IMAGES.'/google_map_marker.png';
		} else {
			$marker_ats = wp_get_attachment_image_src($marker, 'full');
			$marker     =  $marker_ats[0];
		}

		$output .= '<div class="map" id="gmap-'.$id.'"  data-x="'.$x_coords.'" data-y="'.$y_coords.'" data-type="'.$type.'" data-zoom="'.$zoom.'" data-marker="'.$marker.'" style="width:'.$width.';height:'.$height.';"></div>';

		$id++;

		return $output;

	}
	add_shortcode('nz_gmap', 'nz_gmap');

/*  ICON-PROGRESS-BAR
/*====================================================================*/
	
	function nz_icon_progress($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'icon'           => 'icon-star3',
				'inactive_color' => '',
				'active_color'   => '',
				'active'         => '',
				'number'         => '',
				'align'          => ''
			), $atts)
		);

		global $nz_color;

		$output     = '';
		$data_color = '';
		$styles     = '';

		static $id_counter = 1;

		if(!is_numeric($number) || $number < 0){$number = "";}
		if(!is_numeric($active) || $active < 0){$active = "";}
		if($active > $number){$active = $number;}

		if(isset($inactive_color) && !empty($inactive_color)) {
			$styles .= 'color:'.$inactive_color.';';
		}

		if(isset($active_color) && !empty($active_color)) {
			$data_color = $active_color;
		} else {
			$data_color = $nz_color;
		}

		if((isset($icon) && !empty($icon)) && (isset($active) && !empty($active))) {
			$output .= '<div id="nz-icon-progress-'.$id_counter.'" class="nz-icon-progress '.$align.'" data-color="'.$data_color.'" data-active="'.$active.'">';
			if(isset($inactive_color) && !empty($inactive_color)) {$output .= '<style scoped>#nz-icon-progress-'.$id_counter.' span {color:'.$inactive_color.';}</style>';}
			if(isset($number) && !empty($number)){
				for ($i=0; $i < $number; $i++) { 
					$output .= '<span class="icon '.$icon.'"></span>';
				}
			}
			$output .= '</div>';
		}

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_icon_progress', 'nz_icon_progress');

/*  PROGRESS-BAR
/*====================================================================*/
	
	function nz_line($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'percentage'  => '',
				'bar_color'   => '',
				'track_color' => '',
				'title'       => ''
			), $atts)
		);

		$output = '';

		if(!is_numeric($percentage) || $percentage < 0){$percentage = "";} 
		elseif ($percentage > 100) {$percentage = "100";}

		if(isset($track_color) && !empty($track_color)) {$track_color = 'background-color:'.$track_color.';';}
		if(isset($bar_color) && !empty($bar_color)) {$bar_color = 'background-color:'.$bar_color.';';}

		if(isset($title)){
			$output .= '<div class="bar" style="'.$track_color.'"><div style="'.$bar_color.'" class="nz-line" data-title="'.$title.'" data-percentage="'.$percentage.'"></div></div>';
		}
		return $output;
	}

	add_shortcode('nz_line', 'nz_line');

	function nz_progress($atts, $content = null) {
		static $id_counter = 1;
		$output = '<div id="nz-progress-'.$id_counter.'" class="nz-progress nz-clearfix">'.do_shortcode($content).'</div>';
		$id_counter++;
		return $output;
	}
	add_shortcode('nz_progress', 'nz_progress');

/*  PROGRESS-CIRCLE
/*====================================================================*/
	
	function nz_circle($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'percentage'  => '',
				'bar_color'   => '',
				'track_color' => '',
				'color'       => '',
				'title'       => ''
			), $atts)
		);

		global $nz_color;

		$output = '';
		$color_styles = '';
		$data_attr = '';

		if(!is_numeric($percentage) || $percentage < 0){$percentage = "";} 
		elseif ($percentage > 100) {$percentage = "100";}


		if(isset($bar_color) && !empty($bar_color)) {
			$data_attr .= 'data-bar="'.$bar_color.'"';
		} else {
			$data_attr .= ' data-bar="'.$nz_color.'"';
		}

		if(isset($track_color) && !empty($track_color)) {
			$data_attr .= ' data-track="'.$track_color.'"';
		}

		if(isset($color) && !empty($color)) {
			$color_styles .= 'style="color:'.$color.';"';
		}

		$output .= '<div class="nz-circle"><div class="circle" '.$data_attr.' data-percent="'.$percentage.'"><span class="title" '.$color_styles.'>'.$title.'</span></div></div>';
		return $output;
	}

	add_shortcode('nz_circle', 'nz_circle');


	function nz_circle_progress($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'align'    => 'center'
			), $atts)
		);

		$output = "";
		static $id_counter = 1;
		$output = '<div id="nz-circle-progress-'.$id_counter.'" class="nz-circle-progress nz-clearfix '.$align.'">'.do_shortcode($content).'</div>';
		$id_counter++;
		return $output;
	}

	add_shortcode('nz_circle_progress', 'nz_circle_progress');

/*  COUNTER
/*====================================================================*/
	
	function nz_count($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'value'      => '',
				'title'      => '',
				'color'      => '',
				'icon'       => '',
				'icon_color' => ''
			), $atts)
		);

		global $nz_color;

		$output = '';
		$styles = '';
		$icon_styles = '';

		if(!is_numeric($value) || $value < 0){$value = "";}
		if(isset($color) && !empty($color)) {$styles .= 'color:'.$color.';';}

		if(isset($icon_color) && !empty($icon_color)) {
			$icon_color = 'style="color:'.$icon_color.';box-shadow:inset 0 0 0 2px '.$icon_color.';"';
		} else {
			$icon_color = 'style="color:'.$nz_color.';box-shadow:inset 0 0 0 2px '.$nz_color.';"';
		}

		if (isset($value) && !empty($value)) {
			$value = 'data-value="'.$value.'"';
		}

        $output .= '<div class="nz-count" style="'.$styles.'">';
        	if(isset($icon) && !empty($icon)) {
				$output .= '<span class="count-icon '.$icon.'" '.$icon_color.'></span>';
			}
			$output .= '<span '.$value.' class="count-value">0</span>';
			if(isset($title) && !empty($title)) {
				$output .= '<span class="count-title">'.$title.'</span>';
			}
        $output .= '</div>';
		return $output;
	}

	add_shortcode('nz_count', 'nz_count');

	function nz_counter($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns' => '3'
			), $atts)
		);

		static $id_counter = 1;
		$output = '<div id="nz-counter-'.$id_counter.'" class="nz-counter nz-clearfix" data-columns="'.$columns.'">'.do_shortcode($content).'</div>';
		$id_counter++;

		return $output;
	}

	add_shortcode('nz_counter', 'nz_counter');

/*  CONTENT BOXES
/*====================================================================*/
	
	function nz_content_box($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns' => '3',
				'version' => 'v1',
				'animate' => 'none'
			), $atts)
		);

		static $id_counter = 1;
		$output = '<div class="nz-content-box nz-clearfix '.$version.' '.$animate.'" data-columns="'.$columns.'">'.do_shortcode($content).'</div>';
		$id_counter++;
		return $output;
	}

	add_shortcode('nz_content_box', 'nz_content_box');

	function nz_box($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'icon'       	          => '',
				'icon_color' 	          => '',
				'icon_back_color' 	      => '',
				'icon_border_color'       => '',
				'icon_hover_effect_color' => '',
				'icon_hover_color'        => '',
				'link'                    => ''
			), $atts)
		);

		$output     = '';
		$extra_class = "";
		static $id_counter = 1;

		if(isset($icon_back_color) && !empty($icon_back_color)){
			$extra_class .= "back-active ";
		}
		if(isset($icon_border_color) && !empty($icon_border_color)){
			$extra_class .= "border-active ";
		}

		$link_before = "";
		$link_after  = "";

		if (isset($link) && !empty($link)) {
			$link_before = '<a href="'.esc_url($link).'">';
			$link_after  = '</a>';
		}

		$output .= '<div id="nz-box-'.$id_counter.'" class="'.$extra_class.' nz-box">';
			$output .= $link_before;
				$output .= '<style>';
					if(isset($icon_color) && !empty($icon_color)){
						$output .= '#nz-box-'.$id_counter.' .box-icon {color:'.$icon_color.';}';
					}
					if (isset($icon_hover_color) && !empty($icon_hover_color)) {
						$output .= '#nz-box-'.$id_counter.':hover .box-icon {color:'.$icon_hover_color.' !important;}';
					}
					if(isset($icon_back_color) && !empty($icon_back_color)){
						$output .= '#nz-box-'.$id_counter.' .box-icon-wrap:before {background-color:'.$icon_back_color.';}';
						$output .= '#nz-box-'.$id_counter.'.back-active:not(.border-active) .box-icon-wrap:after {box-shadow:inset 0 0 0 2px '.$icon_back_color.';}';
					}
					if(isset($icon_border_color) && !empty($icon_border_color)){
						$output .= '#nz-box-'.$id_counter.' .box-icon-wrap:after {box-shadow:inset 0 0 0 2px'.$icon_border_color.';}';
						$output .= '#nz-box-'.$id_counter.'.border-active:not(.back-active) .box-icon-wrap:before {background-color:'.$icon_border_color.';}';
					}
					if (isset($icon_hover_effect_color) && !empty($icon_hover_effect_color)) {
						$output .= '#nz-box-'.$id_counter.':hover .box-icon-wrap:before {background-color:'.$icon_hover_effect_color.' !important;}';
						$output .= '#nz-box-'.$id_counter.':hover .box-icon-wrap:after {box-shadow:inset 0 0 0 2px '.$icon_hover_effect_color.' !important;}';
					}
				$output .= '</style>';
				if(isset($icon) && !empty($icon)){
					$output .= '<div class="box-icon-wrap"><div class="box-icon '.$icon.'"></div></div>';
				}
				$output .= '<div class="box-data">';
					$output .= do_shortcode($content);
				$output .= '</div>';
			$output .= $link_after;
		$output .= '</div>';

		$id_counter++;

		return $output;
	}

	add_shortcode('nz_box', 'nz_box');

/*  TESTIMONIALS
/*====================================================================*/
	
	function nz_testimonials($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'color'=>''
			), $atts)
		);

		static $id_counter = 1;

		$output = "";

		if (isset($color) && !empty($color)) {
			$color = 'style="color:'.$color.';"';
		}

		$output .= '<div id="nz-testimonials-'.$id_counter.'" class="lazy flexslider nz-testimonials" '.$color.'>';
			$output .= '<ul class="slides">';
				$output .= do_shortcode($content);
			$output .= '</ul>';
		$output .= '</div>';

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_testimonials', 'nz_testimonials');

	function nz_testimonial($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'img'      => '',
				'name'     => '',
				'title'  => ''
			), $atts)
		);

		$output = '';

		if (isset($img) && !empty($img)) {
			$img_ats = wp_get_attachment_image_src($img, 'full');
			$img     =  $img_ats[0];
		}

		$output .= '<li class="testimonial" data-img="'.$img.'">';

			$output .= '<div class="text">'.$content.'</div>';

			if (isset($name) && !empty($name)) {
				$output .= '<span class="name">'.$name.'</span>';
			}
				
			if (isset($title) && !empty($title)) {
				$output .= '<span class="title">'.$title.'</span>';
			}
							
		$output .= '</li>';

		return $output;
	}
	add_shortcode('nz_testimonial', 'nz_testimonial');

/*  CLIENTS
/*====================================================================*/
	
	function nz_cl($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns'  => '6',
				'autoplay' => 'false',
				'animate'  => 'none'
			), $atts)
		);

		$output = "";

		static $id_counter = 1;

		$output .= '<div id="nz-clients-'.$id_counter.'" class="lazy nz-clients '.$animate.'" data-columns="'.$columns.'" data-autoplay="'.$autoplay.'">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		return $output;
		$id_counter++;
	}
	add_shortcode('nz_cl', 'nz_cl');

	function nz_c($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'img'   => '',
				'name' 	=> '',
				'link' 	=> ''
			), $atts)
		);

		$output = '';

		$before_link = "";
		$after_link  = "";

		if (isset($link) && !empty($link)) {
			$before_link = '<a href="'.$link.'" target="_blank">';
			$after_link  = '</a>';
		}

		if (isset($img) && !empty($img)) {

			$img_ats = wp_get_attachment_image_src($img, 'full');
			$img     =  $img_ats[0];

			if (isset($name) && !empty($name)) {
				$name = 'alt="'.$name.'"';
			}

			$output .= '<div class="client"><div class="client-inner">'.$before_link.'<img src="'.$img.'" '.$name.' >'.$after_link.'</div></div>';

		}
		return $output;
	}
	add_shortcode('nz_c', 'nz_c');

/*  PERSONS
/*====================================================================*/

	function nz_persons($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns'  => '3',
				'animate'  => 'none'
			), $atts)
		);

		$output = "";

		static $id_counter = 1;

		$output .= '<div id="nz-persons-'.$id_counter.'" class="nz-persons nz-clearfix '.$animate.'" data-columns="'.$columns.'">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_persons', 'nz_persons');


	function nz_person($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'img'          => '',
				'link'         => '',
				'name'         => '',
				'title'        => '',
				'twitter'      => '',
				'facebook'     => '',
				'linkedin'     => '',
				'googleplus'   => '',
				'envelope'     => ''
			), $atts)
		);

		$output  = '';
		$classes = '';
		$link_before = "";
		$link_after  = "";

		if (empty($twitter) && empty($facebook) && empty($linkedin) && empty($googleplus) && empty($envelope)) {
			$classes = "no-social";
		}

		if (isset($img) && !empty($img)) {

			$img_ats = wp_get_attachment_image_src($img, 'full');
			$img     =  $img_ats[0];

			if (isset($link) && !empty($link)) {
				$link_before = '<a href="'.$link.'" >';
				$link_after = '</a>';
			}

			$output .= '<div class="person '.$classes.'">';

				$output .= '<div class="person-inner">';

						$output .= '<div class="person-body">';
							$output .= $link_before;
							$output .='<div class="img"><img src="'.$img.'" alt="'.$name.'" /></div>';
							$output .= $link_after;
							$output .='<div class="person-meta">';

								if(isset($name) && !empty($name)){
									$output .= '<div class="name">'.$name.'</div>';
								}
								if(isset($title) && !empty($title)){
									$output .= '<div class="title">'.$title.'</div>';
								}
								
							$output .= '</div>';

						$output .= '</div>';

						$output .= '<div class="social-links">';

							foreach($atts as $social => $href) {

								if($href && $social != 'img' && $social != 'name' && $social != 'title' && $social != 'link') {
									$output .='<a class="icon-'.$social.'" href="'.$href.'" title="'.$social.'"></a>';
								}

							}

						$output .= '</div>';

				$output .= '</div>';

			$output .= '</div>';

		}

		return $output;
	}
	add_shortcode('nz_person', 'nz_person');

/*  SLIDER
/*====================================================================*/
	
	function nz_media($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'effect'  => 'fade'
			), $atts)
		);

		$output = '<div class="lazy nz-media-slider flexslider" data-effect="'.$effect.'">';
			$output .= '<ul class="slides">';
				$output .= do_shortcode($content);
			$output .= '</ul>';
		$output .= '</div>';

		return $output;
	}
	add_shortcode('nz_media', 'nz_media');

	function nz_slide($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'type'        => '',
				'id'          => '',
				'src'         => '',
				'description' => ''
			), $atts)
		);

		$output = '';

		$output .= '<li>';
			switch ($type) {
				case 'youtube':

					if (isset($id) && !empty($id)) {
						$output .='<div class="video-embed">';
					    	$output .='<div class="flex-mod">';
					    		$output .= '<iframe src="http://www.youtube-nocookie.com/embed/'.$id.'" class="iframevideo" title="'.$description.'"></iframe>';
					    	$output .='</div>';
					    $output .='</div>';
					}
					break;
				case 'vimeo':

					if (isset($id) && !empty($id)) {
						$output .='<div class="video-embed">';
					    	$output .='<div class="flex-mod">';
					    		$output .= '<iframe src="http://player.vimeo.com/video/'.$id.'" class="iframevideo" title="'.$description.'"></iframe>';
					    	$output .='</div>';
					    $output .='</div>';
					} 
					break;
				case 'img':
					if (isset($src) && !empty($src)) {
						$image_attributes = wp_get_attachment_image_src($src, 'full');
						$src = $image_attributes[0];
						$output .='<img src="'.$src.'" alt="'.$description.'">';
					}
					break;
			}
		$output .= '</li>';
		return $output;
	}
	add_shortcode('nz_slide', 'nz_slide');

/*  PRICING TABLE
/*====================================================================*/
	
	function nz_pricing_table($atts, $content = null, $tag) {

		extract(shortcode_atts(
			array(
				'columns' => '3',
				'animate' => 'none'
			), $atts)
		);

		$output = '';

		static $id_counter = 1;

		$output .= '<div id="nz-pricing-table-'.$id_counter.'" class="nz-pricing-table nz-clearfix '.$animate.'" data-columns="'.$columns.'">';
			$output .= do_shortcode($content);
		$output .= '</div>';

		$id_counter++;

		return $output;
	}

	add_shortcode('nz_pricing_table', 'nz_pricing_table');

	function nz_column($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'high'        => '',
				'color'   	  => '',
				'price'       => '',
				'plan'        => '',
				'title'       => '',
				'button_text' => '',
				'link'        => '',
				'shape'       => '',
				'type'        => ''
			), $atts)
		);

		$output = '';
		$styles = "";
		$button_styles = "";
		$button_data = "";

		if (isset($color) && !empty($color)) {
			if ($high == "false") {
				$styles.= 'color:'.$color.';border-bottom-color:'.$color.';';
			} else {
				$styles.= 'border-color:'.$color.';background-color:'.$color.';';
			}

			switch ($type) {
				case 'normal':
					$button_styles .= 'background-color: '.$color.';';
					$button_data = 'data-colorhover="'.ninzio_hex_to_rgb_shade($color,20).'" data-color="'.$color.'"';
					break;
				case 'ghost':
					$button_styles .= 'box-shadow:inset 0 0 0 2px '.$color.';color:'.$color.';';
					$button_data = 'data-color="'.$color.'"';
					break;
				case '3d':
					$button_styles .= 'background-color:'.$color.';box-shadow: 0 4px '.ninzio_hex_to_rgb_shade($color,20).';';
					$button_data = 'data-color="'.ninzio_hex_to_rgb_shade($color,20).'"';
					break;
			}

		}

		$output .='<div class="column highlight-'.$high.'">';

			if (isset($title) && !empty($title)) {
				$output .='<div class="title" style="'.$styles.'">'.$title.'</div>';
			}

			$output .='<div class="pricing">';
				if (isset($price) && !empty($price)) {
					$output .='<span class="price">'.$price.'</span>';
				}
				if (isset($plan) && !empty($plan)) {
					$output .='<span class="plan">'.$plan.'</span>';
				}
			$output .='</div>';

			if (isset($content) && !empty($content)) {
				$output .='<div class="c-body">';
					$split = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $content);
					foreach($split as $haystack) {
		                $output .= '<div class="c-row">' . $haystack . '</div>';
		            }
	            $output .='</div>';
			}

			if (isset($link) && !empty($link)) {

				$output .='<div class="c-foot">';
					$output .='<a href="'.$link.'" style="'.$button_styles.'" '.$button_data.' class="pricing-table-button animate-false small button '.$shape.' button-'.$type.'">'.$button_text.'</a>';
				$output .='</div>';
			}

		$output .='</div>';

		return $output;
	}

	add_shortcode('nz_column', 'nz_column');

/*  CAROUSEL
/*====================================================================*/
	
	function nz_carousel($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns'  => '3',
				'autoplay' => 'false',
				'animate' => 'none'
			), $atts)
		);

		static $id_counter = 1;

		$output = "";
		$output .= '<div id="nz-carousel-'.$id_counter.'" class="lazy nz-carousel '.$animate.'" data-autoplay="'.$autoplay.'" data-columns="'.$columns.'">'.do_shortcode($content).'</div>';

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_carousel', 'nz_carousel');

	function nz_item($atts, $content = null) {
		return '<div class="item nz-clearfix">'.do_shortcode($content).'</div>';
	}
	add_shortcode('nz_item', 'nz_item');

/*  SLICK CAROUSEL
/*====================================================================*/
	
	function nz_slick_carousel($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'autoplay'       => 'false',
				'autoplay_speed' => '3000'
			), $atts)
		);

		static $id_counter = 1;

		$output = "";
		$output .= '<div id="nz-slick-carousel-'.$id_counter.'" class="lazy nz-clearfix nz-slick-carousel" data-autoplayspeed="'.$autoplay_speed.'" data-autoplay="'.$autoplay.'">'.do_shortcode($content).'</div>';

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_slick_carousel', 'nz_slick_carousel');

	function nz_slick_item($atts, $content = null) {
		return '<div class="nz-slick-item nz-clearfix">'.do_shortcode($content).'</div>';
	}
	add_shortcode('nz_slick_item', 'nz_slick_item');

/*  SECTION SLIDER
/*====================================================================*/
	
	function nz_ss($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'bullets'  => 'true',
				'nav'      => 'true',
				'autoplay'  => 'false',
				'nav_color' => ''
			), $atts)
		);

		static $id_counter = 1;

		$output = "";

		if (isset($nav_color) && !empty($nav_color)) {
			$nav_color = '<style scoped>#nz-ss-'.$id_counter.' .owl-prev,#nz-ss-'.$id_counter.' .owl-next {color:'.$nav_color.';} #nz-ss-'.$id_counter.' .owl-controls .owl-page {background-color:'.$nav_color.';} #nz-ss-'.$id_counter.' .owl-controls .owl-page.active {border-color:'.$nav_color.';}</style>';
		}

		$output .='<div id="nz-ss-'.$id_counter.'" class="lazy nz-ss" data-autoplay="'.$autoplay.'" data-bullets="'.$bullets.'" data-nav="'.$nav.'">'. $nav_color.do_shortcode($content).'</div>';

		$id_counter++;

		return $output;
	}
	add_shortcode('nz_ss', 'nz_ss');

	function nz_sec($atts, $content = null) {
		extract(shortcode_atts(
			array(
				'background_color'      => '',
				'background_image'      => '',
				'background_repeat'     => 'no-repeat',
				'background_position'   => 'left top',
				'background_attachment' => 'scroll',
				'padding_top'           => '20',
				'padding_bottom'        => '20',
			), $atts)
		);

		$output = '';
		$styles = '';

		if(isset($background_color) && !empty($background_color)) {
			$styles .= 'background-color:'.$background_color.';';
		}

		if(isset($background_image) && !empty($background_image)) {

			if(empty($background_repeat)) {$background_repeat = "no-repeat";}
			if(empty($background_position)){$background_position = "50% 50%";}
			if(empty($background_attachment)) {$background_attachment = "scroll";}

			if ($parallax == "true") {
				$background_repeat = "no-repeat";
				$background_position = "center top";
				$background_attachment = "fixed";
			}

			if ($background_repeat == "no-repeat") {
				$styles .= "-webkit-background-size: cover; -moz-background-size: cover; background-size: cover;";
			}

			$image_attributes = wp_get_attachment_image_src($background_image, 'full');
			$background_image = $image_attributes[0];

			$data_img_width = $image_attributes[1];
			$data_img_height = $image_attributes[2];

			$styles .= 'background-image:url('.$background_image.');background-repeat:'.$background_repeat.';background-position:'.$background_position.';background-attachment:'.$background_attachment.';';
		}

		if(isset($padding_top) && !empty($padding_top)) {
			$styles .= 'padding-top:'.$padding_top.'px;';
		}
		if(isset($padding_bottom) && !empty($padding_bottom)) {
			$styles .= 'padding-bottom:'.$padding_bottom.'px;';
		}

		$output .= '<div '.$id.' class="ss-item" style="'.$styles.'">';
			$output .= '<div class="container">'.do_shortcode($content).'</div>';
		$output .= '</div>';

		return $output;


	}
	add_shortcode('nz_sec', 'nz_sec');

/*  RECENT POSTS
/*====================================================================*/

	function nz_rposts($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'posts_number'     => '3',
				'cat'              => '',
				'excerpt'          => 'false',
				'autoplay'         => 'false',
				'animate'          => 'false',
				'bullets'          => 'false',
				'version'          => 'carousel',
				'columns'          => '3',
				'columns_carousel' => '3',
				'caption_color'    => ''
			), $atts)
		);

		global $post;
		$output = "";

		$nz_ninzio_grid   = "grid_4";
		$size          = 'Ninzio-Uni';

		if ($version == "masonry") {
			$size = 'Full';
		}

		if ($version == "carousel") {
			$columns = $columns_carousel;
		}

		switch ($columns) {
			case '2':
				$nz_ninzio_grid   = "grid_2";
				break;
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

		if(!is_numeric($posts_number) || !isset($posts_number) || empty($posts_number) || $posts_number < 0) {
			$posts_number = 3;
		}

		static $id_counter = 1;

		$recent_posts = new WP_Query(array( 'orderby' => 'date', 'posts_per_page' => $posts_number, 'cat' => $cat,'post_status' => 'publish','ignore_sticky_posts' => true));

			if($recent_posts->have_posts()){

				$output .= '<div id="nz-recent-posts-'.$id_counter.'" data-animate="'.$animate.'" data-bullets="'.$bullets.'" data-autoplay="'.$autoplay.'" data-columns="'.$columns.'" class="lazy nz-recent-posts '.$version.' '.$nz_ninzio_grid.' nz-clearfix">';

					if (isset($caption_color) && !empty($caption_color)) {
						$output .='<style scoped>';
							$output .= '#nz-recent-posts-'.$id_counter.' .post-date, #nz-recent-posts-'.$id_counter.' .ninzio-overlay:before {background-color: '.$caption_color.';}';
						$output .= '</style>';
					}

					$output .= '<div class="posts-inner">';
						
					while($recent_posts->have_posts()) : $recent_posts->the_post();

						$output .= '<div class="post format-'.get_post_format().'" data-grid="ninzio_01">';

							$output .= '<div class="post-wrap nz-clearfix">';

								if (get_post_format() == 'image') {
									$values = get_post_custom( $post->ID );
									$nz_image_url = isset($values["image_url"][0]) ? $values["image_url"][0] : "";

									if (!empty($nz_image_url)) {
										$output .='<a class="nz-more" href="'.get_permalink().'">';
											$output .= '<div class="nz-thumbnail">';
												$output .= '<img src="'.$nz_image_url.'" alt="'.get_the_title().'">';
												$output .= '<div class="ninzio-overlay"></div>';
												$output .= '<div class="post-date"><span>'.get_the_date("d").'</span><span>'.get_the_date("M").'</span></div>';
											$output .='</div>';
										$output .='</a>';
									}

								} else {
									if (has_post_thumbnail()) {
										$output .='<a class="nz-more" href="'.get_permalink().'">';
											$output .= '<div class="nz-thumbnail">';
												$output .= get_the_post_thumbnail( $post->ID, $size );
												$output .= '<div class="ninzio-overlay"></div>';
												$output .= '<div class="post-date"><span>'.get_the_date("d").'</span><span>'.get_the_date("M").'</span></div>';
											$output .='</div>';
										$output .='</a>';
									}
								}

								

								$output .= '<div class="post-body">';

										if ( '' != get_the_title() ){
											$output .= '<h5 class="post-title">'.get_the_title().'</h5>';
										}

										if ($excerpt == "true") {
											$output .= '<div class="post-excerpt">'.nz_excerpt(95).'</div>';
										}

										$output .='<a href="'.get_permalink().'" title="'.__("Read more about", TEMPNAME).' '.get_the_title().'" rel="bookmark">'.__("Read more", TEMPNAME).' <span class="icon-arrow-right9"></span></a>';

								$output .= '</div>';

							$output .= '</div>';

						$output .= '</div>';

					endwhile;
					wp_reset_postdata();
					$output .= '</div>';

				$output .= '</div>';

				$id_counter++;

				return $output;

			} else {
				return ninzio_not_found('post');
			}
	}

	add_shortcode('nz_rposts', 'nz_rposts');

/*  RECENT PORTFOLIO
/*====================================================================*/

	function nz_rportfolio($atts, $content = null) {

		extract(shortcode_atts(
			array(
				'columns'          => '3',
				'columns_carousel' => '3',
				'posts_number'   => '3',
				'version'        => 'carousel',
				'cat'            => '',
				'autoplay'       => 'false',
				'animate'        => 'false',
				'filter'         => 'false',
				'color'          => '',
				'btnsize'        => '',
				'shape'          => '',
				'caption_color'  => '',
				'nogap'          => 'false'
			), $atts)
		);

		global $post;
		$output = "";
		$nz_ninzio_grid   = "grid_4";
		$size          = 'Ninzio-Uni';

		if ($version == "masonry") {
			$size = 'Full';
		}

		if ($version == "carousel") {
			$columns = $columns_carousel;
		}


		switch ($columns) {
			case '2':
				$nz_ninzio_grid   = "grid_2";
				break;
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

		static $id_counter = 1;

		if(!is_numeric($posts_number) || !isset($posts_number) || empty($posts_number) || $posts_number < 0) {
			$posts_number = 3;
		}

		if (isset($cat) && !empty($cat)) {
			$recent_query_opt = array( 
				'orderby'            => 'date', 
				'post_type'          => 'portfolio', 
				'posts_per_page'     => $posts_number,
				'tax_query'          => array(
					array(
						'taxonomy' => 'portfolio-category',
						'field'    => 'id',
						'terms'    => explode(',',$cat),
						'operator' => 'IN'
					)
				)
			);
		} else {
			$recent_query_opt = array( 
				'orderby'            => 'date', 
				'post_type'          => 'portfolio', 
				'posts_per_page'     => $posts_number
			);
		}

		$recent_portfolio = new WP_Query($recent_query_opt);

			if($recent_portfolio->have_posts()){

					$output .= '<div id="nz-recent-portfolio-'.$id_counter.'" data-animate="'.$animate.'" data-autoplay="'.$autoplay.'" data-columns="'.$columns.'" class="lazy nz-recent-portfolio nogap-'.$nogap.' '.$version.' filter-'.$filter.' nz-clearfix '.$nz_ninzio_grid.'">';

						$output .='<style scoped>';
							if (isset($caption_color) && !empty($caption_color)) {
								$output .= '#nz-recent-portfolio-'.$id_counter.' .project-details, #nz-recent-portfolio-'.$id_counter.' .ninzio-overlay:before {background-color: '.$caption_color.';}';
							}
							if (isset($color) && !empty($color)) {
								$output .= '#nz-recent-portfolio-'.$id_counter.' .button{color:'.$color.';box-shadow:inset 0 0 0 2px '.$color.'}';
								$output .= '#nz-recent-portfolio-'.$id_counter.' .button:hover,#nz-recent-portfolio-'.$id_counter.' .button.active{background-color:'.$color.';}';
							}
						$output .= '</style>';

						if ($filter == "true" && $version != "carousel") {
							
							$args = array(
							    'orderby'           => 'name', 
							    'order'             => 'ASC',
							    'hide_empty'        => true, 
							    'exclude'           => array(), 
							    'exclude_tree'      => array(), 
							    'include'           => array(),
							    'number'            => '', 
							    'fields'            => 'all', 
							    'slug'              => '', 
							    'parent'            => '',
							    'hierarchical'      => false, 
							    'child_of'          => 0, 
							    'get'               => '', 
							    'name__like'        => '',
							    'description__like' => '',
							    'pad_counts'        => false, 
							    'offset'            => '', 
							    'search'            => '', 
							    'cache_domain'      => 'core'
							);

							$output .= '<div class="nz-portfolio-filter">';
								$output .= '<span class="button animate-false active hover-fill button-ghost '.$btnsize.' '.$shape.' filter" data-group="all">'.__('Show All',TEMPNAME).'</span>';
								foreach(get_terms('portfolio-category',$args) as $filter_term) {
									$output .= '<span class="button animate-false hover-fill button-ghost '.$btnsize.' '.$shape.' filter" data-group="'.$filter_term->slug.'">'.$filter_term->name.'</span>';
								}
							$output .= '</div>';

						}

						$output .= '<div class="nz-portfolio-posts">';
							while($recent_portfolio->have_posts()) : $recent_portfolio->the_post();

								$classes= array('"all"');
								if (get_the_terms( $post->ID, 'portfolio-category', '', ' ', '' )) {
									foreach(get_the_terms( $post->ID, 'portfolio-category', '', '', '' ) as $term) {
										array_push($classes, '"'.$term->slug.'"');
									}
								}
								
								$output .= '<div class="mix post nz-clearfix" data-groups=\'['.implode(', ',$classes).']\' data-grid="ninzio_01">';

									$output .= '<div class="post-body">';

										$output .= '<div class="nz-thumbnail">';
											
											if (has_post_thumbnail()) {
												$output .= get_the_post_thumbnail( $post->ID, $size );
											}
											
											$output .='<a href="'.get_permalink().'">';
												$output .= '<div class="ninzio-overlay"></div>';
											$output .= '</a>';

										$output .='</div>';

										$output .= '<div class="project-details">';

											if ( '' != get_the_title() ){
												$output .='<a href="'.get_permalink().'">';
													$output .= '<h4 class="project-title">'.get_the_title().'</h4>';
												$output .= '</a>';
											}

										$output .='</div>';

									$output .='</div>';

								$output .='</div>';
							endwhile;

							wp_reset_postdata();

						$output .= '</div>';

					$output .= '</div>';

				$id_counter++;

				return $output;

			} else {
				return ninzio_not_found('portfolio');
			}
	}

	add_shortcode('nz_rportfolio', 'nz_rportfolio');

/*  TINYMCE ADD SHORTCODES TO CLASSIC VIEW
/*====================================================================*/

	add_action('admin_head', 'ninzio_add_tinymce_button');

	function ninzio_register_tinymce_plugins($buttons) {  
		array_push(
			$buttons,
			'nz_table',
			'nz_dropcap',
			'nz_il',
			'nz_sep',
			'nz_highlight',
			'nz_btn',
			'nz_icons',
			'nz_gap',
			'nz_youtube',
			'nz_vimeo'
		);  
		return $buttons;  
	}

	function ninzio_add_tinymce_plugins($plugin_array) {
	   $plugin_array['nz_table']     = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_dropcap']   = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_highlight'] = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_il']        = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_btn']       = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_sep']       = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_icons']     = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_gap']       = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_fw']        = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_youtube']   = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_vimeo']     = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_you']       = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_vim']       = get_template_directory_uri().'/tinymce/plugins.js';
	   $plugin_array['nz_colorbox']  = get_template_directory_uri().'/tinymce/plugins.js';
	   return $plugin_array;
	}

	function ninzio_add_tinymce_button() { 
		if(!current_user_can('edit_posts') && !current_user_can('edit_pages') ) {return;}
		if (get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", "ninzio_add_tinymce_plugins");
			add_filter('mce_buttons', 'ninzio_register_tinymce_plugins');
		}
	}

?>