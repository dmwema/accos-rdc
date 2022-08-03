<?php
/**
 * Functions for Woocommerce features
 *
 * @package Bosa
 */

/**
* Add a wrapper div to product
* @since Bosa 1.0.0
*/

function bosa_before_shop_loop_item(){
	echo '<div class="product-inner">';
}

add_action( 'woocommerce_before_shop_loop_item', 'bosa_before_shop_loop_item', 9 );

/**
* After shop loop item
* @since Bosa 1.0.0
*/
function bosa_after_shop_loop_item(){
    echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item', 'bosa_after_shop_loop_item', 34 );

/**
* Hide default page title
* @since Bosa 1.0.0
*/
function bosa_woo_show_page_title(){
    return false;
}
add_filter( 'woocommerce_show_page_title', 'bosa_woo_show_page_title' );

/**
* Change number or products per row.
* @since Bosa 1.0.0
*/
if ( !function_exists( 'bosa_loop_columns' ) ) {
	function bosa_loop_columns() {
        if( get_theme_mod( 'woocommerce_product_layout_type', 'product_layout_grid' ) == 'product_layout_grid' ){
		  return get_theme_mod( 'woocommerce_shop_product_column', 3 );
        }elseif( get_theme_mod( 'woocommerce_product_layout_type', 'product_layout_grid' ) == 'product_layout_list' ){
          return get_theme_mod( 'woocommerce_shop_list_column', 2 );
        }
	}
}
add_filter( 'loop_shop_columns', 'bosa_loop_columns' );

/**
* Add buttons in compare and wishlist
* @since Bosa 1.0.0
*/
if (!function_exists('bosa_compare_wishlist_buttons')) {
    function bosa_compare_wishlist_buttons() {
        $double = '';
        $icon_layout = get_theme_mod( 'icon_group_layout', 'group_layout_one' ); 
        if ( function_exists( 'yith_woocompare_constructor' ) && function_exists( 'YITH_WCWL' ) ) {
            $double = ' d-compare-wishlist';
        }
        ?>
        <div class="product-compare-wishlist<?php echo esc_attr( $double ); ?> <?php echo esc_attr( $icon_layout ); ?>">
            <?php
            if( get_theme_mod( 'icon_group_layout', 'group_layout_one' ) == 'group_layout_four' ){
                if ( function_exists( 'YITH_WCWL' ) ) {
                    ?>
                    <div class="product-wishlist">
                        <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ) ?>
                    </div>
                <?php }
            }
            if ( function_exists( 'yith_woocompare_constructor' ) ) {
                global $product, $yith_woocompare;
                $product_id = !is_null($product) ? yit_get_prop($product, 'id', true) : 0;
                // return if product doesn't exist
                if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
                    return;
                $url = is_admin() ? "#" : $yith_woocompare->obj->add_product_url( $product_id );
                ?>
                <div class="product-compare">
                    <a class="compare" rel="nofollow" data-product_id="<?php echo absint( $product_id ); ?>" href="<?php echo esc_url($url); ?>">
                        <i class="fas fa-sync"></i>
                        <span class="info-tooltip">
                            <?php esc_html_e( 'Compare', 'bosa' ); ?>
                        </span>
                    </a>
                </div>
                <?php
            }
            if( get_theme_mod( 'icon_group_layout', 'group_layout_one' ) != 'group_layout_four' ){
                if ( function_exists( 'YITH_WCWL' ) ) {
                    ?>
                    <div class="product-wishlist">
                        <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ) ?>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php
    }
    add_action( 'woocommerce_after_shop_loop_item', 'bosa_compare_wishlist_buttons', 10 );
}

/**
 * Closing for quick view, compare and wishlist.
 * @since Bosa 1.2.6
*/
if (!function_exists('bosa_compare_wishlist_buttons_close')) {
    add_action( 'woocommerce_after_shop_loop_item', 'bosa_compare_wishlist_buttons_close', 16 );
    function bosa_compare_wishlist_buttons_close() {
        echo '</div>'; /* .product-compare-wishlist */
    }
}


/**
* Change number of products that are displayed per page (shop page)
* @since Bosa 1.0.0
*/
function bosa_loop_shop_per_page( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options –> Reading
    // Return the number of products you wanna show per page.
    $cols = get_theme_mod( 'woocommerce_product_per_page', 9 );
    return $cols;
}
add_filter( 'loop_shop_per_page', 'bosa_loop_shop_per_page', 20 );

/**
 * Check if WooCommerce is activated and is shop page.
 *
 * @return bool
 * @since Bosa 1.0.0
 */
if( !function_exists( 'bosa_wooCom_is_shop' ) ){
    function bosa_wooCom_is_shop() {
        if ( class_exists( 'woocommerce' ) ) {  
            if ( is_shop()  ) {
                return true;
            }
        }else{
            return false;
        }
    }
    add_action( 'wp', 'bosa_wooCom_is_shop' );
}

/**
 * Check if WooCommerce is activated and is cart page.
 *
 * @return bool
 * @since Bosa 1.0.0
 */
if( !function_exists( 'bosa_wooCom_is_cart' ) ){
    function bosa_wooCom_is_cart() {
        if ( class_exists( 'woocommerce' ) ) {  
            if ( is_cart()  ) {
                return true;
            }
        }else{
            return false;
        }
    }
    add_action( 'wp', 'bosa_wooCom_is_cart' );
}

/**
 * Check if WooCommerce is activated and is checkout page.
 *
 * @return bool
 * @since Bosa 1.0.0
 */
if( !function_exists( 'bosa_wooCom_is_checkout' ) ){
    function bosa_wooCom_is_checkout() {
        if ( class_exists( 'woocommerce' ) ) {  
            if ( is_checkout()  ) {
                return true;
            }
        }else{
            return false;
        }
    }
    add_action( 'wp', 'bosa_wooCom_is_checkout' );
}

/**
 * Check if WooCommerce is activated and is account page.
 *
 * @return bool
 * @since Bosa 1.0.0
 */
if( !function_exists( 'bosa_wooCom_is_account_page' ) ){
    function bosa_wooCom_is_account_page() {
        if ( class_exists( 'woocommerce' ) ) {  
            if ( is_account_page()  ) {
                return true;
            }
        }else{
            return false;
        }
    }
    add_action( 'wp', 'bosa_wooCom_is_account_page' );
}

/**
* Modify excerpt item priority to last in product detail page.
* @since Bosa 1.2.6
*/
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 55 );

