<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

add_action( 'do_robotstxt', 'wp_kama_do_robotstxt_action' );

/**
 * Function for `do_robotstxt` action-hook.
 * 
 * @return void
 */
function wp_kama_do_robotstxt_action()
{
	echo 'test';

	die();
}

?>