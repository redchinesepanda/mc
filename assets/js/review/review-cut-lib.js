// lib-cookie start

let LegalCut = ( function()
{
	"use strict";

	return {
		cutSetId : 0,

		// toggleItem: function ( element )

		toggleItem ( element )
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
			.forEach( this.toggleItem );
		}, 

		// prepareControl : function ( element )

		prepareControl ( element )
		{
			element.dataset.cutSetId = this.cutSetId;
			
			if ( element.classList.contains( 'legal-cut-control' ) )
			{
				element.addEventListener( 'click', this.toggleDataset, false );

				this.cutSetId++;
			}
		}
	};
} )();

// lib-cookie end