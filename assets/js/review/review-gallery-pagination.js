// review-gallery-pagination-js start

let reviewGalleyPagination = ( function()
{
	"use strict";

	return {
		pageForward : 'pageforward',

		pageForwardEvent : function( id )
		{
			return new CustomEvent(
				this.pageForward,

				{
					detail: {
						id: () => id
					},
				}
			)
		},

		pageBackward : 'pagebackward',

		pageBackwardEvent : function( id )
		{
			return new CustomEvent(
				'pagebackward',

				{
					detail: {
						id: () => id
					},
				}
			)
		}
	};
} )();

document.addEventListener( 'DOMContentLoaded', function ()
{
	function pageChange( element, sibling )
	{
		if ( sibling !== null )
		{
			element.querySelector( selectors.paginationItemActive ).classList.remove( classes.paginationItemActive );

			sibling.classList.add( classes.paginationItemActive );
		}
	}

	function pageForward( event )
	{
		pageChange( event.currentTarget, event.currentTarget.querySelector( selectors.paginationItemActive ).nextElementSibling );
	}

	function pageBackward( event )
	{
		pageChange( event.currentTarget, event.currentTarget.querySelector( selectors.paginationItemActive ).previousElementSibling );
	}
	
	function addPaginationItem( element )
	{
		const paginationItem = document.createElement( 'div' );

		paginationItem.classList.add( classes.paginationItem );

		this.querySelector( selectors.imagesetPagination ).appendChild( paginationItem );
	}

	function removePaginationItem( element )
	{
		element.remove();
	}

	function clearPagination( element )
	{
		element.querySelectorAll( selectors.paginationItemNotFirst ).forEach( removePaginationItem );
	}

	function initPagination( element )
	{
		clearPagination( this.querySelector( selectors.imagesetPagination ) );

		element.querySelectorAll( selectors.offScreen ).forEach( addPaginationItem, this );

		// this.querySelector( selectors.imagesetPagination ).addEventListener( 'pageforward', pageForward, false );
		
		this.querySelector( selectors.imagesetPagination ).addEventListener( reviewGalleyPagination.pageForward, pageForward, false );

		this.querySelector( selectors.imagesetPagination ).addEventListener( reviewGalleyPagination.pageBackward, pageBackward, false );
	}

	function checkOffscreen( element )
	{
		console.log( 'checkOffscreen' );

		console.log( element.getBoundingClientRect().right );
		
		console.log( this.getBoundingClientRect().right );

		if ( element.getBoundingClientRect().right > this.getBoundingClientRect().right )
		{
			element.classList.add( classes.offScreen );
		}
	}

	const selectors = {
		imageset : '.tcb-post-content .legal-imageset',

		imagesetWrapper : '.tcb-post-content .legal-imageset-wrapper',

		imagesetItem : '.tcb-post-content .legal-imageset-wrapper .imageset-item',

		offScreen : '.legal-off-screen',

		imagesetPagination : '.imageset-pagination',
		
		paginationItemActive : '.legal-active',

		paginationItemNext : '.legal-active + .pagination-item',

		paginationItemNotFirst : '.pagination-item:not( :first-of-type )',

		imagesetOops : '.tcb-post-content .legal-imageset-oops'
	};
	
	const classes = {
		offScreen : 'legal-off-screen',

		paginationItem : 'pagination-item',

		paginationItemActive : 'legal-active'
	};

	function setPagination( element )
	{
		element.scroll( {
			left: 0,

			behavior: 'smooth'
		} );

		console.log( 'setPagination' );

		element.querySelectorAll( selectors.imagesetItem ).forEach( checkOffscreen, this );
	}

	function slider( element )
	{
		element.querySelectorAll( selectors.imageset ).forEach( setPagination, element );

		element.querySelectorAll( selectors.imageset ).forEach( initPagination, element );
	}

	document.querySelectorAll( selectors.imagesetWrapper ).forEach( slider );

	function oopsReady( event )
	{
		document.querySelectorAll( selectors.imagesetOops ).forEach( slider );
	}

	document.addEventListener( reviewGalleyOops.oopsReady, oopsReady, false );
	  
} );

// review-gallery-pagination-js end