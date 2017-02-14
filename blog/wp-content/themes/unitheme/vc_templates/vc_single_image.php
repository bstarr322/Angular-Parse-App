<?php


	extract( shortcode_atts( array(
		'image'          => '',
		'img_size'       => 'thumbnail',
		'img_link_large' => false,
		'img_link'       => '',
		'link'           => '',
		'alignment'      => 'none',
		'el_class'       => '',
	), $atts ) );

	$link_to = "";

	$img = wp_get_attachment_image_src($image,$img_size);

	if ($img[3] == false) {$img_size = "full";}
	$img_size = strtolower($img_size);

	if ( $img == NULL ) $img = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';

	$el_class = $this->getExtraClass( $el_class );
	
	if ( $img_link_large == true ) {
		$link_to = wp_get_attachment_image_src($image,'full');
		$link_to = $link_to[0];
	} else if ( strlen($link) > 0 ) {
		$link_to = $link;
	}

	$before_img = '';
	$after_img  = '';
	$thumb_img  = get_post($image);

	if (!empty($thumb_img->post_excerpt)) {
		$before_img = '<figure class="wp-caption aligncenter">';
		$after_img = '<figcaption class="wp-caption-text">'.$thumb_img->post_excerpt.'</figcaption></figure>';
	}

	$img_output = $before_img.'<img class="align'.$alignment.' size-'.$img_size.' wp-image-'.$image.' '.$el_class.'" src="'.$img[0].'" alt="'.$image.'" width="'.$img[1].'" height="'.$img[2].'">'.$after_img;
	$image_string = (!empty( $link_to )) ? '<a class="nz-single-image" href="' . $link_to . '"'. '>' . $img_output . '</a>' : $img_output;
	$output .= $image_string;
	echo $output;

?>