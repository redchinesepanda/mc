<?php

class BilletBonus
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-bonus.php';
    
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

        $args['class'] = BilletMain::disabled( $billet['url']['bonus'] );

        $args['label'] = get_field( 'billet-play-bonus-title' );

        $args['description'] = get_field( 'billet-play-bonus-description' );

        return $args;
    }
    
    private static function get_mobile()
    {
        $args['iphone'] = get_field( 'billet-play-mobile-iphone' );
        
        $args['android'] = get_field( 'billet-play-mobile-android' );

        $args['site'] = get_field( 'billet-play-mobile-site' );

        return $args;
    }
    
    private static function get_profit()
    {
        $args['type'] = get_field( 'billet-play-profit-type' );

        $args['value'] = get_field( 'billet-play-profit-value' );

        return $args;
    }
    
    private static function get_spoiler( $billet )
    {
        $args['id'] = $billet['id'];

        $args['open'] = __( 'More Details', 'Thrive' );

        $args['close'] = __( 'Close Details', 'Thrive' );

        return $args;
    }

    public static function get( $billet )
    {
        $args['bonus'] = self::get_bonus( $billet );

        $args['play'] = self::get_play( $billet );

        $args['mobile'] = self::get_mobile();

        $args['profit'] = self::get_profit();

        $args['spoiler'] = self::get_spoiler( $billet );

        return $args;
    }

    public static function render( $billet = [] )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>