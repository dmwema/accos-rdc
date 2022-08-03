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

require_once("base/class-wpfront-options-base.php");

/**
 * Options class for WPFront Scroll Top plugin
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
class WPFront_Scroll_Top_Options extends WPFront_Options_Base_ST {

    function __construct($optionName, $pluginSlug) {
        parent::__construct($optionName, $pluginSlug);

        //add the options required for this plugin
        $this->addOption('enabled', 'bit', FALSE)->label(__('Enabled', 'wpfront-scroll-top'));
        $this->addOption('javascript_async', 'bit', FALSE)->label(__('JavaScript Async', 'wpfront-scroll-top'));
        $this->addOption('scroll_offset', 'int', 100, array($this, 'validate_zero_positive'))->label(__('Scroll Offset', 'wpfront-scroll-top'));
        $this->addOption('button_width', 'int', 0, array($this, 'validate_zero_positive'));
        $this->addOption('button_height', 'int', 0, array($this, 'validate_zero_positive'));
        $this->addOption('button_opacity', 'int', 80, array($this, 'validate_range_0_100'))->label(__('Button Opacity', 'wpfront-scroll-top'));
        $this->addOption('button_fade_duration', 'int', 200, array($this, 'validate_zero_positive'))->label(__('Button Fade Duration', 'wpfront-scroll-top'));
        $this->addOption('scroll_duration', 'int', 400, array($this, 'validate_zero_positive'))->label(__('Scroll Duration', 'wpfront-scroll-top'));
        $this->addOption('auto_hide', 'bit', FALSE)->label(__('Auto Hide', 'wpfront-scroll-top'));
        $this->addOption('auto_hide_after', 'float', 2, array($this, 'validate_zero_positive'))->label(__('Auto Hide After', 'wpfront-scroll-top'));
        $this->addOption('hide_small_device', 'bit', FALSE)->label(__('Hide on Small Devices', 'wpfront-scroll-top'));
        $this->addOption('small_device_width', 'int', 640, array($this, 'validate_zero_positive'))->label(__('Small Device Max Width', 'wpfront-scroll-top'));
        $this->addOption('hide_small_window', 'bit', FALSE)->label(__('Hide on Small Window', 'wpfront-scroll-top'));
        $this->addOption('small_window_width', 'int', 640, array($this, 'validate_zero_positive'))->label(__('Small Window Max Width', 'wpfront-scroll-top'));
        $this->addOption('button_style', 'string', 'image', array($this, 'validate_button_style'))->label(__('Button Style', 'wpfront-scroll-top'));
        $this->addOption('image_alt', 'string', '')->label(__('Image ALT', 'wpfront-scroll-top'));
        $this->addOption('hide_wpadmin', 'bit', FALSE)->label(__('Hide on WP-ADMIN', 'wpfront-scroll-top'));
        $this->addOption('hide_iframe', 'bit', FALSE)->label(__('Hide on iframes', 'wpfront-scroll-top'));

        $this->addOption('button_action', 'string', 'top', array($this, 'validate_button_action'))->label(__('Button Action', 'wpfront-scroll-top'));
        $this->addOption('button_action_page_url', 'string', '', array($this, 'validate_page_url'))->label(__('Page URL', 'wpfront-scroll-top'));
        $this->addOption('button_action_element_selector', 'string', '')->label(__('Element CSS Selector', 'wpfront-scroll-top'));
        $this->addOption('button_action_container_selector', 'string', 'html, body', array($this, 'button_action_container_selector'))->label(__('Scroll Container CSS Selector', 'wpfront-scroll-top'));
        $this->addOption('button_action_element_offset', 'int', 0)->label(__('Offset', 'wpfront-scroll-top'));

        $this->addOption('location', 'int', 1, array($this, 'validate_range_1_4'))->label(__('Location', 'wpfront-scroll-top'));
        $this->addOption('marginX', 'int', 20)->label(__('Margin X', 'wpfront-scroll-top'));
        $this->addOption('marginY', 'int', 20)->label(__('Margin Y', 'wpfront-scroll-top'));

        $this->addOption('text_button_text', 'string', '')->label(__('Text', 'wpfront-scroll-top'));
        $this->addOption('text_button_text_color', 'string', '#ffffff', array($this, 'validate_color'))->label(__('Text Color', 'wpfront-scroll-top'));
        $this->addOption('text_button_background_color', 'string', '#000000', array($this, 'validate_color'))->label(__('Background Color', 'wpfront-scroll-top'));
        $this->addOption('text_button_hover_color', 'string', '#000000', array($this, 'validate_color'))->label(__('Mouse Over Color', 'wpfront-scroll-top'));
        $this->addOption('text_button_css', 'string', '')->label(__('Custom CSS', 'wpfront-scroll-top'));

        $this->addOption('fa_button_class', 'string', '')->label(__('Icon Class', 'wpfront-scroll-top'));
        $this->addOption('fa_button_URL', 'string', '', array($this, 'validate_font_awesome_url'))->label(__('Font Awesome URL', 'wpfront-scroll-top'));
        $this->addOption('fa_button_exclude_URL', 'bit', FALSE)->label(__('Do not include URL', 'wpfront-scroll-top'));
        $this->addOption('fa_button_text_color', 'string', '#000000', array($this, 'validate_color'))->label(__('Icon Color', 'wpfront-scroll-top'));
        $this->addOption('fa_button_css', 'string', '')->label(__('Custom CSS', 'wpfront-scroll-top'));

        $this->addOption('display_pages', 'int', '1', array($this, 'validate_display_pages'))->label(__('Display on Pages', 'wpfront-scroll-top'));
        $this->addOption('include_pages', 'string', '');
        $this->addOption('exclude_pages', 'string', '');

        $this->addOption('image', 'string', '1.png');
        $this->addOption('custom_url', 'string', '', array($this, 'validate_custom_url'));

        $this->addOption('attach_on_shutdown', 'bit', false)->label(__('Attach on Shutdown', 'wpfront-scroll-top'));
    }

    public function text_button_hover_color() {
        $color = parent::text_button_hover_color();
        if (empty($color))
            return $this->text_button_background_color();

        return $color;
    }

    public function include_pages() {
        $pages = parent::include_pages();

        if (strpos($pages, '.') === FALSE)
            return $pages;

        $pages = explode(',', $pages);

        for ($i = 0; $i < count($pages); $i++) {
            $e = explode('.', $pages[$i]);
            $pages[$i] = $e[1];
        }

        return implode(',', $pages);
    }

    public function exclude_pages() {
        $pages = parent::exclude_pages();

        if (strpos($pages, '.') === FALSE)
            return $pages;

        $pages = explode(',', $pages);

        for ($i = 0; $i < count($pages); $i++) {
            $e = explode('.', $pages[$i]);
            $pages[$i] = $e[1];
        }

        return implode(',', $pages);
    }

    protected function validate_range_0_100($arg) {
        if ($arg < 0)
            return 0;

        if ($arg > 100)
            return 100;

        return $arg;
    }

    protected function validate_range_1_4($arg) {
        if ($arg < 1)
            return 1;

        if ($arg > 4)
            return 4;

        return $arg;
    }

    protected function validate_button_style($arg) {
        if ($arg == 'text' || $arg == 'font-awesome')
            return $arg;

        return 'image';
    }

    protected function validate_button_action($arg) {
        if ($arg == 'element' || $arg == 'url')
            return $arg;

        return 'top';
    }

    protected function validate_color($arg) {
        $arg = sanitize_hex_color($arg);

        if (empty($arg)) {
            return '#ffffff';
        }
        return $arg;
    }

    protected function validate_display_pages($arg) {
        if ($arg < 1) {
            return 1;
        }

        if ($arg > 3) {
            return 3;
        }

        return $arg;
    }

    protected function button_action_container_selector($args) {
        if (trim($args) === "")
            return "html, body";

        return $args;
    }

    protected function validate_page_url($arg) {
        return esc_url_raw($arg);
    }

    protected function validate_font_awesome_url($arg) {
        return esc_url_raw($arg);
    }

    protected function validate_custom_url($arg) {
        return esc_url_raw($arg);
    }

}
