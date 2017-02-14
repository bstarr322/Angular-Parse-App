<?php 

add_action("admin_init", "ninzio_add_post_meta_box");
function ninzio_add_post_meta_box(){

    add_meta_box(
        "ninzio-post-format-options", 
        __("Post Format Options", TEMPNAME),
        "render_ninzio_post_options", 
        "post",
        "normal", 
        "high"
    );

    add_meta_box(
        "ninzio-post-title-options", 
        __("Post page title section options (Rich header)", TEMPNAME),
        "render_ninzio_post_title_options", 
        "post",
        "normal", 
        "high"
    );

}

function render_ninzio_post_options($post) {
    
    $values            = get_post_custom( $post->ID );
    $audio_mp3         = isset( $values['audio_mp3'] ) ? esc_url( $values["audio_mp3"][0] ) : "";
    $audio_ogg         = isset( $values['audio_ogg'] ) ? esc_url( $values["audio_ogg"][0] ) : "";
    $audio_embed       = isset( $values['audio_embed'] ) ? esc_attr( $values["audio_embed"][0] ) : "";
    $video_mp4         = isset( $values['video_mp4'] ) ? esc_url( $values["video_mp4"][0] ) : "";
    $video_ogv         = isset( $values['video_ogv'] ) ? esc_url( $values["video_ogv"][0] ) : "";
    $video_webm        = isset( $values['video_webm'] ) ? esc_url( $values["video_webm"][0] ) : "";
    $video_embed       = isset( $values['video_embed'] ) ? esc_attr( $values["video_embed"][0] ) : "";
    $video_poster      = isset( $values['video_poster'] ) ? esc_attr( $values["video_poster"][0] ) : "";
    $link_url          = isset( $values['link_url'] ) ? esc_url( $values["link_url"][0] ) : "";
    $image_url         = isset( $values['image_url'] ) ? esc_url( $values["image_url"][0] ) : "";
    $image_description = isset( $values['image_description'] ) ? esc_attr( $values["image_description"][0] ) : "";
    $status_author     = isset( $values['status_author'] ) ? esc_attr( $values["status_author"][0] ) : "";
    $quote_author      = isset( $values['quote_author'] ) ? esc_attr( $values["quote_author"][0] ) : "";
    $featured_media    = isset( $values['featured_media'] ) ? esc_attr( $values["featured_media"][0] ) : "true";

    wp_nonce_field( 'ninzio_post_meta_nonce', 'ninzio_post_meta_nonce' );

?>
    <div id="ninzio-post-featured-media">
        <label for="post-featured-media">
            <input type="checkbox" id="post-featured-media" name="featured_media" value="no" <?php checked( $featured_media, "false" ); ?> />
            <?php echo __(' - Disable Featured Media in this post (Featured Image / Featured Gallery)', TEMPNAME); ?>
        </label>
    </div>
    <div id="ninzio-post-format-audio" class="ninzio-post-option">
        <h4><?php echo __("Audio post format options", TEMPNAME); ?></h4>
        <div>
            <label for="audio_mp3"><?php echo __('Enter  MP3 audio file link here:', TEMPNAME); ?></label>
            <input name="audio_mp3" id="post-audio-mp3" type="text" value="<?php echo $audio_mp3;?>"/>
        </div>
        <div>
            <label for="audio_ogg"><?php echo __('Enter  OGG audio file link here:', TEMPNAME); ?></label>
            <input name="audio_ogg" id="post-audio-ogg" type="text" value="<?php echo $audio_ogg;?>"/>
        </div>
        <div>
            <label for="audio_embed"><?php echo __('Embed audio here:', TEMPNAME); ?></label>
            <textarea name="audio_embed" id="post-audio-embed"><?php echo $audio_embed;?></textarea>
        </div>
    </div>
    <div id="ninzio-post-format-video" class="ninzio-post-option">
        <h4><?php echo __("Video post format options", TEMPNAME); ?></h4>
        <div>
            <label for="video_mp4"><?php echo __('Enter  MP4 video file link here:', TEMPNAME); ?></label>
            <input name="video_mp4" id="post-video-mp3" type="text" value="<?php echo $video_mp4;?>"/>
        </div>
        <div>
            <label for="video_ogv"><?php echo __('Enter  OGV video file link here:', TEMPNAME); ?></label>
            <input name="video_ogv" id="post-video-ogv" type="text" value="<?php echo $video_ogv;?>"/>
        </div>
        <div>
            <label for="video_webm"><?php echo __('Enter  WEBM video file link here:', TEMPNAME); ?></label>
            <input name="video_webm" id="post-video-webm" type="text" value="<?php echo $video_webm;?>"/>
        </div>
        <br>
        <div>
            <div class="ninzio-upload">
                <input name="video_poster" id="post-video-poster" type="hidden" class="ninzio-upload-path" value="<?php echo $video_poster;?>"/> 
                <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload video poster image', TEMPNAME) ?>" />
                <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove video poster image', TEMPNAME) ?>" />
                <img src='<?php echo $video_poster; ?>' class='ninzio-preview-upload'/>
            </div>
        </div>

        <div>
            <label for="video_embed"><?php echo __('Embed video here:', TEMPNAME); ?></label>
            <textarea name="video_embed" id="post-video-embed"><?php echo $video_embed;?></textarea>
        </div>
    </div>
    <div id="ninzio-post-format-gallery" class="ninzio-post-option">
        <h4><?php echo __("Gallery post format options", TEMPNAME); ?></h4>
        <div><?php echo __('Use 2nd/3rd ... Featured Images (in the right sidebar, right after main featured image) to upload images for the gallery post format', TEMPNAME); ?></div>
    </div>
    <div id="ninzio-post-format-link" class="ninzio-post-option">
        <h4><?php echo __("Link post format options", TEMPNAME); ?></h4>
        <div>
            <label for="link_url"><?php echo __('Enter link URL here:', TEMPNAME); ?></label>
            <input name="link_url" id="post-link-url" type="text" value="<?php echo $link_url;?>"/>
        </div>
    </div>
    <div id="ninzio-post-format-image" class="ninzio-post-option">
        <h4><?php echo __("Image post format options", TEMPNAME); ?></h4>
        <div>
            <label for="image_url"><?php echo __('Enter image URL here:', TEMPNAME); ?></label>
            <input name="image_url" id="post-image-url" type="text" value="<?php echo $image_url;?>"/>
        </div>
        <div>
            <label for="image_description"><?php echo __('Enter image DESCRIPTION here:', TEMPNAME); ?></label>
            <input name="image_description" id="post-image-description" type="text" value="<?php echo $image_description;?>"/>
        </div>
    </div>
    <div id="ninzio-post-format-status" class="ninzio-post-option">
        <h4><?php echo __("Status post format options", TEMPNAME); ?></h4>
        <div>
            <label for="status_author"><?php echo __('Enter status author name here:', TEMPNAME); ?></label>
            <input name="status_author" id="post-status-author" type="text" value="<?php echo $status_author;?>"/>
        </div>
    </div>
    <div id="ninzio-post-format-quote" class="ninzio-post-option">
        <h4><?php echo __("Quote post format options", TEMPNAME); ?></h4>
        <div>
            <label for="quote_author"><?php echo __('Enter quote author name here:', TEMPNAME); ?></label>
            <input name="quote_author" id="post-quote-author" type="text" value="<?php echo $quote_author;?>"/>
        </div>
    </div>
<?php
}

