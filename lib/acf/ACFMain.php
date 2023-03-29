<?php

require_once( 'ACFBilletCards.php' );

require_once( 'ACFPage.php' );

class ACFMain
{
    const JS = LegalMain::LEGAL_URL . '/assets/js/acf/acf-main.js';

    public static function register_script()
    {
        wp_register_script( 'acf-main', self::JS, [], false, true);

        wp_enqueue_script( 'acf-main' );
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

        ACFBilletCards::register();

        ACFPage::register();
    }
}

?>