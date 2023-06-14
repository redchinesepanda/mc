// tool-tinymce-js start

document.addEventListener( 'DOMContentLoaded', function () {
	const observer = new MutationObserver( function( mutations_list ) {
		mutations_list.forEach( function( mutation ) {
			mutation.addedNodes.forEach( function( added_node ) {
				// console.log( 'added_node.id: ' + added_node.id );

				if( added_node.id == 'mce-modal-block' ) {
					console.log( 'child has been added' );

					console.log( 'added_node.id: ' + added_node.id );

					console.log( 'added_node: ' + added_node );

					for ( const child of added_node.children ) {
						console.log( child.tagName );
					}

					observer.disconnect();
				}
			});
		});
	});

	observer.observe( document.querySelector( 'body' ), { subtree: false, childList: true } );
} );

// tool-tinymce-js end