/**
 * Change column number of related products in product detail page.
 *
 * @return array
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_related_products_args' ) ){
    add_filter( 'woocommerce_output_related_products_args', 'bosa_related_products_args', 20 );
      function bosa_related_products_args( $args ) {
        $args[ 'columns'] = 3;
        return $args;
    }
}

/**
 * Check if WooCommerce is activated and is product detail page.
 *
 * @return bool
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_wooCom_is_product_page' ) ){
    function bosa_wooCom_is_product_page() {
        if ( class_exists( 'woocommerce' ) ) {  
            if ( is_product() ) {
                return true;
            }
        }else{
            return false;
        }
    }
    add_action( 'wp', 'bosa_wooCom_is_product_page' );
}

/**
 * Adds breadcrumb before product title in product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_product_detail_breadcrumb' ) ){
    add_action( 'woocommerce_single_product_summary', 'bosa_product_detail_breadcrumb', 1 );
    function bosa_product_detail_breadcrumb(){
        if( bosa_wooCom_is_product_page() ){
           if( ( get_theme_mod( 'breadcrumbs_controls', 'show_in_all_page_post' ) == 'disable_in_all_pages' || get_theme_mod( 'breadcrumbs_controls', 'show_in_all_page_post' ) == 'show_in_all_page_post' ) && !get_theme_mod( 'disable_single_product_breadcrumbs', false ) ){
                bosa_breadcrumb_wrap();
            }
        }
    }
}

/**
 * Add left sidebar to product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_woo_product_detail_left_sidebar' ) ){
    function bosa_woo_product_detail_left_sidebar( $sidebarColumnClass ){
        if( !get_theme_mod( 'disable_sidebar_woocommerce_page', false ) ){
            if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){ 
                if( is_active_sidebar( 'woocommerce-left-sidebar') ){ ?>
                    <div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
                        <?php dynamic_sidebar( 'woocommerce-left-sidebar' ); ?>
                    </div>
                <?php }
            }elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
                if( is_active_sidebar( 'woocommerce-left-sidebar') || is_active_sidebar( 'woocommerce-right-sidebar') ){ ?>
                    <div id="secondary" class="sidebar left-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
                        <?php dynamic_sidebar( 'woocommerce-left-sidebar' ); ?>
                    </div>
                <?php
                }
            }
        }
    }
}

/**
 * Add right sidebar to product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_woo_product_detail_right_sidebar' ) ){
    function bosa_woo_product_detail_right_sidebar( $sidebarColumnClass ){
        if( !get_theme_mod( 'disable_sidebar_woocommerce_page', false ) ){
            if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){ 
                if( is_active_sidebar( 'woocommerce-right-sidebar') ){ ?>
                    <div id="secondary" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
                        <?php dynamic_sidebar( 'woocommerce-right-sidebar' ); ?>
                    </div>
                <?php }
            }elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
                if( is_active_sidebar( 'woocommerce-left-sidebar') || is_active_sidebar( 'woocommerce-right-sidebar') ){ ?>
                    <div id="secondary-sidebar" class="sidebar right-sidebar <?php echo esc_attr( $sidebarColumnClass ); ?>">
                        <?php dynamic_sidebar( 'woocommerce-right-sidebar' ); ?>
                    </div>
                <?php
                }
            }
        }
    }
}

/**
 * Returns the sidebar column classes in product detail page.
 *
 * @return array
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_get_sidebar_class' ) ){
    function bosa_get_sidebar_class(){
        $sidebarClass = 'col-lg-8';
        $sidebarColumnClass = 'col-lg-4';

        if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right' ){
            if( !is_active_sidebar( 'woocommerce-right-sidebar') ){
                $sidebarClass = "col-12";
            }   
        }elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'left' ){
            if( !is_active_sidebar( 'woocommerce-left-sidebar') ){
                $sidebarClass = "col-12";
            }   
        }elseif ( get_theme_mod( 'sidebar_settings', 'right' ) == 'right-left' ){
            $sidebarClass = 'col-lg-6';
            $sidebarColumnClass = 'col-lg-3';
            if( !is_active_sidebar( 'woocommerce-left-sidebar') && !is_active_sidebar( 'woocommerce-right-sidebar') ){
                $sidebarClass = "col-12";
            }
        }
        if ( get_theme_mod( 'sidebar_settings', 'right' ) == 'no-sidebar' || get_theme_mod( 'disable_sidebar_woocommerce_page', false ) ){
            $sidebarClass = 'col-12';
        }
        $colClasses = array(
            'sidebarClass' => $sidebarClass, 
            'sidebarColumnClass' => $sidebarColumnClass, 
        );
        return $colClasses;
    }
}

/**
 * Add wrapper product gallery in product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_woocommerce_before_single_product_summary' ) ){
    add_action( 'woocommerce_before_single_product_summary', 'bosa_woocommerce_before_single_product_summary', 5 );
    function bosa_woocommerce_before_single_product_summary(){
        echo '<div class="product-detail-wrapper">';
    }
}

/**
 * Add left sidebar before tabs in product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_woocommerce_after_single_product_summary' ) ){
    add_action( 'woocommerce_after_single_product_summary', 'bosa_woocommerce_after_single_product_summary', 5 );
    function bosa_woocommerce_after_single_product_summary(){
        $getSidebarClass = bosa_get_sidebar_class();
        echo '</div>';/* .product-detail-wrapper */
        echo '<div class="row">';
            bosa_woo_product_detail_left_sidebar( $getSidebarClass[ 'sidebarColumnClass' ] );
            echo '<div class="'. $getSidebarClass[ 'sidebarClass' ] .'">';
    }
}

