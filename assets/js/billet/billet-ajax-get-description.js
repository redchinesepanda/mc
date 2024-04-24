let MCAjaxBilletActions = ( function()
{
	"use strict";

    return {
        ajaxGetDescription: function ( data )
		{
			const xhttp = new XMLHttpRequest();

			xhttp.onload = function() {
				// document.getElementById( "demo" ).innerHTML = this.responseText;

				let parsed = JSON.parse( this.responseText );

				console.log( parsed );

				// document.querySelector( '.billet-footer' ).innerHTML = this.responseText;
			}

			// xhttp.open( "GET", MCAjax.ajax_url, true );
			
			xhttp.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=2484975", true );

			// xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
			
			// xhttp.send( "action=mc_ajax_get_description&post_id=2484975" );

			xhttp.send();
		}
    }
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	MCAjaxBilletActions.ajaxGetDescription( {} );

	console.log( 'DOMContentLoaded' );
} );