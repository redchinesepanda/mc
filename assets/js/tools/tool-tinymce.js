// tool-tinymce-js start

document.addEventListener( 'DOMContentLoaded', function () {
	const callback = ( mutationList ) => {
		for (const mutation of mutationList) {
			if (mutation.type === "childList") {
				mutation.addedNodes.forEach( function ( added_node, index, listObj ) {
					added_node.querySelectorAll( 'label' ).forEach( function ( element ) {
						if ( element.textContent == 'ID' ) {
							// console.log( 'mutation: ' + mutation );

							// console.log( `${added_node}, ${index}, ${this}` );

							// console.log( 'added_node.id: ' + added_node.id );

							// console.log( 'textContent: ' + element.textContent );

							element.setAttribute( 'list', 'legal-anchor-choices' );

							let datalist = document.createElement( 'DATALIST' );

							datalist.setAttribute( 'id', 'legal-anchor-choices' );

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