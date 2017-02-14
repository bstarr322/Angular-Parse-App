<?php

global $nz_ninzio;


/*	STYLING OPTIONS
/*====================================================================*/
	
	$nz_color         = ($nz_ninzio['main-color']) ? $nz_ninzio['main-color'] : "#08ade4";

	$nz_site_back_col = (isset($nz_ninzio['site-background']['background-color']) && $nz_ninzio['site-background']['background-color']) ? $nz_ninzio['site-background']['background-color'] : "#ffffff";
	$nz_site_back_img = (isset($nz_ninzio['site-background']['background-image']) && $nz_ninzio['site-background']['background-image']) ? esc_url($nz_ninzio['site-background']['background-image']) : "";
	$nz_site_back_r   = (isset($nz_ninzio['site-background']['background-repeat']) && $nz_ninzio['site-background']['background-repeat']) ? $nz_ninzio['site-background']['background-repeat'] : "no-repeat";
	$nz_site_back_s   = (isset($nz_ninzio['site-background']['background-size']) && $nz_ninzio['site-background']['background-size']) ? $nz_ninzio['site-background']['background-size'] : "inherit";
	$nz_site_back_a   = (isset($nz_ninzio['site-background']['background-attachment']) && $nz_ninzio['site-background']['background-attachment']) ? $nz_ninzio['site-background']['background-attachment'] : "inherit";
	$nz_site_back_p   = (isset($nz_ninzio['site-background']['background-position']) && $nz_ninzio['site-background']['background-position']) ? $nz_ninzio['site-background']['background-position'] : "left top";

	

/*	TYPOGRAPHY OPTIONS
/*====================================================================*/
	
	$nz_main_font_size        = (isset($nz_ninzio['main-typo']['font-size']) && $nz_ninzio['main-typo']['font-size']) ? $nz_ninzio['main-typo']['font-size'] : "13px";
	$nz_main_line_height      = (isset($nz_ninzio['main-typo']['line-height']) && $nz_ninzio['main-typo']['line-height']) ? $nz_ninzio['main-typo']['line-height'] : "22px";
	$nz_main_font_family      = (isset($nz_ninzio['main-typo']['font-family']) && $nz_ninzio['main-typo']['font-family']) ? $nz_ninzio['main-typo']['font-family'] : "Arial, Helvetica, sans-serif";
	$nz_main_color            = (isset($nz_ninzio['main-typo']['color']) && $nz_ninzio['main-typo']['color']) ? $nz_ninzio['main-typo']['color'] : "#777777";

	$nz_small_font_size       = (isset($nz_ninzio['small-typo']['font-size']) && $nz_ninzio['small-typo']['font-size']) ? $nz_ninzio['small-typo']['font-size'] : "11px";
	$nz_small_line_height     = (isset($nz_ninzio['small-typo']['line-height']) && $nz_ninzio['small-typo']['line-height']) ? $nz_ninzio['small-typo']['line-height'] : "22px";

	$nz_headings_font_family    = (isset($nz_ninzio['headings-typo']['font-family']) && $nz_ninzio['headings-typo']['font-family']) ? $nz_ninzio['headings-typo']['font-family'] : $nz_main_font_family;
	$nz_headings_text_transform = (isset($nz_ninzio['headings-typo']['text-transform']) && $nz_ninzio['headings-typo']['text-transform']) ? $nz_ninzio['headings-typo']['text-transform'] : "none";
	$nz_headings_color          = (isset($nz_ninzio['headings-typo']['color']) && $nz_ninzio['headings-typo']['color']) ? $nz_ninzio['headings-typo']['color'] : "#333333";

	$nz_h1_font_size    = (isset($nz_ninzio['h1-typo']['font-size']) && $nz_ninzio['h1-typo']['font-size']) ? $nz_ninzio['h1-typo']['font-size'] : "28px";
	$nz_h1_line_height  = (isset($nz_ninzio['h1-typo']['line-height']) && $nz_ninzio['h1-typo']['line-height']) ? $nz_ninzio['h1-typo']['line-height'] : "34px";
	$nz_h2_font_size    = (isset($nz_ninzio['h2-typo']['font-size']) && $nz_ninzio['h2-typo']['font-size']) ? $nz_ninzio['h2-typo']['font-size'] : "26px";
	$nz_h2_line_height  = (isset($nz_ninzio['h2-typo']['line-height']) && $nz_ninzio['h2-typo']['line-height']) ? $nz_ninzio['h2-typo']['line-height'] : "32px";
	$nz_h3_font_size    = (isset($nz_ninzio['h3-typo']['font-size']) && $nz_ninzio['h3-typo']['font-size']) ? $nz_ninzio['h3-typo']['font-size'] : "24px";
	$nz_h3_line_height  = (isset($nz_ninzio['h3-typo']['line-height']) && $nz_ninzio['h3-typo']['line-height']) ? $nz_ninzio['h3-typo']['line-height'] : "30px";
	$nz_h4_font_size    = (isset($nz_ninzio['h4-typo']['font-size']) && $nz_ninzio['h4-typo']['font-size']) ? $nz_ninzio['h4-typo']['font-size'] : "22px";
	$nz_h4_line_height  = (isset($nz_ninzio['h4-typo']['line-height']) && $nz_ninzio['h4-typo']['line-height']) ? $nz_ninzio['h4-typo']['line-height'] : "28px";
	$nz_h5_font_size    = (isset($nz_ninzio['h5-typo']['font-size']) && $nz_ninzio['h5-typo']['font-size']) ? $nz_ninzio['h5-typo']['font-size'] : "20px";
	$nz_h5_line_height  = (isset($nz_ninzio['h5-typo']['line-height']) && $nz_ninzio['h5-typo']['line-height']) ? $nz_ninzio['h5-typo']['line-height'] : "26px";
	$nz_h6_font_size    = (isset($nz_ninzio['h6-typo']['font-size']) && $nz_ninzio['h6-typo']['font-size']) ? $nz_ninzio['h6-typo']['font-size'] : "18px";
	$nz_h6_line_height  = (isset($nz_ninzio['h6-typo']['line-height']) && $nz_ninzio['h6-typo']['line-height']) ? $nz_ninzio['h6-typo']['line-height'] : "24px";

	$nz_button_typo   = (isset($nz_ninzio['button-typo']['font-family']) && $nz_ninzio['button-typo']['font-family']) ? $nz_ninzio['button-typo']['font-family'] : $nz_main_font_family;
	$nz_button_fw     = (isset($nz_ninzio['button-typo']['font-weight']) && $nz_ninzio['button-typo']['font-weight']) ? $nz_ninzio['button-typo']['font-weight'] : '700';

