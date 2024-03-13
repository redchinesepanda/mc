<?php

// add_action( 'do_robotstxt', 'wp_kama_do_robotstxt_action' );

// function wp_kama_do_robotstxt_action()
// {
// 	echo 'test';

// 	die();
// }

add_action( 'robots_txt', 'wp_kama_robots_txt_append', -1 );

function wp_kama_robots_txt_append( $output ){

	$str = '
	Disallow: /cgi-bin             # Стандартная папка на хостинге.
	Disallow: /?                   # Все параметры запроса на главной.
	Disallow: *?s=                 # Поиск.
	Disallow: *&s=                 # Поиск.
	Disallow: /search              # Поиск.
	Disallow: /author/             # Архив автора.
	Disallow: */embed              # Все встраивания.
	Disallow: */page/              # Все виды пагинации.
	Disallow: */xmlrpc.php         # Файл WordPress API
	Disallow: *utm*=               # Ссылки с utm-метками
	Disallow: *openstat=           # Ссылки с метками openstat
	';

	$str = trim( $str );
	$str = preg_replace( '/^[\t ]+(?!#)/mU', '', $str );
	$output .= "$str\n";

	return $output;
}

require_once( 'lib/LegalMain.php' );

LegalMain::register();

?>