function render_ninzio_post_title_options($post) {

    global $nz_ninzio;

    $nz_stuck               = ($nz_ninzio['blog-hs'] && $nz_ninzio['blog-hs'] == 1) ? "true" : "false";
    $nz_rh                  = ($nz_ninzio['blog-rh'] && $nz_ninzio['blog-rh']  == 1) ? "true" : "false";
    $nz_rh_height           = ($nz_ninzio['blog-rh-height']) ? $nz_ninzio["blog-rh-height"] : "500";
    $nz_back_color          = ($nz_ninzio['blog-back']['background-color']) ? $nz_ninzio["blog-back"]['background-color'] : "";
    $nz_back_img            = ($nz_ninzio['blog-back']['background-image']) ? $nz_ninzio['blog-back']['background-image'] : "";
    $nz_back_img_repeat     = ($nz_ninzio['blog-back']['background-repeat']) ? $nz_ninzio['blog-back']['background-repeat'] : "no-repeat";
    $nz_back_img_position   = ($nz_ninzio['blog-back']['background-position']) ? $nz_ninzio['blog-back']['background-position'] : "left_top";
    $nz_back_img_attachment = ($nz_ninzio['blog-back']['background-attachment']) ? $nz_ninzio['blog-back']['background-attachment'] : "scroll";
    $nz_back_img_size       = ($nz_ninzio['blog-back']['background-size']) ? $nz_ninzio['blog-back']['background-size'] : "auto";
    $nz_parallax            = ($nz_ninzio['blog-parallax'] && $nz_ninzio['blog-parallax']  == 1) ? "true" : "false";

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

add_action( 'save_post', 'save_ninzio_post_format_options' );  
function save_ninzio_post_format_options( $post_id )  
{  
    
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    if( !isset( $_POST['ninzio_post_meta_nonce'] ) || !wp_verify_nonce( $_POST['ninzio_post_meta_nonce'], 'ninzio_post_meta_nonce' ) ) return;  
    if( !current_user_can( 'edit_post' ) ) return;

    if( isset( $_POST['audio_mp3'] ) ){update_post_meta($post_id, "audio_mp3",$_POST["audio_mp3"]);}
    if( isset( $_POST['audio_ogg'] ) ){update_post_meta($post_id, "audio_ogg",$_POST["audio_ogg"]);}
    if( isset( $_POST['audio_embed'] ) ){update_post_meta($post_id, "audio_embed",$_POST["audio_embed"]);}
    if( isset( $_POST['video_mp4'] ) ){update_post_meta($post_id, "video_mp4",$_POST["video_mp4"]);}
    if( isset( $_POST['video_ogv'] ) ){update_post_meta($post_id, "video_ogv",$_POST["video_ogv"]);}
    if( isset( $_POST['video_webm'] ) ){update_post_meta($post_id, "video_webm",$_POST["video_webm"]);}
    if( isset( $_POST['video_embed'] ) ){update_post_meta($post_id, "video_embed",$_POST["video_embed"]);}
    if( isset( $_POST['video_poster'] ) ){update_post_meta($post_id, "video_poster",$_POST["video_poster"]);}
    if( isset( $_POST['link_url'] ) ){update_post_meta($post_id, "link_url",$_POST["link_url"]);}
    if( isset( $_POST['image_url'] ) ){update_post_meta($post_id, "image_url",$_POST["image_url"]);}
    if( isset( $_POST['image_description'] ) ){update_post_meta($post_id, "image_description",$_POST["image_description"]);}
    if( isset( $_POST['status_author'] ) ){update_post_meta($post_id, "status_author",$_POST["status_author"]);}
    if( isset( $_POST['quote_author'] ) ){update_post_meta($post_id, "quote_author",$_POST["quote_author"]);}

    if( isset( $_POST['rh_height'] ) ){update_post_meta($post_id, "rh_height",$_POST["rh_height"]);}
    if( isset( $_POST['rh_back_color'] ) ){update_post_meta($post_id, "rh_back_color",$_POST["rh_back_color"]);}
    if( isset( $_POST['rh_back_img'] ) ){update_post_meta($post_id, "rh_back_img",$_POST["rh_back_img"]);}
    if( isset( $_POST['rh_back_img_repeat'] ) ){update_post_meta($post_id, "rh_back_img_repeat",$_POST["rh_back_img_repeat"]);}
    if( isset( $_POST['rh_back_img_position'] ) ){update_post_meta($post_id, "rh_back_img_position",$_POST["rh_back_img_position"]);}
    if( isset( $_POST['rh_back_img_attachment'] ) ){update_post_meta($post_id, "rh_back_img_attachment",$_POST["rh_back_img_attachment"]);}
    if( isset( $_POST['rh_back_img_size'] ) ){update_post_meta($post_id, "rh_back_img_size",$_POST["rh_back_img_size"]);}

    $featured_media_checked = ( isset( $_POST['featured_media'] ) ) ? "false" : "true";
    update_post_meta($post_id, "featured_media", $featured_media_checked);

    $rh_checked = ( isset( $_POST['rh'] ) ) ? "true" : "false";
    update_post_meta($post_id, "rh", $rh_checked);

    $header_stuck_checked = ( isset( $_POST['header_stuck'] ) ) ? "true" : "false";
    update_post_meta($post_id, "header_stuck", $header_stuck_checked);

    $parallax_checked = ( isset( $_POST['parallax'] ) ) ? "true" : "false";
    update_post_meta($post_id, "parallax", $parallax_checked);
    
}

?>