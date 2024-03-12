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
		},

		pageActive : 'pageactive',

		pageActiveEvent : function( valueID, valueIndex )
		{
			return new CustomEvent(
				this.pageActive,

				{
					detail: {
						id: valueID,

						index: valueIndex
					}
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

	function pageActive( event )
	{
		pageChange( event.currentTarget, event.currentTarget.querySelector( selectors.paginationItemIndex( event.detail.index ) ) );
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

	function scrollActive( element )
	{
		let active = element.querySelector( selectors.imageActive );

		let index = [ ...element.children ].indexOf( active );

		reviewGalleySlider.scrollX( element, reviewGalleySlider.getShift( active ) * index );

		element.parentElement.querySelector( selectors.imagesetPagination ).dispatchEvent( reviewGalleyPagination.pageActiveEvent( element.parentElement.dataset.id, index ) );
	}

	function initPagination( element )
	{
		clearPagination( this.querySelector( selectors.imagesetPagination ) );

		element.querySelectorAll( selectors.offScreen ).forEach( addPaginationItem, this );

		this.querySelector( selectors.imagesetPagination ).addEventListener( reviewGalleyPagination.pageForward, pageForward, false );

		this.querySelector( selectors.imagesetPagination ).addEventListener( reviewGalleyPagination.pageBackward, pageBackward, false );

		this.querySelector( selectors.imagesetPagination ).addEventListener( reviewGalleyPagination.pageActive, pageActive, false );

		if ( element.parentElement.classList.contains( classes.imagesetOops ) )
		{
			scrollActive( element );
		}
	}

	function checkOffscreen( element )
	{
		element.classList.remove( classes.offScreen );

		// console.log( 'element: ' + parseFloat( element.getBoundingClientRect().right ) );

		// console.log( 'this: ' + parseFloat( this.getBoundingClientRect().right ) );

		// console.log( '>: ' + ( parseFloat( element.getBoundingClientRect().right )
			
		// > parseFloat( this.getBoundingClientRect().right ) ) );
		
		if (
			parseFloat( element.getBoundingClientRect().right )
			
			> parseFloat( this.getBoundingClientRect().right )
		)
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

		paginationItemNotFirst : '.pagination-item:not( .legal-active )',

		paginationItemIndex : function( index )
		{
			return '.pagination-item:nth-child( ' + ( index + 1 ) + ' )';
		},

		imagesetOops : '.tcb-post-content .legal-imageset-oops',

		imageActive : '.legal-active',
	};
	
	const classes = {
		offScreen : 'legal-off-screen',

		paginationItem : 'pagination-item',

		paginationItemActive : 'legal-active',

		imagesetOops : 'legal-imageset-oops'
	};

	function setPagination( element )
	{
		reviewGalleySlider.scrollX( element, null );

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