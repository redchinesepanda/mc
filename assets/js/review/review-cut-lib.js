// lib-cookie start

let LegalCut = ( function()
{
	"use strict";

	return {
		toggleItem: function ( element )
		{
			element.classList.toggle( 'legal-active' );
		},

		// toggleDataset: function ( event )
		toggleDataset ( event )
		{
			event.currentTarget.classList.toggle( 'legal-active' );

			event.currentTarget.parentElement.querySelectorAll(
				'.legal-cut-item[data-cut-set-id="' + event.currentTarget.dataset.cutSetId + '"]'
			)
			.forEach( LegalCut.toggleItem );
		}, 

		// prepareControl : function ( element )
		prepareControl ( element )
		{
			element.dataset.cutSetId = this.id;
			
			if ( element.classList.contains( 'legal-cut-control' ) )
			{
				element.addEventListener( 'click', this.toggleDataset, false );

				// this.id++;
			}
		}
	};
} )();

// lib-cookie end