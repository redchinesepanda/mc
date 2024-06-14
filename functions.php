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

?>