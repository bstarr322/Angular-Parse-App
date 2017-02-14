<?php 

add_action("admin_init", "ninzio_add_page_meta_box");
function ninzio_add_page_meta_box(){

    add_meta_box(
        "ninzio-page-options", 
        __("Page options", TEMPNAME),
        "render_ninzio_page_options", 
        "page",
        "normal", 
        "high"
    );

}

function render_ninzio_page_options($post) {

    global $nz_ninzio;
    $nz_stuck = ($nz_ninzio['blog-hs'] && $nz_ninzio['blog-hs'] == 1) ? "true" : "false";

    $values                 = get_post_custom( $post->ID );

    // Layout options
    $blank                  = isset( $values['blank'][0] ) ? esc_attr( $values["blank"][0] ) : "false";
    $layout                 = isset( $values['layout'][0] ) ? esc_attr( $values["layout"][0] ) : "false";
    $one_page               = isset( $values['one_page'][0] ) ? esc_attr( $values["one_page"][0] ) : "false";
    $slider                 = isset( $values["slider"][0] ) ? esc_attr( $values["slider"][0] ) : "false";
    $padding                = isset( $values['padding'][0] ) ? esc_attr( $values["padding"][0] ) : "true";
    $header_stuck           = isset( $values["header_stuck"][0] ) ? esc_attr( $values["header_stuck"][0] ) : $nz_stuck;

    // Sidebar options
    $sidebar                = isset( $values['sidebar'] ) ? esc_attr( $values["sidebar"][0] ) : "none";
    $sidebar_pos            = isset( $values['sidebar_pos'] ) ? esc_attr( $values["sidebar_pos"][0] ) : "left";

    // Rich options
    $rh                     = isset( $values['rh'][0] ) ? esc_attr( $values["rh"][0] ) : "false";
    $rh_content             = isset( $values['rh_content'] ) ? wp_kses_post($values["rh_content"][0]) : "";
    $rh_height              = isset( $values['rh_height'] ) ? esc_attr( $values["rh_height"][0] ) : "500";
    $rh_back_color          = isset( $values['rh_back_color'] ) ? esc_attr( $values["rh_back_color"][0] ) : "#f6f6f6";
    $rh_back_img            = isset( $values['rh_back_img'] ) ? esc_url( $values["rh_back_img"][0] ) : "";
    $rh_back_img_repeat     = isset( $values['rh_back_img_repeat'] ) ? esc_attr( $values["rh_back_img_repeat"][0] ) : "no-repeat";
    $rh_back_img_position   = isset( $values['rh_back_img_position'] ) ? esc_attr( $values["rh_back_img_position"][0] ) : "left_top";
    $rh_back_img_attachment = isset( $values['rh_back_img_attachment'] ) ? esc_attr( $values["rh_back_img_attachment"][0] ) : "scroll";
    $rh_back_img_size       = isset( $values['rh_back_img_size'] ) ? esc_attr( $values["rh_back_img_size"][0] ) : "auto";
    $parallax               = isset( $values['parallax'][0] ) ? esc_attr( $values["parallax"][0] ) : "false";

    wp_nonce_field( 'ninzio_page_meta_nonce', 'ninzio_page_meta_nonce' );

?>
    <br>
    <div class="ninzio-page-subsection">
        <h2>Layout options</h2>

        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="blank" value="true" <?php checked( $blank, "true" ); ?> />
                <?php echo __(' - Blank page', TEMPNAME); ?>
            </label>
        </div>

        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="layout" value="true" <?php checked( $layout, "true" ); ?> />
                <?php echo __(' - Full width', TEMPNAME); ?>
            </label>
        </div>

        <div class="ninzio-page-option one-page">
            <label>
                <input type="checkbox" name="one_page" value="true" <?php checked( $one_page, "true" ); ?> />
                <?php echo __(' - One page layout', TEMPNAME); ?>
            </label>
        </div>

        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="slider" value="true" <?php checked( $slider, "true" ); ?> />
                <?php echo __(' - Ninzio slider', TEMPNAME); ?>
            </label>
            <p><?php echo __("Toggle Ninzio slider on this page", TEMPNAME); ?></p>
        </div>

        <div class="ninzio-page-option header-stuck">
            <label>
                <input type="checkbox" name="header_stuck" value="true" <?php checked( $header_stuck, "true" ); ?> />
                <?php echo __(' - Header stuck', TEMPNAME); ?>
            </label>
            <p><?php echo __("Toggle Header stuck state on this page", TEMPNAME); ?></p>
        </div>

        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="padding" value="false" <?php checked( $padding, "false" ); ?> />
                <?php echo __(' - Page top no padding', TEMPNAME); ?>
            </label>
            <p><?php echo __("Turn off padding top of this page", TEMPNAME); ?></p>
        </div>

    </div>

    <div class="ninzio-page-subsection sidebar-options">
        <h2>Sidebar options</h2>
        <div class="ninzio-page-option">
            <label><?php echo __("Choose page sidebar", TEMPNAME); ?></label>
            <select name="sidebar">
                <option value="none" <?php selected( $sidebar, 'none' ); ?>><?php echo __('None', TEMPNAME) ?></option> 
                <option value="page-sidebar-1" <?php selected( $sidebar, 'page-sidebar-1' ); ?>><?php echo __('Page sidebar #1', TEMPNAME) ?></option> 
                <option value="page-sidebar-2" <?php selected( $sidebar, 'page-sidebar-2' ); ?>><?php echo __('Page sidebar #2', TEMPNAME) ?></option>  
                <option value="page-sidebar-3" <?php selected( $sidebar, 'page-sidebar-3' ); ?>><?php echo __('Page sidebar #3', TEMPNAME) ?></option>  
            </select>
        </div>
        <div class="ninzio-page-option sidebar-pos">
            <label><?php echo __("Choose page sidebar position", TEMPNAME); ?></label>
            <select name="sidebar_pos">
                <option value="left" <?php selected( $sidebar_pos, 'left' ); ?>><?php echo __('left', TEMPNAME) ?></option>
                <option value="right" <?php selected( $sidebar_pos, 'right' ); ?>><?php echo __('right', TEMPNAME) ?></option>
            </select>
        </div>
    </div>

    <div class="ninzio-page-subsection">

        <h2>Page title section options (Rich header)</h2>
        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="rh" value="true" <?php checked( $rh, "true" ); ?> />
                <?php echo __(' - Rich header', TEMPNAME); ?>
            </label>
            <p><?php echo __("Toggle rich header (page title section) on this page", TEMPNAME); ?></p>
        </div>

        <div class="ninzio-page-option">
            <label for="rh_content"><?php echo __('Enter page title content here', TEMPNAME); ?></label>
            <?php

                $tinymce_opt = array(
                    'height'  => "150",
                    'plugins' => "textcolor,paste,nz_gap,nz_sep,nz_btn,nz_icons",
                    'toolbar1' => "bold,italic,alignleft,aligncenter,alignright,alignjustify,link,unlink,formatselect,fontselect,fontsizeselect,styleselect,forecolor,removeformat,charmap,undo,redo",
                    'toolbar2' => "nz_gap, nz_sep, nz_btn, nz_icons",
                    'toolbar3' => "",
                );

                $settings = array ('tinymce' => $tinymce_opt);
                wp_editor( $rh_content, "rh_content", $settings); 
            ?>
        </div>

        <div class="ninzio-page-option">
            <label><?php echo __('Page header section height:', TEMPNAME); ?></label>
            <input name="rh_height" type="text" value="<?php echo $rh_height; ?>" />
        </div>

        <div class="ninzio-page-option">
            <label><?php echo __('Page header section background color:', TEMPNAME); ?></label>
            <input name="rh_back_color" class="ninzio-color-picker" value="<?php echo $rh_back_color; ?>" />
        </div>

        <div class="ninzio-page-option">
            <label><?php echo __('Page header section background image:', TEMPNAME); ?></label>
            <div class="ninzio-upload">
                <input name="rh_back_img" type="hidden" class="ninzio-upload-path" value="<?php echo $rh_back_img;?>"/> 
                <input class="ninzio-button-upload button" type="button" value="<?php echo __('Upload background image', TEMPNAME) ?>" />
                <input class="ninzio-button-remove button" type="button" value="<?php echo __('Remove background image', TEMPNAME) ?>" />
                <br>
                <img src='<?php echo $rh_back_img; ?>' class='ninzio-preview-upload'/>
            </div>
        </div>

        <div class="ninzio-page-option">
            <label><?php echo __("Page header section background image repeat", TEMPNAME); ?></label>
            <select name="rh_back_img_repeat">  
                <option value="no-repeat" <?php selected( $rh_back_img_repeat, 'no-repeat' ); ?>><?php echo __('no-repeat',TEMPNAME); ?></option>
                <option value="repeat-x" <?php selected( $rh_back_img_repeat, 'repeat-x' ); ?>><?php echo __('repeat-x',TEMPNAME); ?></option>
                <option value="repeat-y" <?php selected( $rh_back_img_repeat, 'repeat-y' ); ?>><?php echo __('repeat-y',TEMPNAME); ?></option>
                <option value="repeat" <?php selected( $rh_back_img_repeat, 'repeat' ); ?>><?php echo __('repeat',TEMPNAME); ?></option>
            </select>
        </div>

        <div class="ninzio-page-option">
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

        <div class="ninzio-page-option">
            <label><?php echo __("Page header section background image attachment", TEMPNAME); ?></label>
            <select name="rh_back_img_attachment">  
                <option value="scroll" <?php selected( $rh_back_img_attachment, 'scroll' ); ?>><?php echo __('scroll',TEMPNAME); ?></option>
                <option value="fixed" <?php selected( $rh_back_img_attachment, 'fixed' ); ?>><?php echo __('fixed',TEMPNAME); ?></option>
            </select>
        </div>

        <div class="ninzio-page-option">
            <label><?php echo __("Page title section background image size", TEMPNAME); ?></label>
            <select name="rh_back_img_size">  
                <option value="auto" <?php selected( $rh_back_img_size, 'auto' ); ?>><?php echo __('auto',TEMPNAME); ?></option>
                <option value="cover" <?php selected( $rh_back_img_size, 'cover' ); ?>><?php echo __('cover',TEMPNAME); ?></option>
            </select>
        </div>
        <div class="ninzio-page-option">
            <label>
                <input type="checkbox" name="parallax" value="true" <?php checked( $parallax, "true" ); ?> />
                <?php echo __(' - Parallax', TEMPNAME); ?>
            </label>
            <p><?php echo __("Activate parallax effect on page title section (not available on mobile devices). Use images with a height greater than page title section (1:1.5 ratio)", TEMPNAME); ?></p>
        </div>
    </div>
<?php
}

