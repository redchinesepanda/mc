<?php

require_once( 'ReviewAbout.php' );

require_once( 'ReviewAnchors.php' );

require_once( 'ReviewGroup.php' );

require_once( 'ReviewOverview.php' );

require_once( 'RviewGallery.php' );

require_once( 'ReviewFAQ.php' );

class ReviewMain
{
    const CSS = [
        'review-main' => LegalMain::LEGAL_URL . '/assets/css/review/review-main.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        ReviewAbout::register();

        ReviewAnchors::register();

        ReviewGroup::register();

        ReviewOverview::register();

        RviewGallery::register();

        ReviewFAQ::register();
    }
}

?>