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

				document.querySelector( '.billet-footer' ).innerHTML = parsed.description;
			}

			// xhttp.open( "GET", MCAjax.ajax_url, true );
			
			xhttp.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=2484975", true );

			// xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
			
			// xhttp.send( "action=mc_ajax_get_description&post_id=2484975" );

			xhttp.send();
		}
    }
} )();

function prepareBillet( element )
{
	let id = element.id.replace( 'billet-', '' );

	console.log( id );
}
document.addEventListener( 'DOMContentLoaded', function ()
{

	const selectors = {
		billet: '.billet',

		showTnCButton: '.billet-footer-control',
	};

	document.querySelectorAll( selectors.aboutAchievement ).forEach( prepareBillet );

	MCAjaxBilletActions.ajaxGetDescription( {} );

	console.log( 'DOMContentLoaded' );
} );