add_action( 'save_post', 'save_ninzio_page_options' );  
function save_ninzio_page_options( $post_id )  
{  
    
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
    if( !isset( $_POST['ninzio_page_meta_nonce'] ) || !wp_verify_nonce( $_POST['ninzio_page_meta_nonce'], 'ninzio_page_meta_nonce' ) ) return;  
    if( !current_user_can( 'edit_post' ) ) return;

    if( isset( $_POST['sidebar'] ) ){update_post_meta($post_id, "sidebar",$_POST["sidebar"]);}
    if( isset( $_POST['sidebar_pos'] ) ){update_post_meta($post_id, "sidebar_pos",$_POST["sidebar_pos"]);}
    if( isset( $_POST['rh_content'] ) ){update_post_meta($post_id, "rh_content",$_POST["rh_content"]);}
    if( isset( $_POST['rh_height'] ) ){update_post_meta($post_id, "rh_height",$_POST["rh_height"]);}
    if( isset( $_POST['rh_back_color'] ) ){update_post_meta($post_id, "rh_back_color",$_POST["rh_back_color"]);}
    if( isset( $_POST['rh_back_img'] ) ){update_post_meta($post_id, "rh_back_img",$_POST["rh_back_img"]);}
    if( isset( $_POST['rh_back_img_repeat'] ) ){update_post_meta($post_id, "rh_back_img_repeat",$_POST["rh_back_img_repeat"]);}
    if( isset( $_POST['rh_back_img_position'] ) ){update_post_meta($post_id, "rh_back_img_position",$_POST["rh_back_img_position"]);}
    if( isset( $_POST['rh_back_img_attachment'] ) ){update_post_meta($post_id, "rh_back_img_attachment",$_POST["rh_back_img_attachment"]);}
    if( isset( $_POST['rh_back_img_size'] ) ){update_post_meta($post_id, "rh_back_img_size",$_POST["rh_back_img_size"]);}
    
    $rh_checked = ( isset( $_POST['rh'] ) ) ? "true" : "false";
    update_post_meta($post_id, "rh", $rh_checked);

    $header_stuck_checked = ( isset( $_POST['header_stuck'] ) ) ? "true" : "false";
    update_post_meta($post_id, "header_stuck", $header_stuck_checked);

    $slider_checked = ( isset( $_POST['slider'] ) ) ? "true" : "false";
    update_post_meta($post_id, "slider", $slider_checked);

    $blank_checked = ( isset( $_POST['blank'] ) ) ? "true" : "false";
    update_post_meta($post_id, "blank", $blank_checked);

    $layout_checked = ( isset( $_POST['layout'] ) ) ? "true" : "false";
    update_post_meta($post_id, "layout", $layout_checked);

    $one_page_checked = ( isset( $_POST['one_page'] ) ) ? "true" : "false";
    update_post_meta($post_id, "one_page", $one_page_checked);

    $padding_checked = ( isset( $_POST['padding'] ) ) ? "false" : "true";
    update_post_meta($post_id, "padding", $padding_checked);

    $parallax_checked = ( isset( $_POST['parallax'] ) ) ? "true" : "false";
    update_post_meta($post_id, "parallax", $parallax_checked);
}

?>