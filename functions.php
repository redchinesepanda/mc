<?php



add_filter( 'redirection_request_headers', function( $headers )
{
	LegalDebug::debug( [
		'NotFoundMain' => 'redirection_request_headers-1',

		'headers' => $headers,
	] );

	return $headers;
}, 10, 1 );

add_filter( 'redirection_request_header', function( $value, $name )
{
	LegalDebug::debug( [
		'NotFoundMain' => 'redirection_request_headers-1',

		'value' => $value,

		'name' => $name,
	] );

	return $value;
}, 10, 2 );

require_once( 'lib/LegalMain.php' );

LegalMain::register();

?>