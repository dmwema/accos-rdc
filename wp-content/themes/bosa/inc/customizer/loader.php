<?php
/**
* Loads all the comp3nts related to customizer 
*
* @since Bosa 1.0.0
*/

function bosa_modify_default_settings( $wp_customize ){

	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

}
add_action( 'customize_register', 'bosa_modify_default_settings' );

if( !function_exists( 'bosa_hex2rgba' ) ):
/**
* Convert hexdec color string to rgb(a) string
*/
function bosa_hex2rgba($color, $opacity = false) {
 
    $default = 'rgba(0,0,0, 0.1)';
 
    # Return default if no color provided
    if( empty( $color ) )
          return $default; 
 
    # Sanitize $color if "#" is provided 
    if ( $color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    # Check if color has 6 or 3 characters and get values
    if ( strlen( $color ) == 6 ) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }
 
    # Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    # Check if opacity is set(rgba or rgb)
    if( $opacity ){
        if( abs( $opacity ) > 1 )
            $opacity = 1.0;
        $output = 'rgba('.implode( ",",$rgb ).','.$opacity.')';
    } else {
        $output = 'rgb('.implode( ",",$rgb ).')';
    }

    # Return rgb(a) color string
    return $output;
}
endif;

function bosa_default_styles(){

	// Begin Style
	$css = '<style>';

	# Site Title
	#Site Title Height
	$logo_width = get_theme_mod( 'logo_width', 270 );
	$css .= '
		.site-header .site-branding > a {
			max-width: '. esc_attr( $logo_width ) .'px;
			overflow: hidden;
			display: inline-block;
		}
	';

	$site_title_color = get_theme_mod( 'site_title_color', '#030303' );
	$site_tagline_color = get_theme_mod( 'site_tagline_color', '#767676' );
	$css .= '
		/* Site Title */
		.header-one .site-branding .site-title, 
		.header-two .site-branding .site-title, 
		.header-three .site-branding .site-title {
			color: '. esc_attr( $site_title_color ) .';
		}
		/* Tagline */
		.header-one .site-branding .site-description,
		.header-two .site-branding .site-description,
		.header-three .site-branding .site-description {
			color: '. esc_attr( $site_tagline_color ) .';
		}
	';
	
	# Colors
	$site_body_text_color = get_theme_mod( 'site_body_text_color', '#333333' );
	$site_heading_text_color = get_theme_mod( 'site_heading_text_color', '#030303' );
	$header_textcolor = get_theme_mod( 'header_textcolor', '#101010' );
	$site_primary_color = get_theme_mod( 'site_primary_color', '#EB5A3E' );
	$site_hover_color = get_theme_mod( 'site_hover_color', '#086abd' );
	$site_general_link_color = get_theme_mod( 'site_general_link_color', '#a6a6a6' );
	$css .= '
		/* Site general link color */
		a {
			color: '. esc_attr( $site_general_link_color ) .';
		}
		/* Page and Single Post Title */
		body.single .page-title, body.page .page-title {
			color: '. esc_attr( $header_textcolor ) .';
		}
		/* Site body Text */
		body, html {
			color: '. esc_attr( $site_body_text_color ) .';
		}
		/* Heading Text */
		h1, h2, h3, h4, h5, h6, .product-title {
			color: '. esc_attr( $site_heading_text_color ) .';
		}
		/* Primary Background */
		.section-title:before, .button-primary, body[class*="woocommerce"] span.onsale, body .woocommerce.widget_price_filter .ui-slider .ui-slider-handle, #offcanvas-menu .header-btn-wrap .header-btn .button-primary {
			background-color: '. esc_attr( $site_primary_color ) .';
		}
		/* Primary Border */		
		.post .entry-content .entry-header .cat-links a, .attachment .entry-content .entry-header .cat-links a, .wrap-coming-maintenance-mode .content .button-container .button-primary {
			border-color: '. esc_attr( $site_primary_color ) .';
		}
		/* Primary Color */
	 	blockquote:before, .post .entry-content .entry-header .cat-links a, .attachment .entry-content .entry-header .cat-links a, .post .entry-meta a:before, .attachment .entry-meta a:before, .single .entry-container .cat-links:before, .post .entry-meta .tag-links:before {
			color: '. esc_attr( $site_primary_color ) .';
		}
		/* Hover Background */
		input[type=button]:hover, input[type=button]:active, input[type=button]:focus, input[type=reset]:hover, input[type=reset]:active, input[type=reset]:focus, input[type=submit]:hover, input[type=submit]:active, input[type=submit]:focus, .button-primary:hover, .button-primary:focus, .button-primary:active, .button-outline:hover, .button-outline:focus, .button-outline:active, .search-form .search-button:hover, .search-form .search-button:focus, .search-form .search-button:active, .page-numbers .page-numbers:hover, .page-numbers .page-numbers:focus, .page-numbers .page-numbers:active, .nav-links .page-numbers:hover, .nav-links .page-numbers:focus, .nav-links .page-numbers:active, #back-to-top a:hover, #back-to-top a:focus, #back-to-top a:active, .section-highlight-post .slick-control li.slick-arrow:not(.slick-disabled):hover, .section-highlight-post .slick-control li.slick-arrow:not(.slick-disabled):focus, .section-highlight-post .slick-control li.slick-arrow:not(.slick-disabled):active, .alt-menu-icon a:hover .icon-bar, .alt-menu-icon a:focus .icon-bar, .alt-menu-icon a:active .icon-bar, .alt-menu-icon a:hover .icon-bar:before, .alt-menu-icon a:hover .icon-bar:after, .alt-menu-icon a:focus .icon-bar:before, .alt-menu-icon a:focus .icon-bar:after, .alt-menu-icon a:active .icon-bar:before, .alt-menu-icon a:active .icon-bar:after, #offcanvas-menu .close-offcanvas-menu button:hover,  #offcanvas-menu .close-offcanvas-menu button:active, .highlight-post-slider .post .entry-meta .cat-links a:hover, .highlight-post-slider .post .entry-meta .cat-links a:focus, .highlight-post-slider .post .entry-meta .cat-links a:active, .site-footer .social-profile ul li a:hover, .site-footer .social-profile ul li a:focus, .site-footer .social-profile ul li a:active, #back-to-top a:hover, #back-to-top a:focus, #back-to-top a:active, .comments-area .comment-list .reply a:hover, .comments-area .comment-list .reply a:focus, .comments-area .comment-list .reply a:active, .widget .tagcloud a:hover, .widget .tagcloud a:focus, .widget .tagcloud a:active, .infinite-scroll #infinite-handle span:hover, .infinite-scroll #infinite-handle span:focus, .infinite-scroll #infinite-handle span:active, .slicknav_btn:hover .slicknav_icon-bar, .slicknav_btn:focus .slicknav_icon-bar, .slicknav_btn:hover .slicknav_icon-bar, .slicknav_btn:hover .slicknav_icon-bar:first-child:before, .slicknav_btn:hover .slicknav_icon-bar:first-child:after, .slicknav_btn:focus .slicknav_icon-bar:first-child:before, .slicknav_btn:focus .slicknav_icon-bar:first-child:after, .slicknav_btn:hover .slicknav_icon-bar:first-child:before, .slicknav_btn:hover .slicknav_icon-bar:first-child:after, .woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:focus, .woocommerce #respond input#submit:active, .woocommerce #respond input#submit:hover, .woocommerce #respond input#submit:focus, .woocommerce #respond input#submit:active, .woocommerce a.button:hover, .woocommerce a.button:focus, .woocommerce a.button:active, .woocommerce button.button:hover, .woocommerce button.button:focus, .woocommerce button.button:active, .woocommerce input.button:hover, .woocommerce input.button:focus, .woocommerce input.button:active, .woocommerce a.button.alt:hover, .woocommerce a.button.alt:focus, .woocommerce a.button.alt:active, .woocommerce button.button.alt:hover, .woocommerce button.button.alt:focus, .woocommerce button.button.alt:active, .woocommerce a.button:hover, .woocommerce a.button:focus, .widget.widget_product_search [type=submit]:hover, .widget.widget_product_search [type=submit]:focus, .widget.widget_product_search [type=submit]:active, #offcanvas-menu .header-btn-wrap .header-btn .button-primary:hover, #offcanvas-menu .header-btn-wrap .header-btn .button-primary:focus, #offcanvas-menu .header-btn-wrap .header-btn .button-primary:active, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:hover, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:focus, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:active, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current {
			background-color: '. esc_attr( $site_hover_color ) .';
		}
		/* Hover Border */
		.button-outline:hover, .button-outline:focus, .button-outline:active, #offcanvas-menu .close-offcanvas-menu button:hover, #offcanvas-menu .close-offcanvas-menu button:active, .page-numbers .page-numbers:hover, .page-numbers .page-numbers:focus, .page-numbers .page-numbers:active, .nav-links .page-numbers:hover, .nav-links .page-numbers:focus, .nav-links .page-numbers:active, #back-to-top a:hover, #back-to-top a:focus, #back-to-top a:active, .post .entry-content .entry-header .cat-links a:hover, .post .entry-content .entry-header .cat-links a:focus, .post .entry-content .entry-header .cat-links a:active, .attachment .entry-content .entry-header .cat-links a:hover, .attachment .entry-content .entry-header .cat-links a:focus, .attachment .entry-content .entry-header .cat-links a:active, .banner-content .entry-content .entry-header .cat-links a:hover, .banner-content .entry-content .entry-header .cat-links a:focus, .banner-content .entry-content .entry-header .cat-links a:active, .slick-control li:not(.slick-disabled):hover span, .slick-control li:not(.slick-disabled):focus span, .slick-control li:not(.slick-disabled):active span, .section-banner .banner-content .button-container .button-outline:hover, .section-banner .banner-content .button-container .button-outline:focus, .section-banner .banner-content .button-container .button-outline:active, #back-to-top a:hover, #back-to-top a:focus, #back-to-top a:active, .widget .tagcloud a:hover, .widget .tagcloud a:focus, .widget .tagcloud a:active, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:hover, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:focus, #offcanvas-menu .header-btn-wrap .header-btn .button-outline:active, .wrap-coming-maintenance-mode .content .social-profile ul a:hover, .wrap-coming-maintenance-mode .content .social-profile ul a:focus, .wrap-coming-maintenance-mode .content .social-profile ul a:active, .summary .yith-wcwl-add-button a:hover, .woocommerce .entry-summary a.compare.button:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current {
			border-color: '. esc_attr( $site_hover_color ) .';

			}
		/* Hover Text */
		a:hover, a:focus, a:active, .main-navigation ul.menu ul li a:hover, .main-navigation ul.menu ul li a:focus, .main-navigation ul.menu ul li a:active, .main-navigation ul.menu > li:hover > a, .main-navigation ul.menu > li:focus > a, .main-navigation ul.menu > li:active > a, .main-navigation ul.menu > li.focus > a, .main-navigation ul.menu li.current-menu-item > a, .main-navigation ul.menu li.current_page_item > a, .main-navigation ul.menu li.current-menu-parent > a, .comment-navigation .nav-previous a:hover, .comment-navigation .nav-previous a:focus, .comment-navigation .nav-previous a:active, .comment-navigation .nav-next a:hover, .comment-navigation .nav-next a:focus, .comment-navigation .nav-next a:active, .posts-navigation .nav-previous a:hover, .posts-navigation .nav-previous a:focus, .posts-navigation .nav-previous a:active, .posts-navigation .nav-next a:hover, .posts-navigation .nav-next a:focus, .posts-navigation .nav-next a:active, .post-navigation .nav-previous a:hover, .post-navigation .nav-previous a:focus, .post-navigation .nav-previous a:active, .post-navigation .nav-next a:hover, .post-navigation .nav-next a:focus, .post-navigation .nav-next a:active, .social-profile ul li a:hover, .social-profile ul li a:focus, .social-profile ul li a:active, .post .entry-content .entry-header .cat-links a:hover, .post .entry-content .entry-header .cat-links a:focus, .post .entry-content .entry-header .cat-links a:active, .attachment .entry-content .entry-header .cat-links a:hover, .attachment .entry-content .entry-header .cat-links a:focus, .attachment .entry-content .entry-header .cat-links a:active, .banner-content .entry-content .entry-header .cat-links a:hover, .banner-content .entry-content .entry-header .cat-links a:focus, .banner-content .entry-content .entry-header .cat-links a:active, .post .entry-meta a:hover, .post .entry-meta a:focus, .post .entry-meta a:active, .attachment .entry-meta a:hover, .attachment .entry-meta a:focus, .attachment .entry-meta a:active, .banner-content .entry-meta a:hover, .banner-content .entry-meta a:focus, .banner-content .entry-meta a:active, .post .entry-meta a:hover:before, .post .entry-meta a:focus:before, .post .entry-meta a:active:before, .attachment .entry-meta a:hover:before, .attachment .entry-meta a:focus:before, .attachment .entry-meta a:active:before, .banner-content .entry-meta a:hover:before, .banner-content .entry-meta a:focus:before, .banner-content .entry-meta a:active:before, .breadcrumb-wrap .breadcrumbs .trail-items a:hover, .breadcrumb-wrap .breadcrumbs .trail-items a:focus, .breadcrumb-wrap .breadcrumbs .trail-items a:active, .site-header .site-branding .site-title a:hover, .site-header .site-branding .site-title a:focus, .site-header .site-branding .site-title a:active, .header-icons .search-icon:hover, .header-icons .search-icon:focus, .header-icons .search-icon:active, .header-search .search-form .search-button:hover, .header-search .close-button:hover, .header-contact ul a:hover, .header-contact ul a:focus, .header-contact ul a:active, .section-banner .banner-content .entry-meta a:hover, .section-banner .banner-content .entry-meta a:focus, .section-banner .banner-content .entry-meta a:active, .site-footer .site-info a:hover, .site-footer .site-info a:focus, .site-footer .site-info a:active, .site-footer .footer-menu ul li a:hover, .site-footer .footer-menu ul li a:focus, .site-footer .footer-menu ul li a:active, .comments-area .comment-list .comment-metadata a:hover, .comments-area .comment-list .comment-metadata a:focus, .comments-area .comment-list .comment-metadata a:active, .widget ul li a:hover, .widget ul li a:focus, .widget ul li a:active, .woocommerce .product_meta .posted_in a:hover, .woocommerce .product_meta .posted_in a:focus, .woocommerce .product_meta .posted_in a:active, .woocommerce .product_meta .tagged_as a:hover, .woocommerce .product_meta .tagged_as a:focus, .woocommerce .product_meta .tagged_as a:active, .woocommerce .woocommerce-MyAccount-navigation ul li a:hover, .woocommerce .woocommerce-MyAccount-navigation ul li a:focus, .woocommerce .woocommerce-MyAccount-navigation ul li a:active, .woocommerce .woocommerce-MyAccount-content p a:hover, .woocommerce .woocommerce-MyAccount-content p a:focus, .woocommerce .woocommerce-MyAccount-content p a:active, .product .product-compare-wishlist .product-compare a:hover, .product .product-compare-wishlist .product-wishlist a:hover, .section-banner .banner-content .button-container .button-text:hover, .section-banner .banner-content .button-container .button-text:focus, .section-banner .banner-content .button-container .button-text:active, .social-profile ul li a:hover, .wrap-coming-maintenance-mode .content .header-contact ul a:hover, .wrap-coming-maintenance-mode .content .header-contact ul a:focus, .wrap-coming-maintenance-mode .content .header-contact ul a:active, #offcanvas-menu .header-navigation ul.menu > li a:hover, #offcanvas-menu .header-navigation ul.menu > li a:focus, #offcanvas-menu .header-navigation ul.menu > li a:active, #offcanvas-menu .social-profile ul li a:hover, #offcanvas-menu .social-profile ul li a:focus, #offcanvas-menu .social-profile ul li a:active, #offcanvas-menu .header-contact ul li a:hover, #offcanvas-menu .header-contact ul li a:focus, #offcanvas-menu .header-contact ul li a:active, #offcanvas-menu .header-btn-wrap .header-btn .button-text:hover, #offcanvas-menu .header-btn-wrap .header-btn .button-text:focus, #offcanvas-menu .header-btn-wrap .header-btn .button-text:active, .wrap-coming-maintenance-mode .content .social-profile ul a:hover, .wrap-coming-maintenance-mode .content .social-profile ul a:focus, .wrap-coming-maintenance-mode .content .social-profile ul a:active,  .woocommerce .woocommerce-MyAccount-navigation ul li.is-active a, .woocommerce ul.products li.product .woocommerce-loop-product__title:hover, .woocommerce ul.products li.product .woocommerce-loop-product__title:focus, .woocommerce ul.products li.product .woocommerce-loop-product__title:active, .woocommerce ul.products li.product .price ins:hover, .woocommerce ul.products li.product .price ins:focus, .woocommerce ul.products li.product .price ins:active, .widget.widget_recently_viewed_products li .product-title:hover, .widget.widget_recently_viewed_products li .product-title:active, .widget.widget_recent_reviews li .product-title:hover, .widget.widget_recent_reviews li .product-title:active, .widget.widget_products .product_list_widget li .product-title:hover,
			.widget.widget_products .product_list_widget li .product-title:active, .summary .yith-wcwl-add-button a:hover, .woocommerce .entry-summary a.compare.button:hover, [class*=woocommerce] ul.products li.product .price:hover {
			color: '. esc_attr( $site_hover_color ) .';
		}
	';

	# Overlay Opacity
	$feature_posts_overlay_opacity = get_theme_mod( 'feature_posts_overlay_opacity', 4 );
	$css .= '
		/* Feature Posts*/
		.feature-posts-layout-one .feature-posts-content-wrap .feature-posts-image:before {
		 	background-color: rgba(0, 0, 0, 0.'. esc_attr( $feature_posts_overlay_opacity ) .');
		}
	';
	
	# Header Color
	/* Top Header Background */
	$top_header_background_color = get_theme_mod( 'top_header_background_color', '' );
	$top_header_text_color = get_theme_mod( 'top_header_text_color', '#333333' );
	$top_header_text_link_hover_color = get_theme_mod( 'top_header_text_link_hover_color', '#086abd' );
	$sub_menu_link_hover_color = get_theme_mod( 'sub_menu_link_hover_color', '#086abd' );
	$css .= '
		.header-one .top-header,
		.header-two .top-header,
		.header-three .top-header {
			background-color: '. esc_attr( $top_header_background_color ) .';
		}
	';

	$css .= '
		.header-one .header-contact ul li, 
		.header-one .header-contact ul li a, 
		.header-one .social-profile ul li a,
		.header-one .header-icons .search-icon,
		.header-two .header-contact ul li, 
		.header-two .header-contact ul li a, 
		.header-two .social-profile ul li a,
		.header-two .header-icons .search-icon,
		.header-three .header-navigation ul.menu > li > a, 
		.header-three .alt-menu-icon .iconbar-label, 
		.header-three .social-profile ul li a {
			color: '. esc_attr( $top_header_text_color ) .';
		}
		@media only screen and (max-width: 991px) {
			.alt-menu-icon .iconbar-label {
			    color: '. esc_attr( $top_header_text_color ) .';
			}
			header.site-header .alt-menu-icon .icon-bar, 
			header.site-header .alt-menu-icon .icon-bar:before, 
			header.site-header .alt-menu-icon .icon-bar:after {
				background-color: '. esc_attr( $top_header_text_color ) .';
			}
			.alt-menu-icon a:hover .iconbar-label,
			.alt-menu-icon a:focus .iconbar-label,
			.alt-menu-icon a:active .iconbar-label {
			    color: '. esc_attr( $top_header_text_link_hover_color ) .';
			}
			header.site-header .alt-menu-icon a:hover .icon-bar, 
			header.site-header .alt-menu-icon a:focus .icon-bar, 
			header.site-header .alt-menu-icon a:active .icon-bar, 
			header.site-header .alt-menu-icon a:hover .icon-bar:before, 
			header.site-header .alt-menu-icon a:focus .icon-bar:before, 
			header.site-header .alt-menu-icon a:active .icon-bar:before, 
			header.site-header .alt-menu-icon a:hover .icon-bar:after,
			header.site-header .alt-menu-icon a:focus .icon-bar:after,
			header.site-header .alt-menu-icon a:active .icon-bar:after {
				background-color: '. esc_attr( $top_header_text_link_hover_color ) .';
			}
		}
		.header-one .alt-menu-icon .icon-bar, 
		.header-one .alt-menu-icon .icon-bar:before, 
		.header-one .alt-menu-icon .icon-bar:after,
		.header-two .alt-menu-icon .icon-bar, 
		.header-two .alt-menu-icon .icon-bar:before, 
		.header-two .alt-menu-icon .icon-bar:after {
			background-color: '. esc_attr( $top_header_text_color ) .';
		}

		.header-one .header-contact ul li a:hover, 
		.header-one .header-contact ul li a:focus, 
		.header-one .header-contact ul li a:active, 
		.header-one .social-profile ul li a:hover, 
		.header-one .social-profile ul li a:focus, 
		.header-one .social-profile ul li a:active,
		.header-one .header-search-wrap .search-icon:hover,
		.header-one .header-search-wrap .search-icon:focus,
		.header-one .header-search-wrap .search-icon:active,
		.header-two .header-contact ul li a:hover, 
		.header-two .header-contact ul li a:focus, 
		.header-two .header-contact ul li a:active, 
		.header-two .social-profile ul li a:hover,
		.header-two .social-profile ul li a:focus,
		.header-two .social-profile ul li a:active,
		.header-two .header-icons .search-icon:hover,
		.header-two .header-icons .search-icon:focus,
		.header-two .header-icons .search-icon:active,
		.header-three .header-navigation ul.menu > li > a:hover, 
		.header-three .header-navigation ul.menu > li > a:focus, 
		.header-three .header-navigation ul.menu > li > a:active, 
		.header-three .social-profile ul li a:hover, 
		.header-three .social-profile ul li a:focus, 
		.header-three .social-profile ul li a:active {
			color: '. esc_attr( $top_header_text_link_hover_color ) .';
		}
		.header-one .alt-menu-icon a:hover .icon-bar, 
		.header-one .alt-menu-icon a:focus .icon-bar, 
		.header-one .alt-menu-icon a:active .icon-bar, 
		.header-one .alt-menu-icon a:hover .icon-bar:before, 
		.header-one .alt-menu-icon a:focus .icon-bar:before, 
		.header-one .alt-menu-icon a:active .icon-bar:before, 
		.header-one .alt-menu-icon a:hover .icon-bar:after,
		.header-one .alt-menu-icon a:focus .icon-bar:after,
		.header-one .alt-menu-icon a:active .icon-bar:after,
		.header-two .alt-menu-icon a:hover .icon-bar, 
		.header-two .alt-menu-icon a:focus .icon-bar, 
		.header-two .alt-menu-icon a:active .icon-bar, 
		.header-two .alt-menu-icon a:hover .icon-bar:before, 
		.header-two .alt-menu-icon a:focus .icon-bar:before, 
		.header-two .alt-menu-icon a:active .icon-bar:before, 
		.header-two .alt-menu-icon a:hover .icon-bar:after,
		.header-two .alt-menu-icon a:focus .icon-bar:after,
		.header-two .alt-menu-icon a:active .icon-bar:after,
		.home .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:active .icon-bar, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar:before, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar:before, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:active .icon-bar:before, 
		.home .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar:after,
		.home .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar:after,
		.home .header-two:not(.sticky-header) .alt-menu-icon a:active .icon-bar:after {
			background-color: '. esc_attr( $top_header_text_link_hover_color ) .';
		}
	';


	/* Mid Header Background */
	$mid_header_background_color = get_theme_mod( 'mid_header_background_color', '' );
	$mid_header_text_link_hover_color = get_theme_mod( 'mid_header_text_link_hover_color', '#086abd' );
	$css .= '
		.mid-header .overlay {
			background-color: '. esc_attr( $mid_header_background_color ) .';
		}
	';

	$css .= '
		.header-three .site-branding .site-title a:hover,
		.header-three .site-branding .site-title a:focus,
		.header-three .site-branding .site-title a:active {
			color: '. esc_attr( $mid_header_text_link_hover_color ) .';
		}
	';

	/* Bottom Header Background */
	$bottom_header_background_color = get_theme_mod( 'bottom_header_background_color', '' );
	$bottom_header_text_color = get_theme_mod( 'bottom_header_text_color', '#333333' );
	$bottom_header_text_link_hover_color = get_theme_mod( 'bottom_header_text_link_hover_color', '#086abd' );
	$css .= '
		.header-one .bottom-header .overlay,
		.header-two .bottom-header .overlay,
		.header-three .bottom-header,
		.header-three .mobile-menu-container {
			background-color: '. esc_attr( $bottom_header_background_color ) .';
		}
		@media only screen and (max-width: 991px) {
			.header-one .mobile-menu-container {
				background-color: '. esc_attr( $bottom_header_background_color ) .';
			}
		}
	';

	$css .= '
		.header-one .main-navigation ul.menu > li > a,
		.header-two .main-navigation ul.menu > li > a,
		.header-three .main-navigation ul.menu > li > a, 
		.header-three .header-icons .search-icon {
			color: '. esc_attr( $bottom_header_text_color ) .';
		}
		.site-header .slicknav_btn:not(.slicknav_open) .slicknav_icon span,
		.site-header .slicknav_btn:not(.slicknav_open) .slicknav_icon span:first-child:before, 
		.site-header .slicknav_btn:not(.slicknav_open) .slicknav_icon span:first-child:after {
			background-color: '. esc_attr( $bottom_header_text_color ) .';
		}
		.header-one .site-branding .site-title a:hover,
		.header-one .site-branding .site-title a:focus,
		.header-one .site-branding .site-title a:active,
		.header-one .main-navigation ul.menu li a:hover, 
		.header-one .main-navigation ul.menu li a:focus, 
		.header-one .main-navigation ul.menu li a:active, 
		.header-one .main-navigation ul.menu li.current-menu-item > a,
		.header-one .main-navigation ul.menu li.current_page_item > a,
		.header-one .main-navigation ul.menu > li:hover > a, 
		.header-one .main-navigation ul.menu > li:focus > a, 
		.header-one .main-navigation ul.menu > li:active > a, 
		.header-two .site-branding .site-title a:hover,
		.header-two .site-branding .site-title a:focus,
		.header-two .site-branding .site-title a:active,
		.header-two .header-search-wrap .search-icon:hover,
		.header-two .header-search-wrap .search-icon:focus,
		.header-two .header-search-wrap .search-icon:active,
		.header-two .main-navigation ul.menu li a:hover, 
		.header-two .main-navigation ul.menu li a:focus, 
		.header-two .main-navigation ul.menu > li > a:active, 
		.header-two .main-navigation ul.menu li.current-menu-item > a,
		.header-two .main-navigation ul.menu li.current_page_item > a,
		.header-two .main-navigation ul.menu > li:hover > a, 
		.header-two .main-navigation ul.menu > li:focus > a, 
		.header-two .main-navigation ul.menu > li:active > a, 
		.header-two .header-icons .search-icon:hover, 
		.header-two .header-icons .search-icon:focus, 
		.header-two .header-icons .search-icon:active, 
		.home .header-two:not(.sticky-header) .main-navigation ul.menu li a:hover, 
		.home .header-two:not(.sticky-header) .main-navigation ul.menu li a:focus, 
		.home .header-two:not(.sticky-header) .main-navigation ul.menu li a:active,
		.header-three .main-navigation ul.menu > li > a:hover, 
		.header-three .main-navigation ul.menu > li > a:focus, 
		.header-three .main-navigation ul.menu > li > a:active, 
		.header-three .main-navigation ul.menu li.current-menu-item > a,
		.header-three .main-navigation ul.menu li.current_page_item > a,
		.header-three .main-navigation ul.menu > li:hover > a, 
		.header-three .main-navigation ul.menu > li:focus > a, 
		.header-three .main-navigation ul.menu > li:active > a, 
		.header-three .header-icons .search-icon:hover, 
		.header-three .header-icons .search-icon:focus, 
		.header-three .header-icons .search-icon:active {
			color: '. esc_attr( $bottom_header_text_link_hover_color ) .';
		}
	';

	$css .= '
		.header-three .alt-menu-icon .icon-bar, 
		.header-three .alt-menu-icon .icon-bar:before, 
		.header-three .alt-menu-icon .icon-bar:after {
			background-color: '. esc_attr( $bottom_header_text_color ) .';
		}
		
		.header-three .alt-menu-icon a:hover .icon-bar, 
		.header-three .alt-menu-icon a:focus .icon-bar, 
		.header-three .alt-menu-icon a:active .icon-bar, 
		.header-three .alt-menu-icon a:hover .icon-bar:before, 
		.header-three .alt-menu-icon a:focus .icon-bar:before, 
		.header-three .alt-menu-icon a:active .icon-bar:before, 
		.header-three .alt-menu-icon a:hover .icon-bar:after,
		.header-three .alt-menu-icon a:focus .icon-bar:after,
		.header-three .alt-menu-icon a:active .icon-bar:after {
			background-color: '. esc_attr( $bottom_header_text_link_hover_color ) .';
		}
		@media only screen and (max-width: 991px) {
			.mobile-menu-container .slicknav_menu .slicknav_menutxt {
			    color: '. esc_attr( $bottom_header_text_color ) .';
			}
			.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span, 
			.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:before,
			.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:after {
				background-color: '. esc_attr( $bottom_header_text_color ) .';
			}
			.mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_menutxt,
			.mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_menutxt,
			.mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_menutxt,
			.slicknav_menu .slicknav_nav li a:hover, 
			.slicknav_menu .slicknav_nav li a:focus, 
			.slicknav_menu .slicknav_nav li a:active {
			    color: '. esc_attr( $bottom_header_text_link_hover_color ) .';
			}
			.mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span, 
			.mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span, 
			.mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span, 
			.mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span:first-child:before,
			.mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span:first-child:before,
			.mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span:first-child:before,
			.mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span:first-child:after,
			.mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span:first-child:after,
			.mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span:first-child:after {
				background-color: '. esc_attr( $bottom_header_text_link_hover_color ) .';
			}
		}
	';

	#Header two separate colors
	$transparent_header_top_background_color = get_theme_mod( 'transparent_header_top_background_color', '' );
	$transparent_header_bottom_background_color = get_theme_mod( 'transparent_header_bottom_background_color', '' );
	$transparent_header_top_header_color = get_theme_mod( 'transparent_header_top_header_color', '#ffffff' );
	$top_hover_color_transparent_header = get_theme_mod( 'top_hover_color_transparent_header', '#086abd' );
	$site_title_color_transparent_header = get_theme_mod( 'site_title_color_transparent_header', '#ffffff' );
	$site_tagline_color_transparent_header = get_theme_mod( 'site_tagline_color_transparent_header', '#e6e6e6' );
	$content_color_transparent_header = get_theme_mod( 'content_color_transparent_header', '#ffffff' );
	$content_hover_color_transparent_header = get_theme_mod( 'content_hover_color_transparent_header', '#086abd' );

	$css .= '
		/* Transparent Top Header */
		.transparent-header .header-two.site-header .top-header {
			background-color: '. esc_attr( $transparent_header_top_background_color ) .';
		}
		
		/* Site Title */
		.transparent-header .site-header.header-two:not(.sticky-header) .site-branding .site-title {
			color: '. esc_attr( $site_title_color_transparent_header ) .';
		}
		/* Tagline */
		.transparent-header .site-header.header-two:not(.sticky-header) .site-branding .site-description {
			color: '. esc_attr( $site_tagline_color_transparent_header ) .';
		}
		/* Top Header Color */
		.transparent-header .header-two.site-header .header-contact ul a,
		.transparent-header .header-two.site-header .header-contact ul li,
		.transparent-header .header-two.site-header .social-profile ul li a, 
		.transparent-header .header-two.site-header .header-search-wrap .search-icon {
			color: '. esc_attr( $transparent_header_top_header_color ) .';
		}
		.transparent-header .header-two.site-header .header-contact ul a:hover,
		.transparent-header .header-two.site-header .header-contact ul a:focus,
		.transparent-header .header-two.site-header .header-contact ul a:active,
		.transparent-header .header-two.site-header .social-profile ul li a:hover, 
		.transparent-header .header-two.site-header .social-profile ul li a:focus, 
		.transparent-header .header-two.site-header .social-profile ul li a:active, 
		.transparent-header .header-two.site-header .header-search-wrap .search-icon:hover,
		.transparent-header .header-two.site-header .header-search-wrap .search-icon:focus,
		.transparent-header .header-two.site-header .header-search-wrap .search-icon:active {
			color: '. esc_attr( $top_hover_color_transparent_header ) .';
		}
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon .icon-bar,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon .icon-bar:before, 
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon .icon-bar:after {
			background-color: '. esc_attr( $transparent_header_top_header_color ) .';
		}
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar:before, 
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar:before, 
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:active .icon-bar:before, 
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:hover .icon-bar:after,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:focus .icon-bar:after,
		.transparent-header .header-two:not(.sticky-header) .alt-menu-icon a:active .icon-bar:after {
			background-color: '. esc_attr( $top_hover_color_transparent_header ) .';
		}

		/* Transparent bottom Header */
		.transparent-header .header-two.site-header .bottom-header .overlay {
			background-color: '. esc_attr( $transparent_header_bottom_background_color ) .';
		}
		/* Header Menu */
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu > li > a {
			color: '. esc_attr( $content_color_transparent_header ) .';
		}

		@media only screen and (max-width: 991px) {
			.transparent-header .header-two .alt-menu-icon .iconbar-label {
			    color: '. esc_attr( $transparent_header_top_header_color ) .';
			}
			.transparent-header .header-two .alt-menu-icon a:hover .iconbar-label,
			.transparent-header .header-two .alt-menu-icon a:focus .iconbar-label,
			.transparent-header .header-two .alt-menu-icon a:active .iconbar-label {
				color: '. esc_attr( $top_hover_color_transparent_header ) .';
			}
			.transparent-header .header-two:not(.sticky-header) .mobile-menu-container .slicknav_menu .slicknav_menutxt {
				color: '. esc_attr( $content_color_transparent_header) .';
			}
			.transparent-header .header-two:not(.sticky-header) .mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span, 
			.transparent-header .header-two:not(.sticky-header) .mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:before, 
			.transparent-header .header-two:not(.sticky-header) .mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:after {
				background-color: '. esc_attr( $content_color_transparent_header ) .';
			}
		}

		/* Transparent Header bottom Hover Color*/
		.transparent-header .site-header.header-two:not(.sticky-header) .site-branding .site-title a:hover,
		.transparent-header .site-header.header-two:not(.sticky-header) .site-branding .site-title a:focus,
		.transparent-header .site-header.header-two:not(.sticky-header) .site-branding .site-title a:active,  
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li > a:hover,
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li > a:focus,
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li > a:active,
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li:hover > a, 
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li:focus > a, 
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li:active > a,
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_menutxt,
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_menutxt,
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_menutxt,
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li.current-menu-item > a,
		.transparent-header .header-two:not(.sticky-header) .main-navigation ul.menu li.current_page_item > a {
			color: '. esc_attr( $content_hover_color_transparent_header ) .';
		}
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span:first-child:before, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span:first-child:before, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span:first-child:before, 
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:hover .slicknav_icon span:first-child:after,
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:focus .slicknav_icon span:first-child:after,
		.transparent-header .header-two .mobile-menu-container .slicknav_menu .slicknav_btn:active .slicknav_icon span:first-child:after {
			background-color: '. esc_attr( $content_hover_color_transparent_header ) .';
		}
	';
	if ( !get_theme_mod( 'disable_fixed_header', true ) ){
		$bg_color_fixed_header	 		 = get_theme_mod( 'bg_color_fixed_header', '' );
		$site_title_color_fixed_header	 = get_theme_mod( 'site_title_color_fixed_header', '' );
		$site_tagline_color_fixed_header = get_theme_mod( 'site_tagline_color_fixed_header', '' );
		$text_color_fixed_header 		 = get_theme_mod( 'text_color_fixed_header', '' );
		$text_hover_color_fixed_header 	 = get_theme_mod( 'text_hover_color_fixed_header', '' );
		$text_hover_color_fixed_header 	 = $text_hover_color_fixed_header ? $text_hover_color_fixed_header : $bottom_header_text_link_hover_color;

		$css .= '
			.transparent-header .header-two.sticky-header .bottom-header .overlay {
				background-color: '. esc_attr( $bg_color_fixed_header ) .';
			}
			/* Site Title */
			.transparent-header .header-two.sticky-header .site-branding .site-title {
				color: '. esc_attr( $site_title_color_fixed_header ) .';
			}
			/* Tagline */
			.transparent-header .header-two.sticky-header .site-branding .site-description {
				color: '. esc_attr( $site_tagline_color_fixed_header ) .';
			}
			/* Header Menu */
			.transparent-header .header-two.sticky-header .main-navigation ul.menu > li > a {
				color: '. esc_attr( $text_color_fixed_header ) .';
			}
			/* Hover */
			.transparent-header .header-two.sticky-header .site-branding .site-title a:hover,
			.transparent-header .header-two.sticky-header .site-branding .site-title a:focus,
			.transparent-header .header-two.sticky-header .site-branding .site-title a:active, 
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li > a:hover,
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li > a:focus,
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li > a:active,
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li:hover > a, 
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li:focus > a, 
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li:active > a,
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li.current-menu-item > a,
			.transparent-header .header-two.sticky-header .main-navigation ul.menu li.current_page_item > a {
				color: '. esc_attr( $text_hover_color_fixed_header ) .';
			}
		';
		if( !get_theme_mod( 'disable_header_button', false ) ){
			$fixed_header_button_background_color 	 = get_theme_mod( 'fixed_header_button_background_color', '' );
			$fixed_header_button_border_color 		 = get_theme_mod( 'fixed_header_button_border_color', '' );
			$fixed_header_button_text_color 		 = get_theme_mod( 'fixed_header_button_text_color', '' );
			$css .= '
				/* Header Button */
				.transparent-header .header-two.sticky-header .header-btn .button-primary {
					background-color: '. esc_attr( $fixed_header_button_background_color ) .';
					color: '. esc_attr( $fixed_header_button_text_color ) .';
				}
				.transparent-header .header-two.sticky-header .header-btn .button-outline {
					color: '. esc_attr( $fixed_header_button_text_color ) .';
					border-color: '. esc_attr( $fixed_header_button_border_color ) .';
				}
				.transparent-header .header-two.sticky-header .header-btn .button-text {
					color: '. esc_attr( $fixed_header_button_text_color ) .';
					padding: 0;
				}
			';
		}
	}

	# Header Sub Menu Hove Text color
	$css .= '
		#masthead .main-navigation ul.menu ul li a:hover,
		#masthead .main-navigation ul.menu ul li a:focus,
		#masthead .main-navigation ul.menu ul li a:active {
			color: '. esc_attr( $sub_menu_link_hover_color ) .';
		}
	';

	# Header Button
	if( !get_theme_mod( 'disable_header_button', false ) ){
		if( get_theme_mod( 'header_layout', 'header_one' ) == 'header_one' ){
			$header_btn_defaults = array(
				array(
					'header_btn_type' 			=> 'button-outline',
					'header_btn_bg_color'		=> '#EB5A3E',
					'header_btn_border_color'	=> '#1a1a1a',
					'header_btn_text_color'		=> '#1a1a1a',
					'header_btn_hover_color'	=> '#086abd',
					'header_btn_text' 			=> '',
					'header_btn_link' 			=> '',
					'header_btn_target'			=> true,
					'header_btn_radius'			=> 0,
				),		
			);
			$header_buttons = get_theme_mod( 'header_button_repeater', $header_btn_defaults );
			if( !empty( $header_buttons ) && is_array( $header_buttons ) ){
				$i = 1;
		    	foreach( $header_buttons as $value ){
		    		$header_btn_bg_color 		= $value['header_btn_bg_color'];
		    		$header_btn_border_color 	= $value['header_btn_border_color'];
		    		$header_btn_text_color 		= $value['header_btn_text_color'];
		    		$header_btn_hover_color 	= $value['header_btn_hover_color'];
		    		$header_btn_radius 	= $value['header_btn_radius'];
		    		if( $value['header_btn_type'] == 'button-primary' ){
			    		$css .= '
							.site-header .header-btn-'. $i .'.button-primary {
								background-color: '. esc_attr( $header_btn_bg_color ) .';
								color: '. esc_attr( $header_btn_text_color ) .';
							}

							.site-header .header-btn-'. $i .'.button-primary:hover,
							.site-header .header-btn-'. $i .'.button-primary:focus,
							.site-header .header-btn-'. $i .'.button-primary:active {
								background-color: '. esc_attr( $header_btn_hover_color ) .';
								color: #ffffff;
							}

							.site-header .header-btn-'. $i .'.button-primary {
								border-radius: '. esc_attr( $header_btn_radius ) .'px;
							}
						';
					}elseif( $value['header_btn_type'] == 'button-outline' ){
						$css .= '

							.site-header .header-btn-'. $i .'.button-outline {
								border-color: '. esc_attr( $header_btn_border_color ) .';
								color: '. esc_attr( $header_btn_text_color ) .';
							}

							.site-header .header-btn-'. $i .'.button-outline:hover,
							.site-header .header-btn-'. $i .'.button-outline:focus,
							.site-header .header-btn-'. $i .'.button-outline:active {
								background-color: '. esc_attr( $header_btn_hover_color ) .';
								border-color: '. esc_attr( $header_btn_hover_color ) .';
								color: #ffffff;
							}

							.site-header .header-btn-'. $i .'.button-outline {
								border-radius: '. esc_attr( $header_btn_radius ) .'px;
							}
						';
					}elseif( $value['header_btn_type'] == 'button-text' ){
						$css .= '
							.site-header .header-btn-'. $i .'.button-text {
								color: '. esc_attr( $header_btn_text_color ) .';
								padding: 0;
							}
							.site-header .header-btn-'. $i .'.button-text:hover,
							.site-header .header-btn-'. $i .'.button-text:focus,
							.site-header .header-btn-'. $i .'.button-text:active {
								color: '. esc_attr( $header_btn_hover_color ) .';
							}
						';
					}
					$i++;
		    	}
		    }
		}
	}

	# Transparent Header Button
	if( !get_theme_mod( 'disable_header_button', false ) ){
		if( get_theme_mod( 'header_layout', 'header_one' ) == 'header_two' ){
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
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-primary:hover,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-primary:focus,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-primary:active {
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
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-outline:hover,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-outline:focus,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-outline:active {
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
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-text:hover,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-text:focus,
							.transparent-header .header-two.sticky-header .header-btn-'. $i .'.button-text:active {
								color: '. esc_attr( $transparent_header_btn_hover_color ) .';
							}
						';
					}
					$i++;
		    	}
		    }
		}
	}
	
	# Fixed Header
	if( get_theme_mod( 'disable_fixed_header_logo', false ) ){
		$css .= '
			.site-header.sticky-header .site-branding img {
				display: none;
			}
		';
	}

	$the_custom_logo_url = bosa_get_custom_logo_url();
	if( $the_custom_logo_url == ''  && ( get_theme_mod( 'header_layout', 'header_one' ) !== 'header_two' || ( !is_front_page() && ( get_theme_mod( 'disable_transparent_header_post', true ) && !is_single() ) && ( get_theme_mod( 'disable_transparent_header_page', true ) && !is_page() ) ) || empty( get_theme_mod( 'header_separate_logo', '' ) ) ) ){
		$css .= '
			.site-header .site-branding img {
				display: none;
			}
		';
	}

	if( get_theme_mod( 'disable_fixed_header_site_title', false ) ){
		$css .= '
			.site-header.sticky-header .site-branding .site-title {
				display: none;
			}
		';
	}

	if( get_theme_mod( 'disable_fixed_header_site_tagline', false ) ){
		$css .= '
			.site-header.sticky-header .site-branding .site-description {
				display: none;
			}
		';
	}

	if( get_theme_mod( 'disable_mobile_fixed_header', true ) ){
		$css .= '
			@media screen and (max-width: 991px){
				.site-header.sticky-header .fixed-header {
				    position: relative;
				}
			}
		';
	}

	# Header Border For Desktop
	if( get_theme_mod( 'disable_top_header_border', false ) ){
		$css .= '
			@media screen and (min-width: 992px){
				.top-header {
					border-bottom: none;
				}
			}
		';
	}

	if( get_theme_mod( 'disable_mid_header_border', false ) ){
		$css .= '
			@media screen and (min-width: 992px){
				.mid-header {
					border-bottom: none;
				}
			}
		';
	}

	# Header Border For mobile
	if( get_theme_mod( 'disable_mobile_top_header_border', false ) ){
		$css .= '
			@media screen and (max-width: 991px){
				.top-header {
					border-bottom: none;
				}
			}
		';
	}
	if( get_theme_mod( 'disable_mobile_mid_header_border', false ) ){
		$css .= '
			@media screen and (max-width: 991px){
				.mid-header,
				.bottom-header,
				.header-one .mobile-menu-container .slicknav_menu {
					border-bottom: none;
				}
			}
		';
	}

	# Fixed Header Logo Width
	$fixed_header_logo_width = get_theme_mod( 'fixed_header_logo_width', 270 );
	$css .= '
		.site-header.sticky-header .site-branding > a {
			max-width: '. esc_attr( $fixed_header_logo_width ) .'px;
		}
	';

	# Header Image / Slider
	#Header Image Height
	$header_image_height = get_theme_mod( 'header_image_height', 80 );
	$css .= '
		@media only screen and (min-width: 992px) {
			.site-header:not(.sticky-header) .header-image-wrap {
				height: '. esc_attr( $header_image_height ) .'px;
				width: 100%;
				position: relative;
			}
		}
	';

	# Header Image Sizes
	#Cover Size
	if( get_theme_mod( 'header_image_size', 'cover' ) == 'cover' ){
		$css .= '
			.header-slide-item {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		';
	}
	#Repeat Size
	elseif( get_theme_mod( 'header_image_size', 'cover' ) == 'pattern' ){
		$css .= '
			.header-slide-item {
				background-position: center center;
				background-repeat: repeat;
				background-size: inherit;
			}
		';
	}
	#Fit Size
	elseif( get_theme_mod( 'header_image_size', 'cover' ) == 'norepeat' ){
		$css .= '
			.header-slide-item {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: inherit;
			}
		';
	}

	#Parallax Scrolling
	if( !get_theme_mod( 'disable_parallax_scrolling', true ) ){
		$css .= '
		.header-slide-item {
				background-position: center center;
				background-attachment: fixed;
			}
		';
	}

	# Header Slider
	if( get_theme_mod( 'header_media_options', 'image' ) == 'slider' ){
		$css .= '
		#customize-control-header_image {
				display: none;
			}
		';
	}

	// Transparent Header Banner in Post Height
	$transparent_header_banner_post_height = get_theme_mod( 'transparent_header_banner_post_height', 400 );
	$css .= '
		@media only screen and (min-width: 768px) {
			.overlay-post .inner-banner-content {
				height: '. esc_attr( $transparent_header_banner_post_height ) .'px;
				overflow: hidden;
			}
		}
	';
	// Transparent Header Banner in Post Image Size
	#Cover Size
	if( get_theme_mod( 'transparent_header_banner_post_size', 'cover' ) == 'cover' ){
		$css .= '
			.overlay-post .inner-banner-content {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		';
	}
	#Repeat Size
	elseif( get_theme_mod( 'transparent_header_banner_post_size', 'cover' ) == 'pattern' ){
		$css .= '
			.overlay-post .inner-banner-content {
				background-position: center center;
				background-repeat: repeat;
				background-size: inherit;
			}
		';
	}
	#Fit Size
	elseif( get_theme_mod( 'transparent_header_banner_post_size', 'cover' ) == 'norepeat' ){
		$css .= '
			.overlay-post .inner-banner-content {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: inherit;
			}
		';
	}
	# Transparent Header Banner Post Overlay
	$transparent_header_banner_post_opacity = get_theme_mod( 'transparent_header_banner_post_opacity', 4 );
	$css .= '
		.overlay-post .inner-banner-content:before {
		 	background-color: rgba(0, 0, 0, 0.'. esc_attr( $transparent_header_banner_post_opacity ) .');
		}
	';

	// Transparent Header Banner in Page Height
	$transparent_header_banner_page_height = get_theme_mod( 'transparent_header_banner_page_height', 400 );
	$css .= '
		@media only screen and (min-width: 768px) {
			.overlay-page .inner-banner-content {
				height: '. esc_attr( $transparent_header_banner_page_height ) .'px;
				overflow: hidden;
			}
		}
	';
	// Transparent Header Banner in Page Image Size
	#Cover Size
	if( get_theme_mod( 'transparent_header_banner_page_size', 'cover' ) == 'cover' ){
		$css .= '
			.overlay-page .inner-banner-content {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		';
	}
	#Repeat Size
	elseif( get_theme_mod( 'transparent_header_banner_page_size', 'cover' ) == 'pattern' ){
		$css .= '
			.overlay-page .inner-banner-content {
				background-position: center center;
				background-repeat: repeat;
				background-size: inherit;
			}
		';
	}
	#Fit Size
	elseif( get_theme_mod( 'transparent_header_banner_page_size', 'cover' ) == 'norepeat' ){
		$css .= '
			.overlay-page .inner-banner-content {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: inherit;
			}
		';
	}		
	# Transparent Header Banner Page Overlay
	$transparent_header_banner_page_opacity = get_theme_mod( 'transparent_header_banner_page_opacity', 4 );
	$css .= '
		.overlay-page .inner-banner-content:before {
		 	background-color: rgba(0, 0, 0, 0.'. esc_attr( $transparent_header_banner_page_opacity ) .');
		}
	';

	# Main Slider / Image
	#Height
	$main_slider_height = get_theme_mod( 'main_slider_height', 550 );
	$css .= '
		@media only screen and (min-width: 768px) {
			.banner-img {
				height: '. esc_attr( $main_slider_height ) .'px;
				overflow: hidden;
			}
		}
	';

	# Slider
	if ( get_theme_mod( 'main_slider_controls', 'slider' ) == 'slider' ){
		#Blog Slider Color 
		$background_color_main_slider = get_theme_mod( 'background_color_main_slider', '');
		$slider_post_title_color 	= get_theme_mod( 'slider_post_title_color', '#ffffff' );
		$slider_post_category_color = get_theme_mod( 'slider_post_category_color', '#ebebeb' );
		$slider_post_meta_color 	= get_theme_mod( 'slider_post_meta_color', '#ebebeb' );
		$slider_post_meta_icon_color = get_theme_mod( 'slider_post_meta_icon_color', '#FFFFFF' );
		$slider_post_text_color 	= get_theme_mod( 'slider_post_text_color', '#ffffff' );
		$separate_hover_color_for_main_slider = get_theme_mod( 'separate_hover_color_for_main_slider', '#a8d8ff' );
		$css .= '
			.main-slider .banner-img .overlay {
				background-color: '. esc_attr( $background_color_main_slider ) .';
			}
			.section-banner .banner-content .entry-title {
				color: '. esc_attr( $slider_post_title_color ) .';
			}
			.banner-content .entry-content .entry-header .cat-links a {
				color: '. esc_attr( $slider_post_category_color) .';
				border-color: '. esc_attr( $slider_post_category_color) .';
			}
			.section-banner .banner-content .entry-meta a {
				color: '. esc_attr( $slider_post_meta_color ) .';
			}
			.section-banner .banner-content .entry-meta a:before {
				color: '. esc_attr( $slider_post_meta_icon_color) .';
			} 
			.section-banner .entry-text {
				color: '. esc_attr( $slider_post_text_color ) .';
			}
			.banner-content .entry-content .entry-header .cat-links a:hover, 
			.banner-content .entry-content .entry-header .cat-links a:focus, 
			.banner-content .entry-content .entry-header .cat-links a:active,
			.banner-content .entry-title a:hover,
			.banner-content .entry-title a:focus,
			.banner-content .entry-title a:active,
			.section-banner .banner-content .entry-meta a:hover, 
			.section-banner .banner-content .entry-meta a:focus, 
			.section-banner .banner-content .entry-meta a:active,
			.section-banner .banner-content .entry-meta a:hover:before, 
			.section-banner .banner-content .entry-meta a:focus:before, 
			.section-banner .banner-content .entry-meta a:active:before {
				color: '. esc_attr( $separate_hover_color_for_main_slider ) .';
			}
			.banner-content .entry-content .entry-header .cat-links a:hover, .banner-content .entry-content .entry-header .cat-links a:focus, .banner-content .entry-content .entry-header .cat-links a:active {
				border-color: '. esc_attr( $separate_hover_color_for_main_slider ) .';
			}
		';

		# Slider Button
		if( !get_theme_mod( 'hide_slider_button', false ) ){
			$slider_btn_defaults = array(
				array(
					'slider_btn_type' 			=> 'button-outline',
					'slider_btn_bg_color' 		=> '#EB5A3E',
					'slider_btn_border_color' 	=> '#ffffff',
					'slider_btn_text_color' 	=> '#ffffff',
					'slider_btn_hover_color' 	=> '#086abd',
					'slider_btn_text' 			=> '',
					'slider_btn_radius' 		=> 0,
				),		
			);
			$slider_button = get_theme_mod( 'main_slider_button_repeater', $slider_btn_defaults );
			if( !empty( $slider_button ) && is_array( $slider_button ) ){
		    	foreach( $slider_button as $value ){
		    		$slider_btn_bg_color 		= $value['slider_btn_bg_color'];
		    		$slider_btn_border_color 	= $value['slider_btn_border_color'];
		    		$slider_btn_text_color 		= $value['slider_btn_text_color'];
		    		$slider_btn_hover_color 	= $value['slider_btn_hover_color'];
		    		$slider_btn_radius 			= $value['slider_btn_radius'];
		    		if( $value['slider_btn_type'] == 'button-primary' ){
			    		$css .= '
							.section-banner .slide-inner .banner-content .button-container .button-primary {
								background-color: '. esc_attr( $slider_btn_bg_color ) .';
								color: '. esc_attr( $slider_btn_text_color ) .';
							}
							.section-banner .slide-inner .banner-content .button-container .button-primary:hover,
							.section-banner .slide-inner .banner-content .button-container .button-primary:focus,
							.section-banner .slide-inner .banner-content .button-container .button-primary:active {
								background-color: '. esc_attr( $slider_btn_hover_color ) .';
								color: #FFFFFF;
							}
							.section-banner .slide-inner .banner-content .button-container a {
								border-radius: '. esc_attr( $slider_btn_radius ) .'px;
							}
						';

					}elseif( $value['slider_btn_type'] == 'button-outline' ){
						$css .= '
							.section-banner .slide-inner .banner-content .button-container .button-outline {
								border-color: '. esc_attr( $slider_btn_border_color ) .';
								color: '. esc_attr( $slider_btn_text_color ) .';
							}
							.section-banner .slide-inner .banner-content .button-container .button-outline:hover,
							.section-banner .slide-inner .banner-content .button-container .button-outline:focus,
							.section-banner .slide-inner .banner-content .button-container .button-outline:active {
								background-color: '. esc_attr( $slider_btn_hover_color ) .';
								border-color: '. esc_attr( $slider_btn_hover_color ) .';
								color: #FFFFFF;
							}
							.section-banner .slide-inner .banner-content .button-container a {
								border-radius: '. esc_attr( $slider_btn_radius ) .'px;
							}
						';
					}elseif( $value['slider_btn_type'] == 'button-text' ){
						$css .= '
							.section-banner .slide-inner .banner-content .button-container .button-text {
								color: '. esc_attr( $slider_btn_text_color ) .';
							}
							.section-banner .slide-inner .banner-content .button-container .button-text:hover,
							.section-banner .slide-inner .banner-content .button-container .button-text:focus,
							.section-banner .slide-inner .banner-content .button-container .button-text:active {
								color: '. esc_attr( $slider_btn_hover_color ) .';
							}
						';
					}
		    	}
		    }
		}

		#Image Sizes Slider
		#Cover Size
		if( get_theme_mod( 'main_slider_image_size', 'cover' ) == 'cover' ){
			$css .= '
				.main-slider .banner-img {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: cover;
				}
			';
		}
		#Repeat Size
		elseif( get_theme_mod( 'main_slider_image_size', 'cover' ) == 'pattern' ){
			$css .= '
				.main-slider .banner-img {
					background-position: center center;
					background-repeat: repeat;
					background-size: inherit;
				}
			';
		}
		#Fit Size
		elseif( get_theme_mod( 'main_slider_image_size', 'cover' ) == 'norepeat' ){
			$css .= '
				.main-slider .banner-img {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: inherit;
				}
			';
		}
	}
	# Banner
	elseif( get_theme_mod( 'main_slider_controls', 'slider' ) == 'banner' ){
		#Blog Banner Color 
		$background_color_main_banner = get_theme_mod( 'background_color_main_banner', '');
		$banner_title_color 	= get_theme_mod( 'banner_title_color', '#ffffff' );
		$banner_subtitle_color 	= get_theme_mod( 'banner_subtitle_color', '#ffffff' );
		$css .= '
			.section-banner .banner-img .overlay {
				background-color: '. esc_attr( $background_color_main_banner ) .';
			}
			.section-banner .banner-content .entry-title {
				color: '. esc_attr( $banner_title_color ) .';
			}
			.section-banner .banner-content .entry-subtitle {
				color: '. esc_attr( $banner_subtitle_color ) .';
			}
		';

		# Banner Button
		if( !get_theme_mod( 'disable_banner_buttons', false ) ){
			$banner_btn_defaults = array(
				array(
					'banner_btn_type' 			=> 'button-outline',
					'banner_btn_bg_color' 		=> '#EB5A3E',
					'banner_btn_border_color' 	=> '#ffffff',
					'banner_btn_text_color' 	=> '#ffffff',
					'banner_btn_hover_color' 	=> '#086abd',
					'banner_btn_text' 			=> '',
					'banner_btn_link' 			=> '',
					'banner_btn_target'			=> true,
					'banner_btn_radius' 		=> 0,
				),	
			);
			$banner_buttons = get_theme_mod( 'main_banner_buttons_repeater', $banner_btn_defaults );
			if( !empty( $banner_buttons ) && is_array( $banner_buttons ) ){
				$i = 1;
		    	foreach( $banner_buttons as $value ){
		    		$banner_btn_bg_color 		= $value['banner_btn_bg_color'];
		    		$banner_btn_border_color 	= $value['banner_btn_border_color'];
		    		$banner_btn_text_color 		= $value['banner_btn_text_color'];
		    		$banner_btn_hover_color 	= $value['banner_btn_hover_color'];
		    		$banner_btn_radius 			= $value['banner_btn_radius'];
		    		if( $value['banner_btn_type'] == 'button-primary' ){
			    		$css .= '
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-primary {
								background-color: '. esc_attr( $banner_btn_bg_color ) .';
								color: '. esc_attr( $banner_btn_text_color ) .';
							}

							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-primary:hover,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-primary:focus,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-primary:active {
								background-color: '. esc_attr( $banner_btn_hover_color ) .';
								border-color: '. esc_attr( $banner_btn_hover_color ) .';
								color: #FFFFFF;
							}

							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-primary {
								border-radius: '. esc_attr( $banner_btn_radius ) .'px;
							}
						';
					}elseif( $value['banner_btn_type'] == 'button-outline' ){
						$css .= '
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-outline {
								border-color: '. esc_attr( $banner_btn_border_color ) .';
								color: '. esc_attr( $banner_btn_text_color ) .';
							}
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-outline:hover,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-outline:focus,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-outline:active {
								background-color: '. esc_attr( $banner_btn_hover_color ) .';
								border-color: '. esc_attr( $banner_btn_hover_color ) .';
								color: #FFFFFF;
							}
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-outline {
								border-radius: '. esc_attr( $banner_btn_radius ) .'px;
							}
						';
					}elseif( $value['banner_btn_type'] == 'button-text' ){
						$css .= '
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-text {
								color: '. esc_attr( $banner_btn_text_color ) .';
								padding: 0;
							}
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-text:hover,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-text:focus,
							.section-banner .banner-content .button-container .banner-btn-'. $i .'.button-text:active {
								color: '. esc_attr( $banner_btn_hover_color ) .';
							}
						';
					}
					$i++;
		    	}
		    }
		}

		#Image Sizes Banner
		#Cover Size
		if( get_theme_mod( 'main_banner_image_size', 'cover' ) == 'cover' ){
			$css .= '
				.banner-img {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: cover;
				}
			';
		}
		#Repeat Size
		elseif( get_theme_mod( 'main_banner_image_size', 'cover' ) == 'pattern' ){
			$css .= '
				.banner-img {
					background-position: center center;
					background-repeat: repeat;
					background-size: inherit;
				}
			';
		}
		#Fit Size
		elseif( get_theme_mod( 'main_banner_image_size', 'cover' ) == 'norepeat' ){
			$css .= '
				.banner-img {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: inherit;
				}
			';
		}
	}

	# Footer Image Sizes
	#Cover Size
	if( get_theme_mod( 'footer_image_size', 'cover' ) == 'cover' ){
		$css .= '
			.site-footer.has-footer-bg .site-footer-inner {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		';
	}
	#Repeat Size
	elseif( get_theme_mod( 'footer_image_size', 'cover' ) == 'pattern' ){
		$css .= '
			.site-footer.has-footer-bg .site-footer-inner {
				background-position: center center;
				background-repeat: repeat;
				background-size: inherit;
			}
		';
	}
	#Fit Size
	elseif( get_theme_mod( 'footer_image_size', 'cover' ) == 'norepeat' ){
		$css .= '
			.site-footer.has-footer-bg .site-footer-inner {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: inherit;
			}
		';
	}

	# Footer Widget Borders
	if( get_theme_mod( 'disable_footer_widget_title_border', false ) ){
		$css .= '
			.site-footer .widget h2::before {
				display: none;
			}
		';
	}

	if( get_theme_mod( 'disable_footer_widget_list_item_border', false ) ){
		$css .= '
			.latest-posts-widget .post,
			.widget ul li {
				border-bottom: none;
			}
		';
	}

	# Top Footer Area Padding
	$footer_widget_area_top_padding = get_theme_mod( 'footer_widget_area_top_padding', 0 );
	$footer_widget_area_bottom_padding = get_theme_mod( 'footer_widget_area_bottom_padding', 50 );
	$css .= '
		.footer-widget-wrap {
			padding-top: '. $footer_widget_area_top_padding .'px;
			padding-bottom: '. $footer_widget_area_bottom_padding .'px;
		}
	';

	# Top Footer Color
	$top_footer_background_color = get_theme_mod( 'top_footer_background_color', '' );
	$top_footer_widget_title_color = get_theme_mod( 'top_footer_widget_title_color', '#030303' );
	$top_footer_widget_link_color = get_theme_mod( 'top_footer_widget_link_color', '#656565' );
	$top_footer_widget_content_color = get_theme_mod( 'top_footer_widget_content_color', '#656565' );
	$top_footer_widget_link_hover_color = get_theme_mod( 'top_footer_widget_link_hover_color', '#086abd' );
	$css .= '
		.top-footer {
			background-color: '. esc_attr( $top_footer_background_color ) .';
		}
	';

	$css .= '
		.site-footer h1, 
		.site-footer h2, 
		.site-footer h3, 
		.site-footer h4, 
		.site-footer h5, 
		.site-footer h6,
		.site-footer .product-title {
			color: '. esc_attr( $top_footer_widget_title_color ) .';
		}
	';

	$css .= '
		.site-footer .widget .widget-title:before {
			background-color: '. esc_attr( $top_footer_widget_title_color ) .';
		}
	';
	$css .= '
		.site-footer a, 
		.site-footer .widget ul li a,
		.site-footer .widget .tagcloud a,
		.site-footer .post .entry-meta a,
		.site-footer .post .entry-meta a:before {
			color: '. esc_attr( $top_footer_widget_link_color ) .';
		}

		.widget ul li,
		.latest-posts-widget .post {
			border-bottom-color: '. esc_attr( bosa_hex2rgba( $top_footer_widget_link_color, 0.2 ) ).';
		}

		.site-footer .widget .tagcloud a {
			border-color: '. esc_attr( $top_footer_widget_link_color ) .';
		}

		.site-footer,
		.site-footer table th, 
		.site-footer table td,
		.site-footer .widget.widget_calendar table {
			color: '. esc_attr( $top_footer_widget_content_color ) .';
		}

		.site-footer a:hover, 
		.site-footer a:focus, 
		.site-footer a:active, 
		.site-footer .widget ul li a:hover, 
		.site-footer .widget ul li a:focus, 
		.site-footer .widget ul li a:active,
		.site-footer .post .entry-meta a:hover, 
		.site-footer .post .entry-meta a:focus, 
		.site-footer .post .entry-meta a:active,
		.site-footer .post .entry-meta a:hover:before, 
		.site-footer .post .entry-meta a:focus:before, 
		.site-footer .post .entry-meta a:active:before {
			color: '. esc_attr( $top_footer_widget_link_hover_color ) .';
		}

		.site-footer .widget .tagcloud a:hover,
		.site-footer .widget .tagcloud a:focus,
		.site-footer .widget .tagcloud a:active {
			background-color: '. esc_attr( $top_footer_widget_link_hover_color ) .';
			border-color: '. esc_attr( $top_footer_widget_link_hover_color ) .';
			color: #FFFFFF;
		}
	';

	# Bottom Footer Area Padding
	$bottom_footer_area_top_padding = get_theme_mod( 'bottom_footer_area_top_padding', 30 );
	$bottom_footer_area_bottom_padding = get_theme_mod( 'bottom_footer_area_bottom_padding', 30 );
	$css .= '
		.bottom-footer {
			padding-top: '. $bottom_footer_area_top_padding .'px;
			padding-bottom: '. $bottom_footer_area_bottom_padding .'px;
		}
	';

	# Bottom Footer Color
	$bottom_footer_background_color = get_theme_mod( 'bottom_footer_background_color', '' );
	$bottom_footer_text_color = get_theme_mod( 'bottom_footer_text_color', '#656565' );
	$bottom_footer_text_link_color = get_theme_mod( 'bottom_footer_text_link_color', '#383838' );
	$bottom_footer_text_link_hover_color = get_theme_mod( 'bottom_footer_text_link_hover_color', '#086abd' );
	$css .= '
		.bottom-footer {
			background-color: '. esc_attr( $bottom_footer_background_color ) .';
		}
	';

	$css .= '
		.bottom-footer {
			color: '. esc_attr( $bottom_footer_text_color ) .';
		}
	';

	$css .= '
		.site-footer .social-profile ul li a {
			background-color: '. esc_attr( bosa_hex2rgba( $bottom_footer_text_link_color, 0.1 ) ).';
		}
	';

	$css .= '
		.site-info a, .site-footer .social-profile ul li a, .footer-menu ul li a {
			color: '. esc_attr( $bottom_footer_text_link_color ) .';
		}
	';

	$css .= '
		.site-footer .site-info a:hover, 
		.site-footer .site-info a:focus, 
		.site-footer .site-info a:active, 
		.site-footer .footer-menu ul li a:hover,
		.site-footer .footer-menu ul li a:focus,
		.site-footer .footer-menu ul li a:active {
			color: '. esc_attr( $bottom_footer_text_link_hover_color ) .';
		}
		.site-footer .social-profile ul li a:hover, 
		.site-footer .social-profile ul li a:focus, 
		.site-footer .social-profile ul li a:active {
			background-color: '. esc_attr( $bottom_footer_text_link_hover_color ) .';
		}
	';

	# Footer Border
	if( get_theme_mod( 'disable_footer_border', false ) ){
		$css .= '
			.site-footer-five .social-profile,
			.site-footer-eight .social-profile {
				border-bottom: none;
			}
		';
	}

	# Social Media Size
	$social_icons_size = get_theme_mod( 'social_icons_size', 15 );
	$css .= '
		.site-footer .social-profile ul li a {
			font-size: '. esc_attr( $social_icons_size ) .'px;
		}
	';

	#Parallax Scrolling
	if( !get_theme_mod( 'disable_footer_parallax_scrolling', true ) ){
		$css .= '
		.site-footer .site-footer-inner {
				background-position: center center;
				background-attachment: fixed;
			}
		';
	}

	#Image Sizes Featured Posts
	#Cover Size
	if( get_theme_mod( 'feature_posts_image_size', 'cover' ) == 'cover' ){
		$css .= '
			.feature-posts-content-wrap .feature-posts-image {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: cover;
			}
		';
	}
	#Repeat Size
	elseif( get_theme_mod( 'feature_posts_image_size', 'cover' ) == 'pattern' ){
		$css .= '
			.feature-posts-content-wrap .feature-posts-image {
				background-position: center center;
				background-repeat: repeat;
				background-size: inherit;
			}
		';
	}
	#Fit Size
	elseif( get_theme_mod( 'feature_posts_image_size', 'cover' ) == 'norepeat' ){
		$css .= '
			.feature-posts-content-wrap .feature-posts-image {
				background-position: center center;
				background-repeat: no-repeat;
				background-size: inherit;
			}
		';
	}

	#Border Radius Featured Posts
	$feature_posts_radius = get_theme_mod( 'feature_posts_radius', 0 );
	$css .= '
		.feature-posts-content-wrap .feature-posts-image {
    		border-radius: '. esc_attr( $feature_posts_radius ) .'px;
    		overflow: hidden;
    	}
	';

	#Featured Posts Title Alignment
	if( get_theme_mod( 'feature_posts_title_alignment', 'align-bottom' ) == 'align-bottom' ){
		$css .= '
	    	.feature-posts-layout-one .feature-posts-image {
				-webkit-align-items: flex-end;
	    		-moz-align-items: flex-end;
	    		-ms-align-items: flex-end;
	    		-ms-flex-align: flex-end;
	    		align-items: flex-end;
	    	}
	    	.feature-posts-layout-one .feature-posts-content {
	    		margin-bottom: 20px;
	    	}
		';
	}elseif( get_theme_mod( 'feature_posts_title_alignment', 'align-bottom' ) == 'align-top' ) {
		$css .= '
			.feature-posts-layout-one .feature-posts-image {
				-webkit-align-items: flex-start;
	    		-moz-align-items: flex-start;
	    		-ms-align-items: flex-start;
	    		-ms-flex-align: flex-start;
	    		align-items: flex-start;
	    	}
	    	.feature-posts-layout-one .feature-posts-content {
	    		margin-top: 20px;
	    	}
		';
	}elseif( get_theme_mod( 'feature_posts_title_alignment', 'align-bottom' ) == 'align-center' ) {
		$css .= '
			.feature-posts-layout-one .feature-posts-image {
				-webkit-align-items: center;
	    		-moz-align-items: center;
	    		-ms-align-items: center;
	    		-ms-flex-align: center;
	    		align-items: center;
	    	}
		';
	}

	# Preloader logo width
	$preloader_custom_image_width = get_theme_mod( 'preloader_custom_image_width', 40 );
	$css .= '
		.preloader-content {
			max-width: '. esc_attr( $preloader_custom_image_width ) .'px;
			overflow: hidden;
			display: inline-block;
		}
	';
	
	#Global Layouts
	if( get_theme_mod( 'site_layout', 'default' ) == 'box' || get_theme_mod( 'site_layout', 'default' ) == 'frame' ){
		$box_frame_background_color = get_theme_mod( 'box_frame_background_color', '' );
		$css .= '
			/* Box and Frame */
			.site-layout-box:before, 
			.site-layout-frame:before {
				background-color: '. esc_attr( $box_frame_background_color ) .';
			}
		';
		if( get_theme_mod( 'box_frame_image_size', 'cover' ) == 'cover' ){
			$css .= '
				.site-layout-box,
				.site-layout-frame {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: cover;
				}
			';
		}
		elseif( get_theme_mod( 'box_frame_image_size', 'cover' ) == 'pattern' ){
			$css .= '
				.site-layout-box,
				.site-layout-frame {
					background-position: center center;
					background-repeat: repeat;
					background-size: inherit;
				}
			';
		}
		elseif( get_theme_mod( 'box_frame_image_size', 'cover' ) == 'norepeat' ){
			$css .= '
				.site-layout-box,
				.site-layout-frame {
					background-position: center center;
					background-repeat: no-repeat;
					background-size: inherit;
				}
			';
		}
	}

	if( get_theme_mod( 'disable_site_layout_shadow', false ) ){
		$css .= '
			.site-layout-box .site, .site-layout-frame .site {
    			box-shadow: none;
			}
		';
	}

    #Blog Page
    $blog_post_title_color = get_theme_mod( 'blog_post_title_color', '#101010' );
    $blog_post_category_color = get_theme_mod( 'blog_post_category_color', '#EB5A3E' );
    $blog_post_meta_color = get_theme_mod( 'blog_post_meta_color', '#7a7a7a' );
    $blog_post_meta_icon_color = get_theme_mod( 'blog_post_meta_icon_color', '#EB5A3E' );
    $blog_post_text_color = get_theme_mod( 'blog_post_text_color', '#333333' );
    $blog_post_hover_color = get_theme_mod( 'blog_post_hover_color', '#086abd' );
    $latest_posts_radius = get_theme_mod( 'latest_posts_radius', 0 );
    $css .= '
    	#primary article .entry-title {
    		color: '. esc_attr( $blog_post_title_color ) .';
    	}

    	#primary article .entry-title a:hover, 
    	#primary article .entry-title a:focus, 
    	#primary article .entry-title a:active {
    		color: '. esc_attr( $blog_post_hover_color ) .';
    	}
    ';

    $css .= '
    	#primary article .entry-content .entry-header .cat-links a,
    	#primary article .attachment .entry-content .entry-header .cat-links a {
    		color: '. esc_attr( $blog_post_category_color ) .';
    	}

    	#primary article .entry-content .entry-header .cat-links a {
    		border-color: '. esc_attr( $blog_post_category_color ) .';
    	}

    	#primary article .entry-content .entry-header .cat-links a:hover, 
    	#primary article .entry-content .entry-header .cat-links a:focus, 
    	#primary article .entry-content .entry-header .cat-links a:active {
    		color: '. esc_attr( $blog_post_hover_color ) .';
    		border-color: '. esc_attr( $blog_post_hover_color ) .';
    	}
    ';

    $css .= '
    	#primary article .entry-meta a {
    		color: '. esc_attr( $blog_post_meta_color ) .';
    	}
    	#primary article .entry-meta a:before {
    		color: '. esc_attr( $blog_post_meta_icon_color ) .';
    	}
    	#primary article .entry-meta a:hover,
    	#primary article .entry-meta a:focus,
    	#primary article .entry-meta a:active,
    	#primary article .entry-meta a:hover:before,
    	#primary article .entry-meta a:focus:before,
    	#primary article .entry-meta a:active:before {
    		color: '. esc_attr( $blog_post_hover_color ) .';
    	}
    ';

    $css .= '
    	#primary article .entry-text {
    		color: '. esc_attr( $blog_post_text_color ) .';
    	}
    ';

    #Blog Page Radius
    $css .= '
    	#primary article .featured-image a {
    		border-radius: '. esc_attr( $latest_posts_radius ) .'px;
    	}
    	#primary article.sticky .featured-image a { 
    		border-radius: 0px;
    	}
    	article.sticky {
    		border-radius: '. esc_attr( $latest_posts_radius ) .'px;
    	}
    ';

    # Post Button
	if( !get_theme_mod( 'hide_post_button', true ) ){
		$post_btn_defaults = array(
			array(
				'blog_btn_type' 		=> 'button-text',
				'blog_btn_bg_color'		=> '#EB5A3E',
				'blog_btn_border_color'	=> '#1a1a1a',
				'blog_btn_text_color'	=> '#1a1a1a',
				'blog_btn_hover_color'	=> '#086abd',
				'blog_btn_text' 		=> '',
				'blog_btn_radius'		=> 0,
			),		
		);
		$post_button = get_theme_mod( 'blog_page_button_repeater', $post_btn_defaults );
		if( !empty( $post_button ) && is_array( $post_button ) ){
	    	foreach( $post_button as $value ){
	    		$blog_btn_bg_color 		= $value['blog_btn_bg_color'];
	    		$blog_btn_border_color 	= $value['blog_btn_border_color'];
	    		$blog_btn_text_color 	= $value['blog_btn_text_color'];
	    		$blog_btn_hover_color 	= $value['blog_btn_hover_color'];
	    		$blog_btn_radius 		= $value['blog_btn_radius'];
	    		if( $value['blog_btn_type'] == 'button-primary' ){
		    		$css .= '
						#primary article .button-primary {
				    		background-color: '. esc_attr( $blog_btn_bg_color ) .';
				    		color: '. esc_attr( $blog_btn_text_color ) .';
				    	}
				    	#primary article .button-primary:hover,
				    	#primary article .button-primary:focus,
				    	#primary article .button-primary:active {
				    		background-color: '. esc_attr( $blog_btn_hover_color ) .';
				    		border-color: '. esc_attr( $blog_btn_hover_color ) .';
				    		color: #FFFFFF;
				    	}
						#primary article .entry-text .button-container a {
				    		border-radius: '. esc_attr( $blog_btn_radius ) .'px;
				    	}
					';

				}elseif( $value['blog_btn_type'] == 'button-outline' ){
					$css .= '
						#primary article .button-outline {
				    		border-color: '. esc_attr( $blog_btn_border_color ) .';
				    		color: '. esc_attr( $blog_btn_text_color ) .';
				    	}
				    	#primary article .button-outline:hover,
				    	#primary article .button-outline:focus,
				    	#primary article .button-outline:active {
				    		background-color: '. esc_attr( $blog_btn_hover_color ) .';
				    		border-color: '. esc_attr( $blog_btn_hover_color ) .';
				    		color: #FFFFFF;
				    	}
						#primary article .entry-text .button-container a {
				    		border-radius: '. esc_attr( $blog_btn_radius ) .'px;
				    	}
					';
				}elseif( $value['blog_btn_type'] == 'button-text' ){
					$css .= '
						#primary article .button-text {
				    		color: '. esc_attr( $blog_btn_text_color ) .';
				    		padding: 0;
				    	}
				    	#primary article .button-text:hover,
				    	#primary article .button-text:focus,
				    	#primary article .button-text:active {
				    		color: '. esc_attr( $blog_btn_hover_color ) .';
				    	}
					';
				}
	    	}
	    }
	}

	# Blog Homepage
	# Feature Posts
	$featured_post_title_color = get_theme_mod( 'featured_post_title_color', '#FFFFFF' );
	$featured_post_category_bgcolor = get_theme_mod( 'featured_post_category_bgcolor', '#EB5A3E' );
    $featured_post_category_color = get_theme_mod( 'featured_post_category_color', '#FFFFFF' );
    $featured_post_meta_color = get_theme_mod( 'featured_post_meta_color', '#FFFFFF' );
    $featured_post_meta_icon_color = get_theme_mod( 'featured_post_meta_icon_color', '#FFFFFF' );
    $featured_post_hover_color = get_theme_mod( 'featured_post_hover_color', '#a8d8ff' );
    $css .= '
    	.feature-posts-content .feature-posts-title {
    		color: '. esc_attr( $featured_post_title_color) .';
    	}
    	.feature-posts-layout-one .feature-posts-content .feature-posts-title a:after {
    		background-color: '. esc_attr( $featured_post_title_color) .';
    	}
    	.feature-posts-content .feature-posts-title a:hover, 
    	.feature-posts-content .feature-posts-title a:focus, 
    	.feature-posts-content .feature-posts-title a:active {
    		color: '. esc_attr( $featured_post_hover_color ) .';
    	}
    	.feature-posts-layout-one .feature-posts-content .feature-posts-title a:hover:after, 
    	.feature-posts-layout-one .feature-posts-content .feature-posts-title a:focus:after, 
    	.feature-posts-layout-one .feature-posts-content .feature-posts-title a:active:after {
    		background-color: '. esc_attr( $featured_post_hover_color ) .';
    	}
    ';

    $css .= '
		.feature-posts-content .cat-links a {
    		color: '. esc_attr( $featured_post_category_color ) .';
    	}
    	.feature-posts-layout-one .feature-posts-content .cat-links a {
    		background-color: '. esc_attr( $featured_post_category_bgcolor ) .';
    	}
    	.feature-posts-layout-one .feature-posts-content .cat-links a:hover,
    	.feature-posts-layout-one .feature-posts-content .cat-links a:focus,
    	.feature-posts-layout-one .feature-posts-content .cat-links a:active {
    		background-color: '. esc_attr( $featured_post_hover_color ) .';
    		color: #FFFFFF;
    	}
    ';

    $css .= '
    	.post .feature-posts-content .entry-meta a {
    		color: '. esc_attr( $featured_post_meta_color ) .';
    	}
    	.post .feature-posts-content .entry-meta a:before {
    		color: '. esc_attr( $featured_post_meta_icon_color ) .';
    	}
    	.post .feature-posts-content .entry-meta a:hover, 
    	.post .feature-posts-content .entry-meta a:focus, 
    	.post .feature-posts-content .entry-meta a:active,
    	.post .feature-posts-content .entry-meta a:hover:before, 
    	.post .feature-posts-content .entry-meta a:focus:before, 
    	.post .feature-posts-content .entry-meta a:active:before {
    		color: '. esc_attr( $featured_post_hover_color ) .';
    	}
    ';

	$feature_posts_height = get_theme_mod( 'feature_posts_height', 250 );
	$css .= '
		.feature-posts-layout-one .feature-posts-image {
			height: '. esc_attr( $feature_posts_height ) .'px;
			overflow: hidden;
		}
	';

	# Feature Posts
	if(  get_theme_mod( 'disable_feature_posts_title', false ) || get_theme_mod( 'disable_feature_title_divider', false ) ){
		$css .= '
			.feature-posts-layout-one .feature-posts-content .feature-posts-title a:after {
    			display: none;
			}
		';
	}

	# Responsive
	# Responsive Footer Social Icons 
	if( get_theme_mod( 'disable_mobile_social_icons_footer', false ) ){
		$css .= '
			@media screen and (max-width: 991px){
				.site-footer .social-profile {
	    			display: none;
				}
			}
		';
	}


	# Responsive Main Slider / Banner
	if( get_theme_mod( 'disable_mobile_main_slider', false ) ){
		$css .= '
			@media screen and (max-width: 767px){
				.main-slider, .section-banner {
	    			display: none;
				}
			}
		';
	}

	# Responsive Featured Posts
	if( get_theme_mod( 'disable_mobile_feature_posts', false ) ){
		$css .= '
			@media screen and (max-width: 767px){
				.section-feature-posts-area {
	    			display: none;
				}
			}
		';
	}

	# Responsive Latest Posts
	if( get_theme_mod( 'disable_mobile_latest_posts', false ) ){
		$css .= '
			@media screen and (max-width: 767px){
				.section-post-area {
	    			display: none;
				}
			}
		';
	}

	# Responsive Highlight Posts
	if( get_theme_mod( 'disable_mobile_highlight_posts', false ) ){
		$css .= '
			@media screen and (max-width: 767px){
				.section-highlight-post {
	    			display: none;
				}
			}
		';
	}

	# Highlight Posts Colors
	$highlight_post_title_color = get_theme_mod( 'highlight_post_title_color', '#030303' );
    $highlight_post_category_bgcolor = get_theme_mod( 'highlight_post_category_bgcolor', '#1f1f1f' );
    $highlight_post_category_color = get_theme_mod( 'highlight_post_category_color', '#FFFFFF' );
    $highlight_post_meta_color = get_theme_mod( 'highlight_post_meta_color', '#7a7a7a' );
    $highlight_post_meta_icon_color = get_theme_mod( 'highlight_post_meta_icon_color', '#EB5A3E' );
    $highlight_post_hover_color = get_theme_mod( 'highlight_post_hover_color', '#086abd' );
    $css .= '
    	.highlight-post-slider .post .entry-content .entry-title {
    		color: '. esc_attr( $highlight_post_title_color ) .';
    	}
    	.highlight-post-slider .entry-content .entry-title a:hover,
    	.highlight-post-slider .entry-content .entry-title a:focus,
    	.highlight-post-slider .entry-content .entry-title a:active {
    		color: '. esc_attr( $highlight_post_hover_color ) .';
    	}
    	.highlight-post-slider .post .cat-links a {
    		background-color: '. esc_attr( $highlight_post_category_bgcolor ) .';
    	}
    	.highlight-post-slider .post .cat-links a {
    		color: '. esc_attr( $highlight_post_category_color ) .';
    	}
    	.highlight-post-slider .post .cat-links a:hover,
    	.highlight-post-slider .post .cat-links a:focus,
    	.highlight-post-slider .post .cat-links a:active {
    		background-color: '. esc_attr( $highlight_post_hover_color ) .';
    		color: #FFFFFF;
    	}
    	.highlight-post-slider .post .entry-meta a {
    		color: '. esc_attr( $highlight_post_meta_color ) .';
    	}
    	.highlight-post-slider .post .entry-meta a:before {
    		color: '. esc_attr( $highlight_post_meta_icon_color ) .';
    	}
    	.highlight-post-slider .post .entry-meta a:hover,
    	.highlight-post-slider .post .entry-meta a:focus,
    	.highlight-post-slider .post .entry-meta a:active,
    	.highlight-post-slider .post .entry-meta a:hover:before,
    	.highlight-post-slider .post .entry-meta a:focus:before,
    	.highlight-post-slider .post .entry-meta a:active:before {
    		color: '. esc_attr( $highlight_post_hover_color ) .';
    	}
    ';

	# Highlight Posts Border Radius
	$highlight_posts_radius = get_theme_mod( 'highlight_posts_radius', 0 );
	$css .= '
		.section-highlight-post .featured-image a {
			border-radius: '. esc_attr( $highlight_posts_radius ) .'px;
			overflow: hidden;
		}
	';

	#Bottom Footer image width
	if( get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_one' || get_theme_mod( 'footer_layout', 'footer_one' ) == 'footer_two' ){
		$bottom_footer_image_width = get_theme_mod( 'bottom_footer_image_width', 270 );
		$css .= '
			.bottom-footer-image-wrap > a {
				max-width: '. esc_attr( $bottom_footer_image_width ) .'px;
				overflow: hidden;
				display: inline-block;
			}
		';
	}

	# Responsive Footer Widget
	if( get_theme_mod( 'disable_responsive_footer_widget', false ) ){
		$css .= '
			@media screen and (max-width: 767px){
				.top-footer {
	    			display: none;
				}
			}
		';
	}

	# Responsive Scroll to Top
	if( get_theme_mod( 'disable_mobile_scroll_top', true ) ){
		$css .= '
			@media screen and (max-width: 767px){
				#back-to-top {
	    			display: none !important;
				}
			}
		';
	}


	# Sidebar Border
	if( get_theme_mod( 'disable_sidebar_widget_title_border', false ) ){
		$css .= '
			.sidebar .widget .widget-title::before,
			.sidebar .widget .widget-title::after{
	    		display: none;
			}
		';
	}

	# Theme Skins
	# Dark Skin
	if( get_theme_mod( 'skin_select', 'default' ) == 'dark' ){
		$css .= '
			body,
			body.custom-background,
			.site-content {
			  	background-color: #000000;
			  	color: #c7c7c7;
			}
			h1, h2, h3, h4, h5, h6, .entry-title, #primary article .entry-title, body.single .page-title, body.page .page-title,
			.highlight-post-slider .post .entry-content .entry-title {
			  	color: #ffffff;
			}
			table th, table td, table.wishlist_table tbody td, table.wishlist_table thead th {
				border-color: #262626;
			}
			input[type=text], input[type=email], 
			input[type=url], input[type=password], 
			input[type=search], input[type=number], 
			input[type=tel], input[type=range], 
			input[type=date], input[type=month], 
			input[type=week], input[type=time], 
			input[type=datetime], 
			input[type=datetime-local], 
			input[type=color],
			textarea,
			.select2-container--default .select2-selection--single {
			  background-color: #000000;
			  border-color: #262626;
			  color: #ffffff;
			}
			input[type=text]:focus, 
			input[type=text]:active, 
			input[type=email]:focus, 
			input[type=email]:active, 
			input[type=url]:focus, 
			input[type=url]:active, 
			input[type=password]:focus, 
			input[type=password]:active, 
			input[type=search]:focus, 
			input[type=search]:active, 
			input[type=number]:focus, 
			input[type=number]:active, 
			input[type=tel]:focus, 
			input[type=tel]:active, 
			input[type=range]:focus, 
			input[type=range]:active, 
			input[type=date]:focus, 
			input[type=date]:active, 
			input[type=month]:focus, 
			input[type=month]:active, 
			input[type=week]:focus, 
			input[type=week]:active, 
			input[type=time]:focus, 
			input[type=time]:active, 
			input[type=datetime]:focus, 
			input[type=datetime]:active, 
			input[type=datetime-local]:focus, 
			input[type=datetime-local]:active, 
			input[type=color]:focus, 
			input[type=color]:active,
			textarea:focus,
			textarea:active {
			  	border-color: #ffffff;
			}
			.button-outline {
			  	border-color: #e6e6e6;
			  	color: #e6e6e6;
			}
			.button-outline:hover, 
			.button-outline:active, 
			.button-outline:focus {
		  		border-color: #086abd;
			  	color: #ffffff;
			}
			.button-text,
			#primary .post .button-text {
			  	color: #e6e6e6;
			}
			.button-text:hover, 
			.button-text:focus, 
			.button-text:active {
			  	color: #086abd;
			}
			blockquote {
				background-color: #1a1a1a;
			  	color: #c7c7c7;
			}
			.wp-block-quote cite {
				color: #c7c7c7;
			}
			blockquote:before {
				background-color: #1a1a1a;
			  	border-bottom-color: #cccccc;
			  	border-top-color: #cccccc;
			}
			blockquote:after {
			  	background-color: #000000;
			  	color: #cccccc;
			}
			.header-one .header-contact ul li, .header-one .header-contact ul li a, 
			.header-one .social-profile ul li a, 
			.header-one .header-icons .search-icon, 
			.header-two .header-contact ul li, 
			.header-two .header-contact ul li a, 
			.header-two .social-profile ul li a, 
			.header-two .header-icons .search-icon, 
			.header-three .header-navigation ul.menu > li > a, 
			.header-three .alt-menu-icon .iconbar-label, 
			.header-three .social-profile ul li a {
				color: #D5D5D5;
			}
			.header-one .alt-menu-icon .icon-bar, 
			.header-one .alt-menu-icon .icon-bar:before, 
			.header-one .alt-menu-icon .icon-bar:after,
			.header-two .alt-menu-icon .icon-bar, 
			.header-two .alt-menu-icon .icon-bar:before, 
			.header-two .alt-menu-icon .icon-bar:after,
			.header-three .alt-menu-icon .icon-bar, 
			.header-three .alt-menu-icon .icon-bar:before, 
			.header-three .alt-menu-icon .icon-bar:after {
				background-color: #D5D5D5;
			}
			.site-header .site-branding .site-title,
			.site-header .site-branding .site-description {
				color: #FFFFFF;
			}
			.site-header.sticky-header .fixed-header {
				background-color: #000000;
			}
			body:not(.home) .site-header .bottom-header {
			    border-color: #000000;
			}
			.post:not(.list-post) .entry-content {
			  	border-color: #1a1a1a;
			}
			body:not(.custom-background), body.custom-background .site-content .container {
				background-color: #000000;
			}
			.main-navigation ul.menu > li > a:hover, 
			.main-navigation ul.menu > li > a:focus, 
			.main-navigation ul.menu > li > a:active {
			  	color: #086abd;
			}
			.main-navigation ul.menu ul {
			  	background-color: #050505;
			}
			.main-navigation ul.menu ul li {
			  	border-color: #1a1a1a;
			}
			.main-navigation ul.menu ul li a {
				color: #B1B1B1;
			}
			.main-navigation ul.menu ul li a:hover, 
			.main-navigation ul.menu ul li a:focus, 
			.main-navigation ul.menu ul li a:active {
			  	color: #086abd;
			}
			.site-header .bottom-header,
			.site-header .top-header,
			.site-header .mid-header,
			.site-footer {
			  	background-color: #000000;
			}
			.site-header.header-two .top-header {
				background-color: transparent;
			}
			.site-header .top-header,
			.header-three .mid-header,
			.mid-header {
			  	border-bottom-color: #292929;
			}
			.header-search {
				background-color: #000000;
			}
			.header-search .search-form .search-button,
			.header-search .close-button {
				color: #969696;
			}
			.header-sidebar .widget,
			#offcanvas-menu .header-contact, 
			#offcanvas-menu .social-profile, 
			#offcanvas-menu .header-btn-wrap, 
			#offcanvas-menu .header-search-wrap, 
			#offcanvas-menu .header-navigation, 
			#offcanvas-menu .header-date, 
			offcanvas-menu .header-advertisement-banner {
				background-color: #131313;
			}
			#offcanvas-menu .header-contact ul li,
			#offcanvas-menu .header-contact ul li a, 
			#offcanvas-menu .header-contact ul li span, 
			#offcanvas-menu .header-contact ul li i,
			#offcanvas-menu .social-profile ul li a {
				color: #FFFFFF;
			}
			.home .site-content {
			    border-top: 1px solid #292929;
			}
			.site-content {
				border-top-color: #292929;
			}
			.site-header .site-branding .site-title {
			  	color: #ffffff;
			}
			.site-header .main-navigation ul.menu > li > a, 
			.social-profile ul li a,
			.site-header .header-icons .search-icon {
				color: #D5D5D5;
			}
			.alt-menu-icon .icon-bar, 
			.alt-menu-icon .icon-bar:before, 
			.alt-menu-icon .icon-bar:after {
				background-color: #D5D5D5;
			}
			@media screen and (max-width: 991px) {
			  	.header-search-wrap .search-button {
			    	color: #ffffff;
			  	}
			}
			.section-banner .slick-slide {
			  	background-color: #060606;
			}
			.section-banner .post {
			  	background-color: #000000;
			}
			.post .entry-text,
			#primary .post .entry-text {
				color: #c7c7c7;
			}
			.highlight-post-slider .post,
			.wrap-ralated-posts .post .entry-content {
			  	background-color: #000000;
			}
			.site-content .list-post,
			.site-content .single-post {
				border-bottom-color: #1a1a1a;
			}
			.page-numbers {
				border-color: #1a1a1a;
			}
			.sticky {
				-webkit-box-shadow: none;
    			-moz-box-shadow: none;
    			-ms-box-shadow: none;
    			-o-box-shadow: none;
    			box-shadow: none;
    			border: 2px solid #1a1a1a;
			}
			.site-footer h1, 
			.site-footer h2, 
			.site-footer h3, 
			.site-footer h4, 
			.site-footer h5, 
			.site-footer h6,
			.site-footer .product-title {
				color: #ffffff;
			}
			.site-footer .widget .widget-title:before {
				background-color: #ffffff;
			}
			.site-footer .site-info a {
			  	color: #ffffff;
			}
			.site-footer .site-info a:hover, 
			.site-footer .site-info a:focus, 
			.site-footer .site-info a:active {
			  	color: #086abd;
			}
			.site-footer .footer-menu ul li {
			  	border-color: #2A2A2A;
			}
			.site-footer .widget .widget-title:before {
			  	background-color: #ffffff;
			}
			.breadcrumb-wrap .breadcrumbs {
			  	background-color: #080808;
			}
			.comments-area .comment-list .comment-body {
			  	background-color: #000000;
			  	border-color: #1a1a1a;
			}
			.comments-area .comment-list .comment-author .avatar {
			  	background-color: #1a1a1a;
			  	border-color: #000000;
			}
			.comments-area .comment-respond .comment-form .comment-notes {
			  	color: #cccccc;
			}
			.comments-area .comment-respond .comment-form .comment-notes span {
			  	color: #ffffff;
			}
			.author-info .author-content-wrap {
			  	background-color: #060606;
			}
			.post-navigation {
			  	border-bottom-color: #1a1a1a;
			  	border-top-color: #1a1a1a;
			}
			.comment-navigation .nav-previous a, 
			.comment-navigation .nav-next a,
			.post-navigation .nav-previous a,
			.post-navigation .nav-next a {
			  	color: #cccccc;
			}
			.comment-navigation .nav-previous a:hover, 
			.comment-navigation .nav-previous a:focus, 
			.comment-navigation .nav-previous a:active, 
			.comment-navigation .nav-next a:hover, 
			.comment-navigation .nav-next a:focus, 
			.comment-navigation .nav-next a:active,
			.post-navigation .nav-previous a:hover,
			.post-navigation .nav-previous a:focus,
			.post-navigation .nav-previous a:active,
			.post-navigation .nav-next a:hover,
			.post-navigation .nav-next a:focus,
			.post-navigation .nav-next a:active {
			  	color: #086abd;
			}
			.comments-area .comment-respond label {
			  	color: #e6e6e6;
			}
			body[class*="woocommerce"] .woocommerce-result-count,
			body[class*="woocommerce"] .woocommerce-ordering select,
			body[class*="woocommerce"] select {
			  	background-color: #0d0d0d;
			  	border-color: #0d0d0d;
			  	color: #cccccc;
			}
			body[class*="woocommerce"] ul.products li.product .price {
			  	color: #ffffff;
			}
			body[class*="woocommerce"] ul .product-inner {
			  	border-color: #1a1a1a;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs:before {
			  	border-color: #333333;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li {
			  	background-color: #333333;
			  	border-color: #333333;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li:before {
			  	box-shadow: 2px 2px 0 #333333;
			  	border-color: #333333;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li:after {
			  	box-shadow: -2px 2px 0 #333333;
			  	border-color: #333333;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li.active {
			  	background-color: #000000;
			  	border-bottom-color: #000000;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li.active:before {
			  	box-shadow: 2px 2px 0 #000000;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li.active:after {
			  	box-shadow: -2px 2px 0 #000000;
			}
			body[class*="woocommerce"] div.product .woocommerce-tabs ul.tabs li a {
			  	color: #d6d6d6;
			}
			.woocommerce ul.products.columns-3 li.product, 
			.woocommerce-page ul.products.columns-3 li.product {
				border-right-color: #454545;
			}
			.product .product-compare-wishlist {
				border-top-color: #454545;
			}
			.woocommerce .woocommerce-tabs .woocommerce-Tabs-panel {
				border-left-color: #333333;
    			border-right-color: #333333;
    			border-bottom-color: #333333;
			}
			.product-inner ~ a.yith-wcqv-button {
				border-color: #454545;
				color: #454545;
			}
			.widget ul li {
			  	border-bottom-color: #1a1a1a;
			}
			.widget ul li a {
				color: #FFFFFF;
			}
			.widget .tagcloud a {
			  	color: #e6e6e6;
			}
			.widget .tagcloud a:hover, 
			.widget .tagcloud a:focus, 
			.widget .tagcloud a:active {
			  	color: #ffffff;
			}
			.latest-posts-widget .post {
			  	border-bottom-color: #1a1a1a;
			}
			.widget_calendar table {
			    border-color: #1a1a1a;
			}
			.widget.widget_calendar table thead th {
			    border-right-color: #1a1a1a;
			}
			.widget_calendar table th, 
			.widget_calendar table td {
			    border-bottom-color: #1a1a1a;
			}
			body.search-results .hentry,
			body.search-results .product {
			  	border-color: #1a1a1a;
			}
			.slicknav_btn .slicknav_icon span,
			.slicknav_btn .slicknav_icon span:before,
			.slicknav_btn .slicknav_icon span:after {
			  	background-color: #ffffff;
			}
			.slicknav_btn.slicknav_open span {
			  	background-color: transparent;
			}
			.section-banner .main-slider-three .post {
			  	background-color: transparent;
			}
			.slicknav_menu .slicknav_nav {
			  	background-color: #000000;
			}
			.slicknav_menu ul.slicknav_nav {
			  	background-color: #000000;
			}
			.slicknav_menu ul.slicknav_nav li > a {
			  	border-top-color: #1a1a1a;
			  	color: #cccccc;
			}
			.mobile-menu-container .slicknav_menu .slicknav_nav li {
				border-top-color: #1a1a1a;
			}
			.slicknav_menu ul.slicknav_nav li > a, 
			.slicknav_menu ul.slicknav_nav li > .slicknav_parent-link > a {
			    border-top-color: #1a1a1a;
			    color: #cccccc;
			}
			.mobile-menu-container .slicknav_menu .slicknav_row .slicknav_item {
			    border-left-color: #1a1a1a;
			}
			#offcanvas-menu {
			  	background-color: #060606;
			}
			#offcanvas-menu .header-navigation ul.menu > li {
				border-bottom-color: #1a1a1a;
			}
			#offcanvas-menu .header-navigation ul.menu > li a {
				color: #cccccc;
			}
			.bottom-footer,
			.site-footer .social-profile ul li a, 
			.footer-menu ul li a {
				color: #cccccc;
			}
			.site-footer .social-profile ul li a {
				background-color: rgba(255, 255, 255, 0.1);
			}
			.woocommerce-Reviews {
			  	color: #404040;
			}
			body.site-layout-box, body.site-layout-frame {
			  	background-color: #0a0a0a;
			}
			body.site-layout-box .site, body.site-layout-frame .site {
			  	background-color: #000000;
			}
			.breadcrumb-wrap {
			    background-color: transparent;
			}
			.site-header [class*="header-btn-"].button-outline {
				border-color: #969696;
				color: #969696;
			}
			.woocommerce div.product p.price {
				color: #FFFFFF;
			}
			.woocommerce .product_meta,
			#add_payment_method .cart-collaterals .cart_totals tr td, 
			#add_payment_method .cart-collaterals .cart_totals tr th, 
			.woocommerce-cart .cart-collaterals .cart_totals tr td, 
			.woocommerce-cart .cart-collaterals .cart_totals tr th, 
			.woocommerce-checkout .cart-collaterals .cart_totals tr td, 
			.woocommerce-checkout .cart-collaterals .cart_totals tr th {
				border-top-color: #333333;
			}
			.woocommerce-error, 
			.woocommerce-info, 
			.woocommerce-message,
			#add_payment_method #payment, 
			.woocommerce-cart #payment, 
			.woocommerce-checkout #payment,
			.select2-dropdown {
				background-color: #1a1a1a;
				color: #cccccc;
			}
			.comment-respond .comment-form .comment-notes span,
			.woocommerce-Reviews,
			.woocommerce-tabs .comment-respond label,
			.comment-respond .comment-form .comment-notes, {
				color: #cccccc;
			}
			.select2-container--default .select2-selection--single .select2-selection__rendered {
				color: #ffffff;
			}
			#add_payment_method #payment ul.payment_methods, 
			.woocommerce-cart #payment ul.payment_methods, 
			.woocommerce-checkout #payment ul.payment_methods,
			.woocommerce form.checkout_coupon, .woocommerce form.login, .woocommerce form.register {
				border-color: #333333;
			}
			body[class*="woocommerce"] ul.products.columns-3 li.product,
			.woocommerce .woocommerce-MyAccount-navigation ul li,
			#add_payment_method table.cart td.actions .coupon .input-text, 
			.woocommerce-cart table.cart td.actions .coupon .input-text, 
			.woocommerce-checkout table.cart td.actions .coupon .input-text {
				border-color: #333333;
			}
			body[class*="woocommerce"] a.added_to_cart {
				color: #cccccc;
				border-color: #333333;
			}
			body .woocommerce .woocommerce-MyAccount-navigation ul li a {
				color: #cccccc;
			}
			body .select2-container--default .select2-results__option[aria-selected=true], 
			body .select2-container--default .select2-results__option[data-selected=true] {
				background-color: inherit;
			}
			.widget.widget_recently_viewed_products li .product-title, 
			.widget.widget_recent_reviews li .product-title, 
			.widget.widget_products .product_list_widget li .product-title {
				color: #ffffff;
			}
			.widget .tagcloud a:hover, 
			.widget .tagcloud a:focus, 
			.widget .tagcloud a:active, 
			.woocommerce button.button.alt:hover, 
			.woocommerce button.button.alt:focus, 
			.woocommerce button.button.alt:active, 
			.woocommerce .widget.widget_product_search [type=submit]:hover, 
			.woocommerce .widget.widget_product_search [type=submit]:focus, 
			.woocommerce .widget.widget_product_search [type=submit]:active {
				background-color: '. esc_attr( $site_hover_color ) .';
			}
			.button-outline:hover, 
			.button-outline:active, 
			.button-outline:focus,
			.product-inner ~ a.yith-wcqv-button:hover,
			.product-inner ~ a.yith-wcqv-button:focus,
			.product-inner ~ a.yith-wcqv-button:active {
				border-color: '. esc_attr( $site_hover_color ) .';
			}
			.button-text:hover, .button-text:focus, 
			.button-text:active, 
			.main-navigation ul.menu > li > a:hover, 
			.main-navigation ul.menu > li > a:focus, 
			.main-navigation ul.menu > li > a:active, 
			.comment-navigation .nav-previous a:hover, 
			.comment-navigation .nav-previous a:focus, 
			.comment-navigation .nav-previous a:active, 
			.comment-navigation .nav-next a:hover, 
			.comment-navigation .nav-next a:focus, 
			.comment-navigation .nav-next a:active, 
			.post-navigation .nav-previous a:hover,
			.post-navigation .nav-previous a:focus, 
			.post-navigation .nav-previous a:active,
			.post-navigation .nav-next a:hover, 
			.post-navigation .nav-next a:focus, 
			.post-navigation .nav-next a:active, 
			.site-footer .site-info a:hover, 
			.site-footer .site-info a:focus, 
			.site-footer .site-info a:active, 
			.woocommerce .product_meta .posted_in a:hover, 
			.woocommerce .product_meta .posted_in a:focus, 
			.woocommerce .product_meta .posted_in a:active, 
			.woocommerce .product_meta .tagged_as a:hover, 
			.woocommerce .product_meta .tagged_as a:focus, 
			.woocommerce .product_meta .tagged_as a:active, 
			.main-navigation ul.menu ul li a:hover, 
			.main-navigation ul.menu ul li a:focus, 
			.main-navigation ul.menu ul li a:active,
			.widget.widget_recently_viewed_products li .product-title:hover, 
			.widget.widget_recently_viewed_products li .product-title:active, 
			.widget.widget_recent_reviews li .product-title:hover, 
			.widget.widget_recent_reviews li .product-title:active, 
			.widget.widget_products .product_list_widget li .product-title:hover,
			.widget.widget_products .product_list_widget li .product-title:active {
				color: '. esc_attr( $site_hover_color ) .';
			}
			@media only screen and (max-width: 991px) {
				.mobile-menu-container .slicknav_menu .slicknav_menutxt, 
				.alt-menu-icon .iconbar-label {
				    color: #D5D5D5;
				}
				.header-one .bottom-header {
					border-bottom-color: #292929;
				}
				header.site-header .alt-menu-icon .icon-bar, 
				header.site-header .alt-menu-icon .icon-bar:before, 
				header.site-header .alt-menu-icon .icon-bar:after,
				.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span, 
				.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:before, 
				.mobile-menu-container .slicknav_menu .slicknav_btn .slicknav_icon span:first-child:after {
					background-color: #D5D5D5;
				}
			}
			@media only screen and (max-width: 575px) {
				.comments-area .comment-list .comment-metadata {
					border-top-color: #1a1a1a;
				}
			}
		';
	}
	# Black and White
	elseif( get_theme_mod( 'skin_select', 'default' ) == 'blackwhite' ){
		$css .= '
			body.black-white-skin .button-primary {
				background-color: #333333;
			}
			body.black-white-skin .notification-bar .button-primary {
				background-color: #ffffff;
				color: #333333;
			}
			body.black-white-skin .post .entry-content .entry-header .cat-links a, 
			body.black-white-skin .attachment .entry-content .entry-header .cat-links a, 
			body.black-white-skin .banner-content .entry-content .entry-header .cat-links a {
				color: #7a7a7a;
				border-bottom-color: #7a7a7a; 
			}
			body.black-white-skin .post .entry-meta a:before, 
			body.black-white-skin .attachment .entry-meta a:before, 
			body.black-white-skin .banner-content .entry-meta a:before {
				color: #7a7a7a;
			}
			.feature-posts-content-wrap .feature-posts-image,
			.main-slider .banner-img,
			.section-banner .banner-img,
			.site-footer.has-footer-bg .site-footer-inner,
			.header-image-wrap .header-slide-item {
				background-blend-mode: luminosity,normal;
			}
			img,
			.feature-posts-content-wrap a ~  .feature-posts-image {
				filter: grayscale(100%);
				-webkit-filter: grayscale(100%);
			}
			body.black-white-skin .section-title:before {
				background-color: #030303;
			}
			.site-footer.has-footer-bg .site-footer-inner,
			.header-image-wrap .header-slide-item {
				background-color: #cccccc;
			}
		';
	}

	// woocommerce option styles

	// woocommerce product card styles
	$product_card_style 		= get_theme_mod( 'woocommerce_product_card_style', 'card_style_one' );
	// Product image and card radius
	$shop_product_image_radius 	= get_theme_mod( 'shop_product_image_radius', 0 );
	$shop_product_card_radius 	= get_theme_mod( 'shop_product_card_radius', 0 );
	if( $product_card_style == 'card_style_one' ){
		$css .= '
			.products li.product .woo-product-image img {
				border-radius: '. esc_attr( $shop_product_image_radius ) .'px;
			}
		';
	}elseif( $product_card_style == 'card_style_two' ){
		$css .= '
			.product .product-inner {
				border: 1px solid #e6e6e6;
				padding: 15px;
			}
			.product .product-inner {
				border-radius: '. esc_attr( $shop_product_card_radius ) .'px;
				overflow: hidden
			}
			.products li.product .woo-product-image img {
				border-radius: '. esc_attr( $shop_product_image_radius ) .'px;
			}
		';
	}elseif( $product_card_style == 'card_style_three' ){
		$css .= '
			.product .product-inner {
				border: 1px solid #e6e6e6;
			}
			.product .product-inner .product-inner-contents {
				padding: 0 20px 20px;
			}
			.product .product-inner {
				border-radius: '. esc_attr( $shop_product_card_radius ) .'px;
				overflow: hidden;
			}
		';
	}

	// Add to cart Colors
	$add_to_cart_button 	= get_theme_mod( 'woocommerce_add_to_cart_button', 'cart_button_two' );
	$add_to_cart_bg_color 	= get_theme_mod( 'add_to_cart_bg_color', '#333333' );
	$add_to_cart_text_color = get_theme_mod( 'add_to_cart_text_color', '#ffffff' );
	
	if( $add_to_cart_button == 'cart_button_three' ){
		$add_to_cart_text_color = get_theme_mod( 'add_to_cart_black_text_color', '#333333' );
	}elseif( $add_to_cart_button == 'cart_button_four' ){
		$add_to_cart_bg_color 	= get_theme_mod( 'add_to_cart_white_bg_color', '#ffffff' );
		$add_to_cart_text_color = get_theme_mod( 'cart_four_black_text_color', '#333333' );
	}
	$css .= '
		.woocommerce .button-cart_button_two a.button {
			background-color: '. esc_attr( $add_to_cart_bg_color ) .';
			color: '. esc_attr( $add_to_cart_text_color ) .';
		}
		.woocommerce .button-cart_button_three > a {
			border-bottom-color: '. esc_attr( $add_to_cart_text_color ) .';
			color: '. esc_attr( $add_to_cart_text_color ) .';
		}
		.woocommerce .button-cart_button_four > a {
			background-color: '. esc_attr( $add_to_cart_bg_color ) .';
			color: '. esc_attr( $add_to_cart_text_color ) .';
		}
		.woocommerce .button-cart_button_two a.button:hover,
		.woocommerce .button-cart_button_two a.button:focus,
		.woocommerce .button-cart_button_four > a:hover,
		.woocommerce .button-cart_button_four > a:focus {
			background-color: '. esc_attr( $site_hover_color ) .';
			color: #FFFFFF;
		}
		.woocommerce .button-cart_button_three > a:hover,
		.woocommerce .button-cart_button_three > a:focus {
			border-color: '. esc_attr( $site_hover_color ) .';
			color: '. esc_attr( $site_hover_color ) .';
		}
	';

	// Add to cart button radius
	$add_cart_button_radius = get_theme_mod( 'add_cart_button_radius', 0 );
	$css .= '
		.woocommerce .button-cart_button_four > a {
			border-radius: '. esc_attr( $add_cart_button_radius ) .'px;
		}
		.woocommerce .button-cart_button_two a.button {
			border-radius: '. esc_attr( $add_cart_button_radius ) .'px;
		}
	';
	// Add to cart layout four diagonal spacing
	$cart_four_diagonal_spacing = get_theme_mod( 'cart_four_diagonal_spacing', 10 );
	$css .= '
		.woocommerce .button-cart_button_four {
		    left: '. esc_attr( $cart_four_diagonal_spacing ) .'px;
		    bottom: '. esc_attr( $cart_four_diagonal_spacing ) .'px;
		}
	';

	// Sale Tag Layout
	$sale_tag_layout = get_theme_mod( 'woocommerce_sale_tag_layout', 'sale_tag_layout_one' );
	// Sale Button diagonal spacing
	$sale_button_diagonal_spacing = get_theme_mod( 'sale_button_diagonal_spacing', 8 );
	
	$icon_group_layout 				= get_theme_mod( 'icon_group_layout', 'group_layout_one' );

	if( $icon_group_layout != 'group_layout_four' ){
		if( $sale_tag_layout == 'sale_tag_layout_one' ){
			$css .= '
				body[class*="woocommerce"] ul.products li.product .onsale {
					top: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
					right: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
				}
			';
		}elseif( $sale_tag_layout == 'sale_tag_layout_two' ){
			$css .= '
				body[class*="woocommerce"] ul.products li.product .onsale {
					top: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
					left: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
					right: auto;
				}
			';
		}
	}else{
		$css .= '
			body[class*="woocommerce"] ul.products li.product .onsale {
				top: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
				left: '. esc_attr( $sale_button_diagonal_spacing ) .'px;
				right: auto;
			}
		';
	}

	// Sale Tag Colors
	$sale_tag_bg_color = get_theme_mod( 'sale_tag_bg_color', '#EB5A3E' );
	$sale_tag_text_color = get_theme_mod( 'sale_tag_text_color', '#ffffff' );
	$css .= '
		body[class*="woocommerce"] span.onsale {
			background-color: '. esc_attr( $sale_tag_bg_color ) .';
			color: '. esc_attr( $sale_tag_text_color ) .';
		}
	';

	$sale_button_border_radius = get_theme_mod( 'sale_button_border_radius', 0 );
	$css .= '
		body[class*="woocommerce"] span.onsale {
			border-radius: '. esc_attr( $sale_button_border_radius ) .'px;
		}
	';

	// Single Products
	$disable_single_product_sku = get_theme_mod( 'disable_single_product_sku', false );
	$disable_single_product_category = get_theme_mod( 'disable_single_product_category', false );
	$disable_single_product_tags = get_theme_mod( 'disable_single_product_tags', false );

	if( $disable_single_product_sku ){
        $css .= '
			.single-product .product_meta .sku_wrapper {
				display: none !important;
			}
		';
    }
    if( $disable_single_product_category ){
        $css .= '
			.single-product .product_meta .posted_in {
				display: none !important;
			}
		';
    }

    if( $disable_single_product_tags ){
        $css .= '
			.single-product .product_meta .tagged_as {
				display: none !important;
			}
		';
    }

    // disable single product border
    if( $disable_single_product_sku && $disable_single_product_category && $disable_single_product_tags ){
    	$css .= '
			body[class*=woocommerce] .product_meta {
				border-top: none;
				padding-top: 0;
			}
		';
    }

    // Icon Group layout
    $icon_group_layout 				= get_theme_mod( 'icon_group_layout', 'group_layout_one' );
    $icon_group_one_border_radius 	= get_theme_mod( 'icon_group_one_border_radius', 100 );
    $icon_group_two_border_radius 	= get_theme_mod( 'icon_group_two_border_radius', 0 );
    $icon_group_three_border_radius = get_theme_mod( 'icon_group_three_border_radius', 0 );
    $icon_group_four_border_radius 	= get_theme_mod( 'icon_group_four_border_radius', 100 );

    // Icon group layout  diagonal spacing
	$icon_group_diagonal_spacing = get_theme_mod( 'icon_group_diagonal_spacing', 10 );

	if( $icon_group_layout == 'group_layout_one' ){
		$css .= '
			body[class*=woocommerce] ul.products li .product-compare-wishlist a {
				opacity: 0;
				z-index: 99;
			}
			body[class*=woocommerce] ul.products li .product-wishlist a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-50%, -50%);
				-moz-transform: translate(-50%, -50%);
				-ms-transform: translate(-50%, -50%);
				-o-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
			}
			body[class*=woocommerce] ul.products li .product-compare a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-60px, -50%);
				-moz-transform: translate(-60px, -50%);
				-ms-transform: translate(-60px, -50%);
				-o-transform: translate(-60px, -50%);
				transform: translate(-60px, -50%);
			}
			body[class*=woocommerce] ul.products li .product-view a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(25px, -50%);
				-moz-transform: translate(25px, -50%);
				-ms-transform: translate(25px, -50%);
				-o-transform: translate(25px, -50%);
				transform: translate(25px, -50%);
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				background-color: #ffffff;
				border-radius: '. esc_attr( $icon_group_one_border_radius ) .'px;
				line-height: 35px;
				height: 35px;
				text-align: center;
				width: 35px;
			}
			body[class*=woocommerce] ul.products li:hover .product-compare-wishlist a, 
			body[class*=woocommerce] ul.products li:focus .product-compare-wishlist a {
				opacity: 1;
			}
		';
	}elseif( $icon_group_layout == 'group_layout_two' ){
		$css .= '
			body[class*=woocommerce] ul.products li .product-compare-wishlist a {
				opacity: 0;
				z-index: 99;
			}
			body[class*=woocommerce] ul.products li .product-wishlist a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-50%, -50%);
				-moz-transform: translate(-50%, -50%);
				-ms-transform: translate(-50%, -50%);
				-o-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
			}
			body[class*=woocommerce] ul.products li .product-compare a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-45px, -50%);
				-moz-transform: translate(-45px, -50%);
				-ms-transform: translate(-45px, -50%);
				-o-transform: translate(-45px, -50%);
				transform: translate(-45px, -50%);
			}
			body[class*=woocommerce] ul.products li .product-view a {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(11px, -50%);
				-moz-transform: translate(11px, -50%);
				-ms-transform: translate(11px, -50%);
				-o-transform: translate(11px, -50%);
				transform: translate(11px, -50%);
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				background-color: #ffffff;
				line-height: 35px;
				height: 35px;
				text-align: center;
				padding: 0 5px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i {
				padding-left: 16px;
				border-top-left-radius: '. esc_attr( $icon_group_two_border_radius ) .'px;
				border-bottom-left-radius: '. esc_attr( $icon_group_two_border_radius ) .'px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i {
				padding-right: 16px;
				border-top-right-radius: '. esc_attr( $icon_group_two_border_radius ) .'px;
				border-bottom-right-radius: '. esc_attr( $icon_group_two_border_radius ) .'px;
			}
			body[class*=woocommerce] ul.products li:hover .product-compare-wishlist a, 
			body[class*=woocommerce] ul.products li:focus .product-compare-wishlist a {
				opacity: 1;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				font-size: 13px;
			}
		';
	}elseif( $icon_group_layout == 'group_layout_three' ){
		$css .= '
			body[class*=woocommerce] ul.products li .product-compare-wishlist a {
				opacity: 0;
				z-index: 99;
			}
			body[class*=woocommerce] ul.products li .group_layout_three .product-view a {
				bottom: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
			}
			body[class*=woocommerce] ul.products li .group_layout_three .product-wishlist a {
				bottom: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing + 34 ) .'px;
			}
			body[class*=woocommerce] ul.products li .group_layout_three .product-compare a {
				bottom: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing + 57 ) .'px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				background-color: #ffffff;
				line-height: 35px;
				height: 35px;
				text-align: center;
				padding: 0 5px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i {
				padding-left: 16px;
				border-top-left-radius: '. esc_attr( $icon_group_three_border_radius ) .'px;
				border-bottom-left-radius: '. esc_attr( $icon_group_three_border_radius ) .'px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i {
				padding-right: 16px;
				border-top-right-radius: '. esc_attr( $icon_group_three_border_radius ) .'px;
				border-bottom-right-radius: '. esc_attr( $icon_group_three_border_radius ) .'px;
			}
			body[class*=woocommerce] ul.products li:hover .product-compare-wishlist a, 
			body[class*=woocommerce] ul.products li:focus .product-compare-wishlist a {
				opacity: 1;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				font-size: 13px;
			}
		';
	}elseif( $icon_group_layout == 'group_layout_four' ){
		$css .= '
			body[class*=woocommerce] ul.products li .product-compare-wishlist a {
				opacity: 1;
				z-index: 99;
			}
			body[class*=woocommerce] ul.products li .group_layout_four .product-wishlist a {
				top: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
			}
			body[class*=woocommerce] ul.products li .group_layout_four .product-compare a {
				top: '. esc_attr( $icon_group_diagonal_spacing + 45 ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
			}
			body[class*=woocommerce] ul.products li .group_layout_four .product-view a {
				top: '. esc_attr( $icon_group_diagonal_spacing + 90 ) .'px;
				right: '. esc_attr( $icon_group_diagonal_spacing ) .'px;
			}
			body[class*=woocommerce] ul.products li .product-compare-wishlist a i {
				background-color: #ffffff;
				border-radius: '. esc_attr( $icon_group_four_border_radius ) .'px;
				line-height: 35px;
				height: 35px;
				text-align: center;
				width: 35px;
			}
			body[class*=woocommerce] ul.products li .product-compare a,
			body[class*=woocommerce] ul.products li .product-view a {
				opacity: 0;
			}
			body[class*=woocommerce] ul.products li .product-compare a {
				-webkit-transition: all 0.4s ease-out 0s;
				-moz-transition: all 0.4s ease-out 0s;
				-ms-transition: all 0.4s ease-out 0s;
				-o-transition: all 0.4s ease-out 0s;
				transition: all 0.4s ease-out 0s;
			}
			body[class*=woocommerce] ul.products li .product-view a {
				-webkit-transition: all 0.4s ease-out 0.2s;
				-moz-transition: all 0.4s ease-out 0.2s;
				-ms-transition: all 0.4s ease-out 0.2s;
				-o-transition: all 0.4s ease-out 0.2s;
				transition: all 0.4s ease-out 0.2s;
			}
			body[class*=woocommerce] ul.products li:hover .product-compare a, 
			body[class*=woocommerce] ul.products li:focus .product-compare a, 
			body[class*=woocommerce] ul.products li:active .product-compare a,
			body[class*=woocommerce] ul.products li:hover .product-view a, 
			body[class*=woocommerce] ul.products li:focus .product-view a, 
			body[class*=woocommerce] ul.products li:active .product-view a {
				opacity: 1;
			}
			body[class*=woocommerce] ul.products li:hover .product-compare-wishlist a, 
			body[class*=woocommerce] ul.products li:focus .product-compare-wishlist a {
				opacity: 1;
			}
			.product-wishlist .feedback, .yith-wcwl-add-to-wishlist .feedback {
				margin-left: 3.5%;
    			margin-right: 25%;
			}
			.woocommerce ul.products li.product .onsale {
				right: auto;
				left: 8px;
			}
			.info-tooltip {
				top: 50%;
				left: 50%;
				-webkit-transform: translate(-50%, -50%);
				-moz-transform: translate(-50%, -50%);
				-ms-transform: translate(-50%, -50%);
				-o-transform: translate(-50%, -50%);
				transform: translate(-50%, -50%);
				-webkit-transition: right 0.4s;
				-moz-transition: right 0.4s;
				-ms-transition: right 0.4s;
				-o-transition: right 0.4s;
				transition: right 0.4s;
			}
			.product-compare-wishlist a:hover .info-tooltip {
				top: 50%;
				left: auto;
				-webkit-transform: translate(-10px, -50%);
				-moz-transform: translate(-10px, -50%);
				-ms-transform: translate(-10px, -50%);
				-o-transform: translate(-10px, -50%);
				transform: translate(-10px, -50%);
				right: 100%;
			}
		';
	}

	// End Style
	$css .= '</style>';
	?>
	<?php if( get_theme_mod( 'site_layout', 'default' ) == 'box' || get_theme_mod( 'site_layout', 'default' ) == 'frame' ){ ?>
		<style type="text/css">
		    .site-layout-frame,
		    .site-layout-box { background-image: url('<?php echo esc_url( wp_get_attachment_url( get_theme_mod( 'box_frame_background_image', '' ) ) ); ?>'); }
		</style>
	<?php } ?>
	<?php

	// return generated & compressed CSS
	echo str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css); 
}
add_action( 'wp_head', 'bosa_default_styles' );