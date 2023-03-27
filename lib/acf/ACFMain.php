<?php

require_once( 'ACFBilletCards.php' );

require_once( 'ACFPage.php' );

class ACFMain
{
    public static function register()
    {
        ACFBilletCards::register();

        ACFPage::register();
    }
}

?>