/*	HEADER OPTIONS
/*====================================================================*/

	/*	HEADER DESK
	/*----------------------------------------------------------------*/
		
		$nz_desk_top_back               = ($nz_ninzio['desk-top-back']['color']) ? ninzio_hex_to_rgba($nz_ninzio['desk-top-back']['color'], $nz_ninzio['desk-top-back']['alpha']) : "#1e2229";
		$nz_desk_top_color              = ($nz_ninzio['desk-top-color']) ? $nz_ninzio['desk-top-color'] : "#ffffff";
		$nz_desk_sl_color_reg           = (isset($nz_ninzio['desk-sl-color']['regular']) && !empty($nz_ninzio['desk-sl-color']['regular'])) ? $nz_ninzio['desk-sl-color']['regular'] : "#ffffff"; 
		$nz_desk_sl_color_hov           = (isset($nz_ninzio['desk-sl-color']['hover']) && !empty($nz_ninzio['desk-sl-color']['hover'])) ? $nz_ninzio['desk-sl-color']['hover'] : "#ffffff"; 
		$nz_desk_sl_back_hov            = ($nz_ninzio['desk-sl-back-hover']) ? $nz_ninzio['desk-sl-back-hover'] : "#1a1d23"; 
		$nz_desk_ls_w    	            = (isset($nz_ninzio['desk-lw']['width']) && !empty($nz_ninzio['desk-lw']['width'])) ? $nz_ninzio['desk-lw']['width'] : "149px"; 
		$nz_desk_back     	            = ($nz_ninzio['desk-back']) ? ninzio_hex_to_rgba($nz_ninzio['desk-back']['color'], $nz_ninzio['desk-back']['alpha']) : "#ffffff";
		$nz_desk_menu_p                 = ($nz_ninzio['desk-menu-p']) ? $nz_ninzio['desk-menu-p'] : '0';
		$nz_desk_menu_m                 = ($nz_ninzio['desk-menu-m']) ? $nz_ninzio['desk-menu-m'] : '0';
		
		$nz_desk_height                 = ($nz_ninzio['desk-height']) ? $nz_ninzio['desk-height'] : '90';
		$nz_desk_menu_color_reg         = ($nz_ninzio['desk-menu-color']['regular']) ? $nz_ninzio['desk-menu-color']['regular'] : "#1e2229"; 
		$nz_desk_menu_color_hov         = ($nz_ninzio['desk-menu-color']['hover']) ? $nz_ninzio['desk-menu-color']['hover'] : "#1a1d23";
		
		$nz_desk_menu_effect_color      = ($nz_ninzio['desk-menu-effect-color']) ? $nz_ninzio['desk-menu-effect-color'] : "#1a1d23";
		$nz_desk_menu_effect            = ($nz_ninzio['desk-menu-effect']) ? $nz_ninzio['desk-menu-effect'] : "none";
		
		$nz_desk_menu_font_weight       = ($nz_ninzio['desk-menu-typo']['font-weight']) ? $nz_ninzio['desk-menu-typo']['font-weight'] : "normal";
		$nz_desk_menu_font_size         = ($nz_ninzio['desk-menu-typo']['font-size']) ? $nz_ninzio['desk-menu-typo']['font-size'] : "14px";
		$nz_desk_menu_font_family       = ($nz_ninzio['desk-menu-typo']['font-family']) ? $nz_ninzio['desk-menu-typo']['font-family'] : "Arial, Helvetica, sans-serif";
		$nz_desk_menu_text_transform    = ($nz_ninzio['desk-menu-typo']['text-transform']) ? $nz_ninzio['desk-menu-typo']['text-transform'] : "uppercase";
		
		$nz_desk_submenu_color_reg  	= ($nz_ninzio['desk-submenu-color']['regular']) ? $nz_ninzio['desk-submenu-color']['regular'] : "#ffffff"; 
		$nz_desk_submenu_color_hov      = ($nz_ninzio['desk-submenu-color']['hover']) ? $nz_ninzio['desk-submenu-color']['hover'] : "#ffffff";
		$nz_desk_submenu_back           = ($nz_ninzio['desk-submenu-back']['regular']) ? $nz_ninzio['desk-submenu-back']['regular'] : "#1e2229";
		$nz_desk_submenu_back_hov       = ($nz_ninzio['desk-submenu-back']['hover']) ? $nz_ninzio['desk-submenu-back']['hover'] : "#1a1d23";
		$nz_desk_submenu_border_col     = ($nz_ninzio['desk-submenu-border-color']) ? $nz_ninzio['desk-submenu-border-color'] : "#1a1d23";
		$nz_desk_submenu_font_weight    = ($nz_ninzio['desk-submenu-typo']['font-weight']) ? $nz_ninzio['desk-submenu-typo']['font-weight'] : "normal";
		$nz_desk_submenu_font_size      = ($nz_ninzio['desk-submenu-typo']['font-size']) ? $nz_ninzio['desk-submenu-typo']['font-size'] : "14px";
		$nz_desk_submenu_line_height    = ($nz_ninzio['desk-submenu-typo']['line-height']) ? $nz_ninzio['desk-submenu-typo']['line-height'] : "24px";
		$nz_desk_submenu_font_family    = ($nz_ninzio['desk-submenu-typo']['font-family']) ? $nz_ninzio['desk-submenu-typo']['font-family'] : "Arial, Helvetica, sans-serif";
		$nz_desk_submenu_text_transform = ($nz_ninzio['desk-submenu-typo']['text-transform']) ? $nz_ninzio['desk-submenu-typo']['text-transform'] : "none";
		
		$nz_desk_megamenu_font_weight         = (isset($nz_ninzio['desk-megamenu-top-typo']['font-weight']) && $nz_ninzio['desk-megamenu-top-typo']['font-weight']) ? $nz_ninzio['desk-megamenu-top-typo']['font-weight'] : $nz_desk_menu_font_weight;
		$nz_desk_megamenu_text_transform     = (isset($nz_ninzio['desk-megamenu-top-typo']['text-transform']) && $nz_ninzio['desk-megamenu-top-typo']['text-transform']) ? $nz_ninzio['desk-megamenu-top-typo']['text-transform'] : $nz_desk_menu_text_transform;
		$nz_desk_megamenu_sub_font_weight     = (isset($nz_ninzio['desk-megamenu-sub-typo']['font-weight']) && $nz_ninzio['desk-megamenu-sub-typo']['font-weight']) ? $nz_ninzio['desk-megamenu-sub-typo']['font-weight'] : $nz_desk_submenu_font_weight;
		$nz_desk_megamenu_sub_text_transform = (isset($nz_ninzio['desk-megamenu-sub-typo']['text-transform']) && $nz_ninzio['desk-megamenu-sub-typo']['text-transform']) ? $nz_ninzio['desk-megamenu-sub-typo']['text-transform'] : $nz_desk_submenu_text_transform;

	/*	HEADER FIXED
	/*----------------------------------------------------------------*/

		$nz_fixed_back     	            = (isset($nz_ninzio['fixed-back']) && $nz_ninzio['fixed-back']) ? ninzio_hex_to_rgba($nz_ninzio['fixed-back']['color'], $nz_ninzio['fixed-back']['alpha']) : $nz_desk_back;
		$nz_fixed_height                = ($nz_ninzio['fixed-height']) ? $nz_ninzio['fixed-height'] : $nz_desk_height;
		$nz_fixed_menu_color_reg        = (isset($nz_ninzio['fixed-menu-color']['regular']) && $nz_ninzio['fixed-menu-color']['regular']) ? $nz_ninzio['fixed-menu-color']['regular'] : $nz_desk_menu_color_reg; 
		$nz_fixed_menu_color_hov        = (isset($nz_ninzio['fixed-menu-color']['hover']) && $nz_ninzio['fixed-menu-color']['hover']) ? $nz_ninzio['fixed-menu-color']['hover'] : $nz_desk_menu_color_hov;
		$nz_fixed_menu_effect_color     = (isset($nz_ninzio['fixed-menu-effect-color']) && $nz_ninzio['fixed-menu-effect-color']) ? $nz_ninzio['fixed-menu-effect-color'] : $nz_desk_menu_effect_color;
		$nz_fixed_submenu_color_reg  	= (isset($nz_ninzio['fixed-submenu-color']['regular']) && $nz_ninzio['fixed-submenu-color']['regular']) ? $nz_ninzio['fixed-submenu-color']['regular'] : $nz_desk_submenu_color_reg; 
		$nz_fixed_submenu_color_hov     = (isset($nz_ninzio['fixed-submenu-color']['hover']) && $nz_ninzio['fixed-submenu-color']['hover']) ? $nz_ninzio['fixed-submenu-color']['hover'] : $nz_desk_submenu_color_hov;
		$nz_fixed_submenu_back          = (isset($nz_ninzio['fixed-submenu-back']['regular']) && $nz_ninzio['fixed-submenu-back']['regular']) ? $nz_ninzio['fixed-submenu-back']['regular'] : $nz_desk_submenu_back;
		$nz_fixed_submenu_back_hov      = (isset($nz_ninzio['fixed-submenu-back']['hover']) && $nz_ninzio['fixed-submenu-back']['hover']) ? $nz_ninzio['fixed-submenu-back']['hover'] : $nz_desk_submenu_back_hov;
		$nz_fixed_submenu_border_col    = (isset($nz_ninzio['fixed-submenu-border-color']) && $nz_ninzio['fixed-submenu-border-color']) ? $nz_ninzio['fixed-submenu-border-color'] : $nz_desk_submenu_border_col;

	/*	HEADER STUCK
	/*----------------------------------------------------------------*/

		$nz_stuck_top_back               = (isset($nz_ninzio['stuck-top-back']['color']) && !empty($nz_ninzio['stuck-top-back']['color'])) ? ninzio_hex_to_rgba($nz_ninzio['stuck-top-back']['color'], $nz_ninzio['stuck-top-back']['alpha']) : $nz_desk_top_back;
		$nz_stuck_top_color              = (isset($nz_ninzio['stuck-top-color']) && !empty($nz_ninzio['stuck-top-color'])) ? $nz_ninzio['stuck-top-color'] : $nz_desk_top_color;
		$nz_stuck_sl_color_reg           = (isset($nz_ninzio['stuck-sl-color']['regular']) && !empty($nz_ninzio['stuck-sl-color']['regular'])) ? $nz_ninzio['stuck-sl-color']['regular'] : $nz_desk_sl_color_reg; 
		$nz_stuck_sl_color_hov           = (isset($nz_ninzio['stuck-sl-color']['hover']) && !empty($nz_ninzio['stuck-sl-color']['hover'])) ? $nz_ninzio['stuck-sl-color']['hover'] : $nz_desk_sl_color_hov; 
		$nz_stuck_sl_back_hov            = (isset($nz_ninzio['stuck-sl-back-hover']) && !empty($nz_ninzio['stuck-sl-back-hover'])) ? $nz_ninzio['stuck-sl-back-hover'] : $nz_desk_sl_back_hov;

		$nz_stuck_back     	            = (isset($nz_ninzio['stuck-back']) && $nz_ninzio['stuck-back']) ? ninzio_hex_to_rgba($nz_ninzio['stuck-back']['color'], $nz_ninzio['stuck-back']['alpha']) : $nz_desk_back;
		$nz_stuck_height                = ($nz_ninzio['stuck-height']) ? $nz_ninzio['stuck-height'] : $nz_desk_height;
		$nz_stuck_menu_color_reg        = (isset($nz_ninzio['stuck-menu-color']['regular']) && $nz_ninzio['stuck-menu-color']['regular']) ? $nz_ninzio['stuck-menu-color']['regular'] : $nz_desk_menu_color_reg; 
		$nz_stuck_menu_color_hov        = (isset($nz_ninzio['stuck-menu-color']['hover']) && $nz_ninzio['stuck-menu-color']['hover']) ? $nz_ninzio['stuck-menu-color']['hover'] : $nz_desk_menu_color_hov;
		$nz_stuck_menu_effect_color     = (isset($nz_ninzio['stuck-menu-effect-color']) && $nz_ninzio['stuck-menu-effect-color']) ? $nz_ninzio['stuck-menu-effect-color'] : $nz_desk_menu_effect_color;
		$nz_stuck_submenu_color_reg  	= (isset($nz_ninzio['stuck-submenu-color']['regular']) && $nz_ninzio['stuck-submenu-color']['regular']) ? $nz_ninzio['stuck-submenu-color']['regular'] : $nz_desk_submenu_color_reg; 
		$nz_stuck_submenu_color_hov     = (isset($nz_ninzio['stuck-submenu-color']['hover']) && $nz_ninzio['stuck-submenu-color']['hover']) ? $nz_ninzio['stuck-submenu-color']['hover'] : $nz_desk_submenu_color_hov;
		$nz_stuck_submenu_back          = (isset($nz_ninzio['stuck-submenu-back']['regular']) && $nz_ninzio['stuck-submenu-back']['regular']) ? $nz_ninzio['stuck-submenu-back']['regular'] : $nz_desk_submenu_back;
		$nz_stuck_submenu_back_hov      = (isset($nz_ninzio['stuck-submenu-back']['hover']) && $nz_ninzio['stuck-submenu-back']['hover']) ? $nz_ninzio['stuck-submenu-back']['hover'] : $nz_desk_submenu_back_hov;
		$nz_stuck_submenu_border_col    = (isset($nz_ninzio['stuck-submenu-border-color']) && $nz_ninzio['stuck-submenu-border-color']) ? $nz_ninzio['stuck-submenu-border-color'] : $nz_desk_submenu_border_col;

	/*	HEADER MOBILE
	/*----------------------------------------------------------------*/
		
		$nz_mob_height          	   = ($nz_ninzio['mob-height']) ? $nz_ninzio['mob-height'] : '90';
		$nz_mob_toggle_color    	   = ($nz_ninzio['mob-toggle-color']) ? $nz_ninzio['mob-toggle-color'] : "#1e2229";
		$nz_mob_header_back     	   = ($nz_ninzio['mob-header-back']) ? $nz_ninzio['mob-header-back'] : "#ffffff";
		$nz_mob_menu_color_reg  	   = ($nz_ninzio['mob-menu-color']['regular']) ? $nz_ninzio['mob-menu-color']['regular'] : "#ffffff"; 
		$nz_mob_menu_color_hov  	   = ($nz_ninzio['mob-menu-color']['hover']) ? $nz_ninzio['mob-menu-color']['hover'] : "#ffffff";
		$nz_mob_menu_back_reg  	       = ($nz_ninzio['mob-menu-back']['regular']) ? $nz_ninzio['mob-menu-back']['regular'] : "#1e2229"; 
		$nz_mob_menu_back_hov  	       = ($nz_ninzio['mob-menu-back']['hover']) ? $nz_ninzio['mob-menu-back']['hover'] : "#1a1d23";

		$nz_mob_menu_font_weight       = (isset($nz_ninzio['mob-menu-typo']['font-weight']) && $nz_ninzio['mob-menu-typo']['font-weight']) ? $nz_ninzio['mob-menu-typo']['font-weight'] : $nz_desk_menu_font_weight;
		$nz_mob_menu_font_size         = (isset($nz_ninzio['mob-menu-typo']['font-size']) && $nz_ninzio['mob-menu-typo']['font-size']) ? $nz_ninzio['mob-menu-typo']['font-size'] : $nz_desk_menu_font_size;
		$nz_mob_menu_line_height       = (isset($nz_ninzio['mob-menu-typo']['line-height']) && $nz_ninzio['mob-menu-typo']['line-height']) ? $nz_ninzio['mob-menu-typo']['line-height'] : "24px";
		$nz_mob_menu_font_family       = (isset($nz_ninzio['mob-menu-typo']['font-family']) && $nz_ninzio['mob-menu-typo']['font-family']) ? $nz_ninzio['mob-menu-typo']['font-family'] : $nz_desk_menu_font_family;
		$nz_mob_menu_text_transform    = (isset($nz_ninzio['mob-menu-typo']['text-transform']) && $nz_ninzio['mob-menu-typo']['text-transform']) ? $nz_ninzio['mob-menu-typo']['text-transform'] : $nz_desk_menu_text_transform;
		
		$nz_mob_submenu_font_weight    = (isset($nz_ninzio['mob-submenu-typo']['font-weight']) && $nz_ninzio['mob-submenu-typo']['font-weight']) ? $nz_ninzio['mob-submenu-typo']['font-weight'] : $nz_desk_submenu_font_weight;
		$nz_mob_submenu_font_size      = (isset($nz_ninzio['mob-submenu-typo']['font-size']) && $nz_ninzio['mob-submenu-typo']['font-size']) ? $nz_ninzio['mob-submenu-typo']['font-size'] : $nz_desk_submenu_font_size;
		$nz_mob_submenu_line_height    = (isset($nz_ninzio['mob-submenu-typo']['line-height']) && $nz_ninzio['mob-submenu-typo']['line-height']) ? $nz_ninzio['mob-submenu-typo']['line-height'] : $nz_desk_submenu_line_height;
		$nz_mob_submenu_font_family    = (isset($nz_ninzio['mob-submenu-typo']['font-family']) && $nz_ninzio['mob-submenu-typo']['font-family']) ? $nz_ninzio['mob-submenu-typo']['font-family'] : $nz_desk_submenu_font_family;
		$nz_mob_submenu_text_transform = (isset($nz_ninzio['mob-submenu-typo']['text-transform']) && $nz_ninzio['mob-submenu-typo']['text-transform']) ? $nz_ninzio['mob-submenu-typo']['text-transform'] : $nz_desk_submenu_text_transform;

