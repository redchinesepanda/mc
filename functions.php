<?php

defined( 'TVE_EDITOR_URL' ) || define( 'TVE_EDITOR_URL', get_template_directory_uri() . '/architect/' );

add_action( 'wp_enqueue_scripts', function () {
	$parent_style = 'parent-style';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', [ $parent_style ], wp_get_theme()->get( 'Version' ) );
} );

require_once( 'lib/LegalMain.php' );

require_once( 'lib/wpml/WPMLMain.php' );

require_once( 'lib/acf/ACFMain.php' );

require_once( 'lib/admin/AdminMain.php' );

require_once( 'lib/tools/ToolPosts.php' );

WPMLMain::register();

ACFMain::register();

AdminMain::register();

ToolPosts::register();

?>