<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

add_filter( 'wpo_purge_cache_hooks', function( $actions )
{
    // $actions[] = 'my_custom_action';

	LegalDebug::debug( [
        'functions.php' => 'wpo_purge_cache_hooks',

        'actions' => $actions,
    ] );

    return $actions;
} );

add_filter('wpo_cache_cookies', 'myprefix_add_cache_cookies', 20, 2);

function myprefix_add_cache_cookies( $cookies )
{
	// if ()
	// {
	// 	$cookie[] = 'cache_key_that_needs_separate_cache';
	// }

	LegalDebug::debug( [
        'functions.php' => 'myprefix_add_cache_cookies',

        'cookies' => $cookies,
    ] );

	return $cookies;
}

?>