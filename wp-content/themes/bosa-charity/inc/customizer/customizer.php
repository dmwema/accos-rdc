<?php

/**
 * Kirki Customizer
 *
 * @return void
 */
add_action( 'init' , 'bosa_charity_kirki_fields', 999, 1 );

function bosa_charity_kirki_fields(){

	/**
	* If kirki is not installed do not run the kirki fields
	*/

	if ( !class_exists( 'Kirki' ) ) {
		return;
	}

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Site Title', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'site_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => '600',
			'font-size'      => '24px',
			'text-transform' => 'none',
			'line-height'    => '1.2',
		),
		'priority'	  =>  10,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-header .site-branding .site-title',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Site Description', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'site_description_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'normal',
			'font-size'      => '14px',
			'text-transform' => 'none',
		),
		'priority'	  =>  20,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => '.site-header .site-branding .site-description',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Main Menu', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_menu_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'font-size'      => '15px',
			'text-transform' => 'uppercase',
			'variant'        => '500',
			'line-height'    => '1.5',
		),
		'priority'	  =>  30,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.main-navigation ul.menu li a', '.slicknav_menu .slicknav_nav li a' )
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Main Menu Description', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_menu_description_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'font-size'      => '11px',
			'text-transform' => 'none',
			'variant'        => 'normal',
			'line-height'    => '1.4',
		),
		'priority'	  =>  50,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.main-navigation .menu-description, .slicknav_menu .menu-description' ),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Body', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'body_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'normal',
			'font-size'      => '15px',
		),
		'priority'	  =>  60,
		'transport'   => 'auto',
		'output' => array( 
			array(
				'element' => 'body',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'General Title (H1 - H6)', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'general_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'text-transform' => 'none',
		),
		'priority'	  =>  70,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ),
			),
		),	
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Page & Single Post Title', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'page_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => '800',
			'font-size'      => '40px',
			'text-transform' => 'capitalize',
		),
		'priority'	  =>  80,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => array( '.page-title' ),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Blog Homepage Section Title', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'section_title_font_control',
		'section'      => 'typography',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => 'normal',
			'font-size'      => '32px',
			'text-transform' => 'capitalize',
		),
		'priority'	  =>  90,
		'transport'   => 'auto',
		'output'   => array(
			array(
				'element' => '.section-post-area .section-title',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_title_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => '900',
			'font-size'      => '56px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.2',
		),
		'priority'	  =>  260,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-title',
			),
		),
		'active_callback' => array(
			array(
			'setting'  => 'hide_slider_title',
			'operator' => '==',
			'value'    => false,
			),
			array(
			'setting'  => 'main_slider_controls',
			'operator' => '==',
			'value'    => 'slider',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Category Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_cat_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.6',
		),
		'priority'	  =>  280,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-header .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_category',
				'operator' => '==',
				'value'    => false,
				),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Meta Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_meta_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'priority'	  =>  320,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				array(
				'setting'  => 'hide_slider_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_slider_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Excerpt Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_excerpt_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '16px',
			'text-transform' => 'initial',
			'line-height'    => '1.8',
		),
		'priority'	  =>  340,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .banner-content .entry-text p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Slider Button Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'main_slider_button_font_control',
		'section'      => 'main_slider_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '15px',
			'text-transform' => 'capitalize',
			'line-height'    => '1',
		),
		'priority'	  =>  380,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-banner .slide-inner .banner-content .button-container a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'main_slider_controls',
				'operator' => '==',
				'value'    => 'slider',
			),
			array(
				'setting'  => 'hide_slider_button',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Header Buttons Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'header_buttons_font_control',
		'section'      => 'header_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '14px',
			'text-transform' => 'uppercase',
			'line-height'    => '1',
		),
		'priority'	  =>  400,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-header .header-btn a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_header_button',
				'operator' => '==',
				'value'    => false,
			),
			array(
				'setting'  => 'header_layout',
				'operator' => 'contains',
				'value'    => array( 'header_one', 'header_two' ),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Section Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_section_title_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => '700',
			'font-size'      => '32px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.2',
		),
		'priority'	  =>  40,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-feature-posts-area .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Section Description Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_section_description_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'normal',
			'font-size'      => '15px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'priority'	  =>  70,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-feature-posts-area .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'feature_posts_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '20px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.4',
		),
		'priority'	  =>  270,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.feature-posts-content-wrap .feature-posts-content .feature-posts-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_feature_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Category Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'featured_posts_cat_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '500',
			'font-size'      => '11px',
			'text-transform' => 'uppercase',
			'line-height'    => '1',
		),
		'priority'	  =>  300,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.post .feature-posts-content .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_featured_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Meta Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'featured_posts_meta_font_control',
		'section'      => 'feature_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'priority'	  =>  340,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.post .feature-posts-content .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_featured_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_featured_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_featured_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_title_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => 'capitalize',
			'font-size'      => '24px',
			'text-transform' => '700',
			'line-height'    => '1.4',
		),
		'priority'	  =>  120,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary article .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_post_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Category Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_cat_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '500',
			'font-size'      => '13px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.6',
		),
		'priority'	  =>  140,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .post .entry-content .entry-header .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Meta Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_meta_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'priority'	  =>  180,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .entry-meta',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Excerpt Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'blog_post_excerpt_font_control',
		'section'      => 'blog_page_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '400',
			'font-size'      => '15px',
			'text-transform' => 'initial',
			'line-height'    => '1.8',
		),
		'priority'	  =>  200,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '#primary .entry-text p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_blog_page_excerpt',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Section Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_section_title_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => 'normal',
			'font-size'      => '32px',
			'text-transform' => '700',
			'line-height'    => '1.2',
		),
		'priority'	  =>  40,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-highlight-post .section-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Section Description Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_section_description_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => 'normal',
			'font-size'      => '16px',
			'text-transform' => 'none',
			'line-height'    => '1.8',
		),
		'priority'	  =>  70,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.section-highlight-post .section-title-wrap p',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'disable_highlight_posts_section_description',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_title_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Playfair Display',
			'variant'        => '700',
			'font-size'      => '20px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.4',
		),
		'priority'	  =>  280,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.highlight-post-slider .post .entry-content .entry-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_highlight_posts_title',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Category Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_cat_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '11px',
			'text-transform' => 'uppercase',
			'line-height'    => '1',
		),
		'priority'	  =>  260,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.highlight-post-slider .post .cat-links a',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'hide_highlight_posts_category',
				'operator' => '==',
				'value'    => false,
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post Meta Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'highlight_posts_meta_font_control',
		'section'      => 'highlight_posts_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '500',
			'font-size'      => '13px',
			'text-transform' => 'capitalize',
			'line-height'    => '1.6',
		),
		'priority'	  =>  320,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.highlight-post-slider .post .entry-meta a',
			),
		),
		'active_callback' => array(
			array(
				array(
				'setting'  => 'hide_highlight_posts_date',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_author',
				'operator' => '==',
				'value'    => false,
				),
				array(
				'setting'  => 'hide_highlight_posts_comment',
				'operator' => '==',
				'value'    => false,
				),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Widget Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'sidebar_widget_title_font_control',
		'section'      => 'sidebar_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '16px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'priority'	  =>  20,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.sidebar .widget .widget-title',
			),
		),
		'active_callback' => array(
			array(
				'setting'  => 'sidebar_settings',
				'operator' => 'contains',
				'value'    => array( 'right', 'left', 'right-left' ),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Widget Title Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'footer_widget_title_font_control',
		'section'      => 'footer_widgets_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '600',
			'font-size'      => '16px',
			'text-transform' => 'uppercase',
			'line-height'    => '1.4',
		),
		'priority'	  =>  120,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => '.site-footer .widget .widget-title',
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Bottom Footer Typography', 'bosa-charity' ),
		'type'         => 'typography',
		'settings'     => 'footer_style_font_control',
		'section'      => 'footer_style_options',
		'default'  => array(
			'font-family'    => 'Poppins',
			'variant'        => '500',
			'font-size'      => '14px',
			'text-transform' => 'none',
			'line-height'    => '1.6',
		),
		'priority'	  =>  90,
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => array( '.site-footer .site-info', '.site-footer .footer-menu ul li a' ),
			),
		),
	) );

	Kirki::add_field( 'bosa', array(
		'label'       => esc_html__( 'Columns', 'bosa-charity' ),
		'type'        => 'select',
		'settings'    => 'feature_posts_columns',
		'section'     => 'feature_posts_options',
		'default'     => 'four_columns',
		'placeholder' => esc_attr__( 'Select category', 'bosa-charity' ),
		'choices'  => array(
			'one_column'    => esc_html__( '1 Column', 'bosa-charity' ),
			'two_columns'   => esc_html__( '2 Columns', 'bosa-charity' ),
			'three_columns' => esc_html__( '3 Columns', 'bosa-charity' ),
			'four_columns'  => esc_html__( '4 Columns', 'bosa-charity' ),
		),
		'priority'	  =>  160,
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Post View Number', 'bosa-charity' ),
		'description'  => esc_html__( 'Number of posts to show.', 'bosa-charity' ),
		'type'         => 'number',
		'settings'     => 'feature_posts_posts_number',
		'section'      => 'feature_posts_options',
		'default'      => 4,
		'choices' => array(
			'min' => '1',
			'max' => '48',
			'step' => '1',
		),
		'priority'	  =>  190,
	) );

	Kirki::add_field( 'bosa', array(
		'label'        => esc_html__( 'Height (in px)', 'bosa-charity' ),
		'description'  => esc_html__( 'This option will only apply to Desktop. Please click on below Desktop Icon to see changes. Automatically adjust by theme default in the responsive devices.
		', 'bosa-charity' ),
		'type'         => 'slider',
		'settings'     => 'feature_posts_height',
		'section'      => 'feature_posts_options',
		'transport'    => 'postMessage',
		'default'      => 320,
		'choices' => array(
			'min' => '100',
			'max' => '1200',
			'step' => '10',
		),
		'priority'	  =>  200,
	) );

	Kirki::add_field( 'bosa', array(
		'label'       => esc_html__( 'Post Layouts', 'bosa-charity' ),
		'description' => esc_html__( 'Grid / List / Single', 'bosa-charity' ),
		'type'        => 'radio-image',
		'settings'    => 'archive_post_layout',
		'section'     => 'blog_page_style_options',
		'default'     => 'grid',
		'choices'     => apply_filters( 'bosa_archive_post_layout_filter', array(
			'grid'           => get_template_directory_uri() . '/assets/images/grid-layout.png',
			'list'           => get_template_directory_uri() . '/assets/images/list-layout.png',
			'single'         => get_template_directory_uri() . '/assets/images/single-layout.png',
		) ),
		'priority'	  =>  10,
	) );

	Kirki::add_field( 'bosa', array(
		'label'       => esc_html__( 'Footer Layouts', 'bosa-charity' ),
		'type'        => 'radio-image',
		'settings'    => 'footer_layout',
		'section'     => 'footer_style_options',
		'default'     => 'footer_two',
		'choices'     => apply_filters( 'bosa_footer_layout_filter', array(
			'footer_one'   => get_template_directory_uri() . '/assets/images/footer-layout-1.png',
			'footer_two'   => get_template_directory_uri() . '/assets/images/footer-layout-2.png',
			'footer_three' => get_template_directory_uri() . '/assets/images/footer-layout-3.png',
		) ),
		'priority'	  =>  20,
	) );

	Kirki::add_field( 'bosa', array(
		'label'       => esc_html__( 'Header Layouts', 'bosa-charity' ),
		'description' => esc_html__( 'Select layout & scroll below to change its options', 'bosa-charity' ),
		'type'        => 'radio-image',
		'settings'    => 'header_layout',
		'section'     => 'header_style_options',
		'default'     => 'header_two',
		'priority'	  =>  40,
		'choices'     => apply_filters( 'bosa_header_layout_filter', array(
			'header_one'    => get_template_directory_uri() . '/assets/images/header-layout-1.png',
			'header_two'    => get_template_directory_uri() . '/assets/images/header-layout-2.png',
			'header_three'  => get_template_directory_uri() . '/assets/images/header-layout-3.png',
		) ),
	) );
}