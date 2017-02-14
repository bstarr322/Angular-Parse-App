<?php

/*  CONSTANTAS
/*======================*/

    define( 'TEMPNAME', "experion");
    define( 'TEMPPATH', get_template_directory_uri());
    define( 'IMAGES', TEMPPATH. "/images");

    // WPML CONSTANTAS
    define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
    define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);

/*  HANDLE EXTERNAL PLUGINS
/*======================*/
    
    add_action( 'tgmpa_register', 'ninzio_register_required_plugins' );
    function ninzio_register_required_plugins() {

        $plugins = array(

            array(
                'name'      => 'Contact Form 7',
                'slug'      => 'contact-form-7',
                'required'  => true,
            ),

            array(
                'name'      => 'Woocommerce',
                'slug'      => 'woocommerce',
                'required'  => false,
            ),

            array(
                'name'      => 'Envato WordPress Toolkit',
                'slug'      => 'envato-wordpress-toolkit-master',
                'source'    => get_template_directory() . '/plugins/envato-wordpress-toolkit-master.zip',
                'required'  => true,
                'force_activation' => true,
                'force_deactivation' => false,
                'external_url' => ''
            ),

            array(
                'name'      => 'WPBakery Visual Composer',
                'slug'      => 'js_composer',
                'source'    => get_template_directory() . '/plugins/js_composer.zip',
                'required'  => true,
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => ''
            )

        );

        $theme_text_domain = TEMPNAME;


        $config = array(
            'domain'            => $theme_text_domain,
            'default_path'      => '',                          // Default absolute path to pre-packaged plugins
            'parent_menu_slug'  => 'themes.php',                // Default parent menu slug
            'parent_url_slug'   => 'themes.php',                // Default parent URL slug
            'menu'              => 'install-required-plugins',  // Menu slug
            'has_notices'       => true,                        // Show admin notices or not
            'is_automatic'      => false,                       // Automatically activate plugins after installation or not
            'message'           => '',                          // Message to output right before the plugins table
            'strings'           => array(
                'page_title'                                => __( 'Install Required Plugins', TEMPNAME ),
                'menu_title'                                => __( 'Install Plugins', TEMPNAME ),
                'installing'                                => __( 'Installing Plugin: %s', TEMPNAME ), // %1$s = plugin name
                'oops'                                      => __( 'Something went wrong with the plugin API.', TEMPNAME ),
                'notice_can_install_required'               => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
                'notice_can_install_recommended'            => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_install'                     => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
                'notice_can_activate_required'              => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_can_activate_recommended'           => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_activate'                    => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
                'notice_ask_to_update'                      => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
                'notice_cannot_update'                      => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
                'install_link'                              => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
                'activate_link'                             => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
                'return'                                    => __( 'Return to Required Plugins Installer', TEMPNAME ),
                'plugin_activated'                          => __( 'Plugin activated successfully.', TEMPNAME ),
                'complete'                                  => __( 'All plugins installed and activated successfully. %s', TEMPNAME ), // %1$s = dashboard link
                'nag_type'                                  => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
            )
        );

        tgmpa( $plugins, $config );

    }

/*  INCLUDES
/*======================*/

    if (!class_exists('MultiPostThumbnails') && file_exists( dirname( __FILE__ ) . '/includes/multi-post-thumbnails.php' ) ) {
        require_once(dirname( __FILE__ ) . '/includes/multi-post-thumbnails.php');
    }

    if (!class_exists('TGM_Plugin_Activation') && file_exists( dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php' ) ) {
        require_once(dirname( __FILE__ ) . '/includes/class-tgm-plugin-activation.php');
    }

    if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/optionpanel/framework.php' ) ) {
        require_once(dirname( __FILE__ ) . '/optionpanel/framework.php' );
    }

    if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/optionpanel/config.php' ) ) {
        require_once( dirname( __FILE__ ) . '/optionpanel/config.php' );
    }

    if (defined( 'WPB_VC_VERSION' ) && file_exists( dirname( __FILE__ ) . '/plugins/js_composer.zip' ) ) {
        require_once('includes/ninzio_vc.php' );
    }

    require_once('includes/shortcodes.php' );
    require_once('includes/page-extended-options.php' );
    require_once('includes/post-extended-options.php' );
    require_once('includes/custom-ninzio-slider.php' );
    require_once('includes/custom-portfolio.php' );
    require_once('includes/widgets/custom-reglog.php' );
    require_once('includes/widgets/custom-mailchimp.php' );
    require_once('includes/widgets/custom-recent-entries.php' );
    require_once('includes/widgets/custom-flickr.php' );
    require_once('includes/widgets/custom-recent-portfolio.php' );
    require_once('includes/widgets/custom-facebook.php' );
    require_once('includes/widgets/custom-twitter.php' );

