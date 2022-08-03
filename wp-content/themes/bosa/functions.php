<?php

/**
 * Bosa works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Bosa functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bosa
 */

if ( ! function_exists( 'bosa_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function bosa_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Bosa, use a find and replace
		 * to change 'bosa' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'bosa', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'bosa' ),
			'menu-3' => esc_html__( 'Secondary', 'bosa' ),
			'menu-2' => esc_html__( 'Footer', 'bosa' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Add support for Post Formats.
		 *
		 * @link https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats' , array( 'aside', 'gallery' , 'standard', 'link', 'image' , 'quote', 'status', 'video', 'audio' , 'chat' ));
		
		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'width'       => 270,
			'height'      => 80,
			'flex-height' => true,
			'flex-width'  => true,
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for woocommerce.
		add_theme_support( 'woocommerce' );

		// Add custom image size.
		add_image_size( 'bosa-1920-550', 1920, 550, true );
		add_image_size( 'bosa-1370-550', 1370, 550, true );
		add_image_size( 'bosa-590-310', 590, 310, true );
		add_image_size( 'bosa-420-380', 420, 380, true );
		add_image_size( 'bosa-420-300', 420, 300, true );
		add_image_size( 'bosa-420-200', 420, 200, true );
		add_image_size( 'bosa-290-150', 290, 150, true );
		add_image_size( 'bosa-80-60', 80, 60, true );

		/*
		* This theme styles the visual editor to resemble the theme style,
		* specifically font, colors, icons, and column width.
		*/
		
		add_editor_style( array( '/assets/css/editor-style.min.css') );

		// Gutenberg support
		add_theme_support( 'editor-color-palette', array(
	       	array(
				'name'  => esc_html__( 'Tan', 'bosa' ),
				'slug'  => 'tan',
				'color' => '#D2B48C',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Yellow', 'bosa' ),
	           	'slug'  => 'yellow',
	           	'color' => '#FDE64B',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Orange', 'bosa' ),
	           	'slug'  => 'orange',
	           	'color' => '#ED7014',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Red', 'bosa' ),
	           	'slug'  => 'red',
	           	'color' => '#D0312D',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Pink', 'bosa' ),
	           	'slug'  => 'pink',
	           	'color' => '#b565a7',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Purple', 'bosa' ),
	           	'slug'  => 'purple',
	           	'color' => '#A32CC4',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Blue', 'bosa' ),
	           	'slug'  => 'blue',
	           	'color' => '#4E97D8',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Green', 'bosa' ),
	           	'slug'  => 'green',
	           	'color' => '#00B294',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Brown', 'bosa' ),
	           	'slug'  => 'brown',
	           	'color' => '#231709',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Grey', 'bosa' ),
	           	'slug'  => 'grey',
	           	'color' => '#7D7D7D',
	       	),
	       	array(
	           	'name'  => esc_html__( 'Black', 'bosa' ),
	           	'slug'  => 'black',
	           	'color' => '#000000',
	       	),
	   	));

		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-font-sizes', array(
		   	array(
		       	'name'      => esc_html__( 'small', 'bosa' ),
		       	'shortName' => esc_html__( 'S', 'bosa' ),
		       	'size'      => 12,
		       	'slug'      => 'small'
		   	),
		   	array(
		       	'name'      => esc_html__( 'regular', 'bosa' ),
		       	'shortName' => esc_html__( 'M', 'bosa' ),
		       	'size'      => 16,
		       	'slug'      => 'regular'
		   	),
		   	array(
		       	'name'      => esc_html__( 'larger', 'bosa' ),
		       	'shortName' => esc_html__( 'L', 'bosa' ),
		       	'size'      => 36,
		       	'slug'      => 'larger'
		   	),
		   	array(
		       	'name'      => esc_html__( 'huge', 'bosa' ),
		       	'shortName' => esc_html__( 'XL', 'bosa' ),
		       	'size'      => 48,
		       	'slug'      => 'huge'
		   	)
		));
		add_theme_support( 'editor-styles' );
		add_theme_support( 'wp-block-styles' );

		/* woocommerce support */
		add_theme_support( 'wc-product-gallery-zoom' );
	    add_theme_support( 'wc-product-gallery-lightbox' );
	    add_theme_support( 'wc-product-gallery-slider' );
	}
endif;
add_action( 'after_setup_theme', 'bosa_setup' );

/**
 * Enqueue scripts and styles.
 */
