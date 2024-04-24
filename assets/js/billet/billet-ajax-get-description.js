let MCAjaxBilletActions = ( function()
{
	"use strict";

    return {
        ajaxGetDescription: function ( data )
		{
			const xhttp = new XMLHttpRequest();

			let id = data.id;

			let billetId = data.billetId;

			xhttp.onload = function()
			{
				// document.getElementById( "demo" ).innerHTML = this.responseText;

				let parsed = JSON.parse( this.responseText );

				// console.log( 'onload' );

				// console.log( parsed );

				// console.log( id );

				console.log( '#' + id + ' .billet-footer' );

				document.querySelector( '#' + id + ' ~ .billet-footer' ).innerHTML = parsed.description;

				// document.getElementById( id ).innerHTML = parsed.description;
			}

			// xhttp.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=" + billetId, true );
			
			xhttp.open( "POST", MCAjax.ajax_url );

			xhttp.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
			
			xhttp.send( "action=" + MCAjaxBillet.actionGetDescription + "&post_id=" + billetId + "nonce=" + MCAjaxBillet.nonce );

			xhttp.send();
		}
    }
} )();
document.addEventListener( 'DOMContentLoaded', function ()
{
	function getDescription( event )
	{
		console.log( 'getDescription' );

		MCAjaxBilletActions.ajaxGetDescription( {
			id : event.currentTarget.dataset.id,
	
			billetId : event.currentTarget.dataset.billetId,
		} );
	}
	
	function prepareBillet( billet )
	{
		let showTnCButton = billet.querySelector( selectors.showTnCButton );
	
		if ( showTnCButton != null )
		{
			showTnCButton.dataset.id = billet.id;
	
			let billetId = billet.id.replace( 'billet-', '' );
			
			showTnCButton.dataset.billetId = billetId;
	
			showTnCButton.addEventListener( 'click', getDescription, { once: true } );
		}
	}

	const selectors = {
		billet: '.billet',

		showTnCButton: '.billet-footer-control'

		// billetFooter: function ( id ) {
		// 	return '#' + id + ' .billet-footer';
		// }
	};

	document.querySelectorAll( selectors.billet ).forEach( prepareBillet );

	// MCAjaxBilletActions.ajaxGetDescription( {} );

	// console.log( 'DOMContentLoaded' );
} );