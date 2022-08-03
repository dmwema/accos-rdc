<?php

/**
 * The Keon Toolset hooks callback functionality of the plugin.
 *
 */
class Keon_Toolset_Hooks {

    private $hook_suffix;

    public static function instance() {

        static $instance = null;

        if ( null === $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     */
    public function __construct() {
        add_action( 'switch_theme', array( $this, 'flush_transient' ) );

    }

    /**
     * Check to see if advanced import plugin is not installed or activated.
     * Adds the Demo Import menu under Apperance.
     *
     * @since    1.0.0
     */
    public function import_menu() {
        if( !class_exists( 'Advanced_Import' ) ){
            $this->hook_suffix[] = add_theme_page( esc_html__( 'Demo Import ','keon-toolset' ), esc_html__( 'Demo Import','keon-toolset'  ), 'manage_options', 'advanced-import', array( $this, 'demo_import_screen' ) );
        } 
    }

    /**
     * Enqueue styles.
     *
     * @since    1.0.0
     */
    public function enqueue_styles( $hook_suffix ) {
        if ( !is_array( $this->hook_suffix ) || !in_array( $hook_suffix, $this->hook_suffix ) ){
            return;
        }
        wp_enqueue_style( 'keon-toolset', KEON_TEMPLATE_URL . 'assets/keon-toolset.css',array( 'wp-admin', 'dashicons' ), '1.0.0', 'all' );
    }

    /**
     * Enqueue scripts.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook_suffix ) {
        if ( !is_array($this->hook_suffix) || !in_array( $hook_suffix, $this->hook_suffix )){
            return;
        }

        wp_enqueue_script( 'keon-toolset', KEON_TEMPLATE_URL . 'assets/keon-toolset.js', array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'keon-toolset', 'keon_toolset', array(
            'btn_text' => esc_html__( 'Processing...', 'keon-toolset' ),
            'nonce'    => wp_create_nonce( 'keon_toolset_nonce' )
        ) );
    }

    /**
     * The demo import menu page comtent.
     *
     * @since    1.0.0
     */
    public function demo_import_screen() {
        ?>
        <div id="ads-notice">
            <div class="ads-container">
                <img class="ads-screenshot" src="<?php echo esc_url( keon_toolset_get_theme_screenshot() ) ?>" >
                <div class="ads-notice">
                    <h2>
                        <?php
                        printf(
                            esc_html__( 'Thank you for choosing %1$s! It is detected that an essential plugin, Advanced Import, is not activated. Importing demos for %1$s can begin after pressing the button below.', 'keon-toolset' ), '<strong>'. wp_get_theme()->get('Name'). '</strong>');
                        ?>
                    </h2>

                    <p class="plugin-install-notice"><?php esc_html_e( 'Clicking the button below will install and activate the Advanced Import plugin.', 'keon-toolset' ); ?></p>

                    <a class="ads-gsm-btn button" href="#" data-name="" data-slug="" aria-label="<?php esc_html_e( 'Get started with the Theme', 'keon-toolset' ); ?>">
                        <?php esc_html_e( 'Install Now', 'keon-toolset' );?>
                    </a>
                </div>
            </div>
        </div>
        <?php

    }

    /**
     * Installs or activates advanced import plugin if not detected as such.
     *
     * @since    1.0.0
     */
    public function install_advanced_import() {

        check_ajax_referer( 'keon_toolset_nonce', 'security' );

        $slug   = 'advanced-import';
        $plugin = 'advanced-import/advanced-import.php';
        $status = array(
            'install' => 'plugin',
            'slug'    => sanitize_key( wp_unslash( $slug ) ),
        );
        $status['redirect'] = admin_url( '/themes.php?page=advanced-import&browse=all&at-gsm-hide-notice=welcome' );

        if ( is_plugin_active_for_network( $plugin ) || is_plugin_active( $plugin ) ) {
            // Plugin is activated
            wp_send_json_success( $status );
        }

        if ( ! current_user_can( 'install_plugins' ) ) {
            $status['errorMessage'] = __( 'Sorry, you are not allowed to install plugins on this site.', 'keon-toolset' );
            wp_send_json_error( $status );
        }

        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        // Looks like a plugin is installed, but not active.
        if ( file_exists( WP_PLUGIN_DIR . '/' . $slug ) ) {
            $plugin_data          = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
            $status['plugin']     = $plugin;
            $status['pluginName'] = $plugin_data['Name'];

            if ( current_user_can( 'activate_plugin', $plugin ) && is_plugin_inactive( $plugin ) ) {
                $result = activate_plugin( $plugin );

                if ( is_wp_error( $result ) ) {
                    $status['errorCode']    = $result->get_error_code();
                    $status['errorMessage'] = $result->get_error_message();
                    wp_send_json_error( $status );
                }

                wp_send_json_success( $status );
            }
        }

        $api = plugins_api(
            'plugin_information',
            array(
                'slug'   => sanitize_key( wp_unslash( $slug ) ),
                'fields' => array(
                    'sections' => false,
                ),
            )
        );

        if ( is_wp_error( $api ) ) {
            $status['errorMessage'] = $api->get_error_message();
            wp_send_json_error( $status );
        }

        $status['pluginName'] = $api->name;

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $status['debug'] = $skin->get_upgrade_messages();
        }

        if ( is_wp_error( $result ) ) {
            $status['errorCode']    = $result->get_error_code();
            $status['errorMessage'] = $result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( is_wp_error( $skin->result ) ) {
            $status['errorCode']    = $skin->result->get_error_code();
            $status['errorMessage'] = $skin->result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( $skin->get_errors()->get_error_code() ) {
            $status['errorMessage'] = $skin->get_error_messages();
            wp_send_json_error( $status );
        } elseif ( is_null( $result ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            WP_Filesystem();
            global $wp_filesystem;

            $status['errorCode']    = 'unable_to_connect_to_filesystem';
            $status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'keon-toolset' );

            // Pass through the error from WP_Filesystem if one was raised.
            if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->get_error_code() ) {
                $status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
            }

            wp_send_json_error( $status );
        }

        $install_status = install_plugin_install_status( $api );

        if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
            $result = activate_plugin( $install_status['file'] );

            if ( is_wp_error( $result ) ) {
                $status['errorCode']    = $result->get_error_code();
                $status['errorMessage'] = $result->get_error_message();
                wp_send_json_error( $status );
            }
        }

        wp_send_json_success( $status );

    }
    /**
     * Demo list of the Keon Themes with their recommended plugins.
     *
     * @since    1.0.0
     */
    public function keon_toolset_demo_import_lists(){

        $theme_slug = keon_toolset_get_theme_slug();
        switch( $theme_slug ):
            case 'gutener-pro':
            case 'gutener':
            case 'gutener-charity-ngo':
            case 'gutener-pro-child':
            case 'gutener-medical':
            case 'blog-gutener':
            case 'gutener-consultancy':
            case 'gutener-business':
            case 'gutener-corporate':
            case 'gutener-education':
            case 'gutener-corporate-business':
                // Get the demos list
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/gutener%2Fdemolist%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                while( empty( get_transient( 'keon_toolset_theme_state_list' ) ) ){
                    $request_state_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/gutener%2Fstate%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_state_list_body ) ) {
                        return false; // Bail early
                    }
                    $state_list_std     = json_decode( $request_state_list_body,true );
                    $state_list_array   = (array) $state_list_std;
                    $state_list_content = $state_list_array['content'];
                    $state_lists_json   = base64_decode( $state_list_content );
                    $state_lists        = json_decode( $state_lists_json, true );
                    $theme_state_list   = $state_lists[$theme_slug];
                    set_transient( 'keon_toolset_theme_state_list', $theme_state_list, DAY_IN_SECONDS );
                }
                
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                $theme_state_list = get_transient( 'keon_toolset_theme_state_list' );
                $i = 0;
                
