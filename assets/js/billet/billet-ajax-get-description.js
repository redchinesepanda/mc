let MCAjaxBilletActions = ( function()
{
	"use strict";

    return {
        ajaxGetDescription: function ( data )
		{
			const xhr = new XMLHttpRequest();

			let id = data.id;

			let billetId = data.billetId;

			// xhttp.onload = function()
			
			xhr.onreadystatechange = function()
			{
				if ( xhr.readyState === xhr.DONE && xhr.status === 200 )
				{
					try
					{
						let parsed = JSON.parse( this.responseText );

						let billetFooter = document.querySelector( '#' + id + ' ~ .billet-footer' );
		
						if ( billetFooter != null )
						{
							billetFooter.innerHTML = parsed.description;
						}
					}
					catch ( error )
					{
						console.error( error );
					}
				}
			}

			// xhr.open( "GET", MCAjax.ajax_url + "?action=mc_ajax_get_description&post_id=" + billetId, true );

			// xhr.send();
			
			xhr.open( "POST", MCAjax.ajax_url );

			xhr.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
			
			xhr.send( "action=" + MCAjaxBillet.actionGetDescription + "&post_id=" + billetId + "&_ajax_nonce=" + MCAjaxBillet.nonce );
		}
    }
} )();
document.addEventListener( 'DOMContentLoaded', function ()
{
	function getDescription( event )
	{
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
	};

	document.querySelectorAll( selectors.billet ).forEach( prepareBillet );
} );