/*	WIDGET AREAS OPTIONS
/*====================================================================*/
	
	$nz_sidebar_back        = (isset($nz_ninzio['sidebar-back']) && $nz_ninzio['sidebar-back']) ? $nz_ninzio['sidebar-back'] : "#1e2229";
	$nz_sidebar_color       = (isset($nz_ninzio['sidebar-color']) && $nz_ninzio['sidebar-color']) ? $nz_ninzio['sidebar-color'] : "#ffffff";
	$nz_sidebar_hover       = (isset($nz_ninzio['sidebar-hover']) && $nz_ninzio['sidebar-hover']) ? $nz_ninzio['sidebar-hover'] : $nz_color;
	$nz_sidebar_title_color = (isset($nz_ninzio['sidebar-title-color']) && $nz_ninzio['sidebar-title-color']) ? $nz_ninzio['sidebar-title-color'] : "#ffffff";

	$nz_footer_back         = ($nz_ninzio['footer-back']) ? $nz_ninzio['footer-back'] : "#1a1d23";
	$nz_footer_color        = ($nz_ninzio['footer-color']) ? $nz_ninzio['footer-color'] : "#ffffff";
	$nz_footer_color_hover  = ($nz_ninzio['footer-color-hover']) ? $nz_ninzio['footer-color-hover'] : "#ffffff";
	$nz_footer_wa_back      = ($nz_ninzio['footer-wa-back']) ? $nz_ninzio['footer-wa-back'] : "#1e2229";
	$nz_footer_wa_color     = ($nz_ninzio['footer-wa-color']) ? $nz_ninzio['footer-wa-color'] : "#ffffff";
	$nz_footer_wa_hover     = (isset($nz_ninzio['footer-wah']) && $nz_ninzio['footer-wah']) ? $nz_ninzio['footer-wah'] : $nz_color;
	$nz_footer_wat_color    = ($nz_ninzio['footer-wat-color']) ? $nz_ninzio['footer-wat-color'] : "#ffffff";
?>

<style>

<?php 
	if(isset($nz_ninzio['font-custom-css']) && !empty($nz_ninzio['font-custom-css'])){echo $nz_ninzio['font-custom-css'];}
	if(isset($nz_ninzio['custom-css']) && !empty($nz_ninzio['custom-css'])){echo $nz_ninzio['custom-css'];}
?>

/*  MIX
/*====================================================================*/

	.widget_icl_lang_sel_widget a,
	.widget_tag_cloud .tagcloud a,
	.widget_product_tag_cloud .tagcloud a {
		font-size: <?php echo $nz_main_font_size; ?> !important;
		font-family:<?php echo $nz_main_font_family; ?>;
	}

	.social-links a span {
		font-family:<?php echo $nz_main_font_family; ?>;
		font-size: <?php echo $nz_main_font_size; ?>;
		line-height: <?php echo $nz_main_line_height; ?>;
	}

	.woocommerce .quantity input[type="button"].minus,
	.woocommerce .quantity input[type="button"].plus,
	.widget_nav_menu ul li a,
	.nz-counter .count-title {
		font-family:<?php echo $nz_main_font_family; ?>;
	}

	.nz-pricing-table > .column > .pricing > .price,
	.nz-content-box > .nz-box .box-title,
	.nz-persons .person .name,
	.nz-circle .title,
	.single-post .post-meta > .post-author a:hover,
	.single-post .post-meta > .post-category a:hover,
	.single-post .post-meta > .post-comments a:hover,
	.search-r .post-meta > .post-author a:hover,
	.search-r .post-meta > .post-category a:hover,
	.search-r .post-meta > .post-comments a:hover,
	.post-comments-area a:hover,
	.posted_in a:hover,
	.tagged_as a:hover,
	.product-name a:hover {
		color: <?php echo $nz_headings_color; ?>;
	}

	#top:hover,
	#ninzio-slider:hover .controls:hover
	{background-color: <?php echo $nz_color; ?>;}

	.nz-pricing-table .column .title {
		font-family:<?php echo $nz_headings_font_family; ?>;
	}

	.woocommerce .products .product h3 {
		font-size: <?php echo $nz_h4_font_size; ?>; line-height: <?php echo $nz_h4_line_height; ?>;
	}