/**
 * Add right sidebar before tabs in product detail page.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_woocommerce_after_single_product' ) ){
    add_action( 'woocommerce_after_single_product', 'bosa_woocommerce_after_single_product' );
    function bosa_woocommerce_after_single_product(){
        $getSidebarClass = bosa_get_sidebar_class();
        bosa_woo_product_detail_right_sidebar( $getSidebarClass[ 'sidebarColumnClass' ] );
            echo '</div>';/* col woocommerce tabs and related products */
        echo '</div>';/* .row */
    }
}

/**
 * Add icon and tooltip text for Yith Woocommerce Quick View.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_yith_add_quick_view_button_html' ) ){
    add_filter( 'yith_add_quick_view_button_html', 'bosa_yith_add_quick_view_button_html', 10, 3 );
    function bosa_yith_add_quick_view_button_html( $button, $label, $product ){
        
        $product_id = $product->get_id();

        $button = '<div class="product-view"><a href="#" class="yith-wcqv-button" data-product_id="' . esc_attr( $product_id ) . '"><i class="fas fa-search"></i><span class="info-tooltip">' . $label . '</span></a></div>';
        return $button;
    }
}

/**
 * Modify $label for Yith Woocommerce Wishlist.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_yith_wcwl_button_label' ) ){
    add_filter( 'yith_wcwl_button_label', 'bosa_yith_wcwl_button_label' );
    function bosa_yith_wcwl_button_label( $label_option ){
        $label_option = '<span class="info-tooltip">'.$label_option.'</span>';
        return $label_option;
    }
}

/**
 * Modify $browse_wishlist_text for Yith Woocommerce Wishlist.
 *
 * @since Bosa 1.2.6
 */
