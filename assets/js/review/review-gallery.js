// review-gallery start

document.addEventListener( 'DOMContentLoaded', function ()
{
	function popupNext( event )
	{
		console.log( 'review-gallery classList:' +  event.currentTarget.classList );
	}

	function popupRemove( event )
	{
		console.log( 'review-gallery classList:' +  event.currentTarget.classList );

		event.currentTarget.remove();
	}

	function popup( event )
    {
		let lightroom = document.createElement( 'div' );
		
		lightroom.classList.add( 'legal-gallery' );

		lightroom.style.backgroundImage = "url( '" + parse_srcset( event.currentTarget.getAttribute( 'srcset' ) ) + "' )"; 

		lightroom.addEventListener( 'click', popupRemove, false );

		let left = document.createElement( 'div' );
		
		left.classList.add( 'legal-left' );

		left.addEventListener( 'click', popupNext, false );

		lightroom.appendChild( left );

		let right = document.createElement( 'div' );
		
		right.classList.add( 'legal-right' );

		right.addEventListener( 'click', popupNext, false );

		lightroom.appendChild( right );

		document.getElementById( event.currentTarget.dataset.galleryID ).appendChild( lightroom );
	}

	function parse_srcset( srcset )
    {
		return srcset.split( ',' )[ 0 ].split( ' ' )[0];
	}

	document.querySelectorAll( '.tcb-post-content > .gallery' ).forEach( function ( gallery ) {
		console.log( 'review-gallery gallery: ' + gallery.id );

		gallery.querySelectorAll( 'img' ).forEach( function ( img ) {
			// console.log( 'review-gallery parse_srcset: ' + parse_srcset( img.getAttribute( 'srcset' ) ) );

			img.dataset.galleryID = gallery.id;

			img.addEventListener( 'click', popup, false );
		} );
	} );

} );

// review-gallery-js end