                foreach($theme_state_list as $list){
                    if( !is_array( $list ) ){
                        $pos = array_search( $list, array_column( $demo_lists,'title' ) );
                        if( !$pos === FALSE || $pos == 0 ){
                            $demo_lists[$pos]['is_pro'] = false;
                            $this->array_move( $demo_lists, $pos, $i );   
                        }
                    }else{
                        $pro_item = $list['pro'];
                        $pos = array_search( $pro_item,array_column( $demo_lists,'title' ) );
                        if( !$pos === FALSE ){
                            $this->array_move( $demo_lists, $pos, $i );
                        }
                    }
                    $i++;
                }
                foreach ( $demo_lists as &$val ){
                    $hit = $this->in_multiarray( $val['title'], $theme_state_list );
                    if( !$hit ){
                        $pos_demo = array_search( $val['title'], array_column( $demo_lists,'title' ) );
                        array_splice( $demo_lists, $pos_demo, 1 );
                    }
                }      

                break;
            case 'bosa':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-pro':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-pro-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-business':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-business-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-corporate-dark':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-corporate-dark-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-consulting':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-consulting-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-blog-dark':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-blog-dark-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-charity':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-charity-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
             case 'bosa-music':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-music-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-travelers-blog':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-travelers-blog-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-insurance':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-insurance-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-blog':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-blog-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-marketing':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-marketing-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-lawyer':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-lawyer-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-wedding':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-wedding-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-corporate-business':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-corporate-business-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-fitness':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-fitness-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-finance':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-finance-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-news-blog':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-news-blog-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-store':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-store-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-ecommerce':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-ecommerce-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-shop':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-shop-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-shopper':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-shopper-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-online-shop':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-online-shop-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            case 'bosa-storefront':
                while( empty( get_transient( 'keon_toolset_demo_lists' ) ) ){
                    $request_demo_list_body = wp_remote_retrieve_body( wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/bosa%2Fbosa-storefront-demo-list%2Ejson?ref=master' ) );
                    if( is_wp_error( $request_demo_list_body ) ) {
                        return false; // Bail early
                    }
                    $demo_list_std     = json_decode( $request_demo_list_body, true );
                    $demo_list_array   = (array) $demo_list_std;
                    $demo_list_content = $demo_list_array['content'];
                    $demo_lists_json   = base64_decode( $demo_list_content );
                    $demo_lists        = json_decode( $demo_lists_json, true );
                    set_transient( 'keon_toolset_demo_lists', $demo_lists, DAY_IN_SECONDS );
                }
                $demo_lists = get_transient( 'keon_toolset_demo_lists' );
                break;
            default:
                $demo_lists = array();
                break;
        endswitch;
        return $demo_lists;
    }