if( !function_exists( 'bosa_yith_wcwl_browse_wishlist_label' ) ){
    add_filter( 'yith_wcwl_browse_wishlist_label', 'bosa_yith_wcwl_browse_wishlist_label' );
    function bosa_yith_wcwl_browse_wishlist_label( $browse_wishlist_text ){
        if( strpos( $browse_wishlist_text, 'info-tooltip' ) === false ){
            $browse_wishlist_text = '<i class="fas fa-heart"></i><span class="info-tooltip">'.$browse_wishlist_text.'</span>';
        }
        return $browse_wishlist_text;
    }
}

/**
 * Loop product structure
 */
function bosa_loop_product_structure() {
    $elements   = array( 'woocommerce_template_loop_product_title', 'woocommerce_template_loop_price' );
    $layout     = get_theme_mod( 'woocommerce_product_card_layout', 'product_layout_one' );

    if( 'product_layout_one' == $layout ) {
        $loop_count = 0;
        foreach ( $elements as $element ) {
            call_user_func( $element );
            if( $loop_count < 1 ){
                woocommerce_template_loop_rating();
            }
            $loop_count++;
        }
    } 
    else {
        $elements = array_diff( $elements, array( 'woocommerce_template_loop_price' ) );
        echo '<div class="row align-items-center">';
            echo '<div class="col-md-7 text-md-left">';
                foreach ( $elements as $element ) {
                    call_user_func( $element );
                }
                woocommerce_template_loop_rating();
            echo '</div>';
            echo '<div class="col-md-5 text-md-right">';
                woocommerce_template_loop_price();
            echo '</div>';
        echo '</div>';
    }
}

/**
 * Adds cart layout div to add-to-cart loop structure.
 */
function bosa_cart_button_loop_structure() {
    $cart_button_layout     = get_theme_mod( 'woocommerce_add_to_cart_button', 'cart_button_two' );
    echo '<div class="button-' . esc_attr( $cart_button_layout ) . '">';
        woocommerce_template_loop_add_to_cart();
    echo '</div>';
}

/**
 * Inserts the opening figure tag inside product-inner div.
 */
if( !function_exists( 'bosa_product_inner_figure_start' ) ){
    function bosa_product_inner_figure_start(){
        echo '<figure class="woo-product-image">';
    }
}

/**
 * Inserts the closing figure tag.
 */
if( !function_exists( 'bosa_product_inner_figure_close' ) ){
    function bosa_product_inner_figure_close(){
        echo '</figure>';
    }
}

/**
 * Inserts the opening div tag after product-inner div.
 */
if( !function_exists( 'bosa_product_inner_contents_start' ) ){
    function bosa_product_inner_contents_start(){
        $product_card_text_alignment = get_theme_mod( 'woocommerce_product_card_text_alignment', 'text-center' );
        echo '<div class="product-inner-contents '. esc_attr( $product_card_text_alignment ) .'">';
    }
}

/**
 * Inserts the closing div tag for product-inner-content div.
 */
if( !function_exists( 'bosa_product_inner_contents_close' ) ){
    function bosa_product_inner_contents_close(){
        echo '</div>';
    }
}

/**
 * Hook into Woocommerce
 */
add_action( 'wp', 'bosa_woocommerce_hooks' );
function bosa_woocommerce_hooks() {
    $cart_button_layout     = get_theme_mod( 'woocommerce_add_to_cart_button', 'cart_button_two' );

    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
    remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

    add_action( 'woocommerce_before_shop_loop_item', 'bosa_product_inner_figure_start', 9 );
    add_action( 'woocommerce_after_shop_loop_item', 'bosa_product_inner_figure_close', 20 );

    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_open', 29 );
    //Add elements from sortable option
    add_action( 'woocommerce_after_shop_loop_item', 'bosa_loop_product_structure', 30 );
    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 31 );

    add_action( 'woocommerce_after_shop_loop_item', 'bosa_product_inner_contents_start', 25 );
    add_action( 'woocommerce_after_shop_loop_item', 'bosa_product_inner_contents_close', 33 );

    if( $cart_button_layout == 'cart_button_one' ){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    }elseif( $cart_button_layout == 'cart_button_two' ){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
        add_action( 'woocommerce_after_shop_loop_item', 'bosa_cart_button_loop_structure', 32 );
    }elseif( $cart_button_layout == 'cart_button_three' ){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
        add_action( 'woocommerce_after_shop_loop_item', 'bosa_cart_button_loop_structure', 32 );
    }elseif( $cart_button_layout == 'cart_button_four' ){
        remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
        add_action( 'woocommerce_after_shop_loop_item', 'bosa_cart_button_loop_structure', 19 );
    }

    // Single Products
    if( bosa_wooCom_is_product_page() ){
        $disable_single_product_tabs = get_theme_mod( 'disable_single_product_tabs', false );
        if( $disable_single_product_tabs ){
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs' );
        }

        $disable_single_product_related_products = get_theme_mod( 'disable_single_product_related_products', false );
        if( $disable_single_product_related_products ){
            remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
        }
    }
}

