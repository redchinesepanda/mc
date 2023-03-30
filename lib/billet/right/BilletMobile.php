<?php

class BilletMobile
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-mobile.php';

    public static function get( $id )
    {
        $args['mobile']['iphone'] = BilletMain::href( get_field( 'billet-play-mobile-iphone', $id ) );

        $args['mobile']['android'] = BilletMain::href( get_field( 'billet-play-mobile-android', $id ) );

        $args['mobile']['site'] = BilletMain::href( get_field( 'billet-play-mobile-site', $id ) );

        return $args;
    }

    public static function render( $id )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }
}

?>