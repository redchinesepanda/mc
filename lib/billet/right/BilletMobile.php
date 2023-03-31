<?php

class BilletMobile
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-mobile.php';

    public static function get_mobile( $id )
    {
        $args['iphone'] = BilletMain::href( get_field( 'billet-play-mobile-iphone', $id ) );

        $args['android'] = BilletMain::href( get_field( 'billet-play-mobile-android', $id ) );

        $args['site'] = BilletMain::href( get_field( 'billet-play-mobile-site', $id ) );

        return $args;
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( array_key_exists( 'compilation', $billet ) ) {
            $enabled = $billet['compilation']['mobile'];
        }

        if ( $enabled ) {
            $args['mobile'] = self::get_mobile( $billet['id'] );
        }

        return $args;
    }

    public static function render( $billet )
    {
        $args = self::get( $billet );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false, $args );
        }
    }
}

?>