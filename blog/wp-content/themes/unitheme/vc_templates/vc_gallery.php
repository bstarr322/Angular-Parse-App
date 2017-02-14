<?php
extract( shortcode_atts( array(
	'img_size'            => 'thumbnail',
	'images'              => '',
	'link_full'           => 'false',
	'animate'             => 'none',
	'columns'             => '3',
	'el_class'            => '',
	'columns_carousel'    => '',
	'version'             => '',
	'autoplay'            => '',
	'img_size_carousel'   => ''
), $atts ) );

$gal_images = "";

if (isset($images) && !empty($images)) {
	$images = explode( ',', $images );
	$i = - 1;

	if ($version == "carousel") {
		$columns = $columns_carousel;
		$img_size = $img_size_carousel;
	}

	foreach ( $images as $attach_id ) {
		$i ++;
		if ( $attach_id > 0 ) {
			$img = wp_get_attachment_image_src($attach_id,$img_size);
			$link = wp_get_attachment_image_src($attach_id,'full');

			$thumb_img = get_post( $attach_id );

			$before_img = '';
			$after_img  = '';

			if (!empty($thumb_img->post_excerpt)) {
				$before_img = '<figure class="wp-caption aligncenter">';
				$after_img = '<figcaption class="wp-caption-text">'.$thumb_img->post_excerpt.'</figcaption></figure>';
			}

			if ($link_full == "true") {
				$gal_images .= '<div class="gallery-item">'.$before_img.'<a data-lightbox-gallery="gallery1" href="'.$link[0].'"><div class="ninzio-overlay"></div><img alt="'.$thumb_img->post_excerpt.'" src="'.$img[0].'" width="'.$img[1].'" height="'.$img[2].'" /></a>'.$after_img.'</div>';
			} else {
				$gal_images .= '<div class="gallery-item">'.$before_img.'<img src="'.$img[0].'" width="'.$img[1].'" height="'.$img[2].'" />'.$after_img.'</div>';
			}
		}

	}

	if ($link_full == "true") {
		$el_class .= " link-full";
	}

	$output .= '<div class="nz-gallery nz-clearfix '.$version.' '.$el_class.' '.$animate.'" data-columns="'.$columns.'" data-autoplay="'.$autoplay.'">'.$gal_images.'</div>';

	echo $output;

}