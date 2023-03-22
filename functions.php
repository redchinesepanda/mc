<?php

defined( 'TVE_EDITOR_URL' ) || define( 'TVE_EDITOR_URL', get_template_directory_uri() . '/architect/' );

add_action( 'wp_enqueue_scripts', function () {
	$parent_style = 'parent-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [ $parent_style ], wp_get_theme()->get( 'Version' ) );
} );

require_once( 'lib/Template.php' );

require_once( 'lib/wpml/WPMLLangSwitcher.php' );

require_once( 'lib/acf/ACFBilletCards.php' );

require_once( 'lib/admin/AdminMain.php' );

WPMLLangSwitcher::register();

ACFBilletCards::register();

AdminMain::register();

?>