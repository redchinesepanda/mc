<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

function my_acf_json_save_point( $path )
{
    // return get_stylesheet_directory() . '/my-custom-folder';

	LegalDebug::die( [
        'functions.php' =>'my_acf_json_save_point',

        'path' => $path,
    ] );

	return $path;
}

add_filter( 'acf/json/save_paths', 'custom_acf_json_save_paths', 10, 2 );

function custom_acf_json_save_paths( $paths, $post )
{
    // if ( $post['title'] === 'Theme Settings' ) {
    //     $paths = array( get_stylesheet_directory() . '/options-pages' );
    // }

    // if ( $post['title'] === 'Theme Settings Fields' ) {
    //     $paths = array( get_stylesheet_directory() . '/field-groups' );
    // }

	LegalDebug::debug( [
        'functions.php' =>'custom_acf_json_save_paths',

        'paths' => $paths,
    ] );

    return $paths;
}

?>