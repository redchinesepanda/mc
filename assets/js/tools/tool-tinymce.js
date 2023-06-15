// tool-tinymce-js start

document.addEventListener( 'DOMContentLoaded', function () {
	const callback = ( mutationList ) => {
		for (const mutation of mutationList) {
			if (mutation.type === "childList") {
				mutation.addedNodes.forEach( function ( added_node, index, listObj ) {
					added_node.querySelectorAll( 'label' ).forEach( function ( element ) {
						if ( element.textContent == 'ID' ) {
							observer.disconnect();

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

	// const observer = new MutationObserver( function( mutations_list ) {
	// 	mutations_list.forEach( function( mutation ) {
	// 		mutation.addedNodes.forEach( function( added_node ) {
	// 			// console.log( 'added_node.id: ' + added_node.id );

	// 			if( added_node.id == 'mce-modal-block' ) {
	// 				console.log( 'child has been added' );

	// 				console.log( 'added_node.id: ' + added_node.id );

	// 				added_node.querySelectorAll( '.mce-abs-end' ).forEach( function ( element ) {
	// 					console.log( 'element.id: ' + element.id );
	// 				} );

	// 				observer.disconnect();
	// 			}
	// 		});
	// 	});
	// });

	observer.observe( document.querySelector( 'body' ), { subtree: false, childList: true } );
} );

// tool-tinymce-js end