/*  BACKGROUND
/*====================================================================*/

	html {
		background-color:<?php echo $nz_site_back_col; ?>;
		<?php if(!empty($nz_site_back_img)): ?>
			background-image:url(<?php echo $nz_site_back_img; ?>);
			background-repeat:<?php echo $nz_site_back_r; ?>;
			background-attachment: <?php echo $nz_site_back_a; ?>;
			-webkit-background-size: <?php echo $nz_site_back_s; ?>;
			-moz-background-size: <?php echo $nz_site_back_s; ?>;
			background-size: <?php echo $nz_site_back_s; ?>;
			background-position:<?php echo $nz_site_back_p; ?>;
		<?php endif; ?>
	}

/*  COLOR
/*====================================================================*/

	a:not(.button) {color:<?php echo $nz_color; ?>;}

	blockquote {
		border-left-color:<?php echo $nz_color; ?>;
	}
	
	::-moz-selection {
		background-color:<?php echo $nz_color; ?>;
		color: #ffffff;
	}

	::selection {
		background-color:<?php echo $nz_color; ?>;
		color: #ffffff;
	}

	.nz-persons .person .name:after,
	.nz-testimonials .name:before,
	.nz-highlight,
	.nz-thumbnail .post-date,
	.nz-recent-posts .ninzio-overlay:before,
	.nz-recent-portfolio .ninzio-overlay:before,
	.blog-post .post .ninzio-overlay:before,
	.nz-portfolio-posts .portfolio .ninzio-overlay:before,
	.nz-gallery .gallery-item .ninzio-overlay:before,
	.nz-recent-portfolio .project-details,
	.loop .nz-portfolio-posts .project-details,
	.one-page-bullets a[href*="#"]:after,
	.wp-caption .wp-caption-text,
	.nz-media-slider .flex-direction-nav a:hover,
	.post-gallery .flex-direction-nav a:hover,
	.flickr_badge_image .ninzio-overlay,
	.widget_recent_portfolio .ninzio-overlay,
	.post-gallery .post-date,
	.single-details .nz-i-list.square span.icon,
	.woocommerce .product .onsale,
	.woocommerce .product .ninzio-overlay:before,
	.ui-slider .ui-slider-range,
	.desk .cart-info,
	.post-sticky {
		background-color:<?php echo $nz_color; ?>;
	}

	.one-page-bullets a[href*="#"]:before {
		border-color: transparent transparent transparent <?php echo $nz_color; ?>;
	}

	.mejs-controls .mejs-time-rail .mejs-time-loaded {
		background-color:<?php echo $nz_color; ?> !important;
	}

	.ninzio-overlay
	{background-color: <?php echo ninzio_hex_to_rgba($nz_color, 0.8); ?>;}

	.nz-tabs .tabset .tab.active,
	.nz-accordion .active.toggle-title,
	.woocommerce-tabs .tabs > li.active  {
		border-bottom-color:<?php echo $nz_color; ?> !important;
		color:<?php echo $nz_color; ?>;
	}

	.nz-testimonials .flex-control-nav li a.flex-active:before,
	.nz-testimonials .flex-control-nav li a:hover:before {
		box-shadow: inset 0 0 0 2px <?php echo $nz_color; ?>;
	}

	.nz-pricing-table > .column > .title,
	.error404-status,
	.comment-author,
	.woocommerce .product .amount,
	.woocommerce .star-rating {
		color:<?php echo $nz_color; ?>;
	}

	.post-tags a:hover {
		border-color: <?php echo $nz_color; ?>;
		color: <?php echo $nz_color; ?> !important;
	}

	.post-author-info-title a,
	.loop .port-cat a:hover,
	.single-details .nz-i-list a:hover,
	.woocommerce-tabs .tabs > li.active a
	{color: <?php echo $nz_color; ?> !important;}

	.post-author-info-title a:hover
	{color: <?php echo $nz_headings_color; ?> !important;}

	button,
	input[type="reset"],
	input[type="submit"],
	input[type="button"],
	.button {
		font-family: <?php echo $nz_button_typo; ?>;
		font-weight: <?php echo $nz_button_fw; ?>;
	}

	.btn-normal button,
	.btn-normal input[type="reset"],
	.btn-normal input[type="submit"],
	.btn-normal input[type="button"],
	.btn-ghost button:hover,
	.btn-ghost input[type="reset"]:hover,
	.btn-ghost input[type="submit"]:hover,
	.btn-ghost input[type="button"]:hover,
	.button-normal,
	.animate-false.button-ghost:hover,
	.btn-normal .project-link,
	.btn-normal .search-button,
	.btn-ghost .project-link:hover,
	.btn-ghost .search-button:hover,
	.btn-normal .wc-forward,
	.btn-ghost .wc-forward:hover,
	.search-r .post-indication
	{background-color: <?php echo $nz_color; ?>;}

	.btn-ghost button,
	.btn-ghost input[type="reset"],
	.btn-ghost input[type="submit"],
	.btn-ghost input[type="button"],
	.button-ghost,
	.btn-ghost .project-link,
	.btn-ghost .search-button,
	.btn-ghost .wc-forward {
		box-shadow:inset 0 0 0 2px <?php echo $nz_color; ?>;
		color: <?php echo $nz_color; ?>;
	}

	.btn-ghost .wc-forward {color: <?php echo $nz_color; ?> !important;}

	.portfolio-archive-filter .button:hover,
	.portfolio-archive-filter .button.active {
		box-shadow:inset 0 0 0 2px <?php echo $nz_color; ?> !important;
		background-color: <?php echo $nz_color; ?> !important;
	}

	.btn-3d button,
	.btn-3d input[type="reset"],
	.btn-3d input[type="submit"],
	.btn-3d input[type="button"],
	.button-3d,
	.btn-3d .project-link,
	.btn-3d .search-button,
	.btn-3d .wc-forward {
		background-color: <?php echo $nz_color; ?>;
		box-shadow: 0 4px <?php echo ninzio_hex_to_rgb_shade($nz_color,20); ?>;
	}

	.btn-3d button:hover,
	.btn-3d input[type="reset"]:hover,
	.btn-3d input[type="submit"]:hover,
	.btn-3d input[type="button"]:hover,
	.button-3d.animate-false:hover,
	.btn-3d .project-link:hover,
	.btn-3d .search-button:hover,
	.btn-3d .wc-forward:hover
	{box-shadow: 0 2px <?php echo ninzio_hex_to_rgb_shade($nz_color,20); ?>;}

	.nz-mailchimp input[type="submit"]:hover
	{background-color:<?php echo ninzio_hex_to_rgb_shade($nz_color,20); ?>;}

	.ninzio-navigation li a:hover,
	.ninzio-navigation li span.current,
	.woocommerce-pagination li a:hover,
	.woocommerce-pagination li span.current {
		background-color: <?php echo $nz_color; ?>;
	}

/*  TYPOGRAPHY
/*====================================================================*/
	
	body, button, input, pre, code, kbd, samp, dt {
		font-size: <?php echo $nz_main_font_size; ?>;
		line-height: <?php echo $nz_main_line_height; ?>;
		font-family:<?php echo $nz_main_font_family; ?>;
		color: <?php echo $nz_main_color; ?>;
	}

	textarea {
		color: <?php echo $nz_main_color; ?>;
	}

	h1,h2,h3,h4,h5,h6 {
		font-family:<?php echo $nz_headings_font_family; ?>;
		color: <?php echo $nz_headings_color; ?>;
		text-transform: <?php echo $nz_headings_text_transform; ?>;
	}

	h1 {font-size: <?php echo $nz_h1_font_size; ?>; line-height: <?php echo $nz_h1_line_height; ?>;}
	h2 {font-size: <?php echo $nz_h2_font_size; ?>; line-height: <?php echo $nz_h2_line_height; ?>;}
	h3 {font-size: <?php echo $nz_h3_font_size; ?>; line-height: <?php echo $nz_h3_line_height; ?>;}
	h4 {font-size: <?php echo $nz_h4_font_size; ?>; line-height: <?php echo $nz_h4_line_height; ?>;}
	h5 {font-size: <?php echo $nz_h5_font_size; ?>; line-height: <?php echo $nz_h5_line_height; ?>;}
	h6 {font-size: <?php echo $nz_h6_font_size; ?>; line-height: <?php echo $nz_h6_line_height; ?>;}

/*  HEADER
/*====================================================================*/

	.mob-header {background-color: <?php echo $nz_mob_header_back; ?>;}
	.mob-header .logo-toggle {height: <?php echo $nz_mob_height; ?>px;}

	.mob-header .menu-toggle span,
	.mob-header .sidebar-toggle span
	{background-color: <?php echo $nz_mob_toggle_color; ?>;}

	.mob-menu li a {
		color: <?php echo $nz_mob_menu_color_reg; ?>;
		background-color: <?php echo $nz_mob_menu_back_reg; ?>;
		text-transform: <?php echo $nz_mob_menu_text_transform; ?>;
		font-weight: <?php echo $nz_mob_menu_font_weight; ?>;
		font-size: <?php echo $nz_mob_menu_font_size; ?>;
		line-height: <?php echo $nz_mob_menu_line_height; ?>;
		font-family: <?php echo $nz_mob_menu_font_family; ?>;
		border-bottom: 1px solid <?php echo ninzio_hex_to_rgba($nz_mob_menu_color_reg, 0.1); ?>;
	}
	.mob-menu ul ul > li > a {
		text-transform: <?php echo $nz_mob_submenu_text_transform; ?>;
		font-weight: <?php echo $nz_mob_submenu_font_weight; ?>;
		font-size: <?php echo $nz_mob_submenu_font_size; ?>;
		line-height: <?php echo $nz_mob_submenu_line_height; ?>;
		font-family: <?php echo $nz_mob_submenu_font_family; ?>;
	}
	.mob-menu li a:hover {
		color: <?php echo $nz_mob_menu_color_hov; ?>;
		background-color: <?php echo $nz_mob_menu_back_hov; ?>;
	}

	.mob-int-true .mob-menu ul li > a > .di {
		background-color: <?php echo ninzio_hex_to_rgba($nz_mob_menu_color_reg, 0.1); ?>;
	}

	.mob-search-true .search {
		background-color: <?php echo $nz_mob_menu_back_reg; ?>;
	}

	.mob-search-true .search,
	.mob-search-true .search .icon-search2 {
		color: <?php echo $nz_mob_menu_color_reg; ?>;
	}

	.mob-search-true .search input[type="text"] {
		border-color: <?php echo ninzio_hex_to_rgba($nz_mob_menu_color_reg, 0.1); ?>;
		color: <?php echo $nz_mob_menu_color_reg; ?>;
	}

	.mob-search-true .search input[type="text"]:focus {
		background-color: <?php echo $nz_mob_menu_back_hov; ?>;
	}

