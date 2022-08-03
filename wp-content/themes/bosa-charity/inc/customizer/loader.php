<?php

function bosa_charity_default_styles(){

	// Begin Style
	$css = '<style>';

	$feature_posts_height = get_theme_mod( 'feature_posts_height', 320 );
	$css .= '
		.feature-posts-layout-one .feature-posts-image,
		.feature-posts-content-wrap .feature-posts-image {
			height: '. esc_attr( $feature_posts_height ) .'px;
			overflow: hidden;
		}
	';

	# Transparent Header Button
	if( !get_theme_mod( 'disable_header_button', false ) ){
		if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' ){
			$transparent_header_btn_defaults = array(
				array(
					'transparent_header_btn_type' 				=> 'button-outline',
					'transparent_header_home_btn_bg_color'		=> '#EB5A3E',
					'transparent_header_home_btn_border_color'	=> '#ffffff',
					'transparent_header_home_btn_text_color'	=> '#ffffff',
					'transparent_header_btn_bg_color'			=> '#EB5A3E',
					'transparent_header_btn_border_color'		=> '#1a1a1a',
					'transparent_header_btn_text_color'			=> '#1a1a1a',
					'transparent_header_btn_hover_color'		=> '#086abd',
					'transparent_header_btn_text' 				=> '',
					'transparent_header_btn_link' 				=> '',
					'transparent_header_btn_target'				=> true,
					'transparent_header_btn_radius'				=> 0,
				),		
			);
			$transparent_header_buttons = get_theme_mod( 'transparent_header_button_repeater', $transparent_header_btn_defaults );
			if( !empty( $transparent_header_buttons ) && is_array( $transparent_header_buttons ) ){
				$i = 1;
		    	foreach( $transparent_header_buttons as $value ){
		    		$transparent_header_btn_bg_color 		= $value['transparent_header_btn_bg_color'];
		    		$transparent_header_btn_border_color 	= $value['transparent_header_btn_border_color'];
		    		$transparent_header_btn_text_color 		= $value['transparent_header_btn_text_color'];
		    		$transparent_header_btn_hover_color 	= $value['transparent_header_btn_hover_color'];
		    		$transparent_header_btn_radius 			= $value['transparent_header_btn_radius'];
		    		if( $value['transparent_header_btn_type'] == 'button-primary' ){
				    		$css .= '
								.header-two.sticky-header .header-btn-'. $i .'.button-primary {
									background-color: '. esc_attr( $transparent_header_btn_bg_color ) .';
									color: '. esc_attr( $transparent_header_btn_text_color ) .';
								}
							';
					}elseif( $value['transparent_header_btn_type'] == 'button-outline' ){
						$css .= '
							.header-two.sticky-header .header-btn-'. $i .'.button-outline {
								border-color: '. esc_attr( $transparent_header_btn_border_color ) .';
								color: '. esc_attr( $transparent_header_btn_text_color ) .';
							}
						';
					}elseif( $value['transparent_header_btn_type'] == 'button-text' ){
						$css .= '
							.header-two.sticky-header .header-btn-'. $i .'.button-text {
								color: '. esc_attr( $transparent_header_btn_text_color ) .';
								padding: 0;
							}
						';
					}
					if( ( !get_theme_mod( 'disable_transparent_header_page', true ) && is_page() ) || ( !get_theme_mod( 'disable_transparent_header_post', true ) && is_single() ) || is_front_page() ){
						$transparent_header_btn_bg_color 		= $value['transparent_header_home_btn_bg_color'];
		    			$transparent_header_btn_border_color 	= $value['transparent_header_home_btn_border_color'];
		    			$transparent_header_btn_text_color 		= $value['transparent_header_home_btn_text_color'];
		    		}
		    		if( $value['transparent_header_btn_type'] == 'button-primary' ){
			    		$css .= '
							.site-header .header-btn-'. $i .'.button-primary {
								background-color: '. esc_attr( $transparent_header_btn_bg_color ) .';
								color: '. esc_attr( $transparent_header_btn_text_color ) .';
							}

							.site-header .header-btn-'. $i .'.button-primary:hover,
							.site-header .header-btn-'. $i .'.button-primary:focus,
							.site-header .header-btn-'. $i .'.button-primary:active,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-primary:hover,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-primary:focus,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-primary:active,
							.header-two.sticky-header .header-btn-'. $i .'.button-primary:hover,
							.header-two.sticky-header .header-btn-'. $i .'.button-primary:focus,
							.header-two.sticky-header .header-btn-'. $i .'.button-primary:active {
								background-color: '. esc_attr( $transparent_header_btn_hover_color ) .';
								color: #ffffff;
							}

							.site-header .header-btn-'. $i .'.button-primary {
								border-radius: '. esc_attr( $transparent_header_btn_radius ) .'px;
							}
						';
					}elseif( $value['transparent_header_btn_type'] == 'button-outline' ){
						$css .= '

							.site-header .header-btn-'. $i .'.button-outline {
								border-color: '. esc_attr( $transparent_header_btn_border_color ) .';
								color: '. esc_attr( $transparent_header_btn_text_color ) .';
							}

							.site-header .header-btn-'. $i .'.button-outline:hover,
							.site-header .header-btn-'. $i .'.button-outline:focus,
							.site-header .header-btn-'. $i .'.button-outline:active,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-outline:hover,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-outline:focus,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-outline:active,
							.header-two.sticky-header .header-btn-'. $i .'.button-outline:hover,
							.header-two.sticky-header .header-btn-'. $i .'.button-outline:focus,
							.header-two.sticky-header .header-btn-'. $i .'.button-outline:active {
								background-color: '. esc_attr( $transparent_header_btn_hover_color ) .';
								border-color: '. esc_attr( $transparent_header_btn_hover_color ) .';
								color: #ffffff;
							}

							.site-header .header-btn-'. $i .'.button-outline {
								border-radius: '. esc_attr( $transparent_header_btn_radius ) .'px;
							}
						';
					}elseif( $value['transparent_header_btn_type'] == 'button-text' ){
						$css .= '
							.site-header .header-btn-'. $i .'.button-text {
								color: '. esc_attr( $transparent_header_btn_text_color ) .';
								padding: 0;
							}
							.site-header .header-btn-'. $i .'.button-text:hover,
							.site-header .header-btn-'. $i .'.button-text:focus,
							.site-header .header-btn-'. $i .'.button-text:active,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-text:hover,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-text:focus,
							.site-header .offcanvas-menu-inner .header-btn-'. $i .'.button-text:active,
							.header-two.sticky-header .header-btn-'. $i .'.button-text:hover,
							.header-two.sticky-header .header-btn-'. $i .'.button-text:focus,
							.header-two.sticky-header .header-btn-'. $i .'.button-text:active {
								color: '. esc_attr( $transparent_header_btn_hover_color ) .';
							}
						';
					}
					$i++;
		    	}
		    }
		}
	}

	if( get_theme_mod( 'header_layout', 'header_two' ) == 'header_two' && ( is_front_page() || ( !get_theme_mod( 'disable_transparent_header_post', true ) && is_single() ) || ( !get_theme_mod( 'disable_transparent_header_page', true ) && is_page() ) ) && get_theme_mod( 'header_separate_logo', '' ) ){
		$css .= '
			.site-header .site-branding img {
				display: block;
			}
		';
	}

	// End Style
	$css .= '</style>';

	// return generated & compressed CSS
	echo str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css); 
}
add_action( 'wp_head', 'bosa_charity_default_styles', 99 );