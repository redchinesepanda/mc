
// legalDate start

document.addEventListener( 'DOMContentLoaded', function ()
{
	const date = new Date();

	let legalDate = document.querySelector( 'span.myDate' );

	if ( legalDate !== null ) {
		legalDate.textContent = new Intl.DateTimeFormat(
			'ru-RU',
			{ month: 'numeric', day: 'numeric', year: 'numeric' }
		)
		.format( date.setDate( date.getDate() >= 15 ? 15 : 1 ) );
	}
} );

// legalDate end