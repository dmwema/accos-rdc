//Load Image on Widget
jQuery( document ).ready( function($) {
     function media_upload( button_class ) {
        var _custom_media = false,
        _orig_send_attachment = wp.media.editor.send.attachment;
        $( 'body' ).on( 'click', button_class, function(e) {
            var button_id ='#'+$( this ).attr( 'id' );
            var self = $( button_id );
            var send_attachment_bkp = wp.media.editor.send.attachment;
            var button = $( button_id );
            var id = button.attr( 'id' ).replace( '_button', '' );
            _custom_media = true;
            wp.media.editor.send.attachment = function( props, attachment ){
                if ( _custom_media  ) {
                    $( '.custom_media_id' ).val( attachment.id );
                    $( '.custom_media_url' ).val( attachment.url );
                    $( '.custom_media_image' ).attr( 'src', attachment.url ).css( 'display','block' );
                } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                }
            }
            wp.media.editor.open( button );
                return false;
        });
     }

     media_upload( '.custom_media_button' );

    $( '.bosa-install-plugins' ).click( function (e) {
        e.preventDefault();

        $( this ).addClass( 'updating-message' );
        $( this ).text( bosa_adi_install.btn_text );

        $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action     : 'bosa_getting_started',
                security : bosa_adi_install.nonce,
                slug : 'elementor',
                request : 1
            },
            success:function( response ) {
                setTimeout( function(){
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: {
                            action     : 'bosa_getting_started',
                            security : bosa_adi_install.nonce,
                            slug : 'advanced-import',
                            request : 2
                        },
                        success:function( response ) {
                            setTimeout( function(){
                                $.ajax({
                                    type: "POST",
                                    url: ajaxurl,
                                    data: {
                                        action     : 'bosa_getting_started',
                                        security : bosa_adi_install.nonce,
                                        slug : 'keon-toolset',
                                        request : 3
                                    },
                                    success:function( response ) {
                                        setTimeout( function(){
                                            $.ajax({
                                                type: "POST",
                                                url: ajaxurl,
                                                data: {
                                                    action     : 'bosa_getting_started',
                                                    security : bosa_adi_install.nonce,
                                                    slug : 'kirki',
                                                    request : 4
                                                },
                                                success:function( response ) {
                                                    setTimeout( function(){
                                                        $.ajax({
                                                            type: "POST",
                                                            url: ajaxurl,
                                                            data: {
                                                                action     : 'bosa_getting_started',
                                                                security : bosa_adi_install.nonce,
                                                                slug : 'breadcrumb-navxt',
                                                                request : 5
                                                            },
                                                            success:function( response ) {
                                                                setTimeout( function(){
                                                                    $.ajax({
                                                                        type: "POST",
                                                                        url: ajaxurl,
                                                                        data: {
                                                                            action     : 'bosa_getting_started',
                                                                            security : bosa_adi_install.nonce,
                                                                            slug : 'sina-extension-for-elementor',
                                                                            request : 6
                                                                        },
                                                                        success:function( response ) {
                                                                            setTimeout( function(){
                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: ajaxurl,
                                                                                    data: {
                                                                                        action     : 'bosa_getting_started',
                                                                                        security : bosa_adi_install.nonce,
                                                                                        slug : 'contact-form-7',
                                                                                        main_file : 'wp-contact-form-7',
                                                                                        request : 7
                                                                                    },
                                                                                    success:function( response ) {
                                                                                        var extra_uri, redirect_uri, dismiss_nonce;
                                                                                        redirect_uri         = bosa_adi_install.adminurl+'/themes.php?page=advanced-import&browse=all';
                                                                                        window.location.href = redirect_uri;
                                                                                    },
                                                                                    error: function( xhr, ajaxOptions, thrownError ){
                                                                                        console.log( thrownError );
                                                                                    }
                                                                                });
                                                                            }, 500);
                                                                        },
                                                                        error: function( xhr, ajaxOptions, thrownError ){
                                                                            console.log( thrownError );
                                                                        }
                                                                    });
                                                                }, 500);
                                                            },
                                                            error: function( xhr, ajaxOptions, thrownError ){
                                                                console.log( thrownError );
                                                            }
                                                        });
                                                    }, 500);
                                                },
                                                error: function( xhr, ajaxOptions, thrownError ){
                                                    console.log( thrownError );
                                                }
                                            });
                                        }, 500);
                                    },

                                    error: function( xhr, ajaxOptions, thrownError ){
                                        console.log( thrownError );
                                    }
                                });
                            }, 500);
                         },

                        error: function( xhr, ajaxOptions, thrownError ){
                            console.log( thrownError );
                        }
                    });
                }, 500);
            },
            error: function( xhr, ajaxOptions, thrownError ){
                console.log( thrownError );
            }
        });
    } );

});

