<?php

class BilletBonus
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php';
    
    private static function get_play( $billet )
    {
        $args = BilletMain::href( $billet['url']['play'] );

        $args['label'] = get_field( 'billet-button-play', $billet['id'] );

        return $args;
    }
    
    private static function get_bonus( $billet )
    {
        $args = BilletMain::href( $billet['url']['bonus'] );

        $args['label'] = get_field( 'billet-play-bonus-title', $billet['id'] );

        $args['description'] = get_field( 'billet-play-bonus-description', $billet['id'] );

        return $args;
    }
    
    private static function get_spoiler( $id )
    {
        $args['id'] = $id;

        $args['open'] = __( 'More Details', 'Thrive' );

        $args['close'] = __( 'Close Details', 'Thrive' );

        return $args;
    }

    public static function get( $billet )
    {
        $args['id'] = $billet['id'];

        $args['bonus'] = self::get_bonus( $billet );

        $args['play'] = self::get_play( $billet );

        $args['spoiler'] = self::get_spoiler( $billet['id'] );

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>