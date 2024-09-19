<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

function add_my_icons($file) {
    $file = get_stylesheet_directory().'/path_to_my/icons.json';
    return $file;
}

add_filter( 'jvm_richtext_icons_iconset_file', 'add_my_icons');

function add_my_css($cssfile) {
    $cssfile = get_stylesheet_directory_uri().'/path_to_my/cssfile.css';
    return $cssfile;
}

add_filter( 'jvm_richtext_icons_css_file', 'add_my_css');

add_filter( 'jvm_richtext_icons_css_file', '__return_false');

?>