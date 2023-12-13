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

    function setOrder( item, index )
	{
		item.dataset.order = index;
	}

    function filter_children_no( item )
	{
		return !item.classList.contains( 'menu-item-has-children' );
	}

    function filter_children_has( item )
	{
		return item.classList.contains( 'menu-item-has-children' );
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

	function appendAll( item )
	{
		// console.log( this );

		// console.log( item );

		this.appendChild( item );
	}

	// function groupAppend( subMenu, index, group )
	
	function groupAppend( group )
	{
		let element = document.createElement( 'div' );

		element.classList.add( 'menu-group' );

		this.appendChild( element );
		
		group.forEach( appendAll, element );
	}

    function setGroups( element )
	{
		if ( element.hasChildNodes() )
		{
			// let children = [ ...element.children ];
			
			let children = [ ...element.querySelectorAll( elements.menuItem.selectors ) ];

			children.forEach( setOrder );

			// console.log( children );

			let children_no = children.filter( filter_children_no );

			let children_has = children.filter( filter_children_has );
			
			[].concat( arrayChunk( children_no, 6 ), arrayChunk( children_has, 1 ) ).forEach( groupAppend, element );
		}
	}

	function removeAll( item )
	{
		// this.appendChild( item );
		
		this.push( item );
	}

	function groupRemove( group )
	{
		this.removeChild( group );
	}

	function groupClildrenRemove( group )
	{
		[ ...group.children ].forEach( removeAll, this );
	}

	function sortByDataOrder( a, b )
	{
		let valueA = parseInt( a );

		let valueB = parseInt( b );

		if ( valueA.dataset.order < valueB.dataset.order )
		{
			return -1;
		}
		
		if ( valueA.dataset.order > valueB.dataset.order )
		{
			return 1;
		}
		
		return 0;
	}

    function removeGroups( element )
	{
		if ( element.hasChildNodes() )
		{
			let items = [];

			let groups = [ ...element.querySelectorAll( elements.menuGroup.selectors ) ];

			groups.forEach( groupClildrenRemove, items );

			groups.forEach( groupRemove, element );

			items.sort( sortByDataOrder ).forEach( appendAll, element );
		}
	}

	const elements = {
		menu : {
			selectors : '.legal-menu > .menu-item-has-children > .sub-menu'
		},

		menuItem : {
			selectors : ':scope > .menu-item'
		},

		menuGroup : {
			selectors : ':scope > .menu-group'
		}
	};

	function groupsInit()
	{
		if ( window.matchMedia( '( min-width: 768px )' ).matches )
		{
			document.querySelectorAll( elements.menu.selectors ).forEach( setGroups );
		}
		else
		{
			document.querySelectorAll( elements.menu.selectors ).forEach( removeGroups )
		}
	}

	groupsInit();

	window.addEventListener( 'resize', groupsInit, false );
} );

// header-menu-js end