<?php
/**
 * Customizer Upsell Section.
 */
include_once ABSPATH . 'wp-includes/class-wp-customize-section.php';

/**
 * Enqueue style for custom customize control.
 * 
 * @since    1.3.6
 */
add_action( 'customize_controls_enqueue_scripts', 'keon_toolset_customize_enqueue' );
function keon_toolset_customize_enqueue() {
    wp_enqueue_style( 'keon-toolset-customize-controls', KEON_TEMPLATE_URL . 'assets/upsell.css' );
}

/**
 * Removes gutener customizer section register function.
 *
 * @since    1.3.6
 */
add_action( 'customize_register', 'remove_gutener_customize_register', 1 );
function remove_gutener_customize_register() {
    remove_action( 'customize_register', 'gutener_customize_register' );
}

/**
 * Removes bosa customizer section register function.
 *
 * @since    1.3.6
 */
add_action( 'customize_register', 'remove_bosa_customize_register', 1 );
function remove_bosa_customize_register() {
    remove_action( 'customize_register', 'bosa_customize_register' );
}

/**
 * Keon Toolset upsell customizer section.
 *
 * @since  1.3.6
 * @access public
 */
class Keon_Toolset_Customize_Section_Upsell extends WP_Customize_Section {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.3.6
     * @access public
     * @var    string
     */
    public $type = 'upsell';

    /**
     * Custom button text to output.
     *
     * @since  1.3.6
     * @access public
     * @var    string
     */
    public $pro_text = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.3.6
     * @access public
     * @var    string
     */
    public $pro_url = '';

    /**
     * Custom pro button URL.
     *
     * @since  1.3.6
     * @access public
     * @var    string
     */
    public $pro_features = array();

    /**
     * Add custom parameters to pass to the JS via JSON.
     *
     * @since  1.3.6
     * @access public
     * @return void
     */
    public function json() {
        $json = parent::json();

        $json['pro_text'] = $this->pro_text;
        $json['pro_url']  = esc_url( $this->pro_url );
        $json['pro_features']  = $this->pro_features;

        return $json;
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.3.6
     * @access public
     * @return void
     */
    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
            <div class="customizer-featured-list accordion-section-title">
                <h3>{{ data.title }}</h3>
                <ul>
                    <li>{{ data.pro_features.one }}</li>
                    <li>{{ data.pro_features.two }}</li>
                    <li>{{ data.pro_features.three }}</li>
                    <li>{{ data.pro_features.four }}</li>
                </ul>
                
                <# if ( data.pro_text && data.pro_url ) { #>
                    <a href="{{ data.pro_url }}" class="button button-primary" target="_blank">{{ data.pro_text }}</a>
                <# } #>
            </div>
        </li>
    <?php }
}

/**
 * Register Keon Toolset upsell customizer section.
 *
 * @since  1.3.6
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function upsell_customize_register( $wp_customize ) {

    // Register custom section types.
    $wp_customize->register_section_type( 'Keon_Toolset_Customize_Section_Upsell' );

    $title = '';
    $feature_three = '';
    $pro_url = '';
    if( keon_toolset_theme_check( 'bosa' ) ){
        $title          = esc_html__( 'Bosa Pro', 'keon-toolset' );
        $feature_three  = esc_html__( 'All Bosa Free and Pro Features', 'keon-toolset' );
        $pro_url        = esc_url( 'https://bosathemes.com/bosa-pro' );
    }elseif( keon_toolset_theme_check( 'gutener' ) ){
        $title          = esc_html__( 'Gutener Pro', 'keon-toolset' );
        $feature_three  = esc_html__( 'All Gutener Free and Pro Features', 'keon-toolset' );
        $pro_url        = esc_url( 'https://keonthemes.com/downloads/gutener-pro' );
    } 
    // Register sections.
   $wp_customize->add_section(
        new Keon_Toolset_Customize_Section_Upsell(
            $wp_customize,
            'theme_upsell',
            array(
                'title'         => $title,
                'pro_features'  => array(
                    'one'   => esc_html__( 'All Current and Future Free Demos', 'keon-toolset' ),
                    'two'   => esc_html__( 'All Current and Future Pro Demos', 'keon-toolset' ),
                    'three' => $feature_three,
                    'four'  => esc_html__( 'And many more...', 'keon-toolset' ),
                ),
                'pro_text'  => esc_html__( 'Upgrade to Pro', 'keon-toolset' ),
                'pro_url'   => $pro_url,
                'priority'  => 1,
            )
        )
    );   
}