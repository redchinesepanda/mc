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

				console.log( 'onload' );

				console.log( parsed );

				console.log( id );

				console.log( selectors.billetFooter( id ) );

				document.querySelector( '#' + id + ' .billet-footer' ).innerHTML = parsed.description;

				// document.getElementById( id ).innerHTML = parsed.description;
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

		showTnCButton: '.billet-footer-control',

		billetFooter: function ( id ) {
			return '#' + id + ' .billet-footer';
		}
	};

	document.querySelectorAll( selectors.billet ).forEach( prepareBillet );

	// MCAjaxBilletActions.ajaxGetDescription( {} );

	console.log( 'DOMContentLoaded' );
} );