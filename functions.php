<?php

require_once( 'lib/LegalMain.php' );

LegalMain::register();

function add_my_icons($file) {
    $file = get_stylesheet_directory().'/path_to_my/icons.json';
    return $file;
}

add_filter( 'jvm_richtext_icons_iconset_file', 'add_my_icons');

?>