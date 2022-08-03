/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	wp.customize( 'logo_width', function( value ) {
		value.bind( function( to ) {
			$( '.site-header .site-branding > a' ).css( "max-width", to + 'px' );
		} );
	} );

	wp.customize( 'fixed_header_logo_width', function( value ) {
		value.bind( function( to ) {
			$( '.site-header.sticky-header .site-branding > a' ).css( "max-width", to + 'px' );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.inner-header-content h2' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.inner-header-content h2' ).css( {
					'color': to
				} );
			}
		} );
	} );

	// Pre-loader image width
	wp.customize( 'preloader_custom_image_width', function( value ) {
		value.bind( function( to ) {
			$( '.preloader-content' ).css( "max-width", to + 'px' );
		} );
	} );

	// Header image height
	wp.customize( 'header_image_height', function( value ) {
	    value.bind( function( to ) {
	        $( ".header-image-wrap" ).css( "height", to + 'px' );
	    } );
	} );

	// footer social icon size
	wp.customize( 'social_icons_size', function( value ) {
	    value.bind( function( to ) {
	        $( ".site-footer .social-profile ul li a" ).css( "font-size", to + 'px' );
	    } );
	} );

	// Main slider / image height
	wp.customize( 'main_slider_height', function( value ) {
	    value.bind( function( to ) {
	        $( ".banner-img" ).css( "height", to + 'px' );
	    } );
	} );

	// Feature Posts height
	wp.customize( 'feature_posts_height', function( value ) {
	    value.bind( function( to ) {
	        $( ".feature-posts-content-wrap .feature-posts-image" ).css( "height", to + 'px' );
	    } );
	} );

	// Bottom footer image width
	wp.customize( 'bottom_footer_image_width', function( value ) {
		value.bind( function( to ) {
			$( '.bottom-footer-image-wrap > a' ).css( "max-width", to + 'px' );
		} );
	} );

	// Featured Posts Radius
	wp.customize( 'feature_posts_radius', function( value ) {
	    value.bind( function( to ) {
	        $( ".feature-posts-content-wrap .feature-posts-image" ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// Highlighted Posts Radius
	wp.customize( 'highlight_posts_radius', function( value ) {
	    value.bind( function( to ) {
	        $( ".section-highlight-post .featured-image a" ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// Transparent Header Banner in Post Height
	wp.customize( 'transparent_header_banner_post_height', function( value ) {
	    value.bind( function( to ) {
	        $( ".overlay-post.inner-banner-wrap" ).css( "height", to + 'px' );
	        $( ".overlay-post .inner-banner-content" ).css( "height", to + 'px' );
	    } );
	} );

	// Transparent Header Banner in Page Height
	wp.customize( 'transparent_header_banner_page_height', function( value ) {
	    value.bind( function( to ) {
	        $( ".overlay-page.inner-banner-wrap" ).css( "height", to + 'px' );
	        $( ".overlay-page .inner-banner-content" ).css( "height", to + 'px' );
	    } );
	} );

	// Blog Post border radius
	wp.customize( 'latest_posts_radius', function( value ) {
	    value.bind( function( to ) {
	        $( '#primary article:not(.sticky) .featured-image a' ).css( "borderRadius", to + 'px' );
	        $( 'article.sticky' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// Sale button border radius
	wp.customize( 'sale_button_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*="woocommerce"] span.onsale' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	 // Icon group border radius
	wp.customize( 'icon_group_one_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist a i' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	wp.customize( 'icon_group_two_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i' ).css( "border-top-left-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i' ).css( "border-bottom-left-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i' ).css( "border-top-right-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i' ).css( "border-bottom-right-radius", to + 'px' );
	    } );
	} );

	wp.customize( 'icon_group_three_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i' ).css( "border-top-left-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:first-child a i' ).css( "border-bottom-left-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i' ).css( "border-top-right-radius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist > div:last-child a i' ).css( "border-bottom-right-radius", to + 'px' );
	    } );
	} );

	wp.customize( 'icon_group_four_border_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li .product-compare-wishlist a i' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// product image radius
	wp.customize( 'shop_product_image_radius', function( value ) {
	    value.bind( function( to ) {
	        $( '.products li.product .woo-product-image img' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// product card border radius
	wp.customize( 'shop_product_card_radius', function( value ) {
	    value.bind( function( to ) {
	        $( '.product .product-inner' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// Add to cart button radius
	wp.customize( 'add_cart_button_radius', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li.product .button-cart_button_four > a' ).css( "borderRadius", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li.product .button-cart_button_two a.button' ).css( "borderRadius", to + 'px' );
	    } );
	} );

	// Add to cart layout four diagonal spacing
	wp.customize( 'cart_four_diagonal_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li.product .button-cart_button_four' ).css( "left", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li.product .button-cart_button_four' ).css( "bottom", to + 'px' );
	    } );
	} );

	// Icon group layout  diagonal spacing
	wp.customize( 'icon_group_diagonal_spacing', function( value ) {
	    value.bind( function( to ) {
	    	var intTo = parseInt( to ); 
	    	var threeWish = intTo + 34; 
	    	var threeWishStr = threeWish.toString(); 
	    	var threeCompare = intTo + 57;
	    	var threeCompareStr = threeCompare.toString();
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-view a' ).css( "bottom", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-view a' ).css( "right", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-wishlist a' ).css( "bottom", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-wishlist a' ).css( "right", threeWishStr + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-compare a' ).css( "bottom", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_three .product-compare a' ).css( "right", threeCompareStr + 'px' );

	        var fourView = intTo + 90; 
	    	var fourViewStr = fourView.toString(); 
	    	var fourCompare = intTo + 45;
	    	var fourCompareStr = fourCompare.toString();
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-view a' ).css( "top", fourViewStr + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-view a' ).css( "right", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-wishlist a' ).css( "top", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-wishlist a' ).css( "right", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-compare a' ).css( "top", fourCompareStr + 'px' );
	        $( 'body[class*=woocommerce] ul.products li .group_layout_four .product-compare a' ).css( "right", to + 'px' );
	    } );
	} );

	// Sale Button diagonal spacing
	wp.customize( 'sale_button_diagonal_spacing', function( value ) {
	    value.bind( function( to ) {
	        $( 'body[class*=woocommerce] ul.products li.product .onsale' ).css( "top", to + 'px' );
	        $( 'body[class*=woocommerce] ul.products li.product .onsale' ).css( "right", to + 'px' );
	    } );
	} );

} )( jQuery );