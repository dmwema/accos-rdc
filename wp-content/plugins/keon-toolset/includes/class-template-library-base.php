<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Keon_Toolset_Template_Library_Base' ) ) {

    /**
     * Base Class For Keon Toolset for common template's functions
     * @since 1.0.0
     *
     */
    class Keon_Toolset_Template_Library_Base{

        /**
         * Gets an instance of this object.
         * Prevents duplicate instances which avoid artefacts and improves performance.
         *
         * @static
         * @access public
         * @since 1.1.4
         * @return object
         */
        public static function get_instance() {

            // Store the instance locally to avoid private static replication
            static $instance = null;

            // Only run these methods if they haven't been ran previously
            if ( null === $instance ) {
                $instance = new self();
            }

            // Always return the instance
            return $instance;

        }

        /**
         * Run Block
         *
         * @access public
         * @since 1.0.0
         * @return void
         */
        public function run(){

            $theme_slug = keon_toolset_get_theme_slug();
            switch ( $theme_slug ):
                case 'gutener':
                case 'gutener-charity-ngo':
                case 'gutener-pro':
                case 'gutener-pro-child':
                case 'gutener-medical':
                case 'blog-gutener':
                case 'gutener-consultancy':
                case 'gutener-business':
                case 'gutener-corporate':
                case 'gutener-education':
                case 'gutener-corporate-business':
                    add_filter( 'gutentor_advanced_import_templates', array( $this, 'add_keon_template' ) );
                    break;
                default:
                    break;
            endswitch;

        }
        /**
         * Load block library
         * Used for blog template loading
         *
         * @since      1.1.4
         *
         * @param $templates_list array
         * @return array
         */
        public function add_keon_template( $templates_list ){
            $theme_slug = keon_toolset_get_theme_slug();
            // Get the blocks and templates list 
            while( empty( get_transient( 'keon_toolset_template_lists' ) ) ){
                $request_template_list_body = wp_remote_retrieve_body( wp_remote_get('https://gitlab.com/api/v4/projects/19904886/repository/files/gutener%2Ftemplatelist%2Ejson?ref=master' ) );
                if( is_wp_error( $request_template_list_body ) ) {
                    return false; // Bail early
                }
                $template_list_std      = json_decode( $request_template_list_body,true );
                $template_list_array    = (array) $template_list_std;
                $template_list_content  = $template_list_array['content'];
                $template_lists_json    = base64_decode( $template_list_content );
                $keon_template_lists    = json_decode( $template_lists_json, true );
                set_transient( 'keon_toolset_template_lists', $keon_template_lists, DAY_IN_SECONDS );
            }
            while( empty( get_transient( 'keon_toolset_template_state_list' ) ) ){
                $request_temp_state_list_body = wp_remote_retrieve_body(wp_remote_get( 'https://gitlab.com/api/v4/projects/19904886/repository/files/gutener%2Ftemplate_state%2Ejson?ref=master' ));
                if( is_wp_error( $request_temp_state_list_body ) ) {
                    return false; // Bail early
                }
                $temp_state_list_std      = json_decode( $request_temp_state_list_body,true );
                $temp_state_list_array    = (array) $temp_state_list_std;
                $temp_state_list_content  = $temp_state_list_array['content'];
                $temp_state_lists_json    = base64_decode( $temp_state_list_content );
                $temp_state_lists         = json_decode( $temp_state_lists_json, true );
                $theme_temp_state_list    = $temp_state_lists[$theme_slug];
                set_transient( 'keon_toolset_template_state_list', $theme_temp_state_list, DAY_IN_SECONDS );
            }

            $keon_template_lists    = get_transient( 'keon_toolset_template_lists' );
            $theme_temp_state_list  = get_transient( 'keon_toolset_template_state_list' );
            
            foreach( $theme_temp_state_list as &$temp_list ){
                    if( !is_array( $temp_list ) ){
                        $temp_pos = array_search( $temp_list, array_column( $keon_template_lists,'title' ) );
                        if( !$temp_pos === FALSE || $temp_pos == 0 ){
                            $keon_template_lists[$temp_pos]['is_pro'] = false;
                        }
                    }
                }
            return array_merge_recursive( $keon_template_lists, $templates_list );
        }

    }
}
Keon_Toolset_Template_Library_Base::get_instance()->run();