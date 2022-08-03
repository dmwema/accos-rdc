jQuery(document).ready(function ($) {

    /* If there are required actions, add an icon with the number of required actions in the About kt-theme-info page -> Actions recommended tab */
    var kt_theme_info_count_actions_recommended = kt_theme_info_object.count_actions_recommended;

    if ( (typeof kt_theme_info_count_actions_recommended !== 'undefined') && (kt_theme_info_count_actions_recommended != '0') ) {
        jQuery('li.kt-theme-info-w-red-tab a').append('<span class="kt-theme-info-actions-count">' + kt_theme_info_count_actions_recommended + '</span>');
    }

    /* Dismiss required actions */
    jQuery(".kt-theme-info-recommended-action-button,.reset-all").click(function() {

        var id = jQuery(this).attr('id'),
            action = jQuery(this).attr('data-action');

        jQuery.ajax({
            type      : "GET",
            data      : {
                action: 'kt_theme_info_update_recommended_action',
                id: id,
                todo: action
            },
            dataType  : "html",
            url       : kt_theme_info_object.ajaxurl,
            beforeSend: function (data, settings) {
                jQuery('.kt-theme-info-tab-pane#actions_required h1').append('<div id="temp_load" style="text-align:center"><img src="' + kt_theme_info_object.template_directory + '../loader.gif" /></div>');
            },
            success   : function (data) {
                location.reload();
                jQuery("#temp_load").remove();
                /* Remove loading gif */
            },
            error     : function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
            }
        });
    });

    /*faq*/
    jQuery(".faq .faq-title").click(function(e) {

        //Close all <div> but the <div> right after the clicked <a>
        $(e.target).next('div').siblings('div').slideUp();

        //Toggle open/close on the <div> after the <h3>, opening it if not open.
        $(e.target).next('div').slideToggle();
    });

});