/*  HELPER FUNCTIONS
/*======================*/

    /*  Flush rewrite rules
    /*-------------------*/

        add_action( 'after_switch_theme', 'ninzio_flush_rewrite_rules' );
        function ninzio_flush_rewrite_rules() {
             flush_rewrite_rules();
        }

    /*  Excerpt more
    /*-------------------*/

        /*  Excerpt max length
/*--------------------*/

        function nz_excerpt($limit) {
            
            $excerpt = get_the_excerpt();
            $limit++;

            $output = "";

            if ( mb_strlen( $excerpt ) > $limit ) {
                $subex = mb_substr( $excerpt, 0, $limit - 5 );
                $exwords = explode( ' ', $subex );
                $excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

                if ( $excut < 0 ) {
                    $output .= mb_substr( $subex, 0, $excut );
                } else {
                    $output .= $subex;
                }

                $output .= '[...]';

            } else {
                $output .= $excerpt;
            }

            return $output;
        }

        function ninzio_excerpt_more() {
            global $post;
            echo '<a class="read-more" href="'. get_permalink($post->ID) . '" title="'.__("Read more about", TEMPNAME).' '.get_the_title($post->ID).'" >'.__("Read more", TEMPNAME).'<span class="icon-arrow-right9"></span></a>';
        }

    /*  Simple pagination (Next & Prev Controls)
    /*-------------------*/
        
        function ninzio_post_nav($post_id){
            $post_type  = (get_post_type($post_id)) ? get_post_type($post_id) : 'post';
            $prev_title = __('Previous post', TEMPNAME);
            $next_title = __('Next post', TEMPNAME);

            switch ($post_type) {
                case 'portfolio':
                    $prev_title = __('Previous project', TEMPNAME);
                    $next_title = __('Next project', TEMPNAME);
                    break;
                case 'product':
                    $prev_title = __('Previous product', TEMPNAME);
                    $next_title = __('Next product', TEMPNAME);
                    break;
                
                default:
                    $prev_title = __('Previous post', TEMPNAME);
                    $next_title = __('Next post', TEMPNAME);
                    break;
            }

        ?>
            <?php if (is_single()): ?>
                <nav class="nz-clearfix ninzio-nav-single">  
                  <div class="nav-previous" title="<?php echo $prev_title; ?>"><?php previous_post_link( '%link', ''); ?></div>  
                  <div class="nav-next" title="<?php echo $next_title; ?>"><?php next_post_link( '%link', ''); ?></div>  
                </nav>
            <?php endif ?>
        <?php }

    /*  Advanced pagination (Numbered page navigation)
    /*-------------------*/

        function ninzio_post_nav_num(){

            if( is_singular() ){
                return;
            }

            global $wp_query;
            $big = 99999999;

            echo "<nav class=ninzio-navigation>";
                echo paginate_links(array(
                    'base'      => str_replace($big, '%#%', get_pagenum_link($big)),
                    'format'    => '?paged=%#%',
                    'total'     => $wp_query->max_num_pages,
                    'current'   => max(1, get_query_var('paged')),
                    'show_all'  => false,
                    'end_size'  => 2,
                    'mid_size'  => 3,
                    'prev_next' => true,
                    'prev_text' => __('Prev', TEMPNAME),
                    'next_text' => __('Next', TEMPNAME),
                    'type'      => 'list'
                ));
            echo "</nav>";
  
        }
            
    /*  Not found
    /*-------------------*/

        function ninzio_not_found($post_type){

            $output = '';

            $output .= '<p class="ninzio-not-found">';

            switch ($post_type) {

                case 'portfolio':
                    $output .= __('No projects found.', TEMPNAME);
                    break;

                case 'general':
                    $output .= __('No search results found. Try a different search', TEMPNAME);
                    break;
                
                default:
                    $output .= __('No posts found.', TEMPNAME);
                    break;
            }

            $output .= '</p>';

            return $output;
        }

    /*  Ninzio title
    /*-------------------*/

        add_filter( 'wp_title', 'filter_wp_title' );
        function filter_wp_title( $title ) {
            global $page, $paged;

            if ( is_feed() ){
                return $title;
            }
                
            $site_description = get_bloginfo( 'description' );

            $filtered_title = $title . get_bloginfo( 'name' );
            $filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
            $filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', TEMPNAME), max( $paged, $page ) ) : '';

            return $filtered_title;
        }

    /*  Hex to rgba
    /*-------------------*/

        function ninzio_hex_to_rgba($hex, $o) {
           $hex = str_replace("#", "", $hex);
           $hex = array_map('hexdec', str_split($hex, 2));
           return 'rgba('.implode(",", $hex).','.$o.')';
        }

    /*  Hex to rgb shade
    /*-------------------*/

        function ninzio_hex_to_rgb_shade($hex,$o) {
           $hex = str_replace("#", "", $hex);
           $hex = array_map('hexdec', str_split($hex, 2));
           $hex[0] -= $o;
           $hex[1] -= $o;
           $hex[2] -= $o;
           return 'rgb('.implode(",", $hex).')';
        }

    /*  Post thumbnail based on layout
    /*-------------------*/

        function ninzio_thumbnail ($layout, $post_id){

            $thumb_size = 'Ninzio-Uni';

            if (is_single()) {
                    $thumb_size = 'Ninzio-Whole';
            } else {
                switch ($layout) {
                    case 'large' :
                    case 'medium':
                    case 'small' :
                        $thumb_size = 'Ninzio-Half';
                        break;
                    case 'full' :
                        $thumb_size = 'Ninzio-Whole';
                        break;
                }
            }

            ?>
            <?php if (has_post_thumbnail()): ?>
                <?php
                    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                    $href            = (is_single()) ? $large_image_url[0] : get_permalink();
                ?>
                <a class="nz-more media" href="<?php echo $href; ?>">
                    <div class="nz-thumbnail">
                        <?php echo get_the_post_thumbnail( $post_id, $thumb_size );?>
                        <div class="ninzio-overlay"></div>
                        <div class="post-date"><span><?php echo get_the_date("d");?></span><span><?php echo get_the_date("M");?></span></div>
                        <?php if (is_sticky($post_id)): ?>
                           <div class="post-sticky"><span class="icon-pushpin"></span></div> 
                        <?php endif ?>
                    </div>
                </a>

            <?php endif ?>

        <?php }

        function ninzio_port_thumbnail ($layout, $post_id){

            $thumb_size = 'Ninzio-Uni';

            if (is_single()) {
                    $thumb_size = 'Ninzio-Whole';
            } else {
                switch ($layout) {
                    case 'large' :
                    case 'medium':
                    case 'small' :
                    case 'image-grid-small':
                    case 'image-grid-medium':
                    case 'image-grid-large':
                    case 'no-gap-grid-3':
                    case 'no-gap-grid-4':
                        $thumb_size = 'Ninzio-Uni';
                        break;
                    case 'full' :
                        $thumb_size = 'Ninzio-Whole';
                        break;
                    case 'masonry-3':
                    case 'masonry-4':
                        $thumb_size = 'full';
                }
            }

            ?>
            <?php if (has_post_thumbnail()): ?>
                <?php
                    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                    $href            = (is_single()) ? $large_image_url[0] : get_permalink();
                ?>
                <a class="nz-more media" href="<?php echo $href; ?>">
                    <div class="nz-thumbnail">
                        <?php echo get_the_post_thumbnail( $post_id, $thumb_size );?>
                        <div class="ninzio-overlay"></div>
                    </div>
                </a>

            <?php endif ?>

        <?php }

    /*  Post gallery
    /*-------------------*/

        function ninzio_post_gallery ($layout, $post_id){

            global $nz_ninzio;
            $post_gallery_array = array();
            $thumb_size = 'Ninzio-Half';

            if (!is_single()) {
                switch ($layout) {
                    case 'large':
                    case 'medium':
                    case 'small' :
                    $thumb_size = 'Ninzio-Half';
                    break;
                    case 'full' :
                    $thumb_size = 'Ninzio-Whole';
                    break;
                }
            } elseif (is_single()) {
                $thumb_size = 'Ninzio-Whole';
            }

            if (class_exists('MultiPostThumbnails')) {

                if (MultiPostThumbnails::has_post_thumbnail('post', 'feature-image-2')) {
                    $thumb_2 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-2', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-2', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_2);
                }

                if (MultiPostThumbnails::has_post_thumbnail('post', 'feature-image-3')) {
                    $thumb_3 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-3', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-3', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_3);
                }

                if (MultiPostThumbnails::has_post_thumbnail('post', 'feature-image-4')) {
                    $thumb_4 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-4', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-4', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_4);
                }

                if (MultiPostThumbnails::has_post_thumbnail('post', 'feature-image-5')) {
                    $thumb_5 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-5', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-5', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_5);
                }

            }

            ?>
            <?php if (has_post_thumbnail()): ?>
                <div class="post-gallery media">
                    <div class="post-date"><span><?php echo get_the_date("d");?></span><span><?php echo get_the_date("M");?></span></div>
                    <?php if (is_sticky($post_id)): ?>
                       <div class="post-sticky"><span class="icon-pushpin"></span></div> 
                    <?php endif ?>
                    <ul class="slides">
                        <li>
                            <?php
                                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                                $href            = (is_single()) ? $large_image_url[0] : get_permalink();
                            ?>
                            <a class="nz-more" data-lightbox-gallery="gallery3" href="<?php echo $href; ?>">
                                <div class="nz-thumbnail">
                                    <?php echo get_the_post_thumbnail( $post_id, $thumb_size );?>
                                    <div class="ninzio-overlay"></div>
                                </div>
                            </a>
                        </li>
                        <?php foreach ($post_gallery_array as $thumb): ?>
                            <li>
                                <?php $href2 = (is_single()) ? $thumb[1] : get_permalink(); ?>
                                <a class="nz-more" data-lightbox-gallery="gallery3" href="<?php echo $href2; ?>">
                                    <div class="nz-thumbnail">
                                        <img src="<?php echo $thumb[0]; ?>" alt="<?php echo get_the_title(); ?>">
                                        <div class="ninzio-overlay"></div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
        <?php }

        function ninzio_port_gallery ($layout, $post_id){

            global $nz_ninzio;
            $post_gallery_array = array();
            $thumb_size = 'Ninzio-Three-Quarters';

            if (class_exists('MultiPostThumbnails')) {

                if (MultiPostThumbnails::has_post_thumbnail('portfolio', 'feature-image-2')) {
                    $thumb_2 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-2', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-2', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_2);
                }

                if (MultiPostThumbnails::has_post_thumbnail('portfolio', 'feature-image-3')) {
                    $thumb_3 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-3', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-3', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_3);
                }

                if (MultiPostThumbnails::has_post_thumbnail('portfolio', 'feature-image-4')) {
                    $thumb_4 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-4', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-4', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_4);
                }

                if (MultiPostThumbnails::has_post_thumbnail('portfolio', 'feature-image-5')) {
                    $thumb_5 = array(
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-5', $post_id, $size = $thumb_size),
                        MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'feature-image-5', $post_id, $size = 'full')
                    );
                    array_push($post_gallery_array, $thumb_5);
                }

            }

            ?>
            <?php if (has_post_thumbnail()): ?>
                <div class="post-gallery media">
                    <ul class="slides">
                        <li>
                            <?php
                                $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
                                $href            = (is_single()) ? $large_image_url[0] : get_permalink();
                            ?>
                            <a class="nz-more" data-lightbox-gallery="gallery4" href="<?php echo $href; ?>">
                                <div class="nz-thumbnail">
                                    <?php echo get_the_post_thumbnail( $post_id, $thumb_size );?>
                                    <div class="ninzio-overlay"></div>
                                </div>
                            </a>
                        </li>
                        <?php foreach ($post_gallery_array as $thumb): ?>
                            <li>
                                <?php $href2 = (is_single()) ? $thumb[1] : get_permalink(); ?>
                                <a class="nz-more" data-lightbox-gallery="gallery4" href="<?php echo $href2; ?>">
                                    <div class="nz-thumbnail">
                                        <img src="<?php echo $thumb[0]; ?>" alt="<?php echo get_the_title(); ?>">
                                        <div class="ninzio-overlay"></div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>
        <?php }

    /*  Post format chat transcript
    /*-------------------*/

        function ninzio_post_chat_format($content) {
            global $post;
            if (has_post_format('chat')) {
                $chatoutput = "<ul class=\"chat\">\n";
                $split = preg_split("/(\r?\n)+|(<br\s*\/?>\s*)+/", $content);

                foreach($split as $haystack) {
                    if (strpos($haystack, ":")) {
                        $string = explode(":", trim($haystack), 2);
                        $who = strip_tags(trim($string[0]));
                        $what = strip_tags(trim($string[1]));
                        $row_class = empty($row_class)? " class=\"chat-highlight\"" : "";
                        $chatoutput = $chatoutput . "<li><span class='name'>$who</span><p>$what</p></li>\n";
                    } else {
                        $chatoutput = $chatoutput . $haystack . "\n";
                    }
                }

                $content = $chatoutput . "</ul>\n";
                return $content;
            } else { 
                return $content;
            }
        }
        add_filter( "the_content", "ninzio_post_chat_format", 9);

    /*  Column converter
    /*-------------------*/

        function ninzio_column_convert( $width, $front = true ) {
            if ( preg_match( '/^(\d{1,2})\/12$/', $width, $match ) ) {
                $w = 'col'.$match[1];
            } else {
                $w = 'col';
                switch ( $width ) {
                    case "1/6" :
                        $w .= '2';
                        break;
                    case "1/4" :
                        $w .= '3';
                        break;
                    case "1/3" :
                        $w .= '4';
                        break;
                    case "1/2" :
                        $w .= '6';
                        break;
                    case "2/3" :
                        $w .= '8';
                        break;
                    case "3/4" :
                        $w .= '9';
                        break;
                    case "5/6" :
                        $w .= '10';
                        break;
                    case "1/1" :
                        $w .= '12';
                        break;
                    default :
                        $w = $width;
                }
            }
            $custom = $front ? get_custom_column_class( $w ) : false;
            return $custom ? $custom : $w;
        }

    /*  Get the widget
    /*-------------------*/

        if( !function_exists('get_the_widget') ){
      
            function get_the_widget( $widget, $instance = '', $args = '' ){
                ob_start();
                the_widget($widget, $instance, $args);
                return ob_get_clean();
            }
            
        }


