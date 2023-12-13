// header-menu-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
    // function toggleBlock( event )
	// {
	// 	let current = event.currentTarget;

	// 	let element = event.target;
		
	// 	if ( current == element ) {
	// 		current.classList.toggle( 'legal-active' );
	// 	}
	// }

    // function toggleLink( event )
	// {
	// 	let element = event.target;

	// 	if ( element.hasAttribute( 'href' ) ) {

	// 		if ( !element.parentElement.classList.contains( 'legal-active' ) ) {
	// 			event.preventDefault();
	// 		}
	// 	}
	// }

    function filter_children_no( item )
	{
		return !item.hasChildNodes();
	}

    function filter_children_has( item )
	{
		return item.hasChildNodes();
	}

	function arrayChunk( items, size )
	{
		const chunks = [];

		while ( items.length > 0 )
		{
			chunks.push( items.splice( 0, size ) );
		}

		return chunks;
	}

	function groupAppend( element, item, index )
	{
		// let group = element.parentElement.createElement( 'div' );

		console.log( element );

		console.log( item );

		console.log( index );
	}

    function setGroups( element )
	{
		if ( element.hasChildNodes() )
		{
			let children = [ ...element.children ];

			let children_no = children.filter( filter_children_no );

			let children_has = children.filter( filter_children_has );

			arrayChunk( children_no, 6 ).concat( arrayChunk( children_has, 1 ) ).forEach( groupAppend.bind( element ) );
			
			// console.log( arrayChunk( children_no, 6 ).concat( arrayChunk( children_has, 1 ) ) );
			
		}
	}

	const elements = {
		menu : {
			selectors : '.legal-menu > .menu-item-has-children > .sub-menu'
		}
	};

	function groupsInit()
	{
		if ( window.matchMedia( '( min-width: 768px )' ).matches )
		{
			document.querySelectorAll( elements.menu.selectors ).forEach( setGroups );

			// args.forEach( function ( arg ) {
			// 	document.querySelectorAll( arg.selector ).forEach( function ( element ) {
			// 		element.addEventListener( arg.event, arg.action, false );
			// 	} );
			// } );
		} else {
			// args.forEach( function ( arg ) {
			// 	document.querySelectorAll( arg.selector ).forEach( function ( element ) {
			// 		element.removeEventListener( arg.event, arg.action, false );
			// 	} );
			// } );

			
		}
	}

	groupsInit();

	window.addEventListener( 'resize', groupsInit, false );
} );

// header-menu-js end