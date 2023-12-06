document.addEventListener( 'DOMContentLoaded', function ()
{
	const popupIds = [
		35145,

		127831,

		50035,

		127809,

		66132,

		135984,

		24430,

		329208,

		329164,

		315231,

		314143,

		299017,

		2433186,

		2456519
	];

	popupIds.forEach( function( id ) {
		document
		.querySelectorAll( 'a[data-tcb-events*="\\"l_id\\":\\"' + id + '\\""]' )
		.forEach( function( element ) {
			element
			.addEventListener( 'click', function() {
				ym( 86785715,'reachGoal', 'show-not-a-partner-popup' );
			} );
		} );
	} );
} );