<?php

class BilletMobile
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-mobile.php';

    public static function get()
    {
        $args['mobile']['iphone'] = BilletMain::href( get_field( 'billet-play-mobile-iphone' ) );

        $args['mobile']['android'] = BilletMain::href( get_field( 'billet-play-mobile-android' ) );

        $args['mobile']['site'] = BilletMain::href( get_field( 'billet-play-mobile-site' ) );

        return $args;
    }

    public static function render()
    { 
        load_template( self::TEMPLATE, false, self::get() );
    }
}

?>