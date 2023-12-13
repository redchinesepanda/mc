// lib-cookie start

let legalCut = {
	id : 1,

	cutSetId : 1,

	// toggleItem: function ( element )

	toggleItem : function ( element )
	{
		element.classList.toggle( 'legal-active' );
	},

	// toggleDataset: function ( event )

	toggleDataset : function ( event )
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
		element.dataset.cutSetId = this.id;

		console.log( 'this.id: ' + this.id );
		
		console.log( 'this.cutSetId: ' + this.cutSetId );
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', this.toggleDataset(), false );

			this.id++;

			this.cutSetId++;
		}
	}
};

// let legalCut = ( function()
// {
// 	"use strict";

// 	return {
// 		cutSetId : 0,

// 		name : 0,

// 		// toggleItem: function ( element )

// 		toggleItem : function ( element )
// 		{
// 			element.classList.toggle( 'legal-active' );
// 		},

// 		// toggleDataset: function ( event )

// 		toggleDataset : function ( event )
// 		{
// 			event.currentTarget.classList.toggle( 'legal-active' );

// 			event.currentTarget.parentElement.querySelectorAll(
// 				'.legal-cut-item[data-cut-set-id="' + event.currentTarget.dataset.cutSetId + '"]'
// 			)
// 			.forEach( this.toggleItem );
// 		}, 

// 		// prepareControl : function ( element )

// 		prepareControl : function ( element )
// 		{
// 			// element.dataset.cutSetId = this.cutSetId;
			
// 			element.dataset.cutSetId = this.name;
			
// 			if ( element.classList.contains( 'legal-cut-control' ) )
// 			{
// 				element.addEventListener( 'click', this.toggleDataset, false );

// 				// this.cutSetId++;
				
// 				this.name++;
// 			}
// 		}
// 	};
// } )();

// lib-cookie end