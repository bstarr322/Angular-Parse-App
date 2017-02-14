<?php

if (!class_exists('Redux_Framework_config')) {
	class Redux_Framework_config {

		public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            $this->theme = wp_get_theme();
            $this->setArguments();
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections() {
        	ob_start();

        	$ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', TEMPNAME), $this->theme->display('Name'));

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
					<ul class="theme-info">
						<li><?php printf( __('By %s',TEMPNAME), $ct->display('Author') ); ?></li>
						<li><?php printf( __('Version %s',TEMPNAME), $ct->display('Version') ); ?></li>
						<li><?php echo '<strong>'.__('Tags', TEMPNAME).':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
					<?php if ( $ct->parent() ) {
						printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
							__( 'http://codex.wordpress.org/Child_Themes',TEMPNAME ),
							$ct->parent()->display( 'Name' ) );
					} ?>
					
				</div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            // General
            $this->sections[] = array(
				'title'      => __('General', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-wrench',
				'fields' => array(
					
					array(
						'id'       =>'favicon',
						'type'     => 'media', 
						'url'      => true,
						'preview'  => false,
						'title'    => __('Favicon upload', TEMPNAME),
						'subtitle' => __('Upload a 32px x 32px .ico image that will be your favicon', TEMPNAME)
					),

					array(
						'id'       =>'layout',
						'type'     => 'radio',
						'title'    => __('Main layout', TEMPNAME), 
						'options'  => array(
							'wide'  => __('Wide', TEMPNAME), 
							'boxed' => __('Boxed', TEMPNAME)
						),
						'default'  => 'wide',
					),

					array(
						'id'      =>'page-comments',
						'type'    => 'switch', 
						'title'   => __('Comments on pages', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'smooth-scroll',
						'type'    => 'switch', 
						'title'   => __('Smooth scroll', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'one-page-navigation',
						'type'     => 'select',
						'title'    => __('One page navigation', TEMPNAME),
						'options'  => array(
							"top"   => "Top menu",
							"side"  => "Bullets"
						),
						'default' => "top"
					),

					array(
						'id'       =>'one-page-speed',
						'type'     => 'spinner',
						'title'    => __('One page scroll speed in ms', TEMPNAME),
						'min'      =>'500', 
						'max'      =>'1500', 
						'step'     =>'100',
						'default'  => '800'
					),

					array(
						'id'      =>'one-page-hash',
						'type'    => 'switch', 
						'title'   => __('One page layout hash', TEMPNAME),
						'subtitle'=> __("Toggle one page layout hash. In browsers that support the history object, update the url's hash when clicking on the links ", TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'one-page-filter',
						'type'     => 'text',
						'title'    => __('One page menu filter (if one page navigation is top menu)', TEMPNAME),
						'subtitle'=> __("Exclude links from one page menu by entering comma-separated menu items' ids", TEMPNAME),
					),

					array(
			            'id'       => 'google-analytics',
			            'type'     => 'ace_editor',
						'mode'     => 'javascript',
						'theme'    => 'monokai',
			            'title'    => __('Google analytics', TEMPNAME), 
			            'subtitle' => __('Please enter your google analytics tracking code here.', TEMPNAME),
			        )
				)
			);

			// Header
			$this->sections[] = array(
				'title'      => __('Header', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-laptop-alt',
				'fields' => array(

					array(
						'id'       =>'desk-logo',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Normal logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your logo.', TEMPNAME)
					),

					array(
						'id'       =>'desk-logo-retina',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Retina logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your retina logo.', TEMPNAME)
					),

					array(
						'id'       =>'desk-top',
						'type'     => 'switch',
						'title'    => __('Header top', TEMPNAME),
						"default"  => 0
					),

					array(
						'id'       =>'desk-slogan',
						'type'     => 'textarea',
						'title'    => __('Slogan', TEMPNAME), 
						'subtitle' => __('Enter slogan here', TEMPNAME)
					),

					array(
						'id'      =>'desk-search',
						'type'    => 'switch', 
						'title'   => __('Header search', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'      =>'desk-ls',
						'type'    => 'switch', 
						'title'   => __('Header language switcher', TEMPNAME),
						'subtitle'=> __('Toggle language switcher (available if WPML plugin is installed and active)', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'desk-lw',
						'type'     => 'dimensions',
						'title'    => __('Set width of dropdown list of languagies in px', TEMPNAME),
						'subtitle' => __('WPML Language switch has different content, so list width will vary with the content', TEMPNAME),
						'height'   => false,
						'units'    => 'px',
						"default" => '149px',
					),

					array(
						'id'      =>'desk-sl',
						'type'    => 'switch', 
						'title'   => __('Header social links', TEMPNAME),
						'subtitle'=> __('Toggle social links in header (add your social links in social settings)', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'desk-ind',
						'type'    => 'switch', 
						'title'   => __('Header menu dropdown indication', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'desk-shop-cart',
						'type'    => 'switch', 
						'title'   => __('Toggle shopping cart in header', TEMPNAME),
						'subtitle'=> __('Available with WooCommerce installed and active', TEMPNAME),
						"default" => 0
					),

					array(
						'id'       =>'desk-height',
						'type'     => 'spinner',
						'title'    => __('Header height in px', TEMPNAME),
						'min'      =>'60', 
						'max'      =>'120', 
						'step'     =>'10',
						'default'  =>'90'
					),

					array(
						'id'       =>'desk-top-color',
						'type'     => 'color',
						'title'    => __('Header top text color', TEMPNAME),
						'default'  => '#ffffff'
					),

					array(
						'id'       =>'desk-top-back',
						'type'     => 'color_rgba',
						'title'    => __('Header top background color', TEMPNAME),
						'default'  => array(
					        'color' => '#1e2229', 
					        'alpha' => '1.0'
					    )
					),

					array(
						'id'       =>'desk-sl-color',
						'type'     => 'link_color',
						'title'    => __('Header social links/Language select colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#ffffff',
					        'hover'    => '#ffffff'
					    )
					),

					array(
						'id'       =>'desk-sl-back-hover',
						'type'     => 'color',
						'title'    => __('Header social links/Language select background hover colors', TEMPNAME),
					    'default'  => '#1a1d23'
					),

					array(
						'id'       =>'desk-back',
						'type'     => 'color_rgba',
						'title'    => __('Header background color', TEMPNAME),
						'default'  => array(
					        'color' => '#ffffff', 
					        'alpha' => '1.0'
					    )
					),

					array(
						'id'       =>'desk-menu-p',
						'type'     => 'spinner',
						'title'    => __('Set menu padding in px', TEMPNAME),
						'min'      =>'0', 
						'max'      =>'250', 
						'step'     =>'1',
						'default'  =>'15'
					),

					array(
						'id'       =>'desk-menu-m',
						'type'     => 'spinner',
						'title'    => __('Set menu margin in px', TEMPNAME),
						'min'      =>'0', 
						'max'      =>'250', 
						'step'     =>'1',
						'default'  =>'3'
					),

					array(
						'id'       =>'desk-menu-color',
						'type'     => 'link_color',
						'title'    => __('Menu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#1e2229',
					        'hover'    => '#1a1d23'
					    )
					),

					array(
						'id'       =>'desk-menu-effect',
						'type'     => 'select',
						'title'    => __('Menu effect', TEMPNAME),
						'options'  => array(
							"none"       => "None",
							"underline"  => "Underline",
							"line"       => "Line",
							"outline"    => "Outline",
							"fill"       => "Fill",
							"fill-boxed" => "Fill boxed"
						),
						'default' => "none"
					),

					array(
						'id'       =>'desk-menu-effect-color',
						'type'     => 'color',
						'title'    => __('Menu effect hover color', TEMPNAME),
						'default'  => '#1a1d23'
					),

					array(
						'id'       =>'desk-menu-typo',
						'type'     => 'typography',
						'title'    => __('Menu typography', TEMPNAME), 
						'subtitle' => __('Adjust menu typography', TEMPNAME),
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'line-height'    => false,
						'color'          => false,
						'text-align'     => false,
						'default'     => array(
					        'font-weight'    => '400', 
					        'font-family'    => 'Arial, Helvetica, sans-serif', 
					        'font-size'      => '14px', 
					        'text-transform' => 'uppercase'
					    )
					),

					array(
						'id'       =>'desk-submenu-color',
						'type'     => 'link_color',
						'title'    => __('Submenu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#ffffff',
					        'hover'    => '#ffffff'
					    )
					),

					array(
						'id'       =>'desk-submenu-back',
						'type'     => 'link_color',
						'title'    => __('Submenu background colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#1e2229',
					        'hover'    => '#1a1d23'
					    )
					),

					array(
						'id'       =>'desk-submenu-border-color',
						'type'     => 'color',
						'title'    => __('Submenu border color', TEMPNAME),
						'default'  => '#1a1d23'
					),

					array(
						'id'       =>'desk-submenu-typo',
						'type'     => 'typography',
						'title'    => __('Submenu typography', TEMPNAME), 
						'subtitle' => __('Adjust submenu typography', TEMPNAME),
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'color'          => false,
						'text-align'     => false,
						'default'     => array(
					        'font-weight'    => '400', 
					        'font-family'    => 'Arial, Helvetica, sans-serif', 
					        'font-size'      => '13px', 
					        'line-height'    => '22px',
					        'text-transform' => 'uppercase'
					    )
					),

					array(
						'id'       =>'desk-submenu-effect',
						'type'     => 'select',
						'title'    => __('Submenu effect', TEMPNAME),
						'options'  => array(
							"fade"  => "Fade",
							"slide" => "Slide",
							"ghost" => "Ghost"
						),
						'default' => "fade"
					),

					array(
						'id'       =>'desk-megamenu-top-typo',
						'type'     => 'typography',
						'title'    => __('Megamenu top level typography', TEMPNAME), 
						'subtitle' => __('Adjust megamenu top level typography', TEMPNAME),
						'units'          => 'px',
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'line-height'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-size'      => false,
						'font-family'    => false,
						'font-style'     => false
					),

					array(
						'id'       =>'desk-megamenu-sub-typo',
						'type'     => 'typography',
						'title'    => __('Megamenu submenu typography', TEMPNAME), 
						'subtitle' => __('Adjust submenu typography', TEMPNAME),
						'units'          => 'px',
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'line-height'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-size'      => false,
						'font-family'    => false,
						'font-style'     => false
					),
				)
			);

			// Header mobile
			$this->sections[] = array(
				'title'      => __('Mobile', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => '',
			    'subsection' => true,
				'fields' => array(

					array(
						'id'       =>'mob-logo',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Normal logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your logo.', TEMPNAME)
					),

					array(
						'id'       =>'mob-logo-retina',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Retina logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your retina logo.', TEMPNAME)
					),

					array(
						'id'       =>'mob-height',
						'type'     => 'spinner',
						'title'    => __('Header height in px', TEMPNAME),
						'min'      =>'60', 
						'max'      =>'120', 
						'step'     =>'10',
						'default'  =>'90'
					),

					array(
						'id'      =>'mob-search',
						'type'    => 'switch', 
						'title'   => __('Search on mobile', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'mob-int',
						'type'    => 'switch', 
						'title'   => __('Interactive mob menu', TEMPNAME),
						'subtitle'=> __('Toggle this option to enable/disable toggle interactivity on mob menu', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'mob-toggle-color',
						'type'     => 'color',
						'title'    => __('Menu toggle color', TEMPNAME),
						'default'  => '#1e2229'
					),

					array(
						'id'       =>'mob-header-back',
						'type'     => 'color',
						'title'    => __('Header background color', TEMPNAME),
						'default'  => '#ffffff'
					),

					array(
						'id'       =>'mob-menu-color',
						'type'     => 'link_color',
						'title'    => __('Menu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#ffffff',
					        'hover'    => '#ffffff'
					    )
					),

					array(
						'id'       =>'mob-menu-back',
						'type'     => 'link_color',
						'title'    => __('Menu background color', TEMPNAME),
						'active'   => false,
						'visited'  => false,
						'default'  => array(
					        'regular'  => '#1e2229',
					        'hover'    => '#1a1d23'
					    )
					),

					array(
						'id'       =>'mob-menu-typo',
						'type'     => 'typography',
						'title'    => __('Menu typography', TEMPNAME), 
						'subtitle' => __('Adjust menu typography', TEMPNAME),
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'color'          => false,
						'text-align'     => false
					),

					array(
						'id'       =>'mob-submenu-typo',
						'type'     => 'typography',
						'title'    => __('Submenu typography', TEMPNAME), 
						'subtitle' => __('Adjust submenu typography', TEMPNAME),
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'color'          => false,
						'text-align'     => false
					)
				)
			);

			// Header stuck
			$this->sections[] = array(
				'title'      => __('Stuck', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => '',
			    'subsection' => true,
				'fields' => array(

					array(
						'id'       =>'stuck',
						'type'     => 'switch',
						'title'    => __('Header stuck', TEMPNAME),
						'subtitle' => __('Stuck header on slider/page title section?', TEMPNAME),
						"default"  => 0
					),

					array(
						'id'       =>'stuck-logo',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Normal logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your logo.', TEMPNAME)
					),

					array(
						'id'       =>'stuck-logo-retina',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Retina logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your retina logo.', TEMPNAME)
					),

					array(
						'id'       =>'stuck-top',
						'type'     => 'switch',
						'title'    => __('Header top', TEMPNAME),
						"default"  => 0
					),

					array(
						'id'       =>'stuck-height',
						'type'     => 'spinner',
						'title'    => __('Header height in px', TEMPNAME),
						'min'      =>'60', 
						'max'      =>'120', 
						'step'     =>'10',
						'default'  =>'90'
					),

					array(
						'id'       =>'stuck-top-color',
						'type'     => 'color',
						'title'    => __('Header top text color', TEMPNAME),
					),

					array(
						'id'       =>'stuck-top-back',
						'type'     => 'color_rgba',
						'title'    => __('Header top background color', TEMPNAME)
					),

					array(
						'id'       =>'stuck-sl-color',
						'type'     => 'link_color',
						'title'    => __('Header social links/Language select colors', TEMPNAME),
						'active'   => false,
						'visited'  => false
					),

					array(
						'id'       =>'stuck-sl-back-hover',
						'type'     => 'color',
						'title'    => __('Header social links/Language select background hover colors', TEMPNAME)
					),

					array(
						'id'       =>'stuck-back',
						'type'     => 'color_rgba',
						'title'    => __('Header background color', TEMPNAME)
					),

					array(
						'id'       =>'stuck-menu-color',
						'type'     => 'link_color',
						'title'    => __('Menu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false
					),

					array(
						'id'       =>'stuck-menu-effect-color',
						'type'     => 'color',
						'title'    => __('Menu effect hover color', TEMPNAME)
					),

					array(
						'id'       =>'stuck-submenu-color',
						'type'     => 'link_color',
						'title'    => __('Submenu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false
					),

					array(
						'id'       =>'stuck-submenu-back',
						'type'     => 'link_color',
						'title'    => __('Submenu background colors', TEMPNAME),
						'active'   => false,
						'visited'  => false
					),

					array(
						'id'       =>'stuck-submenu-border-color',
						'type'     => 'color',
						'title'    => __('Submenu border color', TEMPNAME)
					)

				)
			);
			
			// Header fixed
			$this->sections[] = array(
				'title'      => __('Fixed', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => '',
			    'subsection' => true,
				'fields' => array(

					array(
						'id'       =>'fixed',
						'type'     => 'switch',
						'title'    => __('Header fixed', TEMPNAME),
						'subtitle' => __('Toggle header fixation', TEMPNAME),
						"default"  => 0
					),

					array(
						'id'       =>'fixed-logo',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Normal logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your logo.', TEMPNAME)
					),

					array(
						'id'       =>'fixed-logo-retina',
						'type'     => 'media', 
						'url'      => false,
						'title'    => __('Retina logo upload', TEMPNAME),
						'subtitle' => __('Upload .jpg, .png or .gif image that will be your retina logo.', TEMPNAME)
					),

					array(
						'id'       =>'fixed-height',
						'type'     => 'spinner',
						'title'    => __('Header height in px', TEMPNAME),
						'min'      =>'60', 
						'max'      =>'120', 
						'step'     =>'10',
						'default'  =>'90'	
					),

					array(
						'id'       =>'fixed-back',
						'type'     => 'color_rgba',
						'title'    => __('Header background color', TEMPNAME),
					),

					array(
						'id'       =>'fixed-menu-color',
						'type'     => 'link_color',
						'title'    => __('Menu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
					),

					array(
						'id'       =>'fixed-menu-effect-color',
						'type'     => 'color',
						'title'    => __('Menu effect hover color', TEMPNAME),
					),

					array(
						'id'       =>'fixed-submenu-color',
						'type'     => 'link_color',
						'title'    => __('Submenu text colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
					),

					array(
						'id'       =>'fixed-submenu-back',
						'type'     => 'link_color',
						'title'    => __('Submenu background colors', TEMPNAME),
						'active'   => false,
						'visited'  => false,
					),

					array(
						'id'       =>'fixed-submenu-border-color',
						'type'     => 'color',
						'title'    => __('Submenu border color', TEMPNAME),
					)
					
				)
			);

			// Sidebar
			$this->sections[] = array(
				'title'      => __('Sidebar', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-th-large',
				'fields' => array(

					array(
						'id'      =>'sidebar',
						'type'    => 'switch', 
						'title'   => __('Toggle sidebar', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'sidebar-back',
						'type'     => 'color',
						'title'    => __('Sidebar background color', TEMPNAME),
					    'regular'  => '#1e2229'
					),

					array(
						'id'       =>'sidebar-title-color',
						'type'     => 'color',
						'title'    => __('Sidebar widgets title color', TEMPNAME),
					    'regular'  => '#ffffff'
					),

					array(
						'id'       =>'sidebar-color',
						'type'     => 'color',
						'title'    => __('Sidebar color', TEMPNAME),
					    'regular'  => '#ffffff'
					),

					array(
						'id'       =>'sidebar-hover',
						'type'     => 'color',
						'title'    => __('Sidebar hover color', TEMPNAME),
						'subtitle' => __('Refers to links, several widgets', TEMPNAME),
					    'regular'  => '#08ade4'
					),

				)
			);
			
			// Footer
			$this->sections[] = array(
				'title'      => __('Footer', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-hand-down',
				'fields' => array(

					array(
						'id'      =>'footer-social-links',
						'type'    => 'switch', 
						'title'   => __('Footer social links', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'      =>'footer-copyright',
						'type'    => 'textarea', 
						'title'   => __('Copyright info', TEMPNAME),
						"default" => '&copy Ninzio Team',
					),

					array(
						'id'       =>'footer-back',
						'type'     => 'color',
						'title'    => __('Footer background color', TEMPNAME),
						'default'  => '#1a1d23',
					),

					array(
						'id'       =>'footer-color',
						'type'     => 'color',
						'title'    => __('Footer text color', TEMPNAME),
						'default'  => '#ffffff',
					),

					array(
						'id'       =>'footer-color-hover',
						'type'     => 'color',
						'title'    => __('Footer text color hover', TEMPNAME),
						'default'  => '#ffffff',
					),

					array(
						'id'       =>'footer-wa-back',
						'type'     => 'color',
						'title'    => __('Footer widget area background color', TEMPNAME),
						'default'  => '#253237',
					),

					array(
						'id'       =>'footer-wa-color',
						'type'     => 'color',
						'title'    => __('Footer widget area text color', TEMPNAME),
						'default'  => '#ffffff',
					),

					array(
						'id'       =>'footer-wat-color',
						'type'     => 'color',
						'title'    => __('Footer widgets title color', TEMPNAME),
						'default'  => '#ffffff',
					),

					array(
						'id'       =>'footer-wah',
						'type'     => 'color',
						'title'    => __('Footer widgets hover color', TEMPNAME),
						'subtitle' => __('Refers to links, several widgets', TEMPNAME),
					    'regular'  => '#08ade4'
					),
				)
			);
			
			// Styling
			$this->sections[] = array(
				'title'      => __('Styling', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-eye-open',
				'fields' => array(

					array(
						'id'       =>'main-color',
						'type'     => 'color',
						'title'    => __('Main color', TEMPNAME), 
						'default'  => '#08ade4',
					),

					array(
						'id'       =>'button-style',
						'type'     => 'select',
						'title'    => __('Button style', TEMPNAME),
						'options'  => array(
							"normal" => "Normal",
							"ghost"  => "Ghost",
							"3d"     => "3d"
						),
						'default' => "normal"
					),

					array(
						'id'       =>'button-shape',
						'type'     => 'select',
						'title'    => __('Button shape', TEMPNAME),
						'options'  => array(
							"square" => "Square",
							"rounded"  => "Rounded",
							"round"     => "Round"
						),
						'default' => "normal"
					),

					array(
						'id'       =>'button-typo',
						'type'     => 'typography',
						'title'    => __('Button typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'font-style'     => false,
						'font-weight'    => true,
						'color'          => false,
						'text-align'     => false,
						'font-size'      => false,
						'line-height'    => false,
						'font-family'    => true,
						'all_styles'     => true
					),

					array(
						'id'       =>'site-background',
						'type'     => 'background',
						'title'    => __('Site background options', TEMPNAME), 
					),

					array(
			            'id'       => 'custom-css',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('Enter custom css code here.', TEMPNAME),
			        ),

			        array(
			            'id'       => 'custom-css-mob-port',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('MAX MOB PORTRAIT (device <= 320)', TEMPNAME),
			        ),

			        array(
			            'id'       => 'custom-css-mob-land',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('MAX MOB LANDSCAPE (320 < device <= 480)', TEMPNAME),
			        ),

			        array(
			            'id'       => 'custom-css-tab-port',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('MAX TABLET PORTRAIT (480 < device <= 768)', TEMPNAME),
			        ),

			        array(
			            'id'       => 'custom-css-tab-land',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('MAX TABLET LANDSCAPE (768 < device <= 1024)', TEMPNAME),
			        ),

			        array(
			            'id'       => 'custom-css-desk',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom CSS Styles', TEMPNAME), 
			            'subtitle' => __('ONLY DESKTOP (1024 < device)', TEMPNAME),
			        ),
				)
			);
			
			// Typography
			$this->sections[] = array(
				'title'      => __('Typography', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-font',
				'fields' => array(

					array(
						'id'       =>'main-typo',
						'type'     => 'typography',
						'title'    => __('Main typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'font-style'     => false,
						'font-weight'    => false,
						'color'          => true,
						'text-align'     => false,
						'font-family'    => true,
						'all_styles'     => true,
						'default'     => array(
							'font-family'    => 'Arial, Helvetica, sans-serif',
					        'font-size'      => '13px', 
					        'line-height'    => '22px',
					        'color'          => '#777777'
					    )
					),

					array(
						'id'       =>'small-typo',
						'type'     => 'typography',
						'title'    => __('Small text typography', TEMPNAME), 
						'subtitle' => __('Choose small text font size for your site (refers to post meta information and several shortcodes)', TEMPNAME),
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'font-style'     => false,
						'font-weight'    => false, 
						'letter-spacing' => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'      => '11px', 
					        'line-height'    => '22px',
					    )
					),

					array(
						'id'       =>'headings-typo',
						'type'     => 'typography',
						'title'    => __('Headings typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => true,
						'subsets'        => false,
						'text-transform' => true,
						'letter-spacing' => false,
						'line-height'    => false,
						'font-style'     => false, 
						'font-size'      => false,
						'font-weight'    => false,
						'color'          => true,
						'text-align'     => false,
						'font-family'    => true,
						'all_styles'     => true,
						'default'     => array(
					        'text-transform' => 'none'
					    )
					),

					array(
						'id'       =>'h1-typo',
						'type'     => 'typography',
						'title'    => __('H1 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-size'      => true,
						'font-weight'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '24px',
					        'line-height' => '34px'
					    )
					),

					array(
						'id'       =>'h2-typo',
						'type'     => 'typography',
						'title'    => __('H2 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-size'      => true,
						'font-weight'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '22px',
					        'line-height' => '32px'
					    )
					),

					array(
						'id'       =>'h3-typo',
						'type'     => 'typography',
						'title'    => __('H3 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-size'      => true,
						'font-weight'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '20px',
					        'line-height' => '30px'
					    )
					),

					array(
						'id'       =>'h4-typo',
						'type'     => 'typography',
						'title'    => __('H4 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-size'      => true,
						'font-weight'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '18px',
					        'line-height' => '28px'
					    )
					),

					array(
						'id'       =>'h5-typo',
						'type'     => 'typography',
						'title'    => __('H5 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-size'      => true,
						'font-weight'    => false,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '16px',
					        'line-height' => '26px'
					    )
					),

					array(
						'id'       =>'h6-typo',
						'type'     => 'typography',
						'title'    => __('H6 typography', TEMPNAME), 
						'units'          => 'px',
						'google'         => false,
						'subsets'        => false,
						'text-transform' => false,
						'letter-spacing' => false,
						'line-height'    => true,
						'font-style'     => false, 
						'font-weight'    => false, 
						'font-size'      => true,
						'color'          => false,
						'text-align'     => false,
						'font-family'    => false,
						'default'     => array(
					        'font-size'   => '14px',
					        'line-height' => '24px'
					    )
					),

					array(
		                'id'        => 'custom-fonts',
		                'type'      => 'media',
		                'title'     => __('Upload custom fonts', TEMPNAME),
		                'subtitle'  => __('Upload custom fonts here (eot, woff,truetype, svg formats)', TEMPNAME),
		                'compiler'  => 'true',
		                'mode'      => false
		            ),

		            array(
			            'id'       => 'font-custom-css',
			            'type'     => 'ace_editor',
						'mode'     => 'css',
						'theme'    => 'monokai',
			            'title'    => __('Custom @font-face CSS Styles', TEMPNAME), 
			            'subtitle' => __('Enter custom @font-face css code here. Step by step instruction of custom font @font-face definitions can be found in help file (Customization >> Typography options)', TEMPNAME),
			        ),

				)
			);
			
			// Social
			$this->sections[] = array(
				'title'      => __('Social', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-group',
				'fields'     => array(

					array(
						'id'      =>'tweets-consumer-key',
						'type'     => 'text',
						'title'    => __('Recent tweets consumer key', TEMPNAME),
						'default'  => ''
					),

					array(
						'id'      =>'tweets-consumer-secret',
						'type'     => 'text',
						'title'    => __('Recent tweets consumer secret', TEMPNAME),
						'subtitle' => __('Enter your consumer key here', TEMPNAME),
						'default'  => ''
					),

					array(
						'id'      =>'tweets-access-token',
						'type'     => 'text',
						'title'    => __('Recent tweets access token', TEMPNAME),
						'subtitle' => __('Enter your access token here', TEMPNAME),
						'default'  => ''
					),

					array(
						'id'      =>'tweets-access-token-secret',
						'type'     => 'text',
						'title'    => __('Recent tweets access token secret', TEMPNAME),
						'subtitle' => __('Enter your access token secret here', TEMPNAME),
						'default'  => ''
					),

					array(
						'id'      =>'social-rss',
						'type'     => 'text',
						'title'    => __('RSS Feed URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-facebook',
						'type'     => 'text',
						'title'    => __('Facebook URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-twitter',
						'type'     => 'text',
						'title'    => __('Twitter URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-googleplus',
						'type'     => 'text',
						'title'    => __('Google Plus URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-youtube',
						'type'     => 'text',
						'title'    => __('Yotube URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-vimeo',
						'type'     => 'text',
						'title'    => __('Vimeo URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-linkedin',
						'type'     => 'text',
						'title'    => __('LinkedIn URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-pinterest',
						'type'     => 'text',
						'title'    => __('Pinterest URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-flickr',
						'type'     => 'text',
						'title'    => __('Flickr URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-instagram',
						'type'     => 'text',
						'title'    => __('Instagram URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-apple',
						'type'     => 'text',
						'title'    => __('Apple URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-dribbble',
						'type'     => 'text',
						'title'    => __('Dribbble URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-android',
						'type'     => 'text',
						'title'    => __('Android URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-behance',
						'type'     => 'text',
						'title'    => __('Behance URL', TEMPNAME),
						'validate' => 'url',
						'default'  => ''
					),

					array(
						'id'      =>'social-email',
						'type'     => 'text',
						'title'    => __('Email URL', TEMPNAME),
						'default'  => ''
					)
				)
			);

			// Ninzio slider
			$this->sections[] = array(
				'title'      => __('Ninzio slider', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-tasks',
				'fields' => array(

					array(
						'id'      =>'slider-mob',
						'type'    => 'switch', 
						'title'   => __('Toggle Ninzio slider on mobile', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'slider-autoplay',
						'type'    => 'switch', 
						'title'   => __('Autoplay', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'slider-autoheight',
						'type'    => 'switch', 
						'title'   => __('Autoheight', TEMPNAME),
						'subtitle'=> __('Make slider height autocorrect to window height (100% of window height)', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'slider-arrow',
						'type'    => 'switch', 
						'title'   => __('Move to content arrow', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'slider-autoplay-d',
						'type'     => 'spinner',
						'title'    => __('Autoplay delay in ms', TEMPNAME),
						'min'      =>'2000', 
						'max'      =>'10000', 
						'step'     =>'500',
						'default'  =>'5000'
					),

					array(
						'id'      =>'slider-bullets',
						'type'    => 'switch', 
						'title'   => __('Bullets', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'slider-parallax',
						'type'    => 'switch', 
						'title'   => __('Parallax effect (make sure fixed effect is turn Off)', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'slider-fixed',
						'type'    => 'switch', 
						'title'   => __('Slides background image fixed effect', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'slider-height',
						'type'     => 'spinner',
						'title'    => __('Set height of Ninzio slider in px', TEMPNAME),
						'min'      =>'0', 
						'max'      =>'1500', 
						'step'     =>'1',
						'default'  =>'500',
					),

					array(
						'id'       =>'slider-transition',
						'type'     => 'select',
						'title'    => __('Slider transition', TEMPNAME),
						'options'  => array(
							"fade"       => "Fade",
							"press-away" => "Press away",
							"soft-scale" => "Soft scale",
							"side-swing" => "Side swing"
						),
						'default' => "fade"
					),

					array(
						'id'       =>'slider-background',
						'type'     => 'background',
						'title'    => __('Slider background options', TEMPNAME), 
					),


					
				)
			);

			// Portfolio
			$this->sections[] = array(
				'title'      => __('Portfolio', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-folder-close',
				'fields' => array(

					array(
						'id'      =>'port-rh',
						'type'    =>'switch', 
						'title'   => __('Portfolio title section (Rich header)', TEMPNAME),
						'subtitle' => __('Toggle portfolio title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-hs',
						'type'    =>'switch', 
						'title'   => __('Portfolio header stuck', TEMPNAME),
						'subtitle' => __('Toggle portfolio title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'port-rh-height',
						'type'     => 'text',
						'title'    => __('Set height of portfolio title section (Rich header) in px', TEMPNAME)
					),

					array(
						'id'      =>'port-title',
						'type'     => 'editor',
						'title'    => __('Portfolio title section area', TEMPNAME),
						'subtitle' => __('Enter portfolio title section content', TEMPNAME),
						'default'           => 'Portfolio',
						'args'    => array('wpautop' => false,'media_buttons' => false)
					),

					array(
						'id'       =>'port-back',
						'type'     => 'background',
						'title'    => __('Portfolio page title options', TEMPNAME),
					),

					array(
						'id'      =>'port-parallax',
						'type'    => 'switch', 
						'title'   => __('Parallax effect for portfolio page header section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-slug',
						'type'     => 'text',
						'title'    => __('Portfolio slug', TEMPNAME),
						'subtitle' => __('Enter portfolio slug here', TEMPNAME),
						'default'  => 'portfolio'
					),

					array(
						'id'      =>'port-cat-slug',
						'type'     => 'text',
						'title'    => __('Portfolio category slug', TEMPNAME),
						'subtitle' => __('Enter portfolio category slug here', TEMPNAME),
						'default'  => 'portfolio-category'
					),

					array(
						'id'      =>'port-tag-slug',
						'type'     => 'text',
						'title'    => __('Portfolio tag slug', TEMPNAME),
						'subtitle' => __('Enter portfolio tag slug here', TEMPNAME),
						'default'  => 'portfolio-tag'
					),

					array(
						'id'       =>'port-layout',
						'type'     => 'select',
						'title'    => __('Choose portfolio layout', TEMPNAME), 
						'options'  => array(
							'small'  => 'small', 
							'medium' => 'medium', 
							'large'  => 'large',
							'full'   => 'full',
							'image-grid-small'   => 'image-grid-small', 
							'image-grid-medium'  => 'image-grid-medium', 
							'image-grid-large'   => 'image-grid-large',
							'no-gap-grid-3'      => 'no-gap-grid 1/3',
							'no-gap-grid-4'      => 'no-gap-grid 1/4',
							'masonry-3'          => 'masonry 1/3',
							'masonry-4'          => 'masonry 1/4'
						),
						'default'  => 'medium'
					),

					array(
						'id'      =>'port-filter',
						'type'    =>'switch', 
						'title'   => __('Portfolio filter', TEMPNAME),
						'subtitle' => __('Toggle portfolio filter', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-width',
						'type'    =>'switch', 
						'title'   => __('Portfolio width 100% wide', TEMPNAME),
						'subtitle' => __('Toggle portfolio width in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-animation',
						'type'    =>'switch', 
						'title'   => __('Portfolio posts animation in archive', TEMPNAME),
						'subtitle' => __('Toggle portfolio posts animation in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-wa',
						'type'    =>'switch', 
						'title'   => __('Portfolio widget area', TEMPNAME),
						'subtitle' => __('Toggle portfolio widget area', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'port-pagination',
						'type'    =>'switch', 
						'title'   => __('Portfolio pagination', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'      =>'port-ss',
						'type'    =>'switch', 
						'title'   => __('Social sharing', TEMPNAME),
						'subtitle' => __('Toggle social sharing on single project page', TEMPNAME),
						"default" => 1
					),

					array(
						'id'      =>'port-rp',
						'type'    => 'switch', 
						'title'   => __('Toggle related projects in single product page', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'       =>'port-rpn',
						'type'     => 'select',
						'title'    => __('Single product related projects number', TEMPNAME),
						'options'  => array(
							'3' =>'3',
							'4' =>'4'
						),
						'default'  => '4',
					)
					
				)
			);

			// Blog
			$this->sections[] = array(
				'title'      => __('Blog', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-pencil',
				'fields' => array(

					array(
						'id'      =>'blog-rh',
						'type'    =>'switch', 
						'title'   => __('Blog title section (Rich header)', TEMPNAME),
						'subtitle' => __('Toggle blog title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'blog-hs',
						'type'    =>'switch', 
						'title'   => __('Blog header stuck', TEMPNAME),
						'subtitle' => __('Toggle blog title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'blog-rh-height',
						'type'     => 'text',
						'title'    => __('Set height of blog title section (Rich header) in px', TEMPNAME)
					),

					array(
						'id'      =>'blog-title',
						'type'     => 'editor',
						'title'    => __('Blog title section area', TEMPNAME),
						'subtitle' => __('Enter blog title section content', TEMPNAME),
						'default'           => 'Blog',
						'args'    => array('wpautop' => false,'media_buttons' => false)
					),

					array(
						'id'       =>'blog-back',
						'type'     => 'background',
						'title'    => __('Blog page title options', TEMPNAME),
					),

					array(
						'id'      =>'blog-parallax',
						'type'    => 'switch', 
						'title'   => __('Parallax effect for blog page header section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'blog-layout',
						'type'     => 'select',
						'title'    => __('Choose blog layout', TEMPNAME), 
						'options'  => array(
							'small'  => 'small', 
							'medium' => 'medium', 
							'large'  => 'large',
							'full'   => 'full'
						),
						'default'  => 'medium'
					),

					array(
						'id'      =>'blog-width',
						'type'    =>'switch', 
						'title'   => __('Blog width 100% wide', TEMPNAME),
						'subtitle' => __('Toggle blog width in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'blog-animation',
						'type'    =>'switch', 
						'title'   => __('Blog posts animation in archive', TEMPNAME),
						'subtitle' => __('Toggle blog posts animation in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'blog-wa',
						'type'    =>'switch', 
						'title'   => __('Blog widget area', TEMPNAME),
						'subtitle' => __('Toggle blog widget area in blog archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'blog-swa',
						'type'    =>'switch', 
						'title'   => __('Blog widget area (single post page)', TEMPNAME),
						'subtitle' => __('Toggle blog widget area in blog single post page', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'blog-author',
						'type'    =>'switch', 
						'title'   => __('Author box', TEMPNAME),
						'subtitle' => __('Toggle author information box on single post page (after post, there is a Author Information Box)', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'      =>'blog-comments',
						'type'    =>'switch', 
						'title'   => __('Comment box', TEMPNAME),
						'subtitle' => __('Toggle comments on single post page (after post, there is a "Leave a comment" section)', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'      =>'blog-ss',
						'type'    =>'switch', 
						'title'   => __('Social sharing', TEMPNAME),
						'subtitle' => __('Toggle social sharing on single post page', TEMPNAME),
						"default" => 1,
					)
					
				)
			);

			// Commerce
			$this->sections[] = array(
				'title'      => __('Woocommerce', TEMPNAME),
				'icon_class' => 'icon-small',
			    'icon'       => 'el-icon-shopping-cart',
				'fields' => array(

					array(
						'id'      =>'shop-rh',
						'type'    =>'switch', 
						'title'   => __('Shop title section (Rich header)', TEMPNAME),
						'subtitle' => __('Toggle shop title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'shop-rh-height',
						'type'     => 'text',
						'title'    => __('Set height of shop title section (Rich header) in px', TEMPNAME)
					),

					array(
						'id'      =>'shop-hs',
						'type'    =>'switch', 
						'title'   => __('Shop header stuck', TEMPNAME),
						'subtitle' => __('Toggle shop title section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'shop-title',
						'type'     => 'editor',
						'title'    => __('Shop title section area', TEMPNAME),
						'subtitle' => __('Enter shop title section content', TEMPNAME),
						'default'           => 'Shop',
						'args'    => array('wpautop' => false,'media_buttons' => false)
					),

					array(
						'id'       =>'shop-back',
						'type'     => 'background',
						'title'    => __('Shop page title options', TEMPNAME),
					),

					array(
						'id'      =>'shop-parallax',
						'type'    => 'switch', 
						'title'   => __('Parallax effect for shop page header section', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'shop-width',
						'type'    =>'switch', 
						'title'   => __('Shop width 100% wide', TEMPNAME),
						'subtitle' => __('Toggle shop width in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'      =>'shop-animation',
						'type'    =>'switch', 
						'title'   => __('Shop posts animation in archive', TEMPNAME),
						'subtitle' => __('Toggle shop posts animation in archive', TEMPNAME),
						"default" => 0,
					),

					array(
						'id'       =>'shop-sidebar',
						'type'     => 'select',
						'title'    => __('Shop sidebar', TEMPNAME),
						'subtitle' => __('Select sidebar for shop', TEMPNAME),
						'options'  => array(
							'none'  =>'none', 
							'left'  =>'left', 
							'right' =>'right' 
						),
						'default'  => 'none',
					),

					array(
						'id'       =>'shop-layout',
						'type'     => 'select',
						'title'    => __('Choose shop layout', TEMPNAME), 
						'options'  => array(
							'small'  => 'small', 
							'medium' => 'medium'
						),
						'default'  => 'medium'
					),

					array(
						'id'      =>'shop-rp',
						'type'    => 'switch', 
						'title'   => __('Toggle related products in single product page', TEMPNAME),
						"default" => 1,
					),

					array(
						'id'       =>'shop-rpn',
						'type'     => 'select',
						'title'    => __('Single product related products number', TEMPNAME),
						'options'  => array(
							'3' =>'3',
							'4' =>'4'
						),
						'default'  => '4',
					)
				)
			);
			
			$theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', TEMPNAME) . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', TEMPNAME) . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', TEMPNAME) . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', TEMPNAME) . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';
			
        }

        public function setArguments() {

            $theme = wp_get_theme();

            $this->args = array(
                'opt_name'          => 'nz_ninzio',
                'display_name'      => $theme->get('Name'),
                'display_version'   => $theme->get('Version'),
                'menu_type'         => 'submenu',
                'allow_sub_menu'    => true,
                'menu_title'        => __('Theme Settings', TEMPNAME),
                'page_title'        => __('Theme Settings', TEMPNAME),
                'google_api_key'    => '',
                'async_typography'  => true,
                'admin_bar'         => true,
                'global_variable'   => 'nz_ninzio',
                'dev_mode'          => false,
                'customizer'        => false,
                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'page_slug'         => 'ninzio_options',
                'save_defaults'     => true,
                'default_show'      => false,
                'default_mark'      => '',
                'system_info'       => false,
            );
        }
        
	}

	global $reduxConfig;
    $reduxConfig = new Redux_Framework_config();
}