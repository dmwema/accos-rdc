<?php
/**
 * Bosa - Theme Info Admin Menu
 * @package Bosa Themes
 * @subpackage Admin
 */
if ( ! class_exists( 'Bosa_Theme_Info' ) ) {
    class Bosa_Theme_Info{

        private $config;
        private $theme_name;
        private $theme_slug;
        private $theme_version;
        private $page_title;
        private $menu_title;
        private $tabs;

        /**
         * Constructor.
         */
        public function __construct( $config ) {
            $this->config = $config;
            $this->prepare_class();

            /*admin menu*/
            add_action( 'admin_menu', array( $this, 'kt_admin_menu' ) );

            /* enqueue script and style for about page */
            add_action( 'admin_enqueue_scripts', array( $this, 'style_and_scripts' ) );

            /* ajax callback for dismissable required actions */
            add_action( 'wp_ajax_kt_theme_info_update_recommended_action', array( $this, 'update_recommended_action_callback' ) );
        }

        /**
         * Prepare and setup class properties.
         */
        public function prepare_class() {
            $theme = wp_get_theme();
            $this->theme_name    = esc_attr( $theme->get( 'Name' ) );
            $this->theme_slug    = $theme->get_template();
            $this->theme_version = $theme->get( 'Version' );
            $this->page_title    = $this->theme_name . esc_html__( ' Info', 'bosa' );
            $this->menu_title    = $this->theme_name . esc_html__( ' Setup', 'bosa' );
            $this->tabs          = isset( $this->config['tabs'] ) ? $this->config['tabs'] : array();
        }

        /**
         * Return the valid array of recommended actions.
         * @return array The valid array of recommended actions.
         */
        /**
         * Dismiss required actions
         */
        public function update_recommended_action_callback() {

            /*getting for provided array*/
            $recommended_actions = isset( $this->config[ 'recommended_actions' ] ) ? $this->config[ 'recommended_actions' ] : array();

            /*from js action*/
            $action_id = esc_attr( ( isset( $_GET[ 'id' ] ) ) ? $_GET[ 'id' ] : 0 );
            $todo = esc_attr( ( isset( $_GET[ 'todo' ] ) ) ? $_GET[ 'todo'] : '' );

            /*getting saved actions*/
            $saved_actions = get_option( $this->theme_slug . '_recommended_actions' );

            echo esc_html( wp_unslash( $action_id ) ); /* this is needed and it's the id of the dismissable required action */

            if ( ! empty( $action_id ) ) {

                if( 'reset' == $todo ){
                    $saved_actions_new = array();
                    if ( ! empty( $recommended_actions ) ) {

                        foreach ( $recommended_actions as $recommended_action ) {
                            $saved_actions[ $recommended_action['id'] ] = true;
                        }
                        update_option( $this->theme_slug . '_recommended_actions', $saved_actions_new );
                    }
                }
                /* if the option exists, update the record for the specified id */
                elseif ( !empty( $saved_actions) and is_array( $saved_actions ) ) {

                    switch ( esc_html( $todo ) ) {
                        case 'add';
                            $saved_actions[ $action_id ] = true;
                            break;
                        case 'dismiss';
                            $saved_actions[ $action_id ] = false;
                            break;
                    }
                    update_option( $this->theme_slug . '_recommended_actions', $saved_actions );

                    /* create the new option,with false for the specified id */
                }
                else {
                    $saved_actions_new = array();
                    if ( ! empty( $recommended_actions ) ) {

                        foreach ( $recommended_actions as $recommended_action ) {
                            echo esc_html($recommended_action['id']);
                            echo " ". esc_html($todo);
                            if ( $recommended_action['id'] == $action_id ) {
                                switch ( esc_html( $todo ) ) {
                                    case 'add';
                                        $saved_actions_new[ $action_id ] = true;
                                        break;
                                    case 'dismiss';
                                        $saved_actions_new[ $action_id ] = false;
                                        break;
                                }
                            }
                        }
                    }
                    update_option( $this->theme_slug . '_recommended_actions', $saved_actions_new );
                }
            }
            exit;
        }

        private function get_recommended_actions() {
            $saved_actions = get_option( $this->theme_slug . '_recommended_actions' );
            if ( ! is_array( $saved_actions ) ) {
                $saved_actions = array();
            }
            $recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
            $valid       = array();
            if( isset( $recommended_actions ) && is_array( $recommended_actions ) ){
                foreach ( $recommended_actions as $recommended_action ) {
                    if (
                        (
                            ! isset( $recommended_action['check'] ) ||
                            ( isset( $recommended_action['check'] ) && ( $recommended_action['check'] == false ) )
                        )
                        &&
                        ( ! isset( $saved_actions[ $recommended_action['id'] ] ) ||
                            ( isset( $saved_actions[ $recommended_action['id']] ) && ($saved_actions[ $recommended_action['id']] == true ) )
                        )
                    ) {
                        $valid[] = $recommended_action;
                    }
                }
            }
            return $valid;
        }

        private function count_recommended_actions() {
            $count = 0;
            $actions_count = $this->get_recommended_actions();
            if ( ! empty( $actions_count ) ) {
                $count = count( $actions_count );
            }
            return $count;
        }
        
        /**
         * Adding Theme Info Menu under Appearance.
         */
        function kt_admin_menu() {

            if ( ! empty( $this->page_title ) && ! empty( $this->menu_title ) ) {
                $count = $this->count_recommended_actions();
                $menu_title = $count > 0 ? $this->menu_title . '<span class="badge-action-count">' . esc_html( $count ) . '</span>' : $this->menu_title;
                /* Example
                 * add_theme_page('My Plugin Theme', 'My Plugin', 'edit_theme_options', 'my-unique-identifier', 'my_plugin_function');
                 * */
                add_theme_page( $this->page_title, $menu_title, 'edit_theme_options', $this->theme_slug . '-info', array(
                    $this,
                    'kt_theme_info_screen',
                ) );
            }
        }

        /**
         * Render the info content screen.
         */
        public function kt_theme_info_screen() {

            if ( ! empty( $this->config[ 'info_title' ] ) ) {
                $welcome_title = $this->config[ 'info_title' ];
            }
            if ( ! empty( $this->config[ 'info_content' ] ) ) {
                $welcome_content = $this->config[ 'info_content' ];
            }
            if ( ! empty( $this->config[ 'quick_links' ] ) ) {
                $quick_links = $this->config[ 'quick_links' ];
            }

            if (
                ! empty( $welcome_title ) ||
                ! empty( $welcome_content ) ||
                ! empty( $quick_links ) ||
                ! empty( $this->tabs )
            ) {
                echo '<div class="wrap about-wrap info-wrap epsilon-wrap">';

                if ( ! empty( $welcome_title ) ) {
                    echo '<h1>';
                    echo esc_html( $welcome_title );
                    if ( ! empty( $this->theme_version ) ) {
                        echo esc_html( $this->theme_version ) . ' </sup>';
                    }
                    echo '</h1>';
                }
                if ( ! empty( $welcome_content ) ) {
                    echo '<div class="about-text">' . wp_kses_post( $welcome_content ) . '</div>';
                }

                echo '<a href="' . esc_url( 'https://bosathemes.com' ) . '" target="_blank" class="wp-badge epsilon-info-logo"></a>';

                /*quick links*/
                if( !empty( $quick_links ) && is_array( $quick_links ) ){
                    echo '<p class="quick-links">';
                    foreach ( $quick_links as $quick_key => $quick_link ) {
                        $button = 'button-secondary';
                        if( 'pro_url' == $quick_key ){
                            $button = 'button-primary';
                        }
                        echo '<a href="'.esc_url( $quick_link['url'] ).'" class="button '.esc_attr( $button ).'" target="_blank">'.$quick_link['text'].'</a>';
                    }
                    echo "</p>";
                }
                /* Display tabs */
                if ( ! empty( $this->tabs ) ) {
                    $current_tab = isset( $_GET['tab'] ) ? wp_unslash( $_GET['tab'] ) : 'getting_started';

                    echo '<h2 class="nav-tab-wrapper wp-clearfix">';
                    $count = $this->count_recommended_actions();
                    foreach ( $this->tabs as $tab_key => $tab_name ) {

                        echo '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_slug . '-info' ) ) . '&tab=' . $tab_key . '" class="nav-tab ' . ( $current_tab == $tab_key ? 'nav-tab-active' : '' ) . '" role="tab" data-toggle="tab">';
                        echo esc_html( $tab_name );
                        if ( $tab_key == 'recommended_actions' ) {
                            if ( $count > 0 ) {
                                echo '<span class="badge-action-count">' . esc_html( $count ) . '</span>';
                            }
                        }
                        echo '</a>';
                    }

                    echo '</h2>';

                    /* Display content for current tab, dynamic method according to key provided*/
                    if ( method_exists( $this, $current_tab ) ) {

                        echo "<div class='changelog point-releases'>";
                        $this->$current_tab();
                        echo "</div>";
                    }
                }
                echo '</div><!--/.wrap.about-wrap-->';
            }
        }

        /**
         * Getting started tab
         */
        public function getting_started() {
            echo '<div class="feature-section col-wrap">';
            if ( ! empty( $this->config['gs_steps'] ) ) {
                $gs_steps = $this->config['gs_steps'];
                if ( ! empty( $gs_steps ) ) {

                    /*defaults values for gs_steps array */
                    $defaults = array(
                        'title'     => '',
                        'desc'       => '',
                        'button_label'   => '',
                        'button_link'   => '',
                        'is_button' => true,
                        'is_new_tab' => false,
                        'is_gs' => false,
                    );
                    foreach ( $gs_steps as $gs_step ) {
                        $instance = wp_parse_args( (array) $gs_step, $defaults );

                        /*allowed 7 value in array */
                        $title = $instance[ 'title' ];
                        $desc = $instance[ 'desc'];
                        $button_label = $instance[ 'button_label'];
                        $button_link = $instance[ 'button_link'];
                        $is_button = $instance[ 'is_button'];
                        $is_new_tab = $instance[ 'is_new_tab'];
                        $is_gs = $instance[ 'is_gs' ];
                        
                        echo '<div class="col"><div class="col-items">';
                        
                        if( $is_gs ) {
                            if ( is_plugin_active('advanced-import/advanced-import.php') && is_plugin_active('keon-toolset/keon-toolset.php') && is_plugin_active('kirki/kirki.php') && is_plugin_active('elementor/elementor.php') && is_plugin_active('breadcrumb-navxt/breadcrumb-navxt.php') && is_plugin_active( 'sina-extension-for-elementor/sina-extension-for-elementor.php' ) && is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
                                echo ('<h3>'.esc_html__('Plugins added successfully. You have completed Step 1.', 'bosa').'</h3>');
                            echo '</div></div>';
                            }else {
                                if ( ! empty( $title ) ) {
                                    echo '<h3>';
                                    echo esc_html($title);
                                    echo '</h3>';
                                }

                                if ( ! empty( $desc ) ) {
                                    echo '<p><i>' . $desc . '</i></p>';
                                }

                                if ( ! empty( $button_label ) ) {

                                    echo '<p>';
                                    $button_class = '';
                                    if ( $is_button ) {
                                        $button_class = 'button button-primary button-hero bosa-install-plugins';
                                    }

                                    $button_new_tab = '_self';
                                    if ( isset( $is_new_tab ) ) {
                                        if ( $is_new_tab ) {
                                        $button_new_tab = '_blank';
                                        }
                                    }
                                    echo '<a target="' . $button_new_tab . '" class="' . $button_class . '">' . $button_label . '</a>';
                                    echo '</p>';
                                }
                                echo '</div></div>';
                            }
                        }else{
                            if ( ! empty( $title ) ) {
                                echo '<h3>';
                                echo esc_html($title);
                                echo '</h3>';
                            }

                            if ( ! empty( $desc ) ) {
                                echo '<p><i>' . $desc . '</i></p>';
                            }

                            if ( ! empty( $button_link ) && ! empty( $button_label ) ) {

                                echo '<p>';
                                $button_class = '';
                                if ( $is_button ) {
                                    $button_class = 'button button-primary button-hero';
                                }

                                $button_new_tab = '_self';
                                if ( isset( $is_new_tab ) ) {
                                    if ( $is_new_tab ) {
                                        $button_new_tab = '_blank';
                                    }
                                }
                                echo '<a target="' . $button_new_tab . '" href="' . $button_link . '" class="' . $button_class . '">' . $button_label . '</a>';
                                echo '</p>';
                            }
                            echo '</div></div>';
                        }
                    }
                }
            }
            echo '</div><!-- .feature-section col-wrap -->';
        }


        /**
         * Recommended Actions tab
         */
        public function check_plugin_status( $slug ) {

            $path = WPMU_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
            if ( ! file_exists( $path ) ) {
                $path = WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php';
                if ( ! file_exists( $path ) ) {
                    $path = false;
                }
            }

            if ( file_exists( $path ) ) {
                include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

                $needs = is_plugin_active( $slug . '/' . $slug . '.php' ) ? 'deactivate' : 'activate';

                return array( 'status' => is_plugin_active( $slug . '/' . $slug . '.php' ), 'needs' => $needs );
            }

            return array( 'status' => false, 'needs' => 'install' );
        }

        public function create_action_link( $state, $slug ) {

            switch ( $state ) {
                case 'install':
                    return wp_nonce_url(
                        add_query_arg(
                            array(
                                'action' => 'install-plugin',
                                'plugin' => $slug
                            ),
                            network_admin_url( 'update.php' )
                        ),
                        'install-plugin_' . $slug
                    );
                    break;

                case 'deactivate':
                    return add_query_arg(
                            array(
                                'action'        => 'deactivate',
                                'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
                                'plugin_status' => 'all',
                                'paged'         => '1',
                                '_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . $slug . '/' . $slug . '.php' )
                                ),
                            network_admin_url( 'plugins.php' )
                    );
                    break;

                case 'activate':
                    return add_query_arg(
                            array(
                                'action'        => 'activate',
                                'plugin'        => rawurlencode( $slug . '/' . $slug . '.php' ),
                                'plugin_status' => 'all',
                                'paged'         => '1',
                                '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . $slug . '/' . $slug . '.php' )
                            ),
                            network_admin_url( 'plugins.php' )
                    );
                    break;
            }
        }

        public function recommended_actions() {

            $recommended_actions = isset( $this->config['recommended_actions'] ) ? $this->config['recommended_actions'] : array();
            $hooray = true;
            if ( ! empty( $recommended_actions ) ) {

                echo '<div class="feature-section action-recommended demo-import-boxed" id="plugin-filter">';

                if ( ! empty( $recommended_actions ) && is_array( $recommended_actions ) ) {

                    /*get saved recommend actions*/
                    $saved_recommended_actions = get_option( $this->theme_slug . '_recommended_actions' );

                    /*defaults values for getting_started array */
                    $defaults = array(
                        'title'         => '',
                        'desc'          => '',
                        'check'         => false,
                        'plugin_slug'   => '',
                        'id'            => ''
                    );
                    foreach ( $recommended_actions as $action_key => $action_value ) {
                        $instance = wp_parse_args( (array) $action_value, $defaults );

                        /*allowed 5 value in array */
                        $title = $instance[ 'title' ];
                        $desc = $instance[ 'desc' ];
                        $check = $instance[ 'check' ];
                        $plugin_slug = $instance[ 'plugin_slug' ];
                        $id = $instance[ 'id' ];

                        $hidden = false;

                        /*magic check for recommended actions*/
                        if (
                            isset( $saved_recommended_actions[ $id ] ) &&
                            $saved_recommended_actions[ $id ] == false ) {
                            $hidden = true;
                        }
                        if ( $hidden ) {
                            echo '';
                        }
                        $done = '';
                        if ( $check ) {
                           $done = 'done';
                        }

                        echo "<div class='kt-theme-info-action-recommended-box {$done}'>";

                        if ( ! $hidden ) {
                            echo '<span data-action="dismiss" class="dashicons dashicons-visibility kt-theme-info-recommended-action-button" id="' . esc_attr( $action_value['id'] ) . '"></span>';
                        } else {
                            echo '<span data-action="add" class="dashicons dashicons-hidden kt-theme-info-recommended-action-button" id="' . esc_attr( $action_value['id'] ) .'"></span>';
                        }

                        if ( ! empty( $title) ) {
                            echo '<h3>' . wp_kses_post( $title ) . '</h3>';
                        }

                        if ( ! empty( $desc ) ) {
                            echo '<p>' . wp_kses_post( $desc ) . '</p>';
                        }

                        if ( ! empty( $plugin_slug ) ) {

                            $active = $this->check_plugin_status( $action_value['plugin_slug'] );
                            $url    = $this->create_action_link( $active['needs'], $action_value['plugin_slug'] );
                            $label  = '';
                            $class  = '';
                            switch ( $active['needs'] ) {

                                case 'install':
                                    $class = 'install-now button';
                                    $label = esc_html__( 'Install', 'bosa' );
                                    break;

                                case 'activate':
                                    $class = 'activate-now button button-primary';
                                    $label = esc_html__( 'Activate', 'bosa' );

                                    break;

                                case 'deactivate':
                                    $class = 'deactivate-now button';
                                    $label = esc_html__( 'Deactivate', 'bosa' );

                                    break;
                            }

                            ?>
                            <p class="plugin-card-<?php echo esc_attr( $action_value['plugin_slug'] ) ?> action_button <?php echo ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ?>">
                                <a data-slug="<?php echo esc_attr( $action_value['plugin_slug'] ) ?>"
                                   class="<?php echo esc_attr( $class ); ?>"
                                   href="<?php echo esc_url( $url ) ?>"> <?php echo esc_html( $label ) ?> </a>
                            </p>

                            <?php

                        }
                        echo '</div>';
                        $hooray = false;
                    }
                }
                if ( $hooray ){
                    echo '<span class="hooray">' . esc_html__( 'Hooray! There are no recommended actions for you right now.', 'bosa' ) . '</span>';
                    echo '<a data-action="reset" id="reset" class="reset-all" href="#">'.esc_html__('Show All Recommended Actions', 'bosa').'</a>';
                }
                echo '</div>';
            }
        }

        /**
         * Recommended plugins tab
         */
        /*
         * Call plugin api
         */
        public function call_plugin_api( $slug ) {
            include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

            if ( false === ( $call_api = get_transient( 'kt_theme_info_plugin_information_transient_' . $slug ) ) ) {
                $call_api = plugins_api( 'plugin_information', array(
                    'slug'   => $slug,
                    'fields' => array(
                        'downloaded'        => false,
                        'rating'            => false,
                        'description'       => false,
                        'short_description' => true,
                        'donate_link'       => false,
                        'tags'              => false,
                        'sections'          => true,
                        'homepage'          => true,
                        'added'             => false,
                        'last_updated'      => false,
                        'compatibility'     => false,
                        'tested'            => false,
                        'requires'          => false,
                        'downloadlink'      => false,
                        'icons'             => true
                    )
                ) );
                set_transient( 'kt_theme_info_plugin_information_transient_' . $slug, $call_api, 30 * MINUTE_IN_SECONDS );
            }

            return $call_api;
        }
        public function get_plugin_icon( $arr ) {

            if ( ! empty( $arr['svg'] ) ) {
                $plugin_icon_url = $arr['svg'];
            } elseif ( ! empty( $arr['2x'] ) ) {
                $plugin_icon_url = $arr['2x'];
            } elseif ( ! empty( $arr['1x'] ) ) {
                $plugin_icon_url = $arr['1x'];
            } else {
                $plugin_icon_url = get_template_directory_uri() . '/assets/placeholder_plugin.png';
            }

            return $plugin_icon_url;
        }
        public function recommended_plugins() {
            $recommended_plugins = $this->config['recommended_plugins'];

            if ( ! empty( $recommended_plugins ) ) {
                if ( ! empty( $recommended_plugins ) && is_array( $recommended_plugins ) ) {

                    echo '<div class="feature-section recommended-plugins col-wrap demo-import-boxed" id="plugin-filter">';

                    foreach ( $recommended_plugins as $recommended_plugins_item ) {

                        if ( ! empty( $recommended_plugins_item['slug'] ) ) {
                            $info   = $this->call_plugin_api( $recommended_plugins_item['slug'] );
                            if ( ! empty( $info->icons ) ) {
                                $icon = $this->get_plugin_icon( $info->icons );
                            }

                            $active = $this->check_plugin_status( $recommended_plugins_item['slug'] );

                            if ( ! empty( $active['needs'] ) ) {
                                $url = $this->create_action_link( $active['needs'], $recommended_plugins_item['slug'] );
                            }

                            echo '<div class="col"><div class="col-items plugin_box">';
                            if ( ! empty( $icon ) ) {
                                echo '<img src="'.esc_url( $icon ).'" alt="plugin box image">';
                            }
                            if ( ! empty(  $info->version ) ) {
                                echo '<span class="version">'. ( ! empty( $this->config['recommended_plugins']['version_label'] ) ? esc_html( $this->config['recommended_plugins']['version_label'] ) : '' ) . esc_html( $info->version ).'</span>';
                            }
                            if ( ! empty( $info->author ) ) {
                                echo '<span class="separator"> | </span>' . wp_kses_post( $info->author );
                            }

                            if ( ! empty( $info->name ) && ! empty( $active ) ) {
                                echo '<div class="action_bar ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
                                echo '<span class="plugin_name">' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'Active: ' : '' ) . esc_html( $info->name ) . '</span>';
                                echo '</div>';

                                $label = '';

                                switch ( $active['needs'] ) {

                                    case 'install':
                                        $class = 'install-now button';
                                        $label = esc_html__( 'Install', 'bosa' );
                                        break;

                                    case 'activate':
                                        $class = 'activate-now button button-primary';
                                        $label = esc_html__( 'Activate', 'bosa' );

                                        break;

                                    case 'deactivate':
                                        $class = 'deactivate-now button';
                                        $label = esc_html__( 'Deactivate', 'bosa' );

                                        break;
                                }

                                echo '<span class="plugin-card-' . esc_attr( $recommended_plugins_item['slug'] ) . ' action_button ' . ( ( $active['needs'] !== 'install' && $active['status'] ) ? 'active' : '' ) . '">';
                                echo '<a data-slug="' . esc_attr( $recommended_plugins_item['slug'] ) . '" class="' . esc_attr( $class ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
                                echo '</span>';
                            }
                            echo '</div></div><!-- .col.plugin_box -->';
                        }
                    }
                    echo '</div><!-- .recommended-plugins -->';
                }
            }
        }

        /**
         * Child themes
         */
        public function child_themes() {
            echo '<div id="child-themes" class="kt-theme-info-tab-pane">';
            $child_themes = isset( $this->config['child_themes'] ) ? $this->config['child_themes'] : array();
            if ( ! empty( $child_themes ) ) {

                /*defaults values for child theme array */
                $defaults = array(
                    'title'        => '',
                    'screenshot'   => '',
                    'download_link'=> '',
                    'preview_link' => ''
                );
                if ( ! empty( $child_themes ) && is_array( $child_themes ) ) {
                    echo '<div class="kt-about-row">';
                    $i = 0;
                    foreach ( $child_themes as $child_theme ){
                        $instance = wp_parse_args( (array) $child_theme, $defaults );

                        /*allowed 5 value in array */
                        $title = $instance[ 'title' ];
                        $screenshot = $instance[ 'screenshot'];
                        $download_link = $instance[ 'download_link'];
                        $preview_link = $instance[ 'preview_link'];

                        if( !empty( $screenshot) ){
                            echo '<div class="kt-about-child-theme">';
                            echo '<div class="kt-theme-info-child-theme-image">';

                            echo '<img src="' . esc_url( $screenshot ) . '" alt="' . ( ! empty( $title ) ? esc_attr( $title ) : '' ) . '" />';

                            if ( ! empty( $title ) ) {
                                echo '<div class="kt-theme-info-child-theme-details">';
                                echo '<div class="theme-details">';
                                echo '<span class="theme-name">' . esc_html( $title  ). '</span>';
                                if ( ! empty( $download_link ) ) {
                                    echo '<a href="' . esc_url( $download_link ) . '" class="button button-primary install right">' . esc_html__( 'Download', 'bosa' ) . '</a>';
                                }
                                if ( ! empty( $preview_link ) ) {
                                    echo '<a class="button button-secondary preview right" target="_blank" href="' . $preview_link . '">' . esc_html__( 'Live Preview', 'bosa' ). '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                            }

                            echo "</div>";
                            echo "</div>";
                            $i++;
                        }
                        if( 0 == $i % 3 ){
                            echo "</div><div class='kt-about-row'>";/*.kt-about-row end-start*/
                        }
                    }

                    echo '</div>';/*.kt-about-row end*/
                }// End if().
            }// End if().
            echo '</div>';
        }

        /**
         * Support tab
         */
        public function support() {
            echo '<div class="feature-section col-wrap">';

            if ( ! empty( $this->config['support_content'] ) ) {

                $supports = $this->config['support_content'];

                if ( ! empty( $supports ) ) {

                    /*defaults values for child theme array */
                    $defaults = array(
                        'title' => '',
                        'icon' => '',
                        'desc' => '',
                        'button_label' => '',
                        'button_link' => '',
                        'is_button' => true,
                        'is_new_tab' => true
                    );

                    foreach ( $supports as $support ) {
                        $instance = wp_parse_args( (array) $support, $defaults );

                        /*allowed 7 value in array */
                        $title = $instance[ 'title' ];
                        $icon = $instance[ 'icon'];
                        $desc = $instance[ 'desc'];
                        $button_label = $instance[ 'button_label'];
                        $button_link = $instance[ 'button_link'];
                        $is_button = $instance[ 'is_button'];
                        $is_new_tab = $instance[ 'is_new_tab'];
                        
                        echo '<div class="col"><div class="col-items">';

                        if ( ! empty( $title ) ) {
                            echo '<h3>';
                            if ( ! empty( $icon ) ) {
                                echo '<i class="' . $icon . '"></i>';
                            }
                            echo esc_html($title);
                            echo '</h3>';
                        }

                        if ( ! empty( $desc ) ) {
                            echo '<p><i>' . $desc . '</i></p>';
                        }

                        if ( ! empty( $button_link ) && ! empty( $button_label ) ) {

                            echo '<p>';
                            $button_class = '';
                            if ( $is_button ) {
                                $button_class = 'button button-primary';
                            }

                            $button_new_tab = '_self';
                            if ( isset( $is_new_tab ) ) {
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }
                            }
                            echo '<a target="' . $button_new_tab . '" href="' . $button_link . '" class="' . $button_class . '">' . $button_label . '</a>';
                            echo '</p>';
                        }
                        echo '</div></div>';
                    }
                }
            }
            echo '</div>';
        }

        /**
         * Changelog tab
         */
        private function parse_changelog() {
            WP_Filesystem();
            global $wp_filesystem;
            if ( is_child_theme() ){
                $changelog = $wp_filesystem->get_contents( get_stylesheet_directory() . '/inc/theme-info/changelog.txt' );
            }else{
                $changelog = $wp_filesystem->get_contents( get_template_directory() . '/inc/theme-info/changelog.txt' );
            }
            if ( is_wp_error( $changelog ) ) {
                $changelog = '';
            }
            return $changelog;
        }

        public function changelog() {
            $changelog = $this->parse_changelog();
            if ( ! empty( $changelog ) ) {
                echo '<div class="featured-section changelog">';
                echo "<pre class='changelog'>";
                echo esc_html($changelog);
                echo "</pre>";
                echo '</div><!-- .featured-section.changelog -->';
            }
        }

        /**
        * Free vs Pro tab
        */
        public function free_pro(){
            if( ! empty( $this->config['free_pro'] ) ){
                $free_pro= $this->config['free_pro'];
                    if( ! empty($free_pro) ){

                    /*defaults values for Free vs Pro array */
                        $defaults = array(
                            'title'     => '',
                            'desc'       => '',
                            'recommended_actions'=> '',
                            'link_title'   => '',
                            'link_url'   => '',
                            'is_button' => false,
                            'is_new_tab' => false
                        );

                         echo '<div class="feature-section col-wrap">';

                        foreach ( $free_pro as $free_pro_item ) {

                            /*allowed 6 value in array */
                            $instance = wp_parse_args( (array) $free_pro_item, $defaults );
                            /*default values*/
                            $title = esc_html( $instance[ 'title' ] );
                            $desc = wp_kses_post( $instance[ 'desc' ] );
                            $link_title = esc_html( $instance[ 'link_title' ] );
                            $link_url = esc_url( $instance[ 'link_url' ] );
                            $is_button = $instance[ 'is_button' ];
                            $is_new_tab = $instance[ 'is_new_tab' ];


                            echo '<div class="col"><div class="col-items">';
                            if ( ! empty( $title ) ) {
                                echo '<h3>' . $title . '</h3>';
                            }
                            if ( ! empty( $desc ) ) {
                                echo '<p>' . $desc . '</p>';
                            }
                            if ( ! empty( $link_title ) && ! empty( $link_url ) ) {

                                echo '<p>';
                                $button_class = '';
                                if ( $is_button ) {
                                    $button_class = 'button button-primary';
                                }

                                $count = $this->count_recommended_actions();

                                if ( $free_pro_item['recommended_actions'] && isset( $count ) ) {
                                    if ( $count == 0 ) {
                                        echo '<span class="dashicons dashicons-yes"></span>';
                                    } else {
                                        echo '<span class="dashicons dashicons-no-alt"></span>';
                                    }
                                }

                                $button_new_tab = '_self';
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }

                                echo '<a target="' . $button_new_tab . '" href="' . $free_pro_item['link_url'] . '"class="' . $button_class . '">' . $free_pro_item['link_title'] . '</a>';
                                echo '</p>';
                            }
                            echo '</div></div><!-- .col -->';
                        }
                        echo '</div><!-- .feature-section three-col -->';
                    }
             }
        }

         /**
         * Demos tab
         */
        public function demos(){
            if( ! empty( $this->config['demos'] ) ){
                $demos= $this->config['demos'];
                    if( ! empty($demos) ){

                    /*defaults values for demos array */
                        $defaults = array(
                            'title'     => '',
                            'desc'       => '',
                            'recommended_actions'=> '',
                            'link_title'   => '',
                            'link_url'   => '',
                            'is_button' => false,
                            'is_new_tab' => false
                        );

                         echo '<div class="feature-section col-wrap">';

                        foreach ( $demos as $demos_item ) {

                            /*allowed 6 value in array */
                            $instance = wp_parse_args( (array) $demos_item, $defaults );
                            /*default values*/
                            $title = esc_html( $instance[ 'title' ] );
                            $desc = wp_kses_post( $instance[ 'desc' ] );
                            $link_title = esc_html( $instance[ 'link_title' ] );
                            $link_url = esc_url( $instance[ 'link_url' ] );
                            $is_button = $instance[ 'is_button' ];
                            $is_new_tab = $instance[ 'is_new_tab' ];


                            echo '<div class="col"><div class="col-items">';
                            if ( ! empty( $title ) ) {
                                echo '<h3>' . $title . '</h3>';
                            }
                            if ( ! empty( $desc ) ) {
                                echo '<p>' . $desc . '</p>';
                            }
                            if ( ! empty( $link_title ) && ! empty( $link_url ) ) {

                                echo '<p>';
                                $button_class = '';
                                if ( $is_button ) {
                                    $button_class = 'button button-primary';
                                }

                                $count = $this->count_recommended_actions();

                                if ( $demos_item['recommended_actions'] && isset( $count ) ) {
                                    if ( $count == 0 ) {
                                        echo '<span class="dashicons dashicons-yes"></span>';
                                    } else {
                                        echo '<span class="dashicons dashicons-no-alt"></span>';
                                    }
                                }

                                $button_new_tab = '_self';
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }

                                echo '<a target="' . $button_new_tab . '" href="' . $demos_item['link_url'] . '"class="' . $button_class . '">' . $demos_item['link_title'] . '</a>';
                                echo '</p>';
                            }
                            echo '</div></div><!-- .col -->';
                        }
                        echo '</div><!-- .feature-section three-col -->';
                    }
             }
        }

        /**
         * Rating tab
         */
        public function rating(){
            if( ! empty( $this->config['rating'] ) ){
                $rating= $this->config['rating'];
                if( ! empty($rating) ){

                    /*defaults values for demos array */
                    $defaults = array(
                            'title'     => '',
                            'desc'       => '',
                            'link_title'   => '',
                            'link_url'   => '',
                            'is_button' => false,
                            'is_new_tab' => false
                    );
                    echo '<div class="feature-section col-wrap">';
                    foreach ( $rating as $rating_item ) {

                            /*allowed 6 value in array */
                            $instance = wp_parse_args( (array) $rating_item, $defaults );
                            /*default values*/
                            $title = esc_html( $instance[ 'title' ] );
                            $desc = wp_kses_post( $instance[ 'desc' ] );
                            $link_title = esc_html( $instance[ 'link_title' ] );
                            $link_url = esc_url( $instance[ 'link_url' ] );
                            $is_button = $instance[ 'is_button' ];
                            $is_new_tab = $instance[ 'is_new_tab' ];


                            echo '<div class="col"><div class="col-items">';
                            if ( ! empty( $title ) ) {
                                echo '<h3>' . $title . '</h3>';
                            }
                            if ( ! empty( $desc ) ) {
                                echo '<p>' . $desc . '</p>';
                            }
                            if ( ! empty( $link_title ) && ! empty( $link_url ) ) {

                                echo '<p>';
                                $button_class = '';
                                if ( $is_button ) {
                                    $button_class = 'button button-primary';
                                }

                                $button_new_tab = '_self';
                                if ( $is_new_tab ) {
                                    $button_new_tab = '_blank';
                                }

                                echo '<a target="' . $button_new_tab . '" href="' . $rating_item['link_url'] . '"class="' . $button_class . '">' . $rating_item['link_title'] . '</a>';
                                echo '</p>';
                            }
                            echo '</div></div><!-- .col -->';
                    }
                        echo '</div><!-- .feature-section three-col -->';
                }
            }
        }

        /**
         * Load css and scripts for the about page
         */
        public function style_and_scripts( $hook_suffix ) {

            // this is needed on all admin pages, not just the about page, for the badge action count in the WordPress main sidebar
            wp_enqueue_style( 'kt-theme-info-css', get_template_directory_uri() . '/inc/theme-info/assets/css/theme-info.css' );

            if ( 'appearance_page_' . $this->theme_slug . '-info' == $hook_suffix ) {

                wp_enqueue_script( 'kt-theme-info-js', get_template_directory_uri() . '/inc/theme-info/assets/js/theme-info.js', array( 'jquery' ) );

                wp_enqueue_style( 'plugin-install' );
                wp_enqueue_script( 'plugin-install' );
                wp_enqueue_script( 'updates' );

                $count = $this->count_recommended_actions();
                wp_localize_script( 'kt-theme-info-js', 'kt_theme_info_object', array(
                    'nr_actions_recommended'   => $count,
                    'ajaxurl'                  => admin_url( 'admin-ajax.php' ),
                    'template_directory'       => get_template_directory_uri()
                ) );

            }

        }
    }
}

