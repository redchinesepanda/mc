<?php

defined( 'TVE_EDITOR_URL' ) || define( 'TVE_EDITOR_URL', get_template_directory_uri() . '/architect/' );

add_action(
	'wp_enqueue_scripts',
	
	function ()
	{
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [ $parent_style ], wp_get_theme()->get( 'Version' ) );
	}
);

require_once( 'lib/LegalMain.php' );

LegalMain::register();

// BonusDuration::date_migrate();

// BonusAbout::affiliate_migrate();

?>