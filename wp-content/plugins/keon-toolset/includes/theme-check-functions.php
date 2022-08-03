<?php

if( ( keon_toolset_theme_check( 'bosa' ) && !keon_toolset_theme_check( 'bosa-pro' ) ) || ( keon_toolset_theme_check( 'gutener' ) && !keon_toolset_theme_check( 'gutener-pro' ) ) ){
    require KEON_TOOLSET_PATH . 'includes/upsell.php';
    // Add customizer upsell section.
    add_action( 'customize_register', 'upsell_customize_register', 99 );
} 

if( keon_toolset_theme_check( 'bosa' ) && !keon_toolset_theme_check( 'bosa-pro' ) ){
    // Add bosa upell admin notice.
    add_action( 'admin_notices', 'bosa_upsell_admin_notice' );
}

if( keon_toolset_theme_check( 'gutener' ) && !keon_toolset_theme_check( 'gutener-pro' ) ){
    // Add gutener upell admin notice.
    add_action( 'admin_notices', 'gutener_upsell_admin_notice' );
}

if( !keon_toolset_theme_check( 'bosa' ) && !keon_toolset_theme_check( 'gutener' ) ){
    // Add bosa store admin notice.
    add_action( 'admin_notices', 'keon_store_admin_notice' );
}

/**
 * Check active theme textdomain against passed string.
 *
 * @since    1.3.6
 * 
 * @param $needle Theme name substring.
 * @return bool
 */
function keon_toolset_theme_check( $needle ){
    if( strpos( keon_toolset_get_theme_slug(), $needle ) !== false  ){
        return true;
    }else{
        return false;
    }
}