function bosa_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css' );
	if ( is_rtl() ){
		wp_enqueue_style( 'bootstrap-rtl', get_template_directory_uri() . '/assets/bootstrap/css/rtl/bootstrap.min.css' );
	}
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/slick/slick.css' );
	wp_enqueue_style( 'slicknav', get_template_directory_uri() . '/assets/css/slicknav.min.css' );
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/assets/slick/slick-theme.css' );
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/font-awesome/css/all.min.css' );
	wp_enqueue_style( 'bosa-blocks', get_template_directory_uri() . '/assets/css/blocks.min.css' );
	wp_enqueue_style( 'bosa-style', get_stylesheet_uri() );
	wp_enqueue_style( 'bosa-google-font', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800|Poppins:300,400,400i,500,600,700,800,900&display=swap', false );

	$scripts = array(
		array(
			'id'     => 'bootstrap',
			'url'    => get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js',
			'footer' => true
		),
		array(
			'id'     => 'slick',
			'url'    => get_template_directory_uri() . '/assets/slick/slick.min.js',
			'footer' => true
		),
		array(
			'id'     => 'slicknav',
			'url'    => get_template_directory_uri() . '/assets/js/jquery.slicknav.min.js',
			'footer' => true
		),
		array(
			'id'     => 'bosa-skip-link-focus-fix',
			'url'    => get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js',
			'footer' => true
		),
		array(
			'id'     => 'bosa-navigation',
			'url'    => get_template_directory_uri() . '/assets/js/navigation.js',
			'footer' => true
		),
		array(
			'id'     => 'theia-sticky-sidebar',
			'url'    => get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.min.js',
			'footer' => true
		),
		array(
			'id'     => 'html5shiv',
			'url'    => get_template_directory_uri() . '/assets/js/html5shiv.min.js',
			'footer' => true
		),
		array(
			'id'     => 'bosa-custom',
			'url'    => get_template_directory_uri() . '/assets/js/custom.min.js',
			'footer' => true
		)
	);

	bosa_add_scripts( $scripts );
	
	$locale = array(
		'is_rtl'                                 => is_rtl(),
		'is_admin_bar_showing'                   => is_admin_bar_showing() ? true : false,
		'responsive_header_menu_text'            => get_theme_mod( 'responsive_header_menu_text', 'MENU' ),
		'header_image_slider' => array(
			'fade'          => absint( get_theme_mod( 'header_slider_effect', 'fade' ) == 'fade' ) ? true : false,
			'autoplay'      => absint( !get_theme_mod( 'disable_header_slider_autoplay', true ) ),
			'autoplaySpeed' => absint( get_theme_mod( 'slider_header_autoplay_speed', 4 ) * 1000 ),
			'fadeControl'   => absint( get_theme_mod( 'slider_header_fade_control', 5 ) ) * 100,
		),
		'main_slider' => array(
			'fade'          => absint( get_theme_mod( 'main_slider_effect', 'fade' ) == 'fade' ) ? true : false,
			'autoplay'      => absint( !get_theme_mod( 'disable_slider_autoplay', true ) ),
			'autoplaySpeed' => absint( get_theme_mod( 'slider_autoplay_speed', 4 ) * 1000 ),
			'fadeControl'   => absint( get_theme_mod( 'slider_fade_control', 5 ) ) * 100,
		),
		'home_highlight_posts' => array(
			'autoplay'      => absint( !get_theme_mod( 'disable_highlight_posts_autoplay', true ) ),
			'autoplaySpeed' => absint( get_theme_mod( 'highlight_posts_autoplay_speed', 4 ) * 1000 ),
			'slidesToShow'  => absint( get_theme_mod( 'highlight_posts_slides_show', 3 ) ),
		),
		'fixed_nav'                  => !get_theme_mod( 'disable_fixed_header', true ) ? true : false,
		'mobile_fixed_nav_off'       => get_theme_mod( 'disable_mobile_fixed_header', true ) ? true : false,
		'disable_scroll_top'         => get_theme_mod( 'disable_scroll_top', false ),
		'sticky_sidebar'             => !get_theme_mod( 'disable_sticky_sidebar', false ) ? true : false,
		'header_two_logo'            => wp_get_attachment_url( get_theme_mod( 'header_separate_logo', '' ) ),
		'is_header_two'	             => ( get_theme_mod( 'header_layout', 'header_one' ) == 'header_two' ) ? true : false,
		'is_frame_layout'	         => ( get_theme_mod( 'site_layout', 'default' ) == 'frame' ) ? true : false,
		'fixed_header_logo'          => !get_theme_mod( 'disable_fixed_header_logo', false ) ? true : false,
		'separate_logo'              => wp_get_attachment_url( get_theme_mod( 'fixed_header_separate_logo', '' ) ),
		'is_front_page'              => is_front_page(),
		'overlay_post'               => ( !get_theme_mod( 'disable_transparent_header_post', true ) && is_single() ),
		'overlay_page'               => ( !get_theme_mod( 'disable_transparent_header_page', true ) && is_page() ),
		'the_custom_logo'            => bosa_get_custom_logo_url(),
	);
	$locale = apply_filters( 'bosa_localize_var', $locale );
	wp_localize_script( 'bosa-custom', 'BOSA', $locale );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bosa_scripts' );

/**
* Add script
* 
* @since Bosa 1.0.0
*/
function bosa_add_scripts( $scripts ){
	foreach ( $scripts as $key => $value ) {
		wp_enqueue_script( $value['id'] , $value['url'] , array( 'jquery', 'jquery-masonry' ), 0.8, $value['footer'] );
	}
}

/**
 * Descriptions on Primary Menu
 */
function bosa_header_menu_desc($item_output, $item, $depth, $args){
    if ( 'menu-1' == $args->theme_location && $item->description )
        $item_output = str_replace( '</a>', '<span class="menu-description">' . $item->description . '</span></a>', $item_output );
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'bosa_header_menu_desc', 10, 4 );

/**
* Bosa: Excerpt
*
* @since Bosa 1.0.0
*/
if( ! class_exists( 'Bosa_Excerpt' ) ):

class Bosa_Excerpt{

    /**
    * Default length (by WordPress)
    *
    * @since Bosa 1.0.0
    * @access public
    * @var int
    */
    public $length = 15;

    /**
    * Read more Text for excerpt
    * @since Bosa 1.0.0
    * @access public
    * @var string
    */
    public $more_text = '';

    /**
    * So you can call: bosa_excerpt( 'short' );
    *
    * @since Bosa 1.0.0
    * @access protected
    * @var    array
    */
    protected $types = array(
        'short'   => 15,
        'regular' => 25,
        'long'    => 55
    );

    /**
    * Stores class instance
    * 
    * @since Bosa 1.0.0
    * @access protected
    * @var    object
    */
    protected static $instance = NULL;

    /**
    * Retrives the instance of this class
    * 
    * @since Bosa 1.0.0
    * @access public
    * @return object
    */
    public static function get_instance() {

        if ( ! self::$instance ) {
          self::$instance = new self();
        }

        return self::$instance;
    }

    /**
    * Sets the length for the excerpt,then it adds the WP filter
    * And automatically calls the_excerpt();
    *
    * @since Bosa 1.0.0
    * @param string $new_length 
    * @access public
    * @return void
    */
    public function excerpt( $new_length = 15, $echo, $more_text ) {

        $this->length    = $new_length;
        $this->more_text = $more_text;
        if(!is_admin()):
            add_filter( 'excerpt_more', array( $this, 'new_excerpt_more' ), 999 );
            add_filter( 'excerpt_length', array( $this, 'new_length' ), 999 );
        endif;

        if( $echo )
          the_excerpt();
        else
          return get_the_excerpt();

    }

    public function new_excerpt_more(){
        return $this->more_text;
    }

    /** 
    * Tells WP the new length
    *
    * @since Bosa 1.0.0
    * @access public
    * @return int
    */
    public function new_length() {

        if( isset( $this->types[ $this->length ] ) )
          return $this->types[ $this->length ];
        else
          return $this->length;
    }
}

endif;

/**
* Call to Bosa_Excerpt
*
* @since  1.0.0
* @uses   Bosa_Excerpt:::get_instance()->excerpt()
* @param  int $length
* @return void
*/
if( ! function_exists( 'bosa_excerpt' ) ):

    function bosa_excerpt( $length = 15, $echo = true, $more = '' ) {
        $length  = apply_filters( 'post_excerpt_length', $length );
        $excerpt = Bosa_Excerpt::get_instance()->excerpt( $length, false, $more );
        
        the_excerpt();
    }
endif;

/**
* Enqueue editor styles for Gutenberg
* 
* @since Bosa 1.0.0
*/
function bosa_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'bosa-block-editor-style', get_theme_file_uri( '/assets/css/editor-blocks.min.css' ) );
	// Google Font
	wp_enqueue_style( 'bosa-google-font', 'https://fonts.googleapis.com/css?family=Poppins:300,400,400i,500,600,700,700i', false );
}
add_action( 'enqueue_block_editor_assets', 'bosa_block_editor_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions for Woocommerce features
 */
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Dynamic CSS.
 */
require get_template_directory() . '/inc/customizer/loader.php';

/**
 * Widgets.
 */
require get_template_directory() . '/inc/widgets/loader.php';

/**
 * Getting Started Notification.
 */
require get_theme_file_path( '/inc/getting-started/getting-started.php' );

/**
 * Theme Info.
 */
require get_theme_file_path( '/inc/theme-info/theme-info.php' );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Disable Getting Start After activating Elementor.
 */
add_action( 'admin_init', function() {
	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', [ \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ] );
	}
}, 1 );