/*  WIDGET AREAS
/*====================================================================*/

	.widget_title,
	.widget_rss .widget_title a
	{color: <?php echo $nz_headings_color; ?>;}

	.sidebar:not(.single-details) a
	{color: <?php echo $nz_main_color; ?>;}

	.sidebar:not(.single-details) a:hover,
	.widget_nav_menu ul li a:hover,
	.widget_rss a:hover,
	.widget_nz_recent_entries a:hover,
	.widget_recent_entries a:hover,
	.widget_recent_comments a:hover,
	.widget_twitter ul li a:hover,
	.widget_categories ul li a:hover,
	.widget_pages ul li a:hover,
	.widget_archive ul li a:hover,
	.widget_mailchimp #mc-embedded-subscribe:hover + .icon-plus,
	.widget_search #searchsubmit:hover + .icon-search22,
	.widget_product_search form:hover:after
	{color: <?php echo $nz_color; ?>;}

	.widget_icl_lang_sel_widget li a:hover 
	{color: <?php echo $nz_color; ?> !important;}

	.widget_icl_lang_sel_widget a
	{color: <?php echo $nz_main_color; ?> !important;}

	.widget_tag_cloud .tagcloud a:hover,
	.widget_product_tag_cloud .tagcloud a:hover {
		color: <?php echo $nz_color; ?> !important;
		border-color: <?php echo $nz_color; ?>;
	}

	.widget_categories ul li a:before,
	.widget_pages ul li a:before,
	.widget_archive ul li a:before,
	.widget_product_categories ul li a:before,
	.widget_layered_nav ul li a:before,
	.widget_layered_nav_filters ul li a:before
	{background-color: <?php echo ninzio_hex_to_rgba($nz_main_color, 0.5); ?>;}

	.widget_calendar td#today 
	{background-color:<?php echo ninzio_hex_to_rgba($nz_main_color, 0.1); ?>;}

	.widget_twitter ul li:before 
	{color: <?php echo ninzio_hex_to_rgba($nz_main_color, 0.3); ?>;}

	.main-widget-area 
	{background-color: <?php echo $nz_sidebar_back; ?>;}
	
	.ps-container .ps-scrollbar-y 
	{background-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.6); ?>;}
	.ps-container .ps-scrollbar-y-rail:hover,
	.ps-container .ps-scrollbar-y-rail.hover,
	.ps-container .ps-scrollbar-y-rail.in-scrolling
	{background-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.4); ?>;}
	.ps-container .ps-scrollbar-y-rail:hover .ps-scrollbar-y,
	.ps-container .ps-scrollbar-y-rail.hover .ps-scrollbar-y
	{background-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.7); ?>;}

	.main-widget-area .widget_title {
		color: <?php echo $nz_sidebar_title_color; ?>;
		border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;
	}

	.main-widget-area .widget_nav_menu ul li a {
		border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;
	}

	.main-widget-area .widget_nav_menu ul.menu > li:first-child > a {
		border-top-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;
	}

	.main-widget-area .widget_icl_lang_sel_widget a 
	{color: <?php echo $nz_sidebar_color; ?> !important;}

	.main-widget-area .widget_rss .widget_title a 
	{color: <?php echo $nz_sidebar_title_color; ?>;}

	.main-widget-area,
	.main-widget-area a
	{color: <?php echo $nz_sidebar_color; ?>;}

	.main-widget-area a:hover,
	.main-widget-area .widget_nav_menu ul li a:hover,
	.main-widget-area .widget_rss a:hover,
	.main-widget-area .widget_nz_recent_entries a:hover,
	.main-widget-area .widget_recent_entries a:hover,
	.main-widget-area .widget_recent_comments a:hover,
	.main-widget-area .widget_twitter ul li a:hover,
	.main-widget-area .widget_categories ul li a:hover,
	.main-widget-area .widget_pages ul li a:hover,
	.main-widget-area .widget_archive ul li a:hover,
	.main-widget-area .widget_mailchimp #mc-embedded-subscribe:hover + .icon-plus,
	.main-widget-area .widget_search .icon-search2:hover,
	.main-widget-area .widget_search #searchsubmit:hover + .icon-search2,
	.main-widget-area .widget_product_search form:hover:after,
	.main-widget-area .woocommerce .star-rating
	{color: <?php echo $nz_sidebar_hover; ?>;}

	.main-widget-area .widget_icl_lang_sel_widget li a:hover 
	{color: <?php echo $nz_sidebar_hover; ?> !important;}

	.main-widget-area .widget_icl_lang_sel_widget a,
	.main-widget-area .widget_tag_cloud .tagcloud a,
	.main-widget-area .widget_product_tag_cloud .tagcloud a
	{color: <?php echo $nz_sidebar_color; ?> !important;}

	.main-widget-area .widget_tag_cloud .tagcloud a,
	.main-widget-area .widget_product_tag_cloud .tagcloud a {
		border-color:<?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;
	}

	.main-widget-area .widget_tag_cloud .tagcloud a:hover,
	.main-widget-area .widget_product_tag_cloud .tagcloud a:hover {
		color: <?php echo $nz_sidebar_hover; ?> !important;
		border-color: <?php echo $nz_sidebar_hover; ?>;
	}

	.main-widget-area textarea,
	.main-widget-area select,
	.main-widget-area input[type="date"],
	.main-widget-area input[type="datetime"],
	.main-widget-area input[type="datetime-local"],
	.main-widget-area input[type="email"],
	.main-widget-area input[type="month"],
	.main-widget-area input[type="number"],
	.main-widget-area input[type="password"],
	.main-widget-area input[type="search"],
	.main-widget-area input[type="tel"],
	.main-widget-area input[type="text"],
	.main-widget-area input[type="time"],
	.main-widget-area input[type="url"],
	.main-widget-area input[type="week"],
	.main-widget-area .widget_icl_lang_sel_widget > div > ul > li:first-child,
	.main-widget-area .widget_price_filter .price_slider_amount .price_label {
		border-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;
		color: <?php echo $nz_sidebar_color; ?>;
	}

	.main-widget-area textarea:focus,
	.main-widget-area select:focus,
	.main-widget-area input[type="date"]:focus,
	.main-widget-area input[type="datetime"]:focus,
	.main-widget-area input[type="datetime-local"]:focus,
	.main-widget-area input[type="email"]:focus,
	.main-widget-area input[type="month"]:focus,
	.main-widget-area input[type="number"]:focus,
	.main-widget-area input[type="password"]:focus,
	.main-widget-area input[type="search"]:focus,
	.main-widget-area input[type="tel"]:focus,
	.main-widget-area input[type="text"]:focus,
	.main-widget-area input[type="time"]:focus,
	.main-widget-area input[type="url"]:focus,
	.main-widget-area input[type="week"]:focus
	{border-color: <?php echo $nz_sidebar_color; ?>;}

	.main-widget-area .widget_categories ul li a:before,
	.main-widget-area .widget_pages ul li a:before,
	.main-widget-area .widget_archive ul li a:before
	{background-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.5); ?>;}

	.main-widget-area .widget_calendar th:first-child 
	{border-left-color:<?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;}
	.main-widget-area .widget_calendar th:last-child 
	{border-right-color:<?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;}
		
	.main-widget-area .widget_calendar td,
	.main-widget-area .widget_calendar td#prev,
	.main-widget-area .widget_calendar td#next,
	.main-widget-area .widget_calendar caption,
	.main-widget-area .widget_nz_recent_entries .post-date,
	.main-widget-area .widget_tag_cloud .tagcloud a,
	.main-widget-area .widget_twitter ul li:before,
	.main-widget-area .widget_shopping_cart .cart_list > li,
	.main-widget-area .widget_products .product_list_widget > li,
	.main-widget-area .widget_recently_viewed_products .product_list_widget > li,
	.main-widget-area .widget_recent_reviews .product_list_widget > li,
	.main-widget-area .widget_top_rated_products .product_list_widget > li
	{border-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;}

	.main-widget-area .widget_calendar td#today 
	{background-color:<?php echo ninzio_hex_to_rgba($nz_sidebar_hover, 0.1); ?>;}

	.main-widget-area .widget_rss ul li,
	.main-widget-area .widget_nz_recent_entries ul li,
	.main-widget-area .widget_recent_entries ul li,
	.main-widget-area .widget_recent_comments ul li,
	.main-widget-area .widget_twitter ul li 
	{border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;}

	.main-widget-area .widget_twitter ul li:before 
	{color: <?php echo ninzio_hex_to_rgba($nz_sidebar_color, 0.3); ?>;}

	.main-widget-area .widget_facebook .fb-like-box,
	.main-widget-area .widget_facebook .fb-like-box span,
	.main-widget-area .widget_facebook .fb-like-box span iframe
	{background-color: <?php echo $nz_sidebar_back; ?>;}

	.footer {
		background-color: <?php echo $nz_footer_back; ?>;
		color: <?php echo $nz_footer_color; ?>;
	}

	.footer .social-links a,
	.footer .footer-menu ul li a
	{color: <?php echo $nz_footer_color; ?> !important;}

	.footer .social-links a:hover,
	.footer .footer-menu a:hover
	{color:<?php echo $nz_footer_color_hover; ?> !important;}

	.footer-widget-area 
	{background-color: <?php echo $nz_footer_wa_back; ?>;}

	.footer-widget-area .widget_title {
		color: <?php echo $nz_footer_wat_color; ?>;
		border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;
	}

	.footer-widget-area .widget_nav_menu ul li a {
		border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;
	}

	.footer-widget-area .widget_nav_menu ul.menu > li:first-child > a {
		border-top-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;
	}

	.footer-widget-area .widget_rss .widget_title a 
	{color: <?php echo $nz_footer_wat_color; ?>;}

	.footer-widget-area,
	.footer-widget-area a:not(.button)
	{color: <?php echo $nz_footer_wa_color; ?>;}

	.footer-widget-area a:not(.button):hover,
	.footer-widget-area .widget_nav_menu ul li a:hover 
	{color: <?php echo $nz_footer_wa_hover; ?>;}

	.footer-widget-area .widget_rss a:hover,
	.footer-widget-area .widget_nz_recent_entries a:hover,
	.footer-widget-area .widget_recent_entries a:hover,
	.footer-widget-area .widget_recent_comments a:hover,
	.footer-widget-area .widget_twitter ul li a:hover,
	.footer-widget-area .widget_categories ul li a:hover,
	.footer-widget-area .widget_pages ul li a:hover,
	.footer-widget-area .widget_archive ul li a:hover,
	.footer-widget-area .widget_mailchimp #mc-embedded-subscribe:hover + .icon-plus,
	.footer-widget-area .widget_search .icon-search2:hover,
	.footer-widget-area .widget_search #searchsubmit:hover + .icon-search2,
	.footer-widget-area .widget_product_search form:hover:after,
	.footer-widget-area .woocommerce .star-rating
	{color: <?php echo $nz_footer_wa_hover; ?>;}

	.footer-widget-area .widget_icl_lang_sel_widget li a:hover 
	{color: <?php echo $nz_footer_wa_hover; ?> !important;}

	.footer-widget-area .widget_icl_lang_sel_widget a,
	.footer-widget-area .widget_tag_cloud .tagcloud a,
	.footer-widget-area .widget_product_tag_cloud .tagcloud a
	{color: <?php echo $nz_footer_wa_color; ?> !important;}

	.footer-widget-area .widget_tag_cloud .tagcloud a,
	.footer-widget-area .widget_product_tag_cloud .tagcloud a {
		border-color:<?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;
	}

	.footer-widget-area .widget_tag_cloud .tagcloud a:hover,
	.footer-widget-area .widget_product_tag_cloud .tagcloud a:hover {
		color: <?php echo $nz_footer_wa_hover; ?> !important;
		border-color: <?php echo $nz_footer_wa_hover; ?>;
	}

	.footer-widget-area textarea,
	.footer-widget-area select,
	.footer-widget-area input[type="date"],
	.footer-widget-area input[type="datetime"],
	.footer-widget-area input[type="datetime-local"],
	.footer-widget-area input[type="email"],
	.footer-widget-area input[type="month"],
	.footer-widget-area input[type="number"],
	.footer-widget-area input[type="password"],
	.footer-widget-area input[type="search"],
	.footer-widget-area input[type="tel"],
	.footer-widget-area input[type="text"],
	.footer-widget-area input[type="time"],
	.footer-widget-area input[type="url"],
	.footer-widget-area input[type="week"],
	.footer-widget-area .widget_icl_lang_sel_widget > div > ul > li:first-child {
		border-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;
		color: <?php echo $nz_footer_wa_color; ?>;
	}

	.footer-widget-area textarea:focus,
	.footer-widget-area select:focus,
	.footer-widget-area input[type="date"]:focus,
	.footer-widget-area input[type="datetime"]:focus,
	.footer-widget-area input[type="datetime-local"]:focus,
	.footer-widget-area input[type="email"]:focus,
	.footer-widget-area input[type="month"]:focus,
	.footer-widget-area input[type="number"]:focus,
	.footer-widget-area input[type="password"]:focus,
	.footer-widget-area input[type="search"]:focus,
	.footer-widget-area input[type="tel"]:focus,
	.footer-widget-area input[type="text"]:focus,
	.footer-widget-area input[type="time"]:focus,
	.footer-widget-area input[type="url"]:focus,
	.footer-widget-area input[type="week"]:focus
	{border-color: <?php echo $nz_footer_wa_color; ?>;}

	.footer-widget-area .widget_categories ul li a:before,
	.footer-widget-area .widget_pages ul li a:before,
	.footer-widget-area .widget_archive ul li a:before
	{background-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.5); ?>;}

	.footer-widget-area .widget_calendar th:first-child 
	{border-left-color:<?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;}
	.footer-widget-area .widget_calendar th:last-child 
	{border-right-color:<?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;}
		
	.footer-widget-area .widget_calendar td,
	.footer-widget-area .widget_calendar td#prev,
	.footer-widget-area .widget_calendar td#next,
	.footer-widget-area .widget_calendar caption,
	.footer-widget-area .widget_nz_recent_entries .post-date,
	.footer-widget-area .widget_tag_cloud .tagcloud a,
	.footer-widget-area .widget_twitter ul li:before,
	.footer-widget-area .widget_shopping_cart .cart_list > li,
	.footer-widget-area .widget_products .product_list_widget > li,
	.footer-widget-area .widget_recently_viewed_products .product_list_widget > li,
	.footer-widget-area .widget_recent_reviews .product_list_widget > li,
	.footer-widget-area .widget_top_rated_products .product_list_widget > li
	{border-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;}

	.footer-widget-area .widget_calendar td#today 
	{background-color:<?php echo ninzio_hex_to_rgba($nz_footer_wa_hover, 0.1); ?>;}

	.footer-widget-area .widget_rss ul li,
	.footer-widget-area .widget_nz_recent_entries ul li,
	.footer-widget-area .widget_recent_entries ul li,
	.footer-widget-area .widget_recent_comments ul li,
	.footer-widget-area .widget_twitter ul li 
	{border-bottom-color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;}

	.footer-widget-area .widget_twitter ul li:before 
	{color: <?php echo ninzio_hex_to_rgba($nz_footer_wa_color, 0.3); ?>;}

	.footer-widget-area .widget_facebook .fb-like-box,
	.footer-widget-area .widget_facebook .fb-like-box span,
	.footer-widget-area .widget_facebook .fb-like-box span iframe
	{background-color: <?php echo $nz_footer_wa_back; ?>;}

