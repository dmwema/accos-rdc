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

/**
 * Template for WPFront Scroll Top Options
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
class WPFront_Scroll_Top_Options_View {

    protected $controller;
    protected $options;

    public function view($controller) {
        $this->controller = $controller;
        $this->options = $controller->get_options();

        $this->options_page_header();
        $this->display_section();
        $this->location_section();
        $this->filter_section();
        $this->text_button_section();
        $this->font_awesome_button_section();
        $this->image_button_section();
        $this->options_page_footer();
        $this->script_section();
    }

    protected function options_page_header() {
        ?>
        <div class="wrap">
            <h2><?php echo __('WPFront Scroll Top Settings', 'wpfront-scroll-top'); ?></h2>
            <div id="wpfront-scroll-top-options" class="inside">
                <form method="post" action="options.php">
                    <?php
                    settings_fields(WPFront_Scroll_Top::OPTIONS_GROUP_NAME);
                    do_settings_sections('wpfront-scroll-top');

                    if ((isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') || (isset($_GET['updated']) && $_GET['updated'] == 'true')) {
                        ?>
                        <div class="updated">
                            <p>
                                <strong><?php echo __('If you have a caching plugin, clear the cache for the new settings to take effect.', 'wpfront-scroll-top'); ?></strong>
                            </p>
                        </div>
                        <?php
                    }
                }

                protected function display_section() {
                    ?>
                    <h3><?php echo __('Display', 'wpfront-scroll-top'); ?></h3>
                    <table class="form-table">
                        <?php
                        $this->display_table_row_enabled();
                        $this->display_table_row_javascript_async();
                        $this->display_table_row_scroll_offset();
                        $this->display_table_row_button_size();
                        $this->display_table_row_button_opacity();
                        $this->display_table_row_button_fade_duration();
                        $this->display_table_row_scroll_duration();
                        $this->display_table_row_auto_hide();
                        $this->display_table_row_auto_hide_after();
                        $this->display_table_row_hide_small_device();
                        $this->display_table_row_small_device_width();
                        $this->display_table_row_hide_small_window();
                        $this->display_table_row_small_window_width();
                        $this->display_table_row_hide_wpadmin();
                        $this->display_table_row_hide_iframe();
                        $this->display_table_row_attach_on_shutdown();
                        $this->display_table_row_button_style();
                        $this->display_table_row_button_action();
                        ?>
                    </table>
                    <?php
                }

                protected function display_table_row_enabled() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->enabled_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->enabled_name(); ?>" <?php echo $this->options->enabled() ? 'checked' : ''; ?> />
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_javascript_async() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->javascript_async_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->javascript_async_name(); ?>" <?php echo $this->options->javascript_async() ? 'checked' : ''; ?> />
                            <span class="description"><?php echo __('[Increases site performance. Keep it enabled, if there are no conflicts.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_scroll_offset() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->scroll_offset_label(); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->scroll_offset_name(); ?>" value="<?php echo esc_attr($this->options->scroll_offset()); ?>" />px 
                            <span class="description"><?php echo __('[Number of pixels to be scrolled before the button appears.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_button_size() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo __('Button Size', 'wpfront-scroll-top'); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->button_width_name(); ?>" value="<?php echo esc_attr($this->options->button_width()); ?>" />px 
                            X
                            <input class="pixels" name="<?php echo $this->options->button_height_name(); ?>" value="<?php echo esc_attr($this->options->button_height()); ?>" />px 
                            <span class="description"><?php echo __('[Set 0px to auto fit.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_button_opacity() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->button_opacity_label(); ?>
                        </th>
                        <td>
                            <input class="seconds" name="<?php echo $this->options->button_opacity_name(); ?>" value="<?php echo esc_attr($this->options->button_opacity()); ?>" />%
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_button_fade_duration() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->button_fade_duration_label(); ?>
                        </th>
                        <td>
                            <input class="seconds" name="<?php echo $this->options->button_fade_duration_name(); ?>" value="<?php echo esc_attr($this->options->button_fade_duration()); ?>" />ms 
                            <span class="description"><?php echo __('[Button fade duration in milliseconds.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_scroll_duration() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->scroll_duration_label(); ?>
                        </th>
                        <td>
                            <input class="seconds" name="<?php echo $this->options->scroll_duration_name(); ?>" value="<?php echo esc_attr($this->options->scroll_duration()); ?>" />ms 
                            <span class="description"><?php echo __('[Window scroll duration in milliseconds.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_auto_hide() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->auto_hide_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->auto_hide_name(); ?>" <?php echo $this->options->auto_hide() ? "checked" : ""; ?> />
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_auto_hide_after() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->auto_hide_after_label(); ?>
                        </th>
                        <td>
                            <input class="seconds" name="<?php echo $this->options->auto_hide_after_name(); ?>" value="<?php echo esc_attr($this->options->auto_hide_after()); ?>" />sec 
                            <span class="description"><?php echo __('[Button will be auto hidden after this duration in seconds, if enabled.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_hide_small_device() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->hide_small_device_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->hide_small_device_name(); ?>" <?php echo $this->options->hide_small_device() ? "checked" : ""; ?> />
                            <span class="description"><?php echo __('[Button will be hidden on small devices when the width matches.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_small_device_width() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->small_device_width_label(); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->small_device_width_name(); ?>" value="<?php echo esc_attr($this->options->small_device_width()); ?>" />px 
                            <span class="description"><?php echo __('[Button will be hidden on devices with lesser or equal width.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_hide_small_window() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->hide_small_window_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->hide_small_window_name(); ?>" <?php echo $this->options->hide_small_window() ? "checked" : ""; ?> />
                            <span class="description"><?php echo __('[Button will be hidden on broswer window when the width matches.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_small_window_width() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->small_window_width_label(); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->small_window_width_name(); ?>" value="<?php echo esc_attr($this->options->small_window_width()); ?>" />px 
                            <span class="description"><?php echo __('[Button will be hidden on browser window with lesser or equal width.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_hide_wpadmin() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->hide_wpadmin_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->hide_wpadmin_name(); ?>" <?php echo $this->options->hide_wpadmin() ? "checked" : ""; ?> />
                            <span class="description"><?php echo __('[Button will be hidden on \'wp-admin\'.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_hide_iframe() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->hide_iframe_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->hide_iframe_name(); ?>" <?php echo $this->options->hide_iframe() ? "checked" : ""; ?> />
                            <span class="description"><?php echo __('[Button will be hidden on iframes, usually inside popups.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_attach_on_shutdown() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->attach_on_shutdown_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->attach_on_shutdown_name(); ?>" <?php echo $this->options->attach_on_shutdown() ? 'checked' : ''; ?> />
                            <span class="description"><?php echo __('[Enable as a last resort if the button is not working. This could create compatibility issues.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_button_style() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->button_style_label(); ?>
                        </th>
                        <td>
                            <div>
                                <label><input type="radio" class="button-style" name="<?php echo $this->options->button_style_name(); ?>" value="image" <?php echo $this->options->button_style() == 'image' ? 'checked' : ''; ?> /> <?php echo __('Image', 'wpfront-scroll-top'); ?></label>
                                <br />
                                <label><input type="radio" class="button-style" name="<?php echo $this->options->button_style_name(); ?>" value="text" <?php echo $this->options->button_style() == 'text' ? 'checked' : ''; ?> /> <?php echo __('Text', 'wpfront-scroll-top'); ?></label>
                                <br />
                                <label><input type="radio" class="button-style" name="<?php echo $this->options->button_style_name(); ?>" value="font-awesome" <?php echo $this->options->button_style() == 'font-awesome' ? 'checked' : ''; ?> /> <?php echo __('Font Awesome', 'wpfront-scroll-top'); ?></label>
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function display_table_row_button_action() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->button_action_label(); ?>
                        </th>
                        <td>
                            <div class="button-action-container">
                                <label><input type="radio" class="button-action" name="<?php echo $this->options->button_action_name(); ?>" value="top" <?php echo $this->options->button_action() == 'top' ? 'checked' : ''; ?> /> <?php echo __('Scroll to Top', 'wpfront-scroll-top'); ?></label> <span class="description"><?php echo __('[Default action on WP-ADMIN pages.]', 'wpfront-scroll-top'); ?></span>
                                <br />
                                <label><input type="radio" class="button-action" name="<?php echo $this->options->button_action_name(); ?>" value="element" <?php echo $this->options->button_action() == 'element' ? 'checked' : ''; ?> /> <?php echo __('Scroll to Element', 'wpfront-scroll-top'); ?></label>
                                <div class="fields-container element hidden">
                                    <div>
                                        <span><input class="alignment-holder" type="radio"/></span>
                                        <span class="sub-label"><?php echo $this->options->button_action_element_selector_label() . ':&nbsp;'; ?></span>
                                        <span><input name="<?php echo $this->options->button_action_element_selector_name(); ?>" value="<?php echo esc_attr($this->options->button_action_element_selector()); ?>" /> <span class="description"><?php echo __('[CSS selector of the element, you are trying to scroll to. Ex: #myDivID, .myDivClass]', 'wpfront-scroll-top'); ?></span></span> 
                                    </div>
                                    <div>
                                        <span><input class="alignment-holder" type="radio"/></span>
                                        <span class="sub-label"><?php echo $this->options->button_action_container_selector_label() . ':&nbsp;'; ?></span>
                                        <span><input name="<?php echo $this->options->button_action_container_selector_name(); ?>" value="<?php echo esc_attr($this->options->button_action_container_selector()); ?>" /> <span class="description"><?php echo __('[CSS selector of the element, which has the scroll bar. "html, body" works in almost all cases.]', 'wpfront-scroll-top'); ?></span></span>
                                    </div>
                                    <div>
                                        <span><input class="alignment-holder" type="radio"/></span>
                                        <span class="sub-label"><?php echo $this->options->button_action_element_offset_label() . ':&nbsp;'; ?></span>
                                        <span><input class="pixels" name="<?php echo $this->options->button_action_element_offset_name(); ?>" value="<?php echo esc_attr($this->options->button_action_element_offset()); ?>" />px <span class="description"><?php echo __('[Negative value allowed. Use this filed to precisely set scroll position. Useful when you have overlapping elements.]', 'wpfront-scroll-top'); ?></span></span>
                                    </div>
                                    <div>
                                        <span><input class="alignment-holder" type="radio"/></span>
                                        <span class="sub-label"><a target="_blank" href="https://wpfront.com/wordpress-plugins/scroll-top-plugin/scroll-top-plugin-faq/"><?php echo __('How to find CSS selector?', 'wpfront-scroll-top'); ?></a></span>
                                    </div>
                                </div>
                                <br />
                                <label><input type="radio" class="button-action" name="<?php echo $this->options->button_action_name(); ?>" value="url" <?php echo $this->options->button_action() == 'url' ? 'checked' : ''; ?> /> <?php echo __('Link to Page', 'wpfront-scroll-top'); ?></label>
                                <div class="fields-container url hidden">
                                    <div>
                                        <span><input class="alignment-holder" type="radio"/></span>
                                        <span class="sub-label"><?php echo $this->options->button_action_page_url_label() . ':&nbsp;'; ?></span>
                                        <span class="url"><input class="url" name="<?php echo $this->options->button_action_page_url_name(); ?>" value="<?php echo esc_attr($this->options->button_action_page_url()); ?>" /></span> 
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function location_section() {
                    ?>
                    <h3><?php echo __('Location', 'wpfront-scroll-top'); ?></h3>
                    <table class="form-table">
                        <?php
                        $this->location_table_row_location();
                        $this->location_table_row_marginX();
                        $this->location_table_row_marginY();
                        ?>
                    </table>
                    <?php
                }

                protected function location_table_row_location() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->location_label(); ?>
                        </th>
                        <td>
                            <select name="<?php echo $this->options->location_name(); ?>">
                                <option value="1" <?php echo $this->options->location() == 1 ? 'selected' : ''; ?> ><?php echo __('Bottom Right', 'wpfront-scroll-top'); ?></option>
                                <option value="2" <?php echo $this->options->location() == 2 ? 'selected' : ''; ?> ><?php echo __('Bottom Left', 'wpfront-scroll-top'); ?></option>
                                <option value="3" <?php echo $this->options->location() == 3 ? 'selected' : ''; ?> ><?php echo __('Top Right', 'wpfront-scroll-top'); ?></option>
                                <option value="4" <?php echo $this->options->location() == 4 ? 'selected' : ''; ?> ><?php echo __('Top Left', 'wpfront-scroll-top'); ?></option>
                            </select> 
                        </td>
                    </tr>
                    <?php
                }

                protected function location_table_row_marginX() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->marginX_label(); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->marginX_name(); ?>" value="<?php echo esc_attr($this->options->marginX()); ?>" />px 
                            <span class="description"><?php echo __('[Negative value allowed.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>

                    <?php
                }

                protected function location_table_row_marginY() {
                    ?>
                    <tr>      
                        <th scope="row">
                            <?php echo $this->options->marginY_label(); ?>
                        </th>
                        <td>
                            <input class="pixels" name="<?php echo $this->options->marginY_name(); ?>" value="<?php echo esc_attr($this->options->marginY()); ?>" />px 
                            <span class="description"><?php echo __('[Negative value allowed.]', 'wpfront-scroll-top'); ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function filter_section() {
                    ?>
                    <h3><?php echo __('Filter', 'wpfront-scroll-top'); ?></h3>
                    <table class="form-table">
                        <?php
                        $this->filter_table_row_display_page();
                        ?>
                    </table>
                    <?php
                }

                protected function filter_table_row_display_page() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->display_pages_label(); ?>
                        </th>
                        <td>
                            <label>
                                <input type="radio" name="<?php echo $this->options->display_pages_name(); ?>" value="1" <?php echo $this->options->display_pages() == 1 ? 'checked' : ''; ?> />
                                <span><?php echo __('All pages.', 'wpfront-scroll-top'); ?></span>
                            </label>
                            <br />
                            <label>
                                <input type="radio" name="<?php echo $this->options->display_pages_name(); ?>" value="2" <?php echo $this->options->display_pages() == 2 ? 'checked' : ''; ?> />
                                <span><?php echo __('Include in following pages', 'wpfront-scroll-top'); ?></span>&#160;<span class="description"><?php echo __('[Use the textbox below to specify the post IDs as a comma separated list.]', 'wpfront-scroll-top'); ?></span>
                            </label>
                            <br />
                            <input class="post-id-list" name="<?php echo $this->options->include_pages_name(); ?>" value="<?php echo esc_attr($this->options->include_pages()); ?>" />
                            <div class="pages-selection">
                                <?php
                                $objects = $this->controller->get_filter_objects();
                                foreach ($objects as $key => $value) {
                                    ?>
                                    <div class="page-div">
                                        <label>
                                            <input type="checkbox" value="<?php echo $key; ?>" <?php echo $this->controller->filter_pages_contains($this->options->include_pages(), $key) === FALSE ? '' : 'checked'; ?> />
                                            <?php echo $value; ?>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <label>
                                <input type="radio" name="<?php echo $this->options->display_pages_name(); ?>" value="3" <?php echo $this->options->display_pages() == 3 ? 'checked' : ''; ?> />
                                <span><?php echo __('Exclude in following pages', 'wpfront-scroll-top'); ?></span>&#160;<span class="description"><?php echo __('[Use the textbox below to specify the post IDs as a comma separated list.]', 'wpfront-scroll-top'); ?></span>
                            </label>
                            <br />
                            <input class="post-id-list" name="<?php echo $this->options->exclude_pages_name(); ?>" value="<?php echo esc_attr($this->options->exclude_pages()); ?>" />
                            <div class="pages-selection">
                                <?php
                                $objects = $this->controller->get_filter_objects();
                                foreach ($objects as $key => $value) {
                                    ?>
                                    <div class="page-div">
                                        <label>
                                            <input type="checkbox" value="<?php echo $key; ?>" <?php echo $this->controller->filter_pages_contains($this->options->exclude_pages(), $key) === FALSE ? '' : 'checked'; ?> />
                                            <?php echo $value; ?>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function text_button_section() {
                    ?>
                    <h3 class="button-options text"><?php echo __('Text Button', 'wpfront-scroll-top'); ?></h3>
                    <table class="form-table button-options text">
                        <?php
                        $this->text_button_table_row_text();
                        $this->text_button_table_row_color();
                        $this->text_button_table_row_background_color();
                        $this->text_button_table_row_hower_color();
                        $this->text_button_table_row_css();
                        ?>
                    </table>
                    <?php
                }

                protected function text_button_table_row_text() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->text_button_text_label(); ?>
                        </th>
                        <td>
                            <input name="<?php echo $this->options->text_button_text_name(); ?>" value="<?php echo esc_attr($this->options->text_button_text()); ?>" />
                        </td>
                    </tr>
                    <?php
                }

                protected function text_button_table_row_color() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->text_button_text_color_label(); ?>
                        </th>
                        <td>
                            <div class="color-selector-div">
                                <div class="color-selector" id="color-selector[text_button_text_color]" color="<?php echo $this->options->text_button_text_color(); ?>"></div>&#160;
                                <input type="text" class="color-selector-input" name="<?php echo $this->options->text_button_text_color_name(); ?>" value="<?php echo esc_attr($this->options->text_button_text_color()); ?>" />
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function text_button_table_row_background_color() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->text_button_background_color_label(); ?>
                        </th>
                        <td>
                            <div class="color-selector-div">
                                <div class="color-selector" id="color-selector[text_button_background_color]" color="<?php echo $this->options->text_button_background_color(); ?>"></div>&#160;
                                <input type="text" class="color-selector-input" name="<?php echo $this->options->text_button_background_color_name(); ?>" value="<?php echo esc_attr($this->options->text_button_background_color()); ?>" />
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function text_button_table_row_hower_color() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->text_button_hover_color_label(); ?>
                        </th>
                        <td>
                            <div class="color-selector-div">
                                <div class="color-selector" id="color-selector[text_button_hover_color]" color="<?php echo $this->options->text_button_hover_color(); ?>"></div>&#160;
                                <input type="text" class="color-selector-input" name="<?php echo $this->options->text_button_hover_color_name(); ?>" value="<?php echo esc_attr($this->options->text_button_hover_color()); ?>" />
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function text_button_table_row_css() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->text_button_css_label(); ?>
                        </th>
                        <td>
                            <textarea name="<?php echo $this->options->text_button_css_name(); ?>" rows="5" cols="100"><?php echo esc_textarea($this->options->text_button_css()); ?></textarea>
                            <br />
                            <span class="description"><?php echo '[' . __('ex:', 'wpfront-scroll-top') . ' font-size: 1.5em; padding: 10px;]'; ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function font_awesome_button_section() {
                    ?>
                    <h3 class="button-options font-awesome"><?php echo __('Font Awesome Button', 'wpfront-scroll-top'); ?></h3>
                    <table class="form-table button-options font-awesome">
                        <?php
                        $this->fa_button_table_row_class();
                        $this->fa_button_display_row_url();
                        $this->fa_button_display_row_exclude_url();
                        $this->fa_button_display_row_text_color();
                        $this->fa_button_display_row_css();
                        ?>
                    </table>
                    <?php
                }

                protected function fa_button_table_row_class() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->fa_button_class_label(); ?>
                        </th>
                        <td>
                            <input class="regular-text" name="<?php echo $this->options->fa_button_class_name(); ?>" value="<?php echo esc_attr($this->options->fa_button_class()); ?>" />
                            <span class="description"><?php echo '[' . __('ex:', 'wpfront-scroll-top') . ' fa fa-arrow-circle-up fa-5x]'; ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function fa_button_display_row_url() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->fa_button_URL_label(); ?>
                        </th>
                        <td>
                            <input class="url" name="<?php echo $this->options->fa_button_URL_name(); ?>" value="<?php echo esc_attr($this->options->fa_button_URL()); ?>" />
                            <br />
                            <span class="description"><?php echo '[Leave blank to use BootstrapCDN URL by MaxCDN. Otherwise specify the URL you want to use.]'; ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function fa_button_display_row_exclude_url() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->fa_button_exclude_URL_label(); ?>
                        </th>
                        <td>
                            <input type="checkbox" name="<?php echo $this->options->fa_button_exclude_URL_name(); ?>" <?php echo $this->options->fa_button_exclude_URL() ? "checked" : ""; ?> />
                            <span class="description"><?php echo '[Enable this setting if your site already has Font Awesome. Usually your theme includes it.]'; ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function fa_button_display_row_text_color() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->fa_button_text_color_label(); ?>
                        </th>
                        <td>
                            <div class="color-selector-div">
                                <div class="color-selector" id="color-selector[fa_button_text_color]" color="<?php echo $this->options->fa_button_text_color(); ?>"></div>&#160;
                                <input type="text" class="color-selector-input" name="<?php echo $this->options->fa_button_text_color_name(); ?>" value="<?php echo esc_attr($this->options->fa_button_text_color()); ?>" />
                            </div>
                        </td>
                    </tr>
                    <?php
                }

                protected function fa_button_display_row_css() {
                    ?>
                    <tr>
                        <th scope="row">
                            <?php echo $this->options->fa_button_css_label(); ?>
                        </th>
                        <td>
                            <textarea name="<?php echo $this->options->fa_button_css_name(); ?>" rows="5" cols="100"><?php echo esc_textarea($this->options->fa_button_css()); ?></textarea>
                            <br />
                            <span class="description"><?php echo '[' . __('ex:', 'wpfront-scroll-top') . ' #wpfront-scroll-top-container i:hover{ color: #000000; }]'; ?></span>
                        </td>
                    </tr>
                    <?php
                }

                protected function image_button_section() {
                    ?>
                    <h3 class="button-options image"><?php echo __('Image Button', 'wpfront-scroll-top'); ?></h3>
                    <div class="button-options image">
                        <div class="icons-container">
                            <?php
                            $files = scandir($this->controller->get_icon_dir());
                            foreach ($files as $file) {
                                if ($file == '.' || $file == '..')
                                    continue;
                                echo '<div ' . ($this->options->image() == $file ? 'class="selected"' : '') . '>';
                                echo '<input id="' . $file . '" name="' . $this->options->image_name() . '" type="radio" value="' . $file . '" ' . ($this->options->image() == $file ? 'checked' : '') . ' />';
                                echo '<label for="' . $file . '"><img src="' . $this->controller->get_icon_url() . $file . '"/></label>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                        <div>
                            <input id="custom" name="<?php echo $this->options->image_name(); ?>" type="radio" value="custom" <?php echo ($this->options->image() == 'custom' ? 'checked' : ''); ?> />
                            <label for="custom"><?php echo __('Custom URL', 'wpfront-scroll-top'); ?>
                                <input id="custom-url-textbox" class="url" name="<?php echo $this->options->custom_url_name(); ?>" value="<?php echo esc_attr($this->options->custom_url()); ?>"/>
                                <input type="button" id="media-library-button" class="button" value="<?php echo __('Media Library', 'wpfront-scroll-top'); ?>" />
                            </label>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th scope="row">
                                    <?php echo $this->options->image_alt_label(); ?>
                                </th>
                                <td>
                                    <input id="alt-textbox" class="altText" name="<?php echo $this->options->image_alt_name(); ?>" value="<?php echo esc_attr($this->options->image_alt()); ?>" />
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php
                }

                protected function options_page_footer() {

                    $settingsLink = 'scroll-top-plugin-settings/';
                    $FAQLink = 'scroll-top-plugin-faq/';
                    submit_button();
                    ?>
                </form>
            </div>
        </div>
        <?php
        $this->settingsLink = $settingsLink;
        $this->FAQLink = $FAQLink;
        add_filter('admin_footer_text', array($this, 'admin_footer_text'));
    }

    public function admin_footer_text($text) {
        $settingsLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wpfront.com/' . $this->settingsLink, __('Settings Description', 'wpfront-scroll-top'));
        $reviewLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wordpress.org/support/plugin/' . WPFront_Scroll_Top::PLUGIN_SLUG . '/reviews/', __('Write a Review', 'wpfront-scroll-top'));
        $donateLink = sprintf('<a href="%s" target="_blank">%s</a>', 'https://wpfront.com/donate/', __('Buy me a Beer or Coffee', 'wpfront-scroll-top'));

        return sprintf('%s | %s | %s | %s', $settingsLink, $reviewLink, $donateLink, $text);
    }

    protected function script_section() {
        ?>
        <script type="text/javascript">
            (function () {
                init_wpfront_scroll_top_options({
                    button_style: '<?php echo $this->options->button_style(); ?>',
                    button_action: '<?php echo $this->options->button_action(); ?>',
                    label_choose_image: '<?php echo __('Choose Image', 'wpfront-scroll-top'); ?>',
                    label_select_image: '<?php echo __('Select Image', 'wpfront-scroll-top'); ?>'
                });
            })();
        </script>
        <?php
    }

}
