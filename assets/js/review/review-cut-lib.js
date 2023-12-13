// lib-cookie start

let LegalCut = {
	id : 0,

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

	prepareControl : function ( element )
	{
		element.dataset.cutSetId = this.id;

		console.log( 'this.id: ' + this.id );
		
		if ( element.classList.contains( 'legal-cut-control' ) )
		{
			element.addEventListener( 'click', this.toggleDataset, false );

			this.id++;
		}
	}
};

// let LegalCut = ( function()
// {
// 	"use strict";

// 	return {
// 		cutSetId : 0,

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
// 			element.dataset.cutSetId = this.cutSetId;
			
// 			if ( element.classList.contains( 'legal-cut-control' ) )
// 			{
// 				element.addEventListener( 'click', this.toggleDataset, false );

// 				this.cutSetId++;
// 			}
// 		}
// 	};
// } )();

// lib-cookie end