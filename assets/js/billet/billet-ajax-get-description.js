let MCAjaxBilletActions = ( function()
{
	"use strict";

    return {
        ajaxGetDescription: function ( data )
		{
			const xhttp = new XMLHttpRequest();

			let id = data.id;

			let billetId = data.billetId;

			xhttp.onload = function() {
				// document.getElementById( "demo" ).innerHTML = this.responseText;

				let parsed = JSON.parse( this.responseText );

				console.log( parsed );

				console.log( id );

				document.querySelector( '.billet-footer' ).innerHTML = parsed.description;
			}

			// xhttp.open( "GET", MCAjax.ajax_url, true );
			
			// xhttp.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=2484975", true );
			
			xhttp.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=" + billetId, true );

			// xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
			
			// xhttp.send( "action=mc_ajax_get_description&post_id=2484975" );

			xhttp.send();
		}
    }
} )();

function getDescription( event )
{
	MCAjaxBilletActions.ajaxGetDescription( {
		id : event.currentTarget.dataset.id,

		billetId : event.currentTarget.dataset.billetId,
	} );
}

function prepareBillet( billet )
{
	

	console.log( billetId );

	let showTnCButton = billet.querySelector( selectors.showTnCButton );

	if ( showTnCButton != null )
	{
		showTnCButton.dataset.id = billet.id;

		let billetId = billet.id.replace( 'billet-', '' );
		
		showTnCButton.dataset.billetId = billetId;

		showTnCButton.addEventListener( 'click', getDescription, { once: true } );
	}
}
document.addEventListener( 'DOMContentLoaded', function ()
{

	const selectors = {
		billet: '.billet',

		showTnCButton: '.billet-footer-control',
	};

	document.querySelectorAll( selectors.billet ).forEach( prepareBillet );

	MCAjaxBilletActions.ajaxGetDescription( {} );

	console.log( 'DOMContentLoaded' );
} );