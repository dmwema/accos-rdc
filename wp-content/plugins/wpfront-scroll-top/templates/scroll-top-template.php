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
 * Template for WPFront Scroll Top
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
class WPFront_Scroll_Top_Template {

    protected $controller;
    protected $options;

    public function write_markup($controller) {
        $this->controller = $controller;
        $this->options = $controller->get_options();

        $this->hide_small_window();
        $this->hide_small_device();
        $this->button_style_css();
        $this->button_script_section();
    }

    public function hide_small_window() {
        if ($this->options->hide_small_window()) {
            ?>
            <style type="text/css">
                @media screen and (max-width: <?php echo $this->options->small_window_width() . "px"; ?>) {
                    #wpfront-scroll-top-container {
                        visibility: hidden;
                    }
                }
            </style>
            <?php
        }
    }

    public function hide_small_device() {
        if ($this->options->hide_small_device()) {
            ?>
            <style type="text/css">
                @media screen and (max-device-width: <?php echo $this->options->small_device_width() . "px"; ?>) {
                    #wpfront-scroll-top-container {
                        visibility: hidden;
                    }
                }
            </style>
            <?php
        }
    }

    public function button_style_css() {
        switch ($this->options->button_style()) {
            case 'text':
                $this->button_style_css_text();
                break;

            case 'font-awesome':
                $this->button_style_css_font_awesome();
                break;

            default:
                $this->button_style_css_image();
                break;
        }
    }

    public function button_style_css_text() {
        ?>
        <div id="wpfront-scroll-top-container">
            <?php
            $html = sprintf('<div class="text-holder">%s</div>', esc_html($this->options->text_button_text()));
            $html = $this->controller->apply_button_action_html($html);
            echo $html;
            ?>
        </div>

        <style type="text/css">
            #wpfront-scroll-top-container div.text-holder {
                color: <?php echo $this->options->text_button_text_color(); ?>;
                background-color: <?php echo $this->options->text_button_background_color(); ?>;
                width: <?php echo $this->options->button_width() == 0 ? 'auto' : $this->options->button_width() . 'px'; ?>;
                height: <?php echo $this->options->button_height() == 0 ? 'auto' : $this->options->button_height() . 'px'; ?>;

                <?php echo wp_strip_all_tags($this->options->text_button_css(), true); ?>
            }

            #wpfront-scroll-top-container div.text-holder:hover {
                background-color: <?php echo $this->options->text_button_hover_color(); ?>;
            }
        </style>
        <?php
    }

    public function button_style_css_font_awesome() {
        ?>
        <div id="wpfront-scroll-top-container">
            <?php
            $html = sprintf('<i class="%s"></i>', esc_attr($this->options->fa_button_class()));
            $html = $this->controller->apply_button_action_html($html);
            echo $html;
            ?>
        </div>

        <style type="text/css">
            #wpfront-scroll-top-container i {
                color: <?php echo $this->options->fa_button_text_color(); ?>;
            }

            <?php echo wp_strip_all_tags($this->options->fa_button_css(), true); ?>
        </style>
        <?php
    }

    public function button_style_css_image() {
        ?>
        <div id="wpfront-scroll-top-container">
            <?php
            $html = sprintf('<img src="%s" alt="%s" />', esc_attr($this->controller->image()), esc_attr($this->options->image_alt()));
            $html = $this->controller->apply_button_action_html($html);
            echo $html;
            ?>
        </div>
        <?php
    }

    private function button_script_section() {

        $json = json_encode(array(
            'scroll_offset' => $this->options->scroll_offset(),
            'button_width' => $this->options->button_width(),
            'button_height' => $this->options->button_height(),
            'button_opacity' => $this->options->button_opacity() / 100,
            'button_fade_duration' => $this->options->button_fade_duration(),
            'scroll_duration' => $this->options->scroll_duration(),
            'location' => $this->options->location(),
            'marginX' => $this->options->marginX(),
            'marginY' => $this->options->marginY(),
            'hide_iframe' => $this->options->hide_iframe(),
            'auto_hide' => $this->options->auto_hide(),
            'auto_hide_after' => $this->options->auto_hide_after(),
            'button_action' => $this->options->button_action(),
            'button_action_element_selector' => $this->options->button_action_element_selector(),
            'button_action_container_selector' => $this->options->button_action_container_selector(),
            'button_action_element_offset' => $this->options->button_action_element_offset()
        ));
        ?>
        <script type="text/javascript">
            function wpfront_scroll_top_init() {
                if (typeof wpfront_scroll_top === "function" && typeof jQuery !== "undefined") {
                    wpfront_scroll_top(<?php echo $json; ?>);
                } else {
                    setTimeout(wpfront_scroll_top_init, 100);
                }
            }
            wpfront_scroll_top_init();
        </script>
        <?php
    }

}
