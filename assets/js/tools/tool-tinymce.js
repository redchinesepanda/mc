// tool-tinymce-js start

document.addEventListener( 'DOMContentLoaded', function () {
	const callback = ( mutationList ) => {
		for (const mutation of mutationList) {
			if (mutation.type === "childList") {
				mutation.addedNodes.forEach( function ( added_node, index, listObj ) {
					added_node.querySelectorAll( 'label' ).forEach( function ( element ) {
						if ( element.textContent == 'ID' ) {
							// observer.disconnect();

							element.nextSibling.setAttribute( 'list', 'legal-anchor-choices' );

							let datalist = document.createElement( 'datalist' );

							datalist.setAttribute( 'id', 'legal-anchor-choices' );
							
							let legal_anchors = [ 'Herr', 'Frau' ];

							legal_anchors.forEach( function( item ){
								var option = document.createElement( 'option' );

								option.value = item;

								datalist.appendChild( option );
							});

							element.parentElement.appendChild( datalist );
						}
					} );
				}, 'myThisArg' );
			}
		}
	};

	const observer = new MutationObserver( callback );

	observer.observe( document.querySelector( 'body' ), { subtree: false, childList: true } );
} );

// tool-tinymce-js end