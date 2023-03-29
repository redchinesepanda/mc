<?php

require_once( 'BilletLogo.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

require_once( 'right/BilletBonus.php' );

require_once( 'right/BilletMobile.php' );

require_once( 'right/BilletProfit.php' );

require_once( 'BilletSpoiler.php' );

class BilletMain
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-main.php';

    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        'billet-main' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main.css',

        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-spoiler.css',
    ];

    const JS = [
        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-spoiler.js'
    ];

    public static function print()
    {
        foreach ( self::CSS as $key => $url ) {
            echo '<link id="' . $key . '" href="' . $url . '" rel="stylesheet" />';
        }
        
        foreach ( self::JS as $key => $src ) {
            echo '<script id="' . $key . '" src="' . $src . '"></script>';
        }
    }

    private static function get_url( $id )
    {
        $referal_url = get_field( 'billet-referal-url', $id );

        $card_id = get_field( 'billet-card-id', $id );

        $card_url = '';
        
        if ( !empty( $card_id ) ) {
            $card_url = get_post_permalink( $card_id );
        }

        $oops = '#oops';

        $args['logo'] = ( $referal_url != '' ? $referal_url : ( $card_url !== false ? $card_url : '' ) );

        $args['review'] = ( $card_url !== false ? $card_url : '' );

        $args['title'] = ( $card_url !== false ? $card_url : ( $referal_url != '' ? $referal_url : '' ) );

        $args['bonus'] = ( $referal_url != '' ? $referal_url : ( $oops != '' ? $oops : '' ) );

        $args['play'] = $args['bonus'];

        return $args;
    }

    public static function get( $id = 0 )
    {
        $url = self::get_url( $id );
        
        $args['url'] = $url;

        if ( $id == 0 ) {
            $post = get_post();
    
            $id = $post->ID;
        }

        $args['id'] = $id;

        $args['selector'] = 'billet-' . $id;

        $args['color'] = self::get_color( $id );

        $args['description'] = get_field( 'billet-description', $id );

        return $args;
    }

    public static function get_color( $id )
    {
        $color = get_field( 'billet-color', $id );

        if ( empty( $color ) ) {
            $color = self::DEFAULT_COLOR;
        }

        return $color;
    }

    public static function disabled( $url )
    {
        return ( $url == '' ? 'legal-disabled' : '' );
    }

    public static function href( $url )
    {
        $args['href'] = $url;

        $args['class'] = self::disabled( $url );

        return $args;
    }

    public static function render( $id )
    { 
        load_template( self::TEMPLATE, false, self::get( $id ) );
    }
}

?>