/**
 * Add to cart button html.
 */
function bosa_filter_loop_add_to_cart( $button, $product, $args ) {
    global $product;

    //Return if not button layout 4
    $cart_button_layout     = get_theme_mod( 'woocommerce_add_to_cart_button', 'cart_button_two' );

    if ( $cart_button_layout != 'cart_button_four' ) {
        return $button;
    }
    $text = '<i class="fas fa-shopping-cart"></i>';
    $button = sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
        esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
        $text
    );

    return $button;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'bosa_filter_loop_add_to_cart', 10, 3 );

/**
 * Sales badge text
 */
function bosa_sale_badge_tag( $html, $post, $product ) {

    if ( !$product->is_on_sale() ) {
        return;
    }   

    $badge_text     = get_theme_mod( 'woocommerce_sale_badge_text', 'Sale!' );
    $enable_sale_percent = get_theme_mod( 'enable_sale_badge_percent', false );
    $percent_text   = get_theme_mod( 'woocommerce_sale_badge_percent', '-{value}%' );

    if( !$enable_sale_percent ){
        $badge = '<span class="onsale">' . esc_html( $badge_text ) . '</span>';
    }
    else{
        if( $product->is_type( 'variable' ) ){
            $percentages = array();

            // Get all variation prices
            $prices = $product->get_variation_prices();

            // Loop through variation prices
            foreach( $prices['price'] as $key => $price ){
                // Only on sale variations
                if( $prices['regular_price'][$key] !== $price ){
                    // Calculate and set in the array the percentage for each variation on sale
                    $percentages[] = round( 100 - ( floatval($prices['sale_price'][$key]) / floatval($prices['regular_price'][$key]) * 100 ) );
                }
            }
            $percentage = max( $percentages );
      
        }elseif( $product->is_type('grouped') ){
            $percentages    = array();
            $children_ids   = $product->get_children();
      
            foreach( $children_ids as $child_id ){
                $child_product = wc_get_product($child_id);
      
                $regular_price = (float) $child_product->get_regular_price();
                $sale_price    = (float) $child_product->get_sale_price();
      
                if ( $sale_price != 0 || ! empty($sale_price) ) {
                    $percentages[] = round(100 - ($sale_price / $regular_price * 100));
                }
            }
            $percentage = max($percentages) ;
        }else{
            $regular_price = (float) $product->get_regular_price();
            $sale_price    = (float) $product->get_sale_price();
      
            if( $sale_price != 0 || ! empty($sale_price) ){
                $percentage = round(100 - ($sale_price / $regular_price * 100) );
            }else{
                return $html;
            }
        }

        $percent_text = str_replace( '{value}', $percentage, $percent_text );

        $badge = '<span class="onsale">' . esc_html( $percent_text ) . '</span>';

    }
    
    return $badge;
}
add_filter( 'woocommerce_sale_flash', 'bosa_sale_badge_tag', 10, 3 );

if( !function_exists('bosa_add_woocommerce_product_class') ){
    /**
     * WooCommerce Post Class filter.
     *
     */
    function bosa_add_woocommerce_product_class( $classes, $product ){

        if( !bosa_wooCom_is_shop() ){
            return $classes;
        }

        if( get_theme_mod( 'woocommerce_product_layout_type', 'product_layout_grid' ) == 'product_layout_grid' ){
            $classes[] = 'product-grid';
        }elseif( get_theme_mod( 'woocommerce_product_layout_type', 'product_layout_grid' ) == 'product_layout_list' ){
            $classes[] = 'product-list';
        }
        return $classes;
    }
}
add_filter( 'woocommerce_post_class', 'bosa_add_woocommerce_product_class', 10, 2 );

add_filter( 'woocommerce_single_product_zoom_options', 'bosa_single_product_zoom_options' );
if( !function_exists('bosa_single_product_zoom_options') ){
    /**
     * WooCommerce single product zoom magnification level.
     *
     */
    function bosa_single_product_zoom_options( $zoom_options ) {
        // Changing the magnification level:
        $magnification = get_theme_mod( 'single_product_iamge_magnify', 1 );
        $zoom_options['magnify'] = $magnification;

        return $zoom_options;
    }
}