/*  THEME SUPPORTS
/*======================*/

    /*  Thumbnail support
    /*-------------------*/

        if ( function_exists( 'add_theme_support' ) ) {

            add_theme_support( 'post-thumbnails');
            add_image_size( 'Ninzio-Uni', 640, 540, true );            // Uni
            add_image_size( 'Ninzio-Half', 570, 480, true );           // Half
            add_image_size( 'Ninzio-One-Third', 370, 300, true );      // One third
            add_image_size( 'Ninzio-Three-Quarters', 870, 570, true ); // Two thirds
            add_image_size( 'Ninzio-Whole', 1170, 570, true );         // Whole

        }

        function custom_image_sizes( $sizes ) {
        
            $new_sizes = array();
            
            $added_sizes = get_intermediate_image_sizes();

            foreach( $added_sizes as $key => $value) {
                if($value != 'post-thumbnails' || $value != 'shop_thumbnail' || $value != 'shop_catalog' || $value != 'shop_single'){
                    $new_sizes[$value] = $value;
                }
            }

            $new_sizes = array_merge( $new_sizes, $sizes );
            
            return $new_sizes;
        }
        add_filter('image_size_names_choose', 'custom_image_sizes', 11, 1);

    /*  Multiple post/portfolio thumbnails
    /*-------------------*/

        if (class_exists('MultiPostThumbnails')) {

            // MultiPostThumbnails for posts

            new MultiPostThumbnails(
                array(
                    'label'     => __('2nd Featured Image', TEMPNAME),
                    'id'        => 'feature-image-2',
                    'post_type' => 'post'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('3rd Featured Image', TEMPNAME),
                    'id'        => 'feature-image-3',
                    'post_type' => 'post'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('4th Featured Image', TEMPNAME),
                    'id'        => 'feature-image-4',
                    'post_type' => 'post'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('5th Featured Image', TEMPNAME),
                    'id'        => 'feature-image-5',
                    'post_type' => 'post'
                )
            );


            // MultiPostThumbnails for portfolio

            new MultiPostThumbnails(
                array(
                    'label'     => __('2nd Featured Image', TEMPNAME),
                    'id'        => 'feature-image-2',
                    'post_type' => 'portfolio'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('3rd Featured Image', TEMPNAME),
                    'id'        => 'feature-image-3',
                    'post_type' => 'portfolio'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('4th Featured Image', TEMPNAME),
                    'id'        => 'feature-image-4',
                    'post_type' => 'portfolio'
                )
            );
            new MultiPostThumbnails(
                array(
                    'label'     => __('5th Featured Image', TEMPNAME),
                    'id'        => 'feature-image-5',
                    'post_type' => 'portfolio'
                )
            );
        }

    /*  Enable shorcodes in widgets
    /*-------------------*/

        add_filter('widget_text', 'do_shortcode');

    /*  HTML5 gallery and caption support (3.9 addition)
    /*-------------------*/

        add_theme_support( 'html5', array( 'gallery', 'caption' ) );

    /*  Content width
    /*-------------------*/

        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }

    /*  Enable excerpt for pages
    /*-------------------*/

        add_action('init', 'page_excerpt');
        function page_excerpt() {
            add_post_type_support( 'page', 'excerpt' );
        }

    /*  Enable post formats for posts
    /*-------------------*/

        add_theme_support( 'post-formats', array( 'aside', 'audio', 'video', 'image', 'gallery', 'link', 'quote', 'status', 'chat') );
        add_post_type_support( 'post', 'post-formats' );

    /*  Enable automatic feed links
    /*-------------------*/

        add_theme_support( 'automatic-feed-links' );

    /*  Languages
    /*-------------------*/

        add_action('after_setup_theme', 'ninzio_language_setup');
        function ninzio_language_setup(){
            load_theme_textdomain(TEMPNAME, get_template_directory() . '/languages');
        }

    /*  Menu
    /*-------------------*/

        function ninzio_register_menu() {

            register_nav_menus(
                array(
                  'header-menu'      => __( 'Header Menu', TEMPNAME ),
                  'one-page-bullets' => __( 'One Page Bullets', TEMPNAME ),
                  'footer-menu'      => __( 'Footer Menu', TEMPNAME )
                )
            );
          
        }
        add_action( 'after_setup_theme', 'ninzio_register_menu' );

    /*  Sidebar
    /*-------------------*/

        if ( function_exists( 'register_sidebar' ) ){

            register_sidebar( 
                array (
                'name'          => __( 'Main sidebar', TEMPNAME),
                'id'            => 'main-widget-area',
                'description'   => __('Main widget area', TEMPNAME),
                'class'         => 'main-widget-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="widget_title">',
                'after_title'   => '</h6>' )
            );

            register_sidebar( 
                array (
                'name'          => __( 'Blog sidebar', TEMPNAME),
                'id'            => 'blog-widget-area',
                'description'   => __('Main widget area', TEMPNAME),
                'class'         => 'blog-widget-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="widget_title">',
                'after_title'   => '</h6>' )
            );

            register_sidebar( 
                array (
                'name'          => __( 'Portfolio sidebar', TEMPNAME),
                'id'            => 'portfolio-widget-area',
                'description'   => __('Portfolio widget area', TEMPNAME),
                'class'         => 'portfolio-widget-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="widget_title">',
                'after_title'   => '</h6>' )
            );

            register_sidebar( 
                array (
                'name'          => __( 'Shop sidebar', TEMPNAME),
                'id'            => 'shop-widget-area',
                'description'   => __('Shop widget area', TEMPNAME),
                'class'         => 'shop-widget-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="widget_title">',
                'after_title'   => '</h6>' )
            );

            for ($i=1; $i < 4; $i++) { 
                register_sidebar( 
                    array (
                    'name'          => __( 'Page sidebar #'.$i, TEMPNAME),
                    'id'            => 'page-widget-area-'.$i,
                    'description'   => __('Page widget area', TEMPNAME),
                    'class'         => 'page-widget-area',
                    'before_widget' => '<div id="%1$s" class="widget %2$s">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<h6 class="widget_title">',
                    'after_title'   => '</h6>' )
                );
            }

            register_sidebar( 
                array (
                'name'          => __( 'Footer sidebar', TEMPNAME),
                'id'            => 'footer-widget-area',
                'description'   => __('Footer widget area', TEMPNAME),
                'class'         => 'footer-widget-area',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<h6 class="widget_title">',
                'after_title'   => '</h6>' )
            );

        }

    /*  WooCommerce
    /*-------------------*/

        global $pagenow;
        if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'nz_woo_img', 1 );

        function nz_woo_img() {
            $catalog = array(
                'width'     => '570',
                'height'    => '480',
                'crop'      => 1
            );
            $single = array(
                'width'     => '600',
                'height'    => '640',
                'crop'      => 1
            );
            $thumbnail = array(
                'width'     => '100',
                'height'    => '100',
                'crop'      => 1 
            );

            update_option( 'shop_catalog_image_size', $catalog );
            update_option( 'shop_single_image_size', $single );
            update_option( 'shop_thumbnail_image_size', $thumbnail );
        }


        //change the position of add to cart
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
        add_action('woocommerce_before_shop_loop_item', 'nz_procut_thumb_cart_before', 10 );
        add_action('woocommerce_after_shop_loop_item', 'nz_procut_thumb_cart_after', 10 );

        function nz_procut_thumb_cart_before() { ?>

            <?php global $product; ?>

            <div class="product-body">
                <div class="nz-thumbnail">
                    <a href="<?php echo get_permalink( $product->ID ); ?>">
                    <?php echo woocommerce_get_product_thumbnail();?>
                    <div class="ninzio-overlay"></div>
                    </a>
                    <div class="ninzio-card-wrapper">
                        <?php woocommerce_get_template( 'loop/add-to-cart.php' ); ?>
                        <div class="shop-loader">&nbsp;</div>
                    </div>
                </div>
                <div class="product-det">

        <?php 
        }

        function nz_procut_thumb_cart_after() { ?>
                </div>
            </div>

        <?php 
        }

        //change the product-category structure
        add_action('woocommerce_before_subcategory_title', 'nz_procut_cat_thumb_start', 5 );
        add_action('woocommerce_before_subcategory_title', 'nz_procut_cat_thumb_end', 10 );
        add_action('woocommerce_after_subcategory_title', 'nz_procut_cat_thumb_end2', 10 );

        function nz_procut_cat_thumb_start() { ?>
            
           <div class="product-body">
                <div class="nz-thumbnail">
                    <div class="ninzio-overlay"></div>
        <?php 
        }

        function nz_procut_cat_thumb_end() { ?>
                </div>
                <div class="product-det cat-det">
        <?php 
        }

        function nz_procut_cat_thumb_end2() { ?>
                </div>
           </div>
        <?php 
        }

        // Ensure cart contents update when products are added to the cart via AJAX
        add_filter('add_to_cart_fragments', 'nz_add_to_cart');
        function nz_add_to_cart( $fragments ) {
            
            global $woocommerce;
            ob_start(); ?>
                <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', TEMPNAME); ?>">
                    <span class="icon-cart3"></span>
                    <span class="cart-info"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
                </a>
                    <div class="cart-dropdown nz-clearfix">
                    <?php
                        if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
                            echo get_the_widget( 'WC_Widget_Cart', 'title=Cart' );
                        } else {
                            echo get_the_widget( 'WooCommerce_Widget_Cart', 'title=Cart' );
                        }
                    ?>
                    </div>
            <?php

            $fragments['a.cart-contents'] = ob_get_clean();
            return $fragments;

        }

        // custom placeholders for images
        add_action( 'init', 'ninzio_custom_woocommerce_thumb' );
        function ninzio_custom_woocommerce_thumb() {
            add_filter('woocommerce_placeholder_img_src', 'nz_woo_place');
            function nz_woo_place( $src ) {

                if (is_product()) {
                   $src = IMAGES . '/placeholder_large.jpg';
                } else {
                   $src = IMAGES . '/placeholder_small.jpg';
                }
                return $src;
            }
        }

        // insert tabs in summary
        remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
        add_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1);  

        //wrap single product image in column div
        add_action( 'woocommerce_before_single_product_summary', 'ninzio_column_open_div', 2);
        add_action( 'woocommerce_before_single_product_summary', 'ninzio_column_close_div', 20);
        add_action( 'woocommerce_after_single_product_summary',  'ninzio_clearfix_div', 2);

        function ninzio_column_open_div(){ echo "<div class='single-product-image'>";}
        function ninzio_column_close_div(){echo "</div><div class='single-product-summary'>";}
        function ninzio_clearfix_div(){echo '</div><div class="nz-clearfix"></div>';}

        //remove wooCommerce prettyPhoto
        global $woocommerce;
        if($woocommerce) {
            
            function ninzio_remove_pretty_photo(){
                wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
                wp_dequeue_style( 'woocommerce_chosen_styles' );
                wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
                wp_dequeue_script( 'prettyPhoto-init' );
                wp_dequeue_script( 'prettyPhoto' );
                wp_dequeue_script( 'wc-chosen' );
            }
            
            add_action( 'wp_enqueue_scripts', 'ninzio_remove_pretty_photo', 99 );

            global $nz_ninzio;

            if (isset($nz_ninzio['shop-rp']) && $nz_ninzio['shop-rp'] == 0) {
                // remove related products
                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
            }

        }

        // related products number
        function woo_related_products_limit() {
          global $product, $nz_ninzio;

            $posts_per_page = ($nz_ninzio['shop-rpn']) ? $nz_ninzio['shop-rpn'] : 4;
            
            $args = array(
                'post_type'             => 'product',
                'no_found_rows'         => 1,
                'posts_per_page'        => $posts_per_page,
                'ignore_sticky_posts'   => 1,
                'orderby'               => 'rand',
                'post__not_in'          => array($product->id)
            );
            return $args;
        }
        add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );
        add_theme_support( 'woocommerce' );
        add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    /*  Custom file upload mime types
    /*-------------------*/

        add_filter('upload_mimes', 'ninzio_custom_upload_mimes');
        function ninzio_custom_upload_mimes ( $existing_mimes=array() ) {
            $existing_mimes['ttf']  = 'application/x-font-ttf';
            $existing_mimes['otf']  = 'application/x-font-opentype';
            $existing_mimes['woff'] = 'application/font-woff';
            $existing_mimes['svg']  = 'image/svg+xml';
            $existing_mimes['eot']  = 'application/vnd.ms-fontobject';
            return $existing_mimes;
        }

    /*  Visual Composer
    /*-------------------*/

        if(function_exists('vc_set_as_theme')) vc_set_as_theme();

