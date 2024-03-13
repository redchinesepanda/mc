<?php

// add_action( 'do_robotstxt', 'my_robotstxt' );
// function my_robotstxt(){

// 	$lines = [
// 		'User-agent: *',
// 		'Disallow: /wp-admin/',
// 		'Disallow: /wp-includes/',
// 		'',
// 	];

// 	echo implode( "\r\n", $lines );

// 	die; // обрываем работу PHP
// }

require_once( 'lib/LegalMain.php' );

LegalMain::register();

?>