$theme_name_config = esc_attr ( wp_get_theme()->get('Name') );
$theme_name_config_url = strtolower( str_replace( ' ', '-', $theme_name_config ) );
$demo_name_config_url = '';
if( is_child_theme() ){
    $demo_name_config_url = $theme_name_config_url;
}

$config = array(

    // Main welcome title
    'info_title' => sprintf( esc_html__( 'Welcome to %s - ', 'bosa' ), $theme_name_config ),

    // Main welcome content
    'info_content' => sprintf( esc_html__( '%s is now installed and ready to use. We hope the following information will help and you enjoy using it!', 'bosa' ), '<b>'.$theme_name_config.'</b>' ),

    /**
     * Quick links
     */
    'quick_links' => array(
        'theme_url'  => array(
            'text' => __( 'Theme Details', 'bosa' ),
            'url' => 'https://bosathemes.com/' .$theme_name_config_url 
        ),
        'demo_url'  => array(
            'text' => __( 'View Demo', 'bosa' ),
            'url' => 'https://demo.bosathemes.com/bosa/' .$demo_name_config_url
        ),
        'pro_url'  => array(
            'text' => __( 'View Pro Version', 'bosa' ),
            'url' => 'https://bosathemes.com/bosa-pro'
        ),
        'rate_url'  => array(
            'text' => __( 'Rate This Theme', 'bosa' ),
            'url' => 'https://wordpress.org/support/theme/' .$theme_name_config_url. '/reviews'
        ),  
    ),

    'tabs' => array(
        'getting_started'      => esc_html__( 'Getting Started', 'bosa' ),
        'recommended_plugins'  => esc_html__( 'Recommended Plugins', 'bosa' ),
        'support'              => esc_html__( 'Support', 'bosa' ),
        'changelog'            => esc_html__( 'Changelog', 'bosa' ),
        'free_pro'             => esc_html__( 'Free VS Pro', 'bosa' ),
        'demos'                => esc_html__( 'Demos', 'bosa' ),
        'rating'               => esc_html__( 'Rate Theme', 'bosa' )
    ),

    /*Getting started tab*/
    'gs_steps' => array(
        'first' => array(
           'title' => esc_html__( 'Step 1 - To fully take advantage of the best our theme can offer, get started.', 'bosa' ),
            'button_label' => sprintf(esc_html__( 'Get started with %s', 'bosa' ), $theme_name_config ),
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true,
            'is_gs' => true,
        ),
        'second' => array(
            'title' => esc_html__( 'Step 2 - Checkout starter sites (Demos)', 'bosa' ),
            'desc' => esc_html__( 'All starter demos sites comes attached to Bosa just ready to pluck one from. Discover them, be enamoured and finally decide on the one you resonate with. If one doesnt catch your fancy dont be afraid to have a go at building a site with your own design.', 'bosa' ),
            'button_label' => esc_html__( 'View Demo', 'bosa' ),
            'button_link' => esc_url( 'https://demo.bosathemes.com/bosa/' .$demo_name_config_url ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'third' => array (
            'title' => esc_html__( 'Step 3 - Import demo of your choice', 'bosa' ),
            'desc' => esc_html__( 'Once you have a found a site you like, you can move ahead and import it. It is to be noted that some necessary plugins will be installed to function the site as you see in the demo site. A fresh Wordpress site is recommended to mirror the demo site on your setup. Importing the demo on an already running site will create discrepancies with the site shown on the demo.', 'bosa' ),
            'button_label' => esc_html__( 'Import Demo', 'bosa' ),
            'button_link' => esc_url( admin_url( 'themes.php?page=advanced-import' ), 'bosa' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'fourth' => array(
            'title' => esc_html__( 'Step 4 - Start editing content and making your site!', 'bosa' ),
            'desc' => esc_html__( 'Once finishing the import you play with the demo to your hearts content.', 'bosa' ),
        ),
        'fifth' => array (
            'title' => esc_html__( "Step 5 - That's it!", 'bosa' ),
            'desc' => esc_html__( 'Go live with the website and enjoy it!', 'bosa' ),
        ),
    ),

    // recommended actions array.
    'recommended_actions' => array(

    ),

    // Generic Plugins array.
    'recommended_plugins' => array(
        'Kirki' => array(
            'slug' => 'kirki'
        ),
        'Elementor' => array(
            'slug' => 'elementor'
        ),
        'Keon Toolset' => array(
            'slug' => 'keon-toolset'
        ),
        'Advanced Import' => array(
            'slug' => 'advanced-import'
        ),
        'Breadcrumb NavXT' => array(
            'slug' => 'breadcrumb-navxt'
        ),
        'Smash Balloon Instagram Feed' => array(
            'slug' => 'instagram-feed'
        ),
    ),

    // Support content tab.
    'support_content' => array(
        'first' => array(
            'title' => esc_html__( 'Need more features?', 'bosa' ),
            'desc' => esc_html__( 'Upgrade to PRO version for more exciting features and Priority Support.', 'bosa' ),
            'button_label' => esc_html__( 'Upgrade to PRO', 'bosa' ),
            'button_link' => esc_url( 'https://bosathemes.com/bosa-pro' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'second' => array (
            'title' => esc_html__( 'Go to Customizer', 'bosa' ),
            'desc' => esc_html__( 'All Settings, Header & Footer Options, Theme Options, Widgets and Menus are available via Customize screen.', 'bosa' ),
            'button_label' => esc_html__( 'Go to Customizer', 'bosa' ),
            'button_link' => esc_url( admin_url( 'customize.php' ) ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'third' => array(
            'title' => esc_html__( 'Documentation', 'bosa' ),
            'desc' => esc_html__( 'Please check our full documentation for detailed information on how to Setup and Use Bosa.', 'bosa' ),
            'button_label' => esc_html__( 'Read full documentation', 'bosa' ),
            'button_link' => esc_url( 'https://bosathemes.com/docs/bosa' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'fourth' => array (
            'title' => esc_html__( 'Support Forum', 'bosa' ),
            'desc' => esc_html__( 'Got theme support question or found bug? Simply create a support ticket with your queries and we will get back to you.', 'bosa' ),
            'button_label' => esc_html__( 'Support Forum', 'bosa' ),
            'button_link' => esc_url( 'https://bosathemes.com/user-login-register' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'fifth' => array(
            'title' => esc_html__( 'Got sales related question?', 'bosa' ),
            'desc' => esc_html__( "Have any query before purchase, you are more than welcome to ask.", 'bosa' ),
            'button_label' => esc_html__( 'Pre-sale Question?', 'bosa' ),
            'button_link' => esc_url( 'https://bosathemes.com/pre-sale' ),
            'is_button' => true,
            'is_new_tab' => true
        ),
        'sixth' => array(
            'title' => esc_html__( 'Customization Request', 'bosa' ),
            'desc' => esc_html__( 'Needed any customization for the theme, you can request from here.', 'bosa' ),
            'button_label' => esc_html__( 'Customization Request', 'bosa' ),
            'button_link' => esc_url( 'https://bosathemes.com/hire-us' ),
            'is_button' => true,
            'is_new_tab' => true
        )
    ),
    
    // Free vs Pro
    'free_pro' => array (
        'first'=> array(
            'title' => esc_html__( 'Free VS Pro Features', 'bosa' ),
            'desc' => sprintf( esc_html__( '%s is a multipurpose free WordPress theme. However, Bosa Pro comes with more cool and awesome features that give you a flexible and wide range of options to build a full-fledged website.', 'bosa' ), $theme_name_config ),
            'link_title' => esc_html__( 'Check All Features', 'bosa' ),
            'link_url' => esc_url( 'https://bosathemes.com/features' ),
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
    ),

    //demos
    'demos' => array (
        'first'=> array(
            'title' => esc_html__( 'Pre-built Demos', 'bosa' ),
            'desc' => esc_html__ ( 'To get started with ready-made starter site templates.', 'bosa' ),
            'link_title' => esc_html__( 'View All Demos', 'bosa' ),
            'link_url' => esc_url( 'https://demo.bosathemes.com/bosa/' .$demo_name_config_url ),
            'is_button' => true,
            'recommended_actions' => false,
            'is_new_tab' => true
        ),
    ),
    // rating
    'rating' => array(
        'first'=> array(
            'title' => esc_html__( 'Show us how much you like our theme.', 'bosa' ),
            'desc' => esc_html__( 'If you like our work, please give us a moment of your time to rate our theme 5 stars on ', 'bosa' ) .'<a target="_blank" href="https://wordpress.org/support/theme/' .$theme_name_config_url. '/reviews">' . 'wordpress.org' . '</a>' . esc_html__('. It will give us more energy to work on this theme.', 'bosa' ),
            'link_title' => esc_html__( 'Rate Theme', 'bosa' ),
            'link_url' => esc_url( 'https://wordpress.org/support/theme/' .$theme_name_config_url. '/reviews' ),
            'is_button' => true,
            'is_new_tab' => true
        )
    )
);
return new Bosa_Theme_Info( $config );