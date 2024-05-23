<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

function my_acf_json_save_point( $path )
{
    // return get_stylesheet_directory() . '/my-custom-folder';

	LegalDebug::die( [
        'functions.php' =>'my_acf_json_save_point',

        'path' => $path,
    ] );

	return $path;
}

add_filter( 'acf/settings/save_json', 'my_acf_json_save_point' );

?>