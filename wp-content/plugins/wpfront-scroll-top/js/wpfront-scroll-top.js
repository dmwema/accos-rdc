/*
 WPFront Scroll Top Plugin
 Copyright (C) 2013, WPFront.com
 Website: wpfront.com
 Contact: syam@wpfront.com
 
 WPFront Scroll Top Plugin is distributed under the GNU General Public License, Version 3,
 June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
 St, Fifth Floor, Boston, MA 02110, USA
 
 */

(function () {
    window.wpfront_scroll_top = function (data) {
        var $ = jQuery;
        
        var container = $("#wpfront-scroll-top-container").css("opacity", 0);

        var css = {};
        switch (data.location) {
            case 1:
                css["right"] = data.marginX + "px";
                css["bottom"] = data.marginY + "px";
                break;
            case 2:
                css["left"] = data.marginX + "px";
                css["bottom"] = data.marginY + "px";
                break;
            case 3:
                css["right"] = data.marginX + "px";
                css["top"] = data.marginY + "px";
                break;
            case 4:
                css["left"] = data.marginX + "px";
                css["top"] = data.marginY + "px";
                break;
        }
        container.css(css);

        if (data.button_width == 0)
            data.button_width = "auto";
        else
            data.button_width += "px";
        if (data.button_height == 0)
            data.button_height = "auto";
        else
            data.button_height += "px";
        container.children("img").css({"width": data.button_width, "height": data.button_height});

        if (data.hide_iframe) {
            if ($(window).attr("self") !== $(window).attr("top"))
                return;
        }

        var mouse_over = false;
        var hideEventID = 0;

        var fnHide = function () {
            clearTimeout(hideEventID);
            if (container.is(":visible")) {
                container.stop().fadeTo(data.button_fade_duration, 0, function () {
                    container.hide();
                    mouse_over = false;
                });
            }
        };

        var fnHideEvent = function () {
            if(!data.auto_hide)
                return;

            clearTimeout(hideEventID);
            hideEventID = setTimeout(function () {
                fnHide();
            }, data.auto_hide_after * 1000);
        };

        var scrollHandled = false;
        var fnScroll = function () {
            if (scrollHandled)
                return;

            scrollHandled = true;

            if ($(window).scrollTop() > data.scroll_offset) {
                container.stop().css("opacity", mouse_over ? 1 : data.button_opacity).show();
                if (!mouse_over) {
                    fnHideEvent();
                }
            } else {
                fnHide();
            }

            scrollHandled = false;
        };

        $(window).on('scroll', fnScroll);
        $(document).on('scroll', fnScroll);

        container
                .on('mouseenter', function() {
                    clearTimeout(hideEventID);
                    mouse_over = true;
                    $(this).css("opacity", 1);
                }).on('mouseleave', function() {
                    $(this).css("opacity", data.button_opacity);
                    mouse_over = false;
                    fnHideEvent();
                }).on('click', function(e) {
                    if(data.button_action === "url") {
                        return true;
                    } else if(data.button_action === "element") {
                        e.preventDefault();

                        var element = $(data.button_action_element_selector).first();
                        var container = $(data.button_action_container_selector);

                        var offset = element.offset();
                        if(offset == null)
                            return false;

                        var contOffset = container.last().offset();
                        if(contOffset == null)
                            return false;

                        data.button_action_element_offset = parseInt(data.button_action_element_offset);
                        if(isNaN(data.button_action_element_offset))
                            data.button_action_element_offset = 0;

                        var top = offset.top - contOffset.top - data.button_action_element_offset;

                        container.animate({scrollTop: top}, data.scroll_duration);

                        return false;
                    }

                    e.preventDefault();
                    $("html, body").animate({scrollTop: 0}, data.scroll_duration);
                    return false;
                });
    };
})();
