/**
 * Getting Started if advance import is not installed or activated
 */
jQuery( document ).ready( function ( $ ) {

	$( '.ads-gsm-btn' ).click( function ( e ) {
		e.preventDefault();

		// Show updating gif icon.
        $( this ).addClass( 'updating-message' );

		// Change button text.
        $( this ).text( keon_toolset.btn_text );

		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
                action     : 'keon_toolset_getting_started',
                security : keon_toolset.nonce
            },
			success:function( response ) {
                var redirect_uri;

				redirect_uri         = response.data.redirect;
                window.location.href = redirect_uri;
			},
			error: function( xhr, ajaxOptions, thrownError ){
				console.log(thrownError);
			}
		});
	} );
} );
