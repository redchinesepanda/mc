// review-cut-js start

document.addEventListener( 'DOMContentLoaded', function ()
{
	let setData = {
		id : 0
	};
	
	document.querySelectorAll(
		// '.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control'
		
		'.tcb-post-content > .legal-cut-item, .tcb-post-content > .legal-cut-control, .legal-menu .legal-cut-item, .legal-menu .legal-cut-control'
	)
	// .forEach( prepareControl );
	.forEach( LegalCut.prepareControl, setData );
} );

// review-cut-js end