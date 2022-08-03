<?php
/**
 * Enqueues style for admin notices.
 * 
 * @since    1.3.7
 */
add_action( 'admin_enqueue_scripts', 'keon_toolset_bosa_store' );
function keon_toolset_bosa_store() {
    wp_enqueue_style( 'keon-toolset-bosa-store', KEON_TEMPLATE_URL . 'assets/bosa-store.css', false );
}

/**
 * Adds bosa upsell admin notice.
 * 
 * @since    1.3.7
 */
function bosa_upsell_admin_notice(){
    if( !get_user_meta( get_current_user_id(), 'dismiss_bosa_upsell_notice' ) ){
        $pro_img_url = KEON_TEMPLATE_URL . 'assets/img/bosa-pro.png';
        echo '<div class="keon-notice">';
            echo '<div class="getting-img">';
                echo '<img id="" src="'.esc_url( $pro_img_url ).'" />';
            echo '</div>';
            echo '<div class="getting-content">';
                echo '<h2>Go PRO for More Features</h2>';
                echo '<p class="text">Get <a href="https://bosathemes.com/bosa-pro" target="_blank">Bosa Pro</a> for more stunning elements, demos and customization options.</p>';
                echo '<a href="https://bosathemes.com/bosa-pro" class="button button-primary" target="_blank">Theme Details</a>';
                echo '<a href="https://bosathemes.com/pricing" class="button button-primary" target="_blank">Buy Bosa Pro</a>';
             echo '</div>';
            echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'bosa-upsell-notice-dismissed', 'dismiss_bosa_upsell_notice' ) ) ) . '" class="admin-notice-dismiss">Dismiss<button type="button" class="notice-dismiss"></button></a>';
        echo '</div>';
    }
}

/**
 * Adds gutener upsell admin notice.
 * 
 * @since    1.3.7
 */
function gutener_upsell_admin_notice(){
    if( !get_user_meta( get_current_user_id(), 'dismiss_gutener_upsell_notice' ) ){
        $pro_img_url = KEON_TEMPLATE_URL . 'assets/img/gutener-pro.png';
        echo '<div class="keon-notice">';
            echo '<div class="getting-img">';
                echo '<img id="" src="'.esc_url( $pro_img_url ).'" />';
            echo '</div>';
            echo '<div class="getting-content">';
                echo '<h2>Go PRO for More Features</h2>';
                echo '<p class="text">Get <a href="https://keonthemes.com/downloads/gutener-pro" target="_blank">Gutener Pro</a> for more stunning elements, demos and customization options.</p>';
                echo '<a href="https://keonthemes.com/downloads/gutener-pro" class="button button-primary" target="_blank">Theme Details</a>';
                echo '<a href="https://keonthemes.com/downloads/gutener-pro" class="button button-primary" target="_blank">Buy Gutener Pro</a>';
             echo '</div>';
            echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'gutener-upsell-notice-dismissed', 'dismiss_gutener_upsell_notice' ) ) ) . '" class="admin-notice-dismiss">Dismiss<button type="button" class="notice-dismiss"></button></a>';
        echo '</div>';
    }
}

/**
 * Adds store admin notice.
 * 
 * @since    1.3.7
 */
function keon_store_admin_notice(){
    if( !get_user_meta( get_current_user_id(), 'store_notice_dismissed' ) ){
        $store_img_url = KEON_TEMPLATE_URL . 'assets/img/bosa-store.png';
        echo '<div class="keon-notice">';
            echo '<div class="getting-img">';
            echo '<img id="" src="'.esc_url( $store_img_url ).'" />';
            echo '</div>';
            echo '<div class="getting-content">';
                echo '<h2>New Awesome FREE WooCommerce Theme - Bosa Store</h2>';
                echo '<p class="text"><a href="https://bosathemes.com/bosa-store" target="_blank">Bosa Store</a> - new free WooCommerce theme from BosaThemes. Check out theme <a href="https://demo.bosathemes.com/bosa/store" target="_blank">Demo</a> that can be imported for FREE with simple click.</p>';
                echo '<a href="https://demo.bosathemes.com/bosa/store" class="button button-primary">View Demo</a>';
                echo '<a href="https://bosathemes.com/bosa-store" class="button button-primary">Theme Details</a>';
            echo '</div>';
            echo '<a href="' . esc_url( wp_nonce_url( add_query_arg( 'store-notice-dismissed', 'dismiss_store_notice' ) ) ) . '" class="admin-notice-dismiss">Dismiss<button type="button" class="notice-dismiss"></button></a>';
        echo '</div>';
    }
}

/**
 * Registers admin notice for current user.
 * 
 * @since    1.3.7
 */
add_action( 'admin_init', 'keon_toolset_notice_dismissed' );
function keon_toolset_notice_dismissed() {
    if ( isset( $_GET['store-notice-dismissed'] ) ){
        add_user_meta( get_current_user_id(), 'store_notice_dismissed', true, true );
    }
    if ( isset( $_GET['bosa-upsell-notice-dismissed'] ) ){
        add_user_meta( get_current_user_id(), 'dismiss_bosa_upsell_notice', true, true );
    }
    if ( isset( $_GET['gutener-upsell-notice-dismissed'] ) ){
        add_user_meta( get_current_user_id(), 'dismiss_gutener_upsell_notice', true, true );
    }
}

/**
 * Removes admin notice dismiss state for current user.
 * 
 * @since    1.3.7
 */
add_action( 'switch_theme', 'flush_admin_notices_dismiss_status' );
function flush_admin_notices_dismiss_status(){
    delete_user_meta( get_current_user_id(), 'store_notice_dismissed', true, true );
    delete_user_meta( get_current_user_id(), 'dismiss_bosa_upsell_notice', true, true );
    delete_user_meta( get_current_user_id(), 'dismiss_gutener_upsell_notice', true, true );
}