<?php

/*
  WPFront Scroll Top Plugin
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace WPFront\Scroll_Top;

require_once("class-wpfront-scroll-top-options.php");
require_once(dirname(__DIR__) . '/templates/scroll-top-template.php');
require_once(dirname(__DIR__) . '/templates/options-template.php');

/**
 * Main class of WPFront Scroll Top plugin
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
class WPFront_Scroll_Top {

    //Constants
    const VERSION = '2.0.7.08086';
    const OPTIONS_GROUP_NAME = 'wpfront-scroll-top-options-group';
    const OPTION_NAME = 'wpfront-scroll-top-options';
    const PLUGIN_SLUG = 'wpfront-scroll-top';
    const PLUGIN_FILE = 'wpfront-scroll-top/wpfront-scroll-top.php';

    //Variables
    protected $iconsDIR = '/tmp/icons/';
    protected $iconsURL = '//tmp/icons/';
    protected $pluginDIRRoot = '/tmp/';
    protected $pluginURLRoot = '//tmp/';
    protected $options;
    protected $markupLoaded;
    protected $scriptLoaded;
    protected $min_file_suffix;
    private static $instance = null;

    protected function __construct() {
        
    }

    public static function Instance() {
        if (empty(self::$instance)) {
            self::$instance = new WPFront_Scroll_Top();
        }

        return self::$instance;
    }

    public function init($pluginFile = null) {
        $this->markupLoaded = FALSE;
        $this->min_file_suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

        //Root variables
        $this->pluginURLRoot = plugins_url() . '/' . self::PLUGIN_SLUG . '/';
        $this->iconsURL = $this->pluginURLRoot . 'images/icons/';
        $this->pluginDIRRoot = plugin_dir_path($pluginFile);
        $this->iconsDIR = $this->pluginDIRRoot . 'images/icons/';

        add_action('plugins_loaded', array($this, 'plugins_loaded'));

        $this->add_activation_redirect();

        if (is_admin()) {
            add_action('admin_init', array($this, 'admin_init'));
            add_action('admin_menu', array($this, 'admin_menu'));
            add_filter('plugin_action_links', array($this, 'action_links'), 10, 2);

            add_action('admin_footer', array($this, 'write_markup'));
        } else {
            add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

            add_action('wp_footer', array($this, 'write_markup'));
        }
    }

    public function action_links($links, $file) {
        if ($file == self::PLUGIN_FILE) {
            $settings_link = '<a id="wpfront-scroll-top-settings-link" href="' . menu_page_url(self::PLUGIN_SLUG, FALSE) . '">' . __('Settings', 'wpfront-scroll-top') . '</a>';
            array_unshift($links, $settings_link);
        }
        return $links;
    }

    protected function add_activation_redirect() {
        add_action('activated_plugin', array($this, 'activated_plugin_callback'));
        add_action('admin_init', array($this, 'admin_init_callback'), 999999);
    }

    public function activated_plugin_callback($plugin) {
        if ($plugin !== self::PLUGIN_FILE) {
            return;
        }

        if (is_network_admin() || isset($_GET['activate-multi'])) {
            return;
        }

        $key = self::PLUGIN_SLUG . '-activation-redirect';
        add_option($key, TRUE);
    }

    public function admin_init_callback() {
        $key = self::PLUGIN_SLUG . '-activation-redirect';

        if (get_option($key, FALSE)) {
            delete_option($key);

            if (is_network_admin() || isset($_GET['activate-multi'])) {
                return;
            }

            wp_safe_redirect(menu_page_url(self::PLUGIN_SLUG, FALSE));
        }
    }

    //add scripts
    public function enqueue_scripts() {
        if ($this->enabled() == FALSE) {
            return;
        }

        $jsRoot = $this->pluginURLRoot . 'js/';

        wp_enqueue_script('jquery');
        wp_enqueue_script('wpfront-scroll-top', $jsRoot . 'wpfront-scroll-top' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION, TRUE);

        $this->scriptLoaded = TRUE;
    }

    //add styles
    public function enqueue_styles() {
        if ($this->enabled() == FALSE) {
            return;
        }

        $cssRoot = $this->pluginURLRoot . 'css/';

        wp_enqueue_style('wpfront-scroll-top', $cssRoot . 'wpfront-scroll-top' . $this->min_file_suffix . '.css', array(), self::VERSION);

        if ($this->options->button_style() == 'font-awesome') {
            if (!$this->options->fa_button_exclude_URL() || is_admin()) {
                $url = trim($this->options->fa_button_URL());
                $ver = FALSE;
                if (empty($url)) {
                    $url = 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
                    $ver = '4.7.0';
                }
                wp_enqueue_style('font-awesome', $url, array(), $ver);
            }
        }
    }

    public function admin_init() {
        register_setting(self::OPTIONS_GROUP_NAME, self::OPTION_NAME);

        $this->enqueue_styles();
        $this->enqueue_scripts();
    }

    public function admin_menu() {
        $page_hook_suffix = add_options_page(__('WPFront Scroll Top', 'wpfront-scroll-top'), __('Scroll Top', 'wpfront-scroll-top'), 'manage_options', self::PLUGIN_SLUG, array($this, 'options_page'));

        add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'enqueue_options_scripts'));
        add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'enqueue_options_styles'));
    }

    public function enqueue_options_scripts() {
        wp_enqueue_media();

        $this->enqueue_scripts();

        $jsRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/js/';
        wp_enqueue_script('jquery.eyecon.colorpicker', $jsRoot . 'colorpicker' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION);

        $jsRoot = $this->pluginURLRoot . 'js/';
        wp_enqueue_script('wpfront-scroll-top-options', $jsRoot . 'options' . $this->min_file_suffix . '.js', array('jquery'), self::VERSION);
    }

    //options page styles
    public function enqueue_options_styles() {
        $styleRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/css/';
        wp_enqueue_style('jquery.eyecon.colorpicker', $styleRoot . 'colorpicker' . $this->min_file_suffix . '.css', array(), self::VERSION);

        $styleRoot = $this->pluginURLRoot . 'css/';
        wp_enqueue_style('wpfront-scroll-top-options', $styleRoot . 'options' . $this->min_file_suffix . '.css', array(), self::VERSION);
    }

    public function set_options($options = null) {
        if ($options === null) {
            $options = new WPFront_Scroll_Top_Options(self::OPTION_NAME, self::PLUGIN_SLUG);
        }

        $this->options = $options;
    }

    public function get_options() {
        return $this->options;
    }

    public function plugins_loaded() {
        //load plugin options
        $this->set_options();

        if ($this->options->javascript_async()) {
            add_filter('script_loader_tag', array($this, 'script_loader_tag'), 999999, 3);
        }

        if (!is_admin()) {
            if ($this->options->attach_on_shutdown()) {
                add_action('shutdown', array($this, 'shutdown_callback'));
            }
        }
    }

    public function script_loader_tag($tag, $handle, $src) {
        if ($handle === 'wpfront-scroll-top') {
            return '<script type="text/javascript" src="' . $src . '" id="wpfront-scroll-top-js" async="async" defer="defer"></script>' . "\n";
        }

        return $tag;
    }

    public function shutdown_callback() {
        if ($this->markupLoaded) {
            return;
        }

        $headers = $this->get_headers();
        $flag = FALSE;
        foreach ($headers as $value) {
            $value = strtolower(str_replace(' ', '', $value));
            if (strpos($value, 'content-type:text/html') === 0) {
                $flag = TRUE;
                break;
            }
        }

        if ($flag) {
            $this->write_markup();
        }
    }

    protected function get_headers() {
        return headers_list();
    }

    //writes the html and script for the button
    public function write_markup() {
        if ($this->markupLoaded) {
            return;
        }

        if (!$this->scriptLoaded) {
            return;
        }

        if ($this->doing_ajax()) {
            return;
        }

        if ($this->enabled()) {
            if (is_admin()) {
                $this->options->set_button_action('top');
            }

            $template = new WPFront_Scroll_Top_Template();
            $template->write_markup($this);
        }

        $this->markupLoaded = TRUE;
    }

    protected function doing_ajax() {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return TRUE;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return TRUE;
        }

        if (!empty($_SERVER['REQUEST_URI']) && strtolower($_SERVER['REQUEST_URI']) == '/wp-admin/async-upload.php') {
            return TRUE;
        }

        if (function_exists('wp_doing_ajax') && wp_doing_ajax()) {
            return TRUE;
        }

        if (function_exists('wp_is_json_request') && wp_is_json_request()) {
            return TRUE;
        }

        if (function_exists('wp_is_jsonp_request') && wp_is_jsonp_request()) {
            return TRUE;
        }

        if (function_exists('wp_is_xml_request') && wp_is_xml_request()) {
            return TRUE;
        }

        if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
            return TRUE;
        }
        
        if (defined('WP_CLI') && WP_CLI) {
            return TRUE;
        }

        return FALSE;
    }

    public function apply_button_action_html($html) {
        if ($this->options->button_action() == "url") {
            return sprintf('<a href="%s">' . $html . '</a>', $this->options->button_action_page_url());
        }

        return $html;
    }

    protected function enabled() {
        $enabled = TRUE;

        if ($enabled && !$this->options->enabled()) {
            $enabled = FALSE;
        }

        if ($enabled && $this->options->hide_wpadmin() && is_admin()) {
            $enabled = FALSE;
        }

        if ($enabled && !$this->filter_pages()) {
            $enabled = FALSE;
        }

        $enabled = apply_filters('wpfront_scroll_top_enabled', $enabled);

        return $enabled;
    }

    public function filter_pages() {
        if (is_admin()) {
            return TRUE;
        }

        switch ($this->options->display_pages()) {
            case 1:
                return TRUE;
            case 2:
            case 3:
                global $post;
                $ID = FALSE;
                if (is_home()) {
                    $ID = 'home';
                } elseif (!empty($post)) {
                    $ID = $post->ID;
                }
                if ($this->options->display_pages() == 2) {
                    if ($ID !== FALSE) {
                        if ($this->filter_pages_contains($this->options->include_pages(), $ID) === FALSE) {
                            return FALSE;
                        } else {
                            return TRUE;
                        }
                    }
                    return FALSE;
                }
                if ($this->options->display_pages() == 3) {
                    if ($ID !== FALSE) {
                        if ($this->filter_pages_contains($this->options->exclude_pages(), $ID) === FALSE) {
                            return TRUE;
                        } else {
                            return FALSE;
                        }
                    }
                    return TRUE;
                }
        }

        return TRUE;
    }

    public function filter_pages_contains($list, $key) {
        return strpos(',' . $list . ',', ',' . $key . ',');
    }

    public function image() {
        $image = $this->options->image();
        if ($image == 'custom') {
            return $this->options->custom_url();
        }
        return $this->iconsURL . $image;
    }

    public function get_filter_objects() {
        $objects = array();

        $objects['home'] = __('[Page]', 'wpfront-scroll-top') . ' ' . __('Home', 'wpfront-scroll-top');

        $pages = get_pages();
        foreach ($pages as $page) {
            $objects[$page->ID] = __('[Page]', 'wpfront-scroll-top') . ' ' . $page->post_title;
        }

        $posts = get_posts();
        foreach ($posts as $post) {
            $objects[$post->ID] = __('[Post]', 'wpfront-scroll-top') . ' ' . $post->post_title;
        }

//            $categories = get_categories();
//            foreach ($categories as $category) {
//                $objects['3.' . $category->cat_ID] = __('[Category]', 'wpfront-scroll-top') . ' ' . $category->cat_name;
//            }

        return $objects;
    }

    public function options_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', 'wpfront-scroll-top'));
            return;
        }

        $options_view = new WPFront_Scroll_Top_Options_View();
        $options_view->view($this);
    }

    public function get_icon_dir() {
        return $this->iconsDIR;
    }

    public function get_icon_url() {
        return $this->iconsURL;
    }

}
