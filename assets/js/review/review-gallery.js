// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function popupNext( event )
	{
		let gallery = document.getElementById( event.currentTarget.dataset.gallery );

		let next = event.currentTarget.dataset.next;

		if( typeof next !== 'undefined' ) {
			let figure = gallery.querySelector( 'figure[data-id="' + event.currentTarget.dataset.next + '"]' );

			figure.click();
		}
	}

	function popupRemove( event )
	{
		if ( event.target === this ) {
			event.currentTarget.remove();
		}
	}

	function popup( event )
    {
		let content = document.querySelector( '.tcb-post-content' );

		if ( content.querySelector( '.legal-gallery' ) === null ) {
			let popup = document.createElement( 'div' );
		
			popup.classList.add( 'legal-gallery' );

			popup.addEventListener( 'click', popupRemove, false );

			let left = document.createElement( 'div' );
			
			left.classList.add( 'legal-left' );

			left.addEventListener( 'click', popupNext, false );

			popup.appendChild( left );

			let right = document.createElement( 'div' );
			
			right.classList.add( 'legal-right' );

			right.addEventListener( 'click', popupNext, false );

			popup.appendChild( right );

			content.appendChild( popup );
		}
	}

	async function loadImage( url, elem ) {
		return new Promise( ( resolve, reject ) => {
			elem.onload = () => resolve( elem );

			elem.onerror = reject;

			elem.style.backgroundImage = `url( ${ url } )`;
		} );
	}

	async function popupUpdate( event )
	{
		let figure = event.currentTarget;

		let content = document.querySelector( '.tcb-post-content' );
		
		let popup = content.querySelector( '.legal-gallery' );

		let url = parse_srcset( figure.querySelector( 'img' ).getAttribute( 'srcset' ) );
		
		// popup.style.backgroundImage = `url( ${ url } )`; 

		console.log( 'review-gallery loadImage url: ' + url );

		await loadImage( url, popup );

		let left = popup.querySelector( '.legal-left' );

		left.dataset.gallery = figure.dataset.gallery;

		if ( figure.previousSibling !== null ) {
			left.dataset.next = figure.previousSibling.dataset.id;
		}

		let right = popup.querySelector( '.legal-right' );

		right.dataset.gallery = figure.dataset.gallery;

		let dataset = figure.nextSibling.dataset;
		
		if ( typeof dataset !== 'undefined' ) {
			right.dataset.next = figure.nextSibling.dataset.id;
		}
	}

	function parse_srcset( srcset )
    {
		return srcset.split( ',' )[ 0 ].split( ' ' )[0];
	}

	document.querySelectorAll( '.tcb-post-content > .gallery' ).forEach( function ( gallery ) {
		gallery.querySelectorAll( 'figure' ).forEach( function ( figure, index ) {
			figure.dataset.gallery = gallery.id;

			figure.dataset.id = index;

			figure.addEventListener( 'click', popup, false );

			figure.addEventListener( 'click', popupUpdate, false );
		} );
	} );

} );

// review-gallery-js end