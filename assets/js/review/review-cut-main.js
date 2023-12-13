// review-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	// let setData = {
	// 	id : 0
	// };

	let cut = LegalCut;
	
	document.querySelectorAll(
		// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
		
		'.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control, .legal-menu .legal-cut-item, .legal-menu .legal-cut-control'
	)
	// .forEach( prepareControl );
	.forEach( cut.prepareControl );
} );

// review-cut-js end