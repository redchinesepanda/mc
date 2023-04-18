// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function popupNext( event )
	{
		// console.log( 'review-gallery classList:' +  event.currentTarget.classList );
		let gallery = document.getElementById( event.currentTarget.dataset.galleryID );

		let figure = gallery.querySelector( '[data-id="' + event.currentTarget.dataset.id + '"]' );

		figure.click();
	}

	function popupRemove( event )
	{
		// console.log( 'review-gallery event.target.classList:' +  event.target.classList );

		// console.log( 'review-gallery event.currentTarget.classList:' +  event.currentTarget.classList );

		if ( event.target === this ) {
			event.currentTarget.remove();
		}
	}

	function popup( galleryID )
    {
		if ( document.getElementById( galleryID ).querySelector( '.legal-gallery' ) === null ) {
			let popup = document.createElement( 'div' );
		
			popup.classList.add( 'legal-gallery' );

			// lightroom.style.backgroundImage = "url( '" + parse_srcset( event.currentTarget.getAttribute( 'srcset' ) ) + "' )"; 

			popup.addEventListener( 'click', popupRemove, false );

			let left = document.createElement( 'div' );
			
			left.classList.add( 'legal-left' );

			left.addEventListener( 'click', popupNext, false );

			popup.appendChild( left );

			let right = document.createElement( 'div' );
			
			right.classList.add( 'legal-right' );

			right.addEventListener( 'click', popupNext, false );

			popup.appendChild( right );

			document.getElementById( galleryID ).appendChild( popup );
		}
	}

	function popupUpdate( event )
	{
		let figure = event.currentTarget;

		popup( figure.dataset.galleryID );

		let popup = document.getElementById( figure.dataset.galleryID ).querySelector( '.legal-gallery' );

		let url = parse_srcset( figure.querySelector( 'img' ).getAttribute( 'srcset' ) );

		popup.style.backgroundImage = "url( '" + url + "' )"; 

		let left = popup.querySelector( '.legal-left' );

		left.dataset.galleryID = figure.dataset.galleryID;

		left.dataset.next = figure.previousSibling.dataset.id;

		let right = popup.querySelector( '.legal-right' );

		right.dataset.galleryID = figure.dataset.galleryID;

		right.dataset.next = figure.nextSibling.dataset.id;
	}

	function parse_srcset( srcset )
    {
		return srcset.split( ',' )[ 0 ].split( ' ' )[0];
	}

	document.querySelectorAll( '.tcb-post-content > .gallery' ).forEach( function ( gallery ) {
		// console.log( 'review-gallery gallery: ' + gallery.id );

		gallery.querySelectorAll( 'figure' ).forEach( function ( figure, index ) {
			figure.dataset.galleryID = gallery.id;

			figure.dataset.id = index;

			figure.addEventListener( 'click', popupUpdate, false );
		} );
	} );

} );

// review-gallery-js end