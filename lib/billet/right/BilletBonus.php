<?php

class BilletBonus
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php';
    
    private static function get_play( $billet )
    {
        $args['href'] = $billet['url']['play'];

        $args['class'] = BilletMain::disabled( $billet['url']['play'] );

        $args['label'] = get_field( 'billet-button-play' );

        return $args;
    }
    
    private static function get_bonus( $billet )
    {
        $args['href'] = $billet['url']['bonus'];

        $args['label'] = get_field( 'billet-play-bonus-title' );

        $args['class'] = BilletMain::disabled( $billet['url']['bonus'] );

        $args['description'] = get_field( 'billet-play-bonus-description' );

        return $args;
    }
    
    private static function get_mobile( $id )
    {
        $args['iphone'] = get_field( 'billet-play-mobile-iphone', $id );
        
        $args['android'] = get_field( 'billet-play-mobile-android', $id );

        $args['site'] = get_field( 'billet-play-mobile-site', $id );

        return $args;
    }
    
    private static function get_profit( $id )
    {
        $args['type'] = get_field( 'billet-play-profit-type', $id );

        $args['value'] = get_field( 'billet-play-profit-value', $id );

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
        $args['bonus'] = self::get_bonus( $billet );

        $args['play'] = self::get_play( $billet );

        $args['mobile'] = self::get_mobile( $billet['id'] );

        $args['profit'] = self::get_profit( $billet['id'] );

        $args['spoiler'] = self::get_spoiler( $billet['id'] );

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>