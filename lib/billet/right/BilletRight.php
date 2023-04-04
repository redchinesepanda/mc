<?php

require_once( 'BilletBonus.php' );

require_once( 'BilletMobile.php' );

require_once( 'BilletProfit.php' );

require_once( 'BilletSpoilerButton.php' );

class BilletRight
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-right.php';
    
    private static function get_play( $billet )
    {
        $args = BilletMain::href( $billet['url']['play'] );

        $args['label'] = get_field( 'billet-button-play', $billet['id'] );

        return $args;
    }

    public static function get( $billet )
    {
        if ( array_key_exists( 'compilation', $billet ) ) {
            $args['compilation'] = $billet['compilation'];
        }

        $args['id'] = $billet['id'];

        $args['url'] = $billet['url'];

        $args['bonus'] = $billet['bonus'];

        $args['play'] = self::get_play( $billet );

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>