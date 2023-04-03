<?php

require_once( 'BilletLogo.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

require_once( 'right/BilletRight.php' );

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

    private static function get_url( $billet )
    {
        $referal_url = get_field( 'billet-referal-url', $billet['id'] );

        $card_id = get_field( 'billet-card-id', $billet['id'] );

        $card_url = '';
        
        if ( !empty( $card_id ) ) {
            $card_url = get_post_permalink( $card_id );
        }

        $bonus_id = get_field( 'billet-bonus-id', $billet['id'] );

        $bonus_url = '';
        
        if ( !empty( $bonus_id ) ) {
            $bonus_url = get_post_permalink( $bonus_id );
        }

        $review_url = $card_url;
        if ( array_key_exists( 'compilation', $billet ) ) {
            if ( $billet['compilation']['review']['type'] == 'legal-bonus' ) {
                $review_url = $bonus_url;
            }
        }

        $oops = '#oops';

        $args['logo'] = ( $referal_url != '' ? $referal_url : ( $card_url !== false ? $card_url : '' ) );

        $args['review'] = ( $review_url !== false ? $review_url : '' );

        $args['title'] = ( $card_url !== false ? $card_url : ( $referal_url != '' ? $referal_url : '' ) );

        $args['bonus'] = ( $referal_url != '' ? $referal_url : ( $oops != '' ? $oops : '' ) );

        $args['play'] = $args['bonus'];

        return $args;
    }

    private static function get( $billet )
    {
        $id = 0;

        $args['index'] = 1;

        if ( !empty( $billet ) ) {
            $id = $billet['id'];

            $args['index'] = $billet['index'];

            if ( array_key_exists( 'compilation', $billet ) ) {
                $args['compilation'] = $billet['compilation'];
            }
        } else {
            $post = get_post();
    
            $id = $post->ID;
        }

        $args['id'] = $id;

        $url = self::get_url( $args );
        
        $args['url'] = $url;

        $args['selector'] = 'billet-' . $id;

        $args['color'] = self::get_color( $id );

        $args['description'] = get_field( 'billet-description', $id );

        return $args;
    }

    private static function get_color( $id )
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

    public static function render( $billet = [] )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>