/* RESPONSIVE
/*====================================================================*/

	<?php if(isset($nz_ninzio['custom-css-mob-port']) && !empty($nz_ninzio['custom-css-mob-port'])): ?>
		@media only screen and (max-width: 320px) {
			<?php echo $nz_ninzio['custom-css-mob-port']; ?>
		}
	<?php endif; ?>

	<?php if(isset($nz_ninzio['custom-css-mob-land']) && !empty($nz_ninzio['custom-css-mob-land'])): ?>
		@media only screen and (min-width: 321px) and (max-width: 480px) {
			<?php echo $nz_ninzio['custom-css-mob-land']; ?>
		}
	<?php endif; ?>

	<?php if(isset($nz_ninzio['custom-css-tab-port']) && !empty($nz_ninzio['custom-css-tab-port'])): ?>
		@media only screen and (min-width: 481px) and (max-width: 768px) {
			<?php echo $nz_ninzio['custom-css-tab-port']; ?>
		}
	<?php endif; ?>

	@media only screen and (min-width: 768px)  {

		.nz-row .col6 .nz-tabs.vertical .tab.active,
		.nz-row .col7 .nz-tabs.vertical .tab.active,
		.nz-row .col8 .nz-tabs.vertical .tabset .tab.active,
		.nz-row .col9 .nz-tabs.vertical .tabset .tab.active,
		.nz-row .col10 .nz-tabs.vertical .tabset .tab.active,
		.nz-row .col11 .nz-tabs.vertical .tabset .tab.active,
		.nz-row .col12 .nz-tabs.vertical .tabset .tab.active {
			border-right-color:<?php echo $nz_color; ?> !important;
			color:<?php echo $nz_color; ?>;
		}

	}

	<?php if(isset($nz_ninzio['custom-css-tab-land']) && !empty($nz_ninzio['custom-css-tab-land'])): ?>
		@media only screen and (min-width: 769px) and (max-width: 1024px) {
			<?php echo $nz_ninzio['custom-css-tab-land']; ?>
		}
	<?php endif; ?>

	@media only screen and (min-width: 1024px)  {

		.footer .social-links a {
			border-right-color:<?php echo ninzio_hex_to_rgba($nz_footer_color, 0.1); ?>;
			border-bottom-color:<?php echo ninzio_hex_to_rgba($nz_footer_color, 0.1); ?>;
		}

		.footer .social-links a:first-child {
			border-left-color:<?php echo ninzio_hex_to_rgba($nz_footer_color, 0.1); ?>;
		}

	}

	@media only screen and (max-width:1024px)  {

		.mob-header + .desk + .rich-header .parallax-container {
			-webkit-transform:translateY(-<?php echo (4*$nz_mob_height/10); ?>px);
			-moz-transform:translateY(-<?php echo (4*$nz_mob_height/10); ?>px);
			transform:translateY(-<?php echo (4*$nz_mob_height/10); ?>px);
		}

	}
	
	@media only screen and (min-width:1025px)  {

		.desk .header-top {background-color:<?php echo $nz_desk_top_back; ?>;}
		.desk-slogan {color: <?php echo $nz_desk_top_color; ?>;}
		
		.desk .social-links a,
		.desk .ls a {
			color: <?php echo $nz_desk_sl_color_reg; ?> !important;
		}

		.desk .social-links a,
		.desk .ls > div > ul > li > a,
		.desk .ls > div.lang_sel_list_vertical > ul > li:last-child > a,
		.desk .ls > div.lang_sel_list_horizontal > ul > li:last-child > a {
			border-color: <?php echo ninzio_hex_to_rgba($nz_desk_sl_color_reg, 0.1); ?> !important;
		}

		.desk .ls a {
			font-size: <?php echo $nz_main_font_size; ?> !important;
			font-family:<?php echo $nz_main_font_family; ?>;
		}

		<?php if($nz_ninzio['desk-top-back']['alpha'] == "0.00"): ?>
			.desk .ls ul ul a,
			.desk #lang_sel_click .lang_sel_sel {background-color:<?php echo $nz_desk_sl_back_hov; ?> !important;}
		<?php else: ?>
			.desk .ls ul ul a,
			.desk #lang_sel_click .lang_sel_sel {background-color:<?php echo $nz_desk_top_back; ?> !important;}
		<?php endif; ?>

		.desk .social-links a:hover,
		.desk .ls li:hover > a,
		.desk #lang_sel_click li:hover > .lang_sel_sel {
			color: <?php echo $nz_desk_sl_color_hov; ?> !important;
			background-color:<?php echo $nz_desk_sl_back_hov; ?> !important;
		}

		.desk .ls ul ul {width: <?php echo $nz_desk_ls_w; ?> !important;}

		.desk {height: <?php echo $nz_desk_height; ?>px;}
		.desk.top-true {height: <?php echo $nz_desk_height+40; ?>px;}

		.desk .header-content {
			background-color: <?php echo $nz_desk_back; ?>;
			height: <?php echo $nz_desk_height; ?>px;
		}

		.desk:not(.stuck-true) + .rich-header .parallax-container {
			-webkit-transform:translateY(-<?php echo (4*$nz_desk_height/10); ?>px);
			-moz-transform:translateY(-<?php echo (4*$nz_desk_height/10); ?>px);
			transform:translateY(-<?php echo (4*$nz_desk_height/10); ?>px);
		}

		.desk.top-true:not(.stuck-true) + .rich-header .parallax-container {
			-webkit-transform:translateY(-<?php echo (4*($nz_desk_height+40)/10); ?>px);
			-moz-transform:translateY(-<?php echo (4*($nz_desk_height+40)/10); ?>px);
			transform:translateY(-<?php echo (4*($nz_desk_height+40)/10); ?>px);
		}

		.desk-menu > ul > li,
		.desk .cart-toggle {
			line-height: <?php echo $nz_desk_height; ?>px;
			height: <?php echo $nz_desk_height; ?>px;
		}

		.desk-menu > ul > li > a,
		.desk .cart-toggle .cart-contents {
			color: <?php echo $nz_desk_menu_color_reg; ?>;
			text-transform: <?php echo $nz_desk_menu_text_transform; ?>;
			font-weight: <?php echo $nz_desk_menu_font_weight; ?>;
			font-size: <?php echo $nz_desk_menu_font_size; ?>;
			font-family: <?php echo $nz_desk_menu_font_family; ?>;
			padding-right:<?php echo $nz_desk_menu_p; ?>px;
			padding-left:<?php echo $nz_desk_menu_p; ?>px;
		}

		.sidebar-toggle span {background-color: <?php echo $nz_desk_menu_color_reg; ?>;}

		.desk .search span {font-size: <?php echo $nz_small_font_size; ?>;}

		.desk-menu > ul > li:hover > a,
		.desk-menu > ul > li.one-page-active > a
		{color: <?php echo $nz_desk_menu_color_hov; ?>;}

		.desk-di-true .desk-menu > ul > li > a:not(:only-child) {
			padding-right:<?php echo ($nz_desk_menu_p+15); ?>px;
			padding-left:<?php echo $nz_desk_menu_p; ?>px;
		}

		.desk-menu > ul > li > a > .di {right: <?php echo ($nz_desk_menu_p+3)/2; ?>px;}
		.desk-menu > ul > li {margin-right:<?php echo $nz_desk_menu_m; ?>px;}

		.desk .cart-toggle .cart-contents,
		.desk .search-toggle 
		{margin-left:<?php echo $nz_desk_menu_m; ?>px;}

		.desk .search-toggle,
		.desk .search span:before,
		.desk .search input[type="text"] 
		{color: <?php echo $nz_desk_menu_color_reg; ?>;}

		.desk.effect-underline .desk-menu > ul > li > a:after,
		.desk.effect-fill .desk-menu > ul > li:hover,
		.desk.effect-fill .desk-menu > ul > li.one-page-active,
		.desk.effect-fill-boxed .desk-menu > ul > li:hover > a,
		.desk.effect-fill-boxed .desk-menu > ul > li.one-page-active > a,
		.desk.effect-line .desk-menu > ul > li > a:after
		{background-color: <?php echo $nz_desk_menu_effect_color; ?>;}

		.desk.effect-outline .desk-menu > ul > li > a:after 
		{border-color: <?php echo $nz_desk_menu_effect_color; ?>;}

		.desk-menu > ul > li > .sub-menu,
		.desk .cart-dropdown 
		{top:<?php echo $nz_desk_height; ?>px;}

		.desk-menu .sub-menu li {line-height: <?php echo $nz_desk_submenu_line_height; ?>;}

		.desk-menu .sub-menu li > a {
			color: <?php echo $nz_desk_submenu_color_reg; ?>;
			background-color: <?php echo $nz_desk_submenu_back; ?>;
			border-bottom-color:<?php echo $nz_desk_submenu_border_col; ?>;
			text-transform: <?php echo $nz_desk_submenu_text_transform; ?>;
			font-weight: <?php echo $nz_desk_submenu_font_weight; ?>;
			font-size: <?php echo $nz_desk_submenu_font_size; ?>;
			font-family: <?php echo $nz_desk_submenu_font_family; ?>;
			line-height: <?php echo $nz_desk_submenu_line_height; ?>;
		}

		.desk .cart-dropdown {
			background-color: <?php echo $nz_desk_submenu_back; ?>;
			color: <?php echo $nz_desk_submenu_color_reg; ?>;
			font-weight: <?php echo $nz_desk_submenu_font_weight; ?>;
			font-size: <?php echo $nz_desk_submenu_font_size; ?>;
			font-family: <?php echo $nz_desk_submenu_font_family; ?>;
			line-height: <?php echo $nz_desk_submenu_line_height; ?>;
		}

		.desk .cart-dropdown .widget_shopping_cart .cart_list > li:not(.empty) {
			border-bottom-color:<?php echo $nz_desk_submenu_border_col; ?>;
		}

		.desk .cart-dropdown .widget_shopping_cart .cart_list > li > a {
			color: <?php echo $nz_desk_submenu_color_reg; ?>;
		}

		.desk-menu .megamenu .sub-menu li:hover > a {
			color: <?php echo $nz_desk_submenu_color_reg; ?>;
			background-color: <?php echo $nz_desk_submenu_back; ?>;
		}

		.desk-menu .sub-menu li:hover > a,
		.desk-menu .megamenu .sub-menu li > a:hover {
			color: <?php echo $nz_desk_submenu_color_hov; ?>;
			background-color: <?php echo $nz_desk_submenu_back_hov; ?>;
		}

		.desk-menu > ul > .megamenu > ul > li 
		{border-right-color: <?php echo $nz_desk_submenu_border_col; ?>;}

		.desk-menu > ul > .megamenu > ul
		{background-color: <?php echo $nz_desk_submenu_back; ?>;}

		.desk-menu .megamenu > .sub-menu > li:last-child > a 
		{border-bottom-color:<?php echo $nz_desk_submenu_border_col; ?> !important;}

		.desk-menu .megamenu > .sub-menu > li > a {
			text-transform: <?php echo $nz_desk_megamenu_text_transform; ?>;
			font-weight: <?php echo $nz_desk_megamenu_font_weight; ?>;
		}

		.desk-menu .megamenu > .sub-menu .sub-menu > li > a {
			text-transform: <?php echo $nz_desk_megamenu_sub_text_transform; ?>;
			font-weight: <?php echo $nz_desk_megamenu_sub_font_weight; ?>;
		}

		.stuck-true .header-top {background-color:<?php echo $nz_stuck_top_back; ?>;}
		.stuck-true-slogan {color: <?php echo $nz_stuck_top_color; ?>;}
		
		.stuck-true .social-links a,
		.stuck-true .ls a {
			color: <?php echo $nz_stuck_sl_color_reg; ?> !important;
		}

		.stuck-true .social-links a,
		.stuck-true .ls > div > ul > li > a,
		.stuck-true .ls > div.lang_sel_list_vertical > ul > li:last-child > a,
		.stuck-true .ls > div.lang_sel_list_horizontal > ul > li:last-child > a {
			border-color: <?php echo ninzio_hex_to_rgba($nz_stuck_sl_color_reg, 0.1); ?> !important;
		}

		<?php if($nz_ninzio['stuck-true-top-back']['alpha'] == "0.00"): ?>
			.stuck-true .ls ul ul a,
			.stuck-true #lang_sel_click .lang_sel_sel {background-color:<?php echo $nz_stuck_sl_back_hov; ?> !important;}
		<?php else: ?>
			.stuck-true .ls ul ul a,
			.stuck-true #lang_sel_click .lang_sel_sel {background-color:<?php echo $nz_stuck_top_back; ?> !important;}
		<?php endif; ?>

		.stuck-true .social-links a:hover,
		.stuck-true .ls li:hover > a,
		.stuck-true #lang_sel_click li:hover > .lang_sel_sel {
			color: <?php echo $nz_stuck_sl_color_hov; ?> !important;
			background-color:<?php echo $nz_stuck_sl_back_hov; ?> !important;
		}

		.stuck-true {height: <?php echo $nz_stuck_height; ?>px;}
		.stuck-true.stuck-top-true {height: <?php echo $nz_stuck_height+40; ?>px;}

		.stuck-true .header-content {
			background-color: <?php echo $nz_stuck_back; ?>;
			height: <?php echo $nz_stuck_height; ?>px;
		}

		.stuck-true + .rich-header .page-title-content,
		.stuck-true + .rich-header .ninzio-nav-single {
			margin-top:<?php echo $nz_stuck_height/2; ?>px; 
		}

		.stuck-true .desk-menu > ul > li > a,
		.stuck-true .cart-toggle .cart-contents 
		{color: <?php echo $nz_stuck_menu_color_reg; ?>;}
		.stuck-true .desk-menu > ul > li:hover > a,
		.stuck-true .desk-menu > ul > li.one-page-active > a 
		{color: <?php echo $nz_stuck_menu_color_hov; ?>;}

		.stuck-true .sidebar-toggle span {background-color: <?php echo $nz_stuck_menu_color_reg; ?>;}

		.stuck-true .search-toggle,
		.stuck-true .search span:before,
		.stuck-true .search input[type="text"]
		{color: <?php echo $nz_stuck_menu_color_reg; ?>;}

		.stuck-true .desk-menu > ul > li,
		.stuck-true .cart-toggle {
			line-height: <?php echo $nz_stuck_height; ?>px;
			height: <?php echo $nz_stuck_height; ?>px;
		}
		
		.stuck-true.effect-underline .desk-menu > ul > li > a:after,
		.stuck-true.effect-fill .desk-menu > ul > li:hover,
		.stuck-true.effect-fill .desk-menu > ul > li.one-page-active,
		.stuck-true.effect-fill-boxed .desk-menu > ul > li:hover > a,
		.stuck-true.effect-fill-boxed .desk-menu > ul > li.one-page-active > a,
		.stuck-true.effect-line .desk-menu > ul > li > a:after
		{background-color: <?php echo $nz_stuck_menu_effect_color; ?>;}

		.stuck-true.effect-outline .desk-menu > ul > li > a:after
		{border-color: <?php echo $nz_stuck_menu_effect_color; ?>;}

		.stuck-true .desk-menu > ul > li > .sub-menu,
		.stuck-true .cart-dropdown 
		{top:<?php echo $nz_stuck_height; ?>px;}

		.stuck-true .desk-menu .sub-menu li > a {
			color: <?php echo $nz_stuck_submenu_color_reg; ?>;
			background-color: <?php echo $nz_stuck_submenu_back; ?>;
			border-bottom-color:<?php echo $nz_stuck_submenu_border_col; ?>;
		}

		.stuck-true .cart-dropdown {background-color: <?php echo $nz_stuck_submenu_back; ?>;}
		.stuck-true .cart-dropdown .widget_shopping_cart .cart_list > li:not(.empty) {border-bottom-color:<?php echo $nz_stuck_submenu_border_col; ?>;}
		.stuck-true .cart-dropdown .widget_shopping_cart .cart_list > li > a {color: <?php echo $nz_stuck_submenu_color_reg; ?>;}

		.stuck-true .desk-menu > ul > .megamenu > ul > li 
		{border-right-color: <?php echo $nz_stuck_submenu_border_col; ?>;}

		.stuck-true .desk-menu .megamenu .sub-menu li:hover > a {
			color: <?php echo $nz_stuck_submenu_color_reg; ?>;
			background-color: <?php echo $nz_stuck_submenu_back; ?>;
		}

		.stuck-true .desk-menu .sub-menu li:hover > a,
		.stuck-true .desk-menu .megamenu .sub-menu li > a:hover {
			color: <?php echo $nz_stuck_submenu_color_hov; ?>;
			background-color: <?php echo $nz_stuck_submenu_back_hov; ?>;
		}

		.stuck-true .desk-menu > ul > .megamenu > ul {background-color: <?php echo $nz_stuck_submenu_back; ?>;}
		.stuck-true .desk-menu .megamenu > .sub-menu > li:last-child > a {border-bottom-color:<?php echo $nz_stuck_submenu_border_col; ?> !important;}

		.blank-false .stuck-false + #ninzio-slider[data-autoheight="true"] {
			height:calc(100% - <?php echo $nz_desk_height; ?>px);
			height: calc(100vh - <?php echo $nz_desk_height; ?>px);
		}
		.blank-false .stuck-false + .admin-bar #ninzio-slider[data-autoheight="true"] {
			height:calc(100% - <?php echo $nz_desk_height+32; ?>px);
		}

		.blank-false .stuck-false.top-true + #ninzio-slider[data-autoheight="true"] {
			height:calc(100% - <?php echo $nz_desk_height+40; ?>px);
			height: calc(100vh - <?php echo $nz_desk_height+40; ?>px);
		}
		.blank-false .stuck-false.top-true + .admin-bar #ninzio-slider[data-autoheight="true"] {
			height:calc(100% - <?php echo $nz_desk_height+72; ?>px);
		}

		.fixed {height: <?php echo $nz_fixed_height; ?>px !important;}

		.fixed .header-content {
			background-color: <?php echo $nz_fixed_back; ?>;
			height: <?php echo $nz_fixed_height; ?>px;
		}

		.fixed .desk-menu > ul > li > a,
		.fixed .cart-toggle .cart-contents 
		{color: <?php echo $nz_fixed_menu_color_reg; ?>;}
		.fixed .desk-menu > ul > li:hover > a,
		.fixed .desk-menu > ul > li.one-page-active > a
		{color: <?php echo $nz_fixed_menu_color_hov; ?>;}

		.fixed .sidebar-toggle span {background-color: <?php echo $nz_fixed_menu_color_reg; ?>;}

		.fixed .search-toggle,
		.fixed .search span:before,
		.fixed .search input[type="text"]
		{color: <?php echo $nz_fixed_menu_color_reg; ?>;}

		.fixed .desk-menu > ul > li,
		.fixed .cart-toggle {
			line-height: <?php echo $nz_fixed_height; ?>px;
			height: <?php echo $nz_fixed_height; ?>px;
		}
		
		.fixed.effect-underline .desk-menu > ul > li > a:after,
		.fixed.effect-fill .desk-menu > ul > li:hover,
		.fixed.effect-fill .desk-menu > ul > li.one-page-active,
		.fixed.effect-fill-boxed .desk-menu > ul > li:hover > a,
		.fixed.effect-fill-boxed .desk-menu > ul > li.one-page-active > a,
		.fixed.effect-line .desk-menu > ul > li > a:after
		{background-color: <?php echo $nz_fixed_menu_effect_color; ?>;}

		.fixed.effect-outline .desk-menu > ul > li > a:after
		{border-color: <?php echo $nz_fixed_menu_effect_color; ?>;}

		.fixed .desk-menu > ul > li > .sub-menu,
		.fixed .cart-dropdown 
		{top:<?php echo $nz_fixed_height; ?>px;}

		.fixed .desk-menu .sub-menu li > a {
			color: <?php echo $nz_fixed_submenu_color_reg; ?>;
			background-color: <?php echo $nz_fixed_submenu_back; ?>;
			border-bottom-color:<?php echo $nz_fixed_submenu_border_col; ?>;
		}

		.fixed .cart-dropdown {background-color: <?php echo $nz_fixed_submenu_back; ?>;}
		.fixed .cart-dropdown .widget_shopping_cart .cart_list > li:not(.empty) {border-bottom-color:<?php echo $nz_fixed_submenu_border_col; ?>;}
		.fixed .cart-dropdown .widget_shopping_cart .cart_list > li > a {color: <?php echo $nz_fixed_submenu_color_reg; ?>;}

		.fixed .desk-menu > ul > .megamenu > ul > li 
		{border-right-color: <?php echo $nz_fixed_submenu_border_col; ?>;}

		.fixed .desk-menu .megamenu .sub-menu li:hover > a {
			color: <?php echo $nz_fixed_submenu_color_reg; ?>;
			background-color: <?php echo $nz_fixed_submenu_back; ?>;
		}

		.fixed .desk-menu .sub-menu li:hover > a,
		.fixed .desk-menu .megamenu .sub-menu li > a:hover {
			color: <?php echo $nz_fixed_submenu_color_hov; ?>;
			background-color: <?php echo $nz_fixed_submenu_back_hov; ?>;
		}

		.fixed .desk-menu > ul > .megamenu > ul {background-color: <?php echo $nz_fixed_submenu_back; ?>;}
		.fixed .desk-menu .megamenu > .sub-menu > li:last-child > a {border-bottom-color:<?php echo $nz_fixed_submenu_border_col; ?> !important;}

	}

</style>