/*  STYLES
/*======================*/
    
    function ninzio_add_menu_icons_styles(){
    ?>
    <style>
        #adminmenu .menu-icon-portfolio div.wp-menu-image:before {content: "\f322";}
        #adminmenu .menu-icon-ninzio-slider div.wp-menu-image:before {content: "\f233"; }
    </style>
    <?php
    }
    add_action( 'admin_head', 'ninzio_add_menu_icons_styles' );

/*  SCRIPTS
/*======================*/

    function ninzio_script()
    {
        if(!is_admin())
        {
            
            global $nz_ninzio;

            wp_enqueue_script( 'modernizr', TEMPPATH . '/js/modernizr.js', array(), false);
            wp_enqueue_script( 'shuffle', TEMPPATH . '/js/jquery.shuffle.js', array('jquery'), '', true);
            if ($nz_ninzio['smooth-scroll'] && $nz_ninzio['smooth-scroll'] == 1) {
                wp_enqueue_script( 'smoothscroll', TEMPPATH . '/js/smoothscroll.js', array('jquery'), '', true);
            }
            wp_enqueue_script( 'controller', TEMPPATH . '/js/controller.js', array('jquery'), '', true);
        }  
    
    }
    add_action( 'wp_enqueue_scripts', 'ninzio_script' );

/* ADMIN STYLES/SCRIPTS
/*======================*/

    function admin_scripts_styles() {
        wp_enqueue_script( 'ninzio-admin', TEMPPATH . '/js/admin-scripts.js', array('jquery'), '', true);
        wp_enqueue_style( 'admin-styles', TEMPPATH . '/css/admin-styles.css', array(), '', 'all' );
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery-ui-spinner' );
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_style( 'thickbox' );
        wp_enqueue_script( 'thickbox' );
        wp_enqueue_media();

        return;
    }
    add_action('admin_enqueue_scripts','admin_scripts_styles');

?>