    /**
     * Reposition of the demos in the demolist.
     *
     * @since    1.1.4
     */
    public function array_move( &$a, $oldpos, $newpos ) {
        if ( $oldpos == $newpos ) {return;}
        array_splice( $a, max( $newpos, 0 ), 0, array_splice( $a, max( $oldpos, 0 ), 1 ) );
    }

    /**
     * Check to if element is in the demolist.
     *
     * @since    1.1.4
     */
    public function in_multiarray( $elem, $array )
    {
        $top = sizeof( $array ) - 1;
        $bottom = 0;
        while( $bottom <= $top )
        {
            if( $array[$bottom] == $elem )
                return true;
            else
                if( is_array( $array[$bottom] ) )
                    if( $array[$bottom]['pro'] == $elem )
                        return true;
                   
            $bottom++;
        }       
        return false;
    }
    /**
     * Deletes the demo and template lists upon theme switch.
     *
     * @since    1.1.4
     */
    public function flush_transient(){
        delete_transient( 'keon_toolset_demo_lists' );
        delete_transient( 'keon_toolset_theme_state_list' );
        delete_transient( 'keon_toolset_template_lists' );
        delete_transient( 'keon_toolset_template_state_list' );
    }

    /**
     * Replaces categories id during demo import.
     *
     * @since    1.1.9
     */
    public function replace_term_ids( $replace_term_ids ){

        /*terms IDS*/
        $term_ids = array(
            'slider_category',
            'highlight_posts_category',
            'feature_posts_category',
            'latest_posts_category',
            'feature_posts_two_category',
        );

        return array_merge( $replace_term_ids, $term_ids );
    }

    /**
     * Replaces attachment id during demo import.
     *
     * @since    1.1.9
     */
    public function replace_attachment_ids( $replace_attachment_ids ){
        $theme_slug = keon_toolset_get_theme_slug();
        switch( $theme_slug ):
            case 'bosa-pro':
            case 'bosa':
            case 'bosa-business':
            case 'bosa-corporate-dark':
            case 'bosa-consulting':
            case 'bosa-blog-dark':
            case 'bosa-charity':
            case 'bosa-music':
            case 'bosa-travelers-blog':
            case 'bosa-insurance':
            case 'bosa-blog':
            case 'bosa-marketing':
            case 'bosa-lawyer':
            case 'bosa-wedding':
            case 'bosa-corporate-business':
            case 'bosa-fitness':
            case 'bosa-finance':
            case 'bosa-news-blog':
            case 'bosa-store':
            case 'bosa-ecommerce':
            case 'bosa-shop':
            case 'bosa-shopper':
            case 'bosa-online-shop':
            case 'bosa-storefront':
                /*attachments IDS*/
                $attachment_ids = array(
                    'banner_image',
                    'error404_image',
                    'footer_image',
                    'bottom_footer_image',
                    'box_frame_background_image',
                    'fixed_header_separate_logo',
                    'header_separate_logo',
                    'header_advertisement_banner',
                    'preloader_custom_image',
                    'notification_bar_image',
                    'slider_item',
                    'blog_advertisement_banner',
                    'featured_pages_one',
                    'featured_pages_two',
                    'featured_pages_three',
                    'featured_pages_four',
                    'blog_services_page_one',
                    'blog_services_page_two',
                    'blog_services_page_three',
                    'teams_page_one',
                    'teams_page_two',
                    'teams_page_three'
                );
                break;
            default:
                $attachment_ids = array();
                break;
        endswitch;
        return array_merge( $replace_attachment_ids, $attachment_ids );
    }
}

/**
 * Begins execution of the hooks.
 *
 * @since    1.0.0
 */
function keon_toolset_hooks( ) {
    return Keon_Toolset_Hooks::instance();
}