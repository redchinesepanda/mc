<?php

// require_once( 'ACFBilletCards.php' );

require_once( 'ACFPage.php' );

require_once( 'ACFCompilation.php' );

require_once( 'ACFMenu.php' );

require_once( 'ACFReview.php' );

require_once( 'ACFBillet.php' );

class ACFMain
{
    const JS = LegalMain::LEGAL_URL . '/assets/js/acf/acf-main.js';

    public static function register_script()
    {
        wp_register_script( 'acf-main', self::JS, [], false, true);

        wp_enqueue_script( 'acf-main' );
    }

    public static function register_functions()
    {
        ACFReview::register_functions();
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );

        // ACFBilletCards::register();

        ACFPage::register();

        ACFCompilation::register();

        ACFMenu::register();

        ACFReview::register();

        ACFBillet::register();
    }
}

?>