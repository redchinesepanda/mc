<?php

class BilletBonus
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/part-billet-bonus.php';
    
    private static function get_data( $billet )
    {
        $post = get_post();

        $args['id'] = $post->ID;

        return $args;
    }
    
    private static function get_bonus()
    {
        $args['title'] = get_field( 'billet-play-bonus-title' );

        $args['description'] = get_field( 'billet-play-bonus-description' );

        $args['play'] = __( 'Bet now', 'Thrive' );

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
    
    private static function get_spoiler()
    {
        $args['open'] = __( 'More Details', 'Thrive' );

        $args['close'] = __( 'Close Details', 'Thrive' );

        return $args;
    }

    public static function get( $billet )
    {
        $args['data'] = self::get_data();

        $args['bonus'] = self::get_bonus();

        $args['mobile'] = self::get_mobile();

        $args['profit'] = self::get_profit();

        $args['spoiler'] = self::get_spoiler();

        return $args;
    }

    public